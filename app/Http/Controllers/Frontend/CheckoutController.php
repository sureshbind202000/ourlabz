<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BookingPatient;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\package;
use App\Models\Product;
use App\Models\Schedule;
use App\Models\UserAddress;
use App\Services\ShiprocketService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{

    public function checkout()
    {
        $items = [];
        $subtotal = 0;
        $discount = 0;
        $tax = 0;
        $total = 0;


        if (Auth::check()) {

            $cartItems = Cart::with([
                'item' => function ($morphTo) {
                    $morphTo->morphWith([
                        package::class => ['categoryDetails'],
                    ]);
                }
            ])
                ->where('user_id', Auth::id())
                ->where('item_type', package::class)
                ->get();

            foreach ($cartItems as $cartItem) {

                $package = $cartItem->item;
                if (!$package)
                    continue;

                $qty = $cartItem->quantity ?? 1;
                $price = $package->price ?? 0;
                $lineTotal = $qty * $price;

                $subtotal += $lineTotal;

                $items[] = [
                    'item' => $package,
                    'quantity' => $qty,
                    'type' => 'package',
                    'line_total' => $lineTotal,
                    'is_prescription' => (int) ($package->is_prescription ?? 0),
                ];
            }
        } else {

            $cart = Session::get('cart', []);

            foreach ($cart as $entry) {

                if (($entry['item_type'] ?? null) !== package::class)
                    continue;

                $model = package::with('categoryDetails')->find($entry['item_id']);
                if (!$model)
                    continue;

                $qty = $entry['quantity'] ?? 1;
                $price = $model->price ?? 0;
                $lineTotal = $qty * $price;

                $subtotal += $lineTotal;

                $items[] = [
                    'item' => $model,
                    'quantity' => $qty,
                    'type' => 'package',
                    'line_total' => $lineTotal,
                    'is_prescription' => (int) ($model->is_prescription ?? 0),
                ];
            }
        }


        $discount = 0;
        $tax = 0;
        $total = max(0, $subtotal - $discount + $tax);


        $pendingPatients = [];

        if (Auth::check()) {
            $pendingPatients = BookingPatient::where('user_id', Auth::id())
                ->where('booking_id', null)
                ->get()
                ->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'name' => $p->name,
                        'gender' => $p->gender,
                        'phone' => $p->phone,
                        'email' => $p->email,
                        'dob' => $p->dob,
                        'age' => $p->age,
                        'relation' => $p->relation,
                        'prescription' => $p->prescription,
                    ];
                })
                ->toArray();
        }


        $packages = collect($items)->map(function ($itemData) use ($pendingPatients) {

            $item = $itemData['item'];

            return [
                'id' => $item->id,
                'package_id' => $item->package_id,
                'name' => $item->name,
                'price' => $item->price,
                'slug' => $item->slug,
                'is_prescription' => (int) ($item->is_prescription ?? 0),
                'quantity' => $itemData['quantity'],
                'patients' => $pendingPatients, // 🔥 booking_patients data
            ];
        })->toArray();

        $patientPackages = [];

        if (Auth::check()) {

            foreach ($pendingPatients as $patient) {

                $patientId = $patient['id'];

                $patientData = $patient;
                $patientData['packages'] = [];

                foreach ($cartItems as $cartItem) {

                    $package = $cartItem->item;
                    if (!$package)
                        continue;

                    $patientIds = $cartItem->patients_id;

                    if (!is_array($patientIds)) {
                        $patientIds = [$patientIds];
                    }

                    if (in_array($patientId, $patientIds)) {

                        $patientData['packages'][] = [
                            'id' => $package->id,
                            'package_id' => $package->package_id,
                            'name' => $package->name,
                            'price' => $package->price,
                            'slug' => $package->slug,
                            'is_prescription' => (int) ($package->is_prescription ?? 0),
                        ];
                    }
                }


                // ✅ ALWAYS push patient
                $patientPackages[] = $patientData;
            }
        }

        $hasPatients = count($pendingPatients) > 0;

        $appliedCoupon = null;
        $couponDiscount = 0;
        if (session()->has('applied_coupon')) {
            $appliedCoupon = Coupon::where('code', session('applied_coupon'))->first();


            if (
                !$appliedCoupon ||
                ($appliedCoupon->end_date && now()->gt($appliedCoupon->end_date))
            ) {
                session()->forget('applied_coupon');
                $appliedCoupon = null;
            }
        }

        if ($appliedCoupon) {
            $couponDiscount = $this->calculateCouponDiscount($appliedCoupon, $subtotal);
        }

        $total = max(
            0,
            $subtotal - $discount - $couponDiscount + $tax
        );


        return view(
            'frontend.checkout.lab_checkout',
            compact('items', 'subtotal', 'discount', 'tax', 'total', 'couponDiscount', 'packages', 'pendingPatients', 'patientPackages', 'hasPatients', 'appliedCoupon')
        );
    }


    private function calculateCouponDiscount($coupon, $subtotal)
    {
        if (!$coupon) {
            return 0;
        }

        switch ($coupon->discount_type) {
            case 'flat':
                return min((float) $coupon->discount_value, $subtotal);

            case 'percentage':
                return ($subtotal * (float) $coupon->discount_value) / 100;

            case 'free_delivery':
                return 0;

            default:
                return 0;
        }
    }


    public function productCheckout()
    {

        $shiprocket = new ShiprocketService();
        $items = [];
        $subtotal = 0;
        $totalShipping = 0;
        $discount = 0;
        $tax = 0;
        $total = 0;

        if (Auth::check()) {
            $cartItems = Cart::with([
                'item' => function ($morphTo) {
                    $morphTo->morphWith([
                        Product::class => ['productType', 'productCategory', 'productSubCategory', 'images'],
                    ]);
                }
            ])
                ->where('user_id', Auth::id())
                ->where('item_type', Product::class)
                ->get();

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->item;
                if (!$product)
                    continue;

                $price = $product->selling_price ?? 0;
                $qty = $cartItem->quantity ?? 1;
                $lineTotal = $price * $qty;
                $subtotal += $lineTotal;

                $items[] = [
                    'item' => $product,
                    'quantity' => $qty,
                    'type' => 'Product',
                    'line_total' => $lineTotal,
                    'vendor_id' => $product->vendor_id ?? null,
                    'product_id' => $product->product_id,
                ];
            }
        } else {
            $cart = Session::get('cart', []);

            foreach ($cart as $entry) {
                if (!isset($entry['item_type']) || $entry['item_type'] !== Product::class) {
                    continue;
                }

                $model = Product::with('productType', 'productCategory', 'productSubCategory', 'images')->find($entry['item_id']);

                if (!$model)
                    continue;

                $qty = $entry['quantity'] ?? 1;
                $price = $model->price ?? 0;
                $lineTotal = $price * $qty;
                $subtotal += $lineTotal;

                $items[] = [
                    'item' => $model,
                    'quantity' => $qty,
                    'type' => 'Product',
                    'line_total' => $lineTotal,
                    'vendor_id' => $model->vendor_id ?? null,
                    'product_id' => $model->product_id,
                ];
            }
        }

        // Apply flat discount and tax (replace with logic if needed)
        $discount = 0;
        $tax = 0;

        $total = max(0, $subtotal - $discount + $tax + $totalShipping);

        return view('frontend.checkout.product_checkout', compact('items', 'subtotal', 'discount', 'tax', 'total', 'totalShipping'));
    }

    public function calculateShipping(Request $request)
    {
        $address = UserAddress::find($request->address_id);
        if (!$address) {
            return response()->json(['error' => 'Address not found'], 404);
        }

        $deliveryPincode = $address->pin;
        $shiprocket = new ShiprocketService();

        $cartItems = Cart::with('item.vendor.user_details')
            ->where('user_id', Auth::id())
            ->where('item_type', Product::class)
            ->get();

        $subtotal = 0;
        $totalShipping = 0;
        $vendorGroups = [];

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->item;
            if (!$product)
                continue;

            $qty = $cartItem->quantity ?? 1;
            $price = $product->selling_price ?? 0;
            $subtotal += $price * $qty;

            if ($product->vendor_id) {
                $vendorGroups[$product->vendor_id][] = [
                    'weight' => $product->weight ?? 0.5,
                    'quantity' => $qty,
                    'pickupPincode' => $product->vendor->user_details->pin ?? '0'
                ];
            }
        }

        foreach ($vendorGroups as $vendorId => $products) {
            $totalWeight = 0;
            $pickupPincode = '0';
            foreach ($products as $p) {
                $totalWeight += $p['weight'] * $p['quantity'];
                $pickupPincode = $p['pickupPincode'];
            }

            try {
                $shipping = $shiprocket->getShippingRate($pickupPincode, $deliveryPincode, $totalWeight);
            } catch (\Exception $e) {
                Log::error("Shiprocket error vendor $vendorId: " . $e->getMessage());
                $shipping = 0;
            }

            $totalShipping += $shipping;
        }

        $total = $subtotal + $totalShipping;

        return response()->json([
            'totalShipping' => $totalShipping,
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }


    public function storePatient(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'gender' => 'required',
            'phone' => 'required',
            'dob' => 'required|date',
            'relation' => 'required',
            'age' => 'required|integer',
        ]);

        // 1️⃣ Create new patient
        $patient = BookingPatient::create([
            'user_id' => Auth::id(),
            'booking_id' => null,
            'name' => $request->name,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
            'dob' => $request->dob,
            'age' => $request->age,
            'relation' => $request->relation,
            'prescription' => $request->prescription, // base64
        ]);

        // 2️⃣ Get all cart items for the user
        $cartItems = Cart::with('item')->where('user_id', Auth::id())->get();

        // 3️⃣ Merge new patient ID into each cart item
        foreach ($cartItems as $cartItem) {
            $existing = [];

            if ($cartItem->patients_id) {
                if (is_array($cartItem->patients_id)) {
                    $existing = $cartItem->patients_id;
                } else {
                    $existing = json_decode($cartItem->patients_id, true) ?: [];
                }
            }

            $existing[] = $patient->id;
            $cartItem->patients_id = array_values(array_unique($existing));

            // ✅ Add patient id if not exists
            if (!in_array($patient->id, $existing)) {
                $existing[] = $patient->id;
            }

            // ✅ Store patients
            $cartItem->patients_id = array_values($existing);

            // ✅ Quantity = number of patients
            $cartItem->quantity = count($existing);
            $cartItem->save();
        }

        // 4️⃣ Prepare patient array with assigned packages
        $patientPackages = [
            'id' => $patient->id,
            'name' => $patient->name,
            'gender' => $patient->gender,
            'phone' => $patient->phone,
            'email' => $patient->email,
            'dob' => $patient->dob,
            'age' => $patient->age,
            'relation' => $patient->relation,
            'prescription' => $patient->prescription,
            'packages' => [],
        ];

        foreach ($cartItems as $cartItem) {
            $package = $cartItem->item;
            if (!$package)
                continue;

            $patientIds = $cartItem->patients_id;
            if (!is_array($patientIds))
                $patientIds = [$patientIds];

            // Only add packages assigned to this patient
            if (in_array($patient->id, $patientIds)) {
                $patientPackages['packages'][] = [
                    'id' => $package->id,
                    'package_id' => $package->package_id,
                    'name' => $package->name,
                    'price' => $package->price,
                    'slug' => $package->slug,
                    'is_prescription' => (int) ($package->is_prescription ?? 0),
                ];
            }
        }

        $subtotal = 0;

        foreach ($cartItems as $item) {
            $price = $item->item->price ?? 0;
            $qty = $item->quantity ?? 1;
            $subtotal += ($price * $qty);
        }

        $discount = 0; // 👈 future logic
        $tax = 0;      // 👈 future logic

        $total = max(0, $subtotal - $discount + $tax);

        // 🔢 Cart total count
        $totalCount = $cartItems->sum('quantity');
        // dd($patientPackages);
        // exit();
        // 5️⃣ Return patient with packages under 'patient' key
        return response()->json([
            'status' => true,
            'patient' => $patientPackages,  // ✅ exactly like your example
            'total_count' => $totalCount,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
        ]);
    }

    public function destroy($id)
    {
        try {
            $patient = BookingPatient::findOrFail($id);
            $patient->delete();
            // 2️⃣ Get all cart items of logged-in user
            $cartItems = Cart::where('user_id', auth()->id())->get();

            foreach ($cartItems as $cartItem) {

                if (!$cartItem->patients_id) {
                    continue;
                }

                // 3️⃣ Decode patients_id safely
                $patients = is_array($cartItem->patients_id)
                    ? $cartItem->patients_id
                    : json_decode($cartItem->patients_id, true);

                if (!is_array($patients)) {
                    $patients = [];
                }

                // 4️⃣ Remove ONLY deleted patient id
                $patients = array_values(array_diff($patients, [$id]));

                // 5️⃣ Update cart
                if (count($patients) === 0) {
                    // ❌ No patient left → remove cart item
                    $cartItem->patients_id = $patients;
                    $cartItem->quantity = count($patients);
                    $cartItem->save();
                    // $cartItem->delete();
                } else {
                    // ✅ Update patients & quantity
                    $cartItem->patients_id = $patients;
                    $cartItem->quantity = count($patients);
                    $cartItem->save();
                }
            }

            $subtotal = 0;

            foreach ($cartItems as $item) {
                $price = $item->item->price ?? 0;
                $qty = $item->quantity ?? 1;
                $subtotal += ($price * $qty);
            }

            $discount = 0; // 👈 future logic
            $tax = 0;      // 👈 future logic

            // $total = max(0, $subtotal - $discount + $tax);

            $appliedCouponCode = session('applied_coupon');
            $couponDiscount = 0;
            $is_coupon = false;
            if ($appliedCouponCode) {
                $coupon = Coupon::where('code', $appliedCouponCode)->first();
                $is_coupon = true;
                if ($coupon && $coupon->min_cart_amount > $subtotal) {
                    session()->forget('applied_coupon');
                    $is_coupon = false;
                } else {
                    if ($appliedCouponCode) {
                        $couponDiscount = $this->calculateCouponDiscount($coupon, $subtotal);
                    }
                }

            }

            $total = max(
                0,
                $subtotal - $discount - $couponDiscount + $tax
            );

            // 🔢 Cart total count
            $totalCount = $cartItems->sum('quantity');
            $remainingPatients = BookingPatient::where('user_id', auth()->id())
                ->whereNull('booking_id')
                ->count();
            return response()->json([
                'status' => true,
                'patient_id' => $id,
                'message' => 'Patient deleted successfully',
                'total_count' => $totalCount,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'couponDiscount' => $couponDiscount,
                'isCoupon' => $is_coupon,
                'hasPatients' => $remainingPatients > 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete patient',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        // exit();
        if ($request->hasFile('prescription')) {
            foreach ($request->file('prescription') as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/prescriptions'), $name);
            }
        }
        $patient = BookingPatient::findOrFail($id);
        $patient->update($request->only(['name', 'gender', 'phone', 'email', 'dob', 'age', 'relation', 'prescription']));

        return response()->json(['status' => true, 'patient' => $patient]);
    }

    public function getPatientTest($pid)
    {
        $userId = auth()->id();
        $subtotal = 0;
        $items = [];

        // ✅ Sirf is patient ki cart items
        $cartItems = Cart::with([
            'item' => function ($morphTo) {
                $morphTo->morphWith([
                    package::class => ['categoryDetails'],
                ]);
            }
        ])
            ->where('user_id', $userId)
            ->whereJsonContains('patients_id', (int) $pid) // ✅ Ye sahi hai
            ->where('item_type', package::class)
            ->get();

        foreach ($cartItems as $cartItem) {
            $package = $cartItem->item;
            if (!$package)
                continue;

            $qty = $cartItem->quantity ?? 1;
            $price = $package->price ?? 0;
            $lineTotal = $qty * $price;

            $subtotal += $lineTotal;

            $items[] = [
                'id' => $package->id,
                'package_id' => $package->package_id,
                'name' => $package->name,
                'slug' => $package->slug,
                'price' => $price,
                'quantity' => $qty,
                'line_total' => $lineTotal,
                'type' => 'package',
                'is_prescription' => (int) ($package->is_prescription ?? 0),
            ];
        }


        $discount = 0;
        $tax = 0;
        $total = max(0, $subtotal - $discount + $tax);

        // ✅ Sirf is patient ki cart count
        $totalCount = $cartItems->sum('quantity');

        return response()->json([
            'packages' => $items,
            'id' => $pid,
            'total_count' => $totalCount,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
        ]);
    }

    public function removePackage(Request $request)
    {
        $request->validate([
            'package_id' => 'required',
            'patient_id' => 'required'
        ]);
        $userId = auth()->id();
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('item_id', $request->package_id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ]);
        }

        // Decode patients
        $patients = is_array($cartItem->patients_id)
            ? $cartItem->patients_id
            : json_decode($cartItem->patients_id, true);

        if (!is_array($patients)) {
            $patients = [];
        }

        // ❌ Remove only this patient
        $patients = array_values(array_diff($patients, [$request->patient_id]));

        if (count($patients) === 0) {
            // 🧹 No patient left → delete cart row
            $cartItem->delete();
        } else {
            $cartItem->patients_id = $patients;
            $cartItem->quantity = count($patients);
            $cartItem->save();
        }


        // ===============================
        // 🔢 RE-CALCULATE TOTALS
        // ===============================

        $cartItems = Cart::with('item')
            ->where('user_id', $userId)
            ->get();

        $subtotal = 0;

        foreach ($cartItems as $item) {
            $price = $item->item->price ?? 0;
            $qty = $item->quantity ?? 1;
            $subtotal += ($price * $qty);
        }

        $discount = 0; // 👈 future logic
        $tax = 0;      // 👈 future logic

        $total = max(0, $subtotal - $discount + $tax);

        // 🔢 Cart total count
        $totalCount = $cartItems->sum('quantity');

        $appliedCouponCode = session('applied_coupon');
        $couponDiscount = 0;
        $is_coupon = false;
        if ($appliedCouponCode) {
            $coupon = Coupon::where('code', $appliedCouponCode)->first();
            $is_coupon = true;
            if ($coupon && $coupon->min_cart_amount > $subtotal) {
                session()->forget('applied_coupon');
                $is_coupon = false;
            } else {
                if ($appliedCouponCode) {
                    $couponDiscount = $this->calculateCouponDiscount($coupon, $subtotal);
                }
            }

        }

        $total = max(
            0,
            $subtotal - $discount - $couponDiscount + $tax
        );

        return response()->json([
            'status' => true,
            'message' => 'Package removed for patient',
            'total_count' => $totalCount,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'couponDiscount' => $couponDiscount,
            'tax' => $tax,
            'total' => $total,
            'isCoupon' => $is_coupon,
        ]);
    }



    public function checkSlotAvailability(Request $request)
    {
        $scheduler_id = $request->input('scheduler_id');
        $date = $request->input('date');
        $time12h = $request->input('time'); // e.g., 07:00 PM

        // Convert 12-hour time to 24-hour format
        $time24h = \Carbon\Carbon::createFromFormat('h:i A', $time12h)->format('H:i:s');

        $slotDateTime = \Carbon\Carbon::parse("$date $time24h");
        $now = \Carbon\Carbon::now();

        // Check if the slot is booked
        $slot = Schedule::where('scheduler_id', $scheduler_id)
            ->whereDate('date', $date)
            ->where('from_time', '<=', $time24h)
            ->where('to_time', '>', $time24h)
            ->where('status', 1) // available
            ->first();

        if (!$slot) {
            return response()->json([
                'available' => false,
                'message' => 'This slot has already been booked. Please choose another time.'
            ]);
        }

        // Check if the slot time is already passed
        if ($slotDateTime->isPast()) {
            return response()->json([
                'available' => false,
                'message' => 'This slot has already passed. Please choose an available time.'
            ]);
        }

        return response()->json([
            'available' => true
        ]);
    }
}
