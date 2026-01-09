<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /* Show all coupons page */
    public function index()
    {
        return view('backend.superadmin.coupon.index');
    }

    /* For Datatable / Ajax listing */
    public function list()
    {
        $coupons = Coupon::latest()->get();

        return response()->json([
            'data' => $coupons
        ]);
    }

    /* Store Coupon */
    public function store(Request $request)
    {
        $request->validate([
            'code'            => 'required|unique:coupons,code',
            'discount_type'   => 'required|in:flat,percentage,buy_get',
            'discount_value'  => 'nullable|numeric',
            'max_discount'    => 'nullable|numeric',
            'min_cart_amount' => 'nullable|numeric',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'usage_limit'     => 'nullable|integer',
            'usage_per_user'  => 'nullable|integer',
        ]);

        Coupon::create([
            'code'              => $request->code,
            'title'             => $request->title,
            'discount_type'     => $request->discount_type,
            'discount_value'    => $request->discount_value,
            'max_discount'      => $request->max_discount,
            'buy_qty'           => $request->buy_qty,
            'get_qty'           => $request->get_qty,
            'get_item_id'       => $request->get_item_id,
            'get_item_model'    => $request->get_item_model,
            'min_cart_amount'   => $request->min_cart_amount,
            'applicable_categories' => $request->applicable_categories ?? [],
            'applicable_products'   => $request->applicable_products ?? [],
            'for_lab_tests'         => $request->for_lab_tests ? 1 : 0,
            'for_products'          => $request->for_products ? 1 : 0,
            'usage_limit'       => $request->usage_limit,
            'usage_per_user'    => $request->usage_per_user,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'is_active'         => $request->is_active ? 1 : 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Coupon created successfully']);
    }

    /* Edit Coupon */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return response()->json([
            'coupon' => $coupon
        ]);
    }

    /* Update Coupon */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code'            => 'required|unique:coupons,code,' . $coupon->id,
            'discount_type'   => 'required|in:flat,percentage,buy_get',
            'discount_value'  => 'nullable|numeric',
            'max_discount'    => 'nullable|numeric',
            'min_cart_amount' => 'nullable|numeric',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'usage_limit'     => 'nullable|integer',
            'usage_per_user'  => 'nullable|integer',
        ]);

        $coupon->update([
            'code'              => $request->code,
            'title'             => $request->title,
            'discount_type'     => $request->discount_type,
            'discount_value'    => $request->discount_value,
            'max_discount'      => $request->max_discount,
            'buy_qty'           => $request->buy_qty,
            'get_qty'           => $request->get_qty,
            'get_item_id'       => $request->get_item_id,
            'get_item_model'    => $request->get_item_model,
            'min_cart_amount'   => $request->min_cart_amount,
            'applicable_categories' => $request->applicable_categories ?? [],
            'applicable_products'   => $request->applicable_products ?? [],
            'for_lab_tests'     => $request->for_lab_tests ? 1 : 0,
            'for_products'      => $request->for_products ? 1 : 0,
            'usage_limit'       => $request->usage_limit,
            'usage_per_user'    => $request->usage_per_user,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'is_active'         => $request->is_active ? 1 : 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Coupon updated successfully']);
    }

    /* Delete Coupon */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Coupon deleted successfully'
        ]);
    }


    public function status(Request $request)
    {
        $coupon = Coupon::findOrFail($request->id);
        $coupon->is_active = $request->status;
        $coupon->save();

        return response()->json(['success' => true, 'message' => 'Status updated']);
    }
}
