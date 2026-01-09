<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTrackingStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Services\ShiprocketService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $validated = $request->validate([
            'address'       => 'required|integer',
            'subtotal'      => 'required|numeric',
            'discount'      => 'required|numeric',
            'tax'           => 'required|numeric',
            'total_amount'  => 'required|numeric',
        ]);

        $cartItems = Cart::where('user_id', $user->id)
            ->where('item_type', Product::class)
            ->with('item.vendor.user_details') // eager load vendor & details
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 422);
        }

        $shiprocket = new ShiprocketService();
        DB::beginTransaction();

        try {
            // Group cart items by vendor
            $groupedItems = $cartItems->groupBy(fn($item) => $item->item->vendor_id ?? 0);

            $freeShippingThreshold = 800;

            foreach ($groupedItems as $vendorId => $items) {

                // Calculate total shipping for this vendor
                $deliveryPincode = $user->user_details->pin ?? '226016';
                $pickupPincode = $items->first()->item->vendor->user_details->pin ?? '110001';
                $totalWeight = 0;

                foreach ($items as $cartItem) {
                    $totalWeight += ($cartItem->item->weight ?? 0.5) * ($cartItem->quantity ?? 1);
                }

                try {
                    $vendorShippingCost = $shiprocket->getShippingRate($pickupPincode, $deliveryPincode, $totalWeight);
                } catch (\Exception $e) {
                    Log::error("Shiprocket error for vendor $vendorId: " . $e->getMessage());
                    $vendorShippingCost = 0;
                }

                // Apply free shipping if subtotal meets threshold
                $vendorSubtotal = $items->sum(fn($i) => ($i->item->selling_price ?? 0) * ($i->quantity ?? 1));

                // if ($vendorSubtotal >= $freeShippingThreshold) {
                //     $vendorShippingCost = 0;
                // }

                // Create order
                $order = Order::create([
                    'order_number'   => $this->generateOrderNumber(),
                    'user_id'        => $user->id,
                    'vendor_id'      => $vendorId,
                    'address_id'     => $request->address,
                    'subtotal'       => $vendorSubtotal,
                    'discount'       => $request->discount,
                    'tax'            => $request->tax,
                    'shipping_cost'  => $vendorShippingCost,
                    'total'          => $vendorSubtotal - $request->discount + $request->tax + $vendorShippingCost,
                    'status'         => 'Confirmed',
                ]);

                // Create payment record
                Payment::create([
                    'type'           => 'Product',
                    'subtotal'       => $vendorSubtotal,
                    'coupon'         => $request->coupon ?? null,
                    'discount'       => $request->discount,
                    'discount_type'  => $request->discount_type ?? null,
                    'shipping'       => $vendorShippingCost,
                    'tax'            => $request->tax,
                    'total'          => $vendorSubtotal - $request->discount + $request->tax + $vendorShippingCost,
                    'order_id'       => $order->id,
                    'transaction_id' => $request->razorpay_payment_id ?? null,
                    'payment_status' => $request->payment_status,
                ]);

                // Distribute shipping cost per item
                $totalQty = $items->sum(fn($i) => $i->quantity ?? 1);
                $perItemShipping = $totalQty > 0 ? $vendorShippingCost / $totalQty : 0;

                foreach ($items as $cartItem) {
                    $product = $cartItem->item;
                    $qty = $cartItem->quantity ?? 1;
                    $price = $product->selling_price ?? 0;

                    OrderItem::create([
                        'order_id'       => $order->id,
                        'product_id'     => $product->id,
                        'vendor_id'      => $product->vendor_id ?? null,
                        'price'          => $price,
                        'quantity'       => $qty,
                        'total'          => $price * $qty,
                        'shipping_cost'  => $perItemShipping * $qty,
                    ]);
                }

                OrderTrackingStatus::create([
                    'order_id'   => $order->id,
                    'status'     => 'Ordered',
                    'title'      => 'Order Placed',
                    'updated_at' => now(),
                ]);
            }

            // After creating order, payment, and order items
            foreach ($groupedItems as $vendorId => $items) {
                $vendor = $items->first()->item->vendor;

                // --- send notification to Vendor ---
                sendNotification(
                    $vendor->id, // vendor user ID
                    'new-order-from-user', // notification type/key
                    [
                        'order_id'   => $order->order_number,
                        'user_name'  => $user->name,
                        'vendor_name'    => $vendor->name,
                        'total'      => $order->total,
                        'date'       => now()->format('d-m-Y / h:i A'),
                    ]
                );

                // --- send notification to User ---
                sendNotification(
                    $user->id, // customer/user ID
                    'order-placed-successfully', // notification type/key
                    [
                        'order_id'  => $order->order_number,
                        'user_name'  => $user->name,
                        'vendor_name'    => $vendor->name,
                        'total'     => $order->total,
                        'date'      => now()->format('d-m-Y / h:i A'),
                    ]
                );
            }

            // Clear cart
            Cart::where('user_id', $user->id)->where('item_type', 'App\Models\Product')->delete();

            DB::commit();

            $smsService = new SmsService();

            $smsService->sendSms($user->phone, [
                'user_name' => $user->name,
                'order_id' => $order->order_number
            ], 'order_placed');

            return response()->json([
                'status'  => 'success',
                'message' => 'Order placed successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Order failed: ' . $e->getMessage(),
            ], 500);
        }
    }


    private function generateOrderNumber()
    {
        $prefix = 'ORD' . now()->format('Ymd') . '-';
        $latest = Order::whereDate('created_at', today())->count() + 1;
        return $prefix . str_pad($latest, 4, '0', STR_PAD_LEFT); // e.g., ORD20250721-0001
    }

    private function generateTrackingId()
    {
        do {
            $tracking = 'TRK' . strtoupper(Str::random(8));
        } while (Order::where('tracking_id', $tracking)->exists());

        return $tracking;
    }

    public function cancelOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:order_items,id',
            'reason' => 'required|string|max:500',
        ]);

        $order = OrderItem::find($request->order_id);

        if ($order->status == 'Cancelled' || $order->status == 'Completed') {
            return response()->json(['message' => 'Order cannot be cancelled at this stage.'], 400);
        }

        $refundAmount = 0;
        $payment = Payment::where('type', 'Product')->where('order_id', $order->order_id)->first();
        if ($payment->payment_status == 'Paid') {
            $refundAmount = $order->total; // Full refund before Shipping
        }

        $order->update([
            'status' => 'Cancelled',
            'cancel_reason' => $request->reason,
            'cancelled_by' => auth()->id(),
            'cancelled_at' => now(),
            'refund_amount' => $refundAmount,
        ]);

        $user = Auth::user();
        $vendor = User::find($order->vendor_id);
        $main_order = Order::find($order->order_id);

        sendNotification(
            $user->id, // customer/user ID
            'order-cancelled-successfully', // notification type/key
            [
                'order_id'  => $main_order->order_number,
                'user_name'  => $user->name,
                'vendor_name'    => $vendor->name,
                'total'     => $order->total,
                'date'      => now()->format('d-m-Y / h:i A'),
            ]
        );

        sendNotification(
            $vendor->id, // customer/user ID
            'order-cancelled-successfully-vendor', // notification type/key
            [
                'order_id'  => $main_order->order_number,
                'user_name'  => $user->name,
                'vendor_name'    => $vendor->name,
                'total'     => $order->total,
                'date'      => now()->format('d-m-Y / h:i A'),
            ]
        );

        return response()->json(['message' => 'Order cancelled successfully.']);
    }
}
