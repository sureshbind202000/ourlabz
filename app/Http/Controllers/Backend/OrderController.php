<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\ShiprocketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // Vendor Order List
    public function list()
    {
        return view('backend.superadmin.vendor.orders.list');
    }

    public function fetchOrders()
    {
        $user = Auth::user();

        $query = Order::with(['user', 'vendor', 'address', 'items'])->latest();

        if ($user->role == 5) {
            // Vendor - show only vendor-specific orders
            $query->where('vendor_id', $user->id);
        }
        // Else for admin (or superadmin), show all orders

        $orders = $query->get();

        $html = view('backend.superadmin.vendor.orders.table', compact('orders'))->render();

        return response()->json([
            'status' => true,
            'html' => $html
        ]);
    }

    public function details($id)
    {
        $dId = decrypt($id);
        $order = Order::with(['user', 'vendor', 'address', 'items'])->where('id', $dId)->first();
        return view('backend.superadmin.vendor.orders.details', compact('order'));
    }

    public function changeStatus(Request $request)
    {
        $order = Order::with([
            'items.product',
            'items.vendor.user_details',
            'user',
            'address'
        ])->findOrFail($request->id);

        $newStatus = ucfirst(strtolower($request->status)); // e.g., "Processing"

        // Only trigger Shiprocket when moving to "Processing"
        if ($newStatus === 'Processing') {
            try {
                $shiprocket = new ShiprocketService(); // Admin Shiprocket account

                $deliveryUser = $order->user;
                $deliveryAddress = $order->address;

                // Validate customer shipping address
                if (
                    !$deliveryAddress ||
                    empty($deliveryAddress->address) ||
                    empty($deliveryAddress->city) ||
                    empty($deliveryAddress->pin) ||
                    empty($deliveryAddress->state) ||
                    empty($deliveryAddress->country)
                ) {
                    Log::warning("Order {$order->id} has incomplete shipping address.", $deliveryAddress ? $deliveryAddress->toArray() : []);
                    return response()->json([
                        'success' => false,
                        'message' => 'Incomplete shipping address. Please check address details before processing.'
                    ]);
                }

                // Group items by vendor
                $vendorGroups = $order->items->groupBy('vendor_id');

                foreach ($vendorGroups as $vendorId => $vendorItems) {
                    $vendor = $vendorItems->first()->vendor;

                    $pickupPincode = $vendor->user_details->pin ?? '110001';
                    $billingPhone = '917275842157'; // Admin 10-digit local
                    $shippingPhone = '91' . preg_replace('/\D/', '', $deliveryUser->phone);
                    $pickupPhone = $vendor->user_details->phone
                        ? '91' . preg_replace('/\D/', '', $vendor->user_details->phone)
                        : '911234567890';

                    $totalWeight = $vendorItems->sum(fn($item) => ($item->product->weight ?? 0.5) * $item->quantity);

                    // Prepare order items for Shiprocket
                    $orderItems = $vendorItems->map(function ($item) {
                        return [
                            'name'          => $item->product->product_name ?? 'Product-' . $item->product_id,
                            'sku'           => $item->product->product_identification_no ?? 'SKU-' . $item->product_id,
                            'units'         => $item->quantity,
                            'selling_price' => $item->price,
                            'discount'      => 0,
                            'tax'           => 0,
                        ];
                    })->toArray();

                    // Shiprocket payload
                    $orderPayload = [
                        'order_id'                => "{$order->id}-V{$vendorId}",
                        'order_date'              => now()->format('Y-m-d H:i'),

                        // Pickup (from vendor)
                        'pickup_location'         => $vendor->name, // or registered pickup ID if needed
                        'pickup_address'          => $vendor->user_details->address,
                        'pickup_city'             => $vendor->user_details->city,
                        'pickup_state'            => $vendor->user_details->state,
                        'pickup_country'          => 'India',
                        'pickup_pincode'          => $pickupPincode,
                        'pickup_phone'            => $pickupPhone,

                        // Billing (admin account)
                        'billing_customer_name'   => "Admin Name",
                        'billing_last_name'     => '',
                        'billing_address'         => "Admin Address",
                        'billing_city'            => "Admin City",
                        'billing_state'           => "Admin State",
                        'billing_country'         => "India",
                        'billing_pincode'         => "110001",
                        'billing_email'           => "admin@example.com",
                        'billing_phone'          => $billingPhone,

                        // Shipping (customer)
                        'shipping_is_billing'     => false,
                        'shipping_customer_name'  => $deliveryUser->name,
                        'shipping_last_name'     => '',
                        'shipping_address'        => $deliveryAddress->address,
                        'shipping_city'           => $deliveryAddress->city,
                        'shipping_state'          => $deliveryAddress->state,
                        'shipping_country'        => $deliveryAddress->country,
                        'shipping_pincode'        => $deliveryAddress->pin,
                        'shipping_email'          => $deliveryUser->email ?? 'noreply@example.com',
                        'shipping_phone'          => $shippingPhone,

                        'order_items'             => $orderItems,
                        'payment_method'          => $order->payment_method == 'cod' ? 'COD' : 'Prepaid',
                        'sub_total'               => $vendorItems->sum('price'),
                        'length'                  => 10,
                        'breadth'                 => 10,
                        'height'                  => 10,
                        'weight'                  => $totalWeight,
                    ];

                    Log::info("Shiprocket order payload for vendor {$vendorId}:", $orderPayload);

                    // Create shipment via admin Shiprocket account
                    $shipmentResponse = $shiprocket->createOrder($orderPayload);
                    $shipmentId = $shipmentResponse['shipment_id'] ?? null;
                    if (!$shipmentId) {
                        Log::error("Shipment ID missing for vendor {$vendorId} in order {$order->id}", $shipmentResponse);
                        // continue; // skip updating items without shipment
                    }
                    // Update order items: shipment_id + status
                    foreach ($vendorItems as $item) {
                        $item->update([
                            'shiprocket_shipment_id' => $shipmentId ?? 'SHIP123456',
                            'status'                 => $newStatus
                        ]);
                    }

                    Log::info("Created Shiprocket shipment {$shipmentId} for vendor {$vendorId} in order {$order->id}");
                }

            } catch (\Exception $e) {
                Log::error("Shiprocket shipment creation failed for order {$order->id}: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create shipment: ' . $e->getMessage()
                ]);
            }
        } else {
            // If status is not "Processing", just update items status
            foreach ($order->items as $item) {
                $item->update(['status' => $newStatus]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Order items status updated successfully.',
            'status'  => $newStatus,
        ]);
    }
}
