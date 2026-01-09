<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\Order;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function list(Request $request)
    {
        $cartTotal = $this->getCartTotal();

        $coupons = Coupon::where('is_active', 1)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->when($request->search, function ($q) use ($request) {
                $q->where('code', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('frontend.partials.coupon-list', compact('coupons', 'cartTotal'));
    }



    private function getCartTotal()
    {
        $userId = auth()->id();

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

        return $total;
    }
public function apply(Request $request)
{
    $userId = auth()->id();
    $request->validate([
        'code' => 'required|string'
    ]);

    $coupon = Coupon::where('code', $request->code)->first();

    if (!$coupon) {
        return response()->json(['status' => false, 'message' => 'Invalid coupon code'], 422);
    }

    if (!$coupon->is_active) {
        return response()->json(['status' => false, 'message' => 'This coupon is no longer active'], 422);
    }

    if (session('applied_coupon') === $coupon->code) {
        return response()->json(['status' => false, 'message' => 'This coupon is already applied'], 422);
    }

    $now = now();
    if ($coupon->start_date && $now->lt($coupon->start_date)) {
        return response()->json(['status' => false, 'message' => 'This coupon is not available yet'], 422);
    }
    if ($coupon->end_date && $now->gt($coupon->end_date)) {
        return response()->json(['status' => false, 'message' => 'This coupon has expired'], 422);
    }

    $cartTotal = $this->getCartTotal();

    if ($coupon->min_cart_amount && $cartTotal < $coupon->min_cart_amount) {
        return response()->json([
            'status' => false,
            'message' => 'Add ₹' . number_format($coupon->min_cart_amount - $cartTotal, 2) . ' more to apply this coupon'
        ], 422);
    }

    if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
        return response()->json(['status' => false, 'message' => 'This coupon usage limit has been reached'], 422);
    }

    if ($coupon->usage_per_user !== null) {
        $userUsage = CouponUser::where('user_id', $userId)
            ->where('coupon_id', $coupon->id)
            ->count();
        if ($userUsage >= $coupon->usage_per_user) {
            return response()->json(['status' => false, 'message' => 'You have already used this coupon'], 422);
        }
    }

    // ✅ Apply coupon
    session(['applied_coupon' => $coupon->code]);

    // 🛒 Cart calculation
    $cartItems = Cart::with('item')->where('user_id', $userId)->get();
    $subtotal = 0;

    foreach ($cartItems as $item) {
        $price = (float)($item->item->price ?? 0);
        $qty   = (int)($item->quantity ?? 1);
        $subtotal += $price * $qty;
    }

    $discount = 0; // normal discount if any
    $tax = 0;      // tax if any
    $couponDiscount = 0;

    // 🔹 Decimal-safe coupon calculation
    switch ($coupon->discount_type) {
        case 'flat':
            $couponDiscount = min((float)$coupon->discount_value, $subtotal);
            break;

        case 'percentage':
            $couponDiscount = ($subtotal * (float)$coupon->discount_value) / 100;
            break;

        case 'free_delivery':
            $couponDiscount = 0; // handle shipping separately
            break;

        default:
            $couponDiscount = 0;
            break;
    }

    $total = max(0.0, $subtotal - $discount - $couponDiscount + $tax);

    $paymentSummary = [
        'subtotal'       => $subtotal,
        'discount'       => $discount,
        'couponDiscount' => $couponDiscount,
        'tax'            => $tax,
        'total'          => $total,
    ];

    return response()->json([
        'status'          => true,
        'message'         => 'Coupon applied successfully',
        'data'            => $coupon->toArray(),
        'paymentSummary'  => $paymentSummary
    ]);
}



    public function remove()
    {
        session()->forget('applied_coupon');

        $userId = auth()->id();

        $cartItems = Cart::with('item')
            ->where('user_id', $userId)
            ->get();

        $subtotal = 0;

        foreach ($cartItems as $item) {
            $price = $item->item->price ?? 0;
            $qty = $item->quantity ?? 1;
            $subtotal += ($price * $qty);
        }

        $discount = 0;
        $tax = 0;

        $total = max(0, $subtotal - $discount + $tax);

        // 🔢 Cart total count
        $totalCount = $cartItems->sum('quantity');

        $payment = [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
        ];

        return response()->json([
            'status' => true,
            'payment'=> $payment,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
