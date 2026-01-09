<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    // List
    public function paymentMethod()
    {
        return view('frontend.user.payment_method');
    }

    public function paymentMethodShow()
    {
        $methods = PaymentMethod::where('user_id', auth()->user()->id)->get();
        return response()->json($methods);
    }

    // Store Method
    public function paymentMethodStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'card_no' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvv' => 'required',
        ]);

        $method = PaymentMethod::create([
            'user_id' => auth()->id(),
            'name' => ucwords($request->name),
            'card_no' => $request->card_no,
            'exp_month' => $request->exp_month,
            'exp_year' => $request->exp_year,
            'cvv' => $request->cvv,
        ]);

        return response()->json($method);
    }

    public function paymentMethodUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'card_no' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvv' => 'required',
        ]);

        $method = PaymentMethod::where('user_id',auth()->user()->id)->first();
        $method->update($request->all());

        return response()->json($method);
    }
}
