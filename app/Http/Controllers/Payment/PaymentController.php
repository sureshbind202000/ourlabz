<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\DoctorConsultation;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        // dd($request);
        // exit();
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|string'
        ]);

        $amount = (int) round($request->amount * 100); 
        $orderType = $request->type;

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $razorpayOrder = $api->order->create([
            'receipt' => 'order_rcpt_' . time(),
            'amount' => $amount,
            'currency' => 'INR',
        ]);

        return response()->json([
            'order_id' => $razorpayOrder['id'],
            'amount' => $amount,
            'currency' => 'INR',
            'type' => $orderType
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'type' => 'required|string'
        ]);

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        try {
            // Verify payment signature
            $api->utility->verifyPaymentSignature($attributes);

            // Payment verified successfully
            // Call your existing order creation logic here
            if ($request->type === 'product') {
                // Instead of creating a simple order here, 
                // send a signal to frontend to call your /checkout/store route
                return response()->json([
                    'success' => true,
                    'message' => 'Payment successful. Place order next.'
                ]);
            } elseif ($request->type === 'test') {
                // Booking::where('id', $request->booking_id)->update([
                //     'payment_id' => $request->razorpay_payment_id,
                //     'status' => 'paid'
                // ]);
                 return response()->json([
                    'success' => true,
                    'message' => 'Payment successful. Place order next.'
                ]);
            } elseif ($request->type === 'doctor') {
                DoctorConsultation::where('id', $request->booking_id)->update([
                    'payment_id' => $request->razorpay_payment_id,
                    'status' => 'paid'
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
