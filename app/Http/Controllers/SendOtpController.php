<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\Cart;
use App\Models\Otp;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\SmsService;

class SendOtpController extends Controller
{
    // Send OTP
    public function sendOtp(Request $request)
    {
        $otp = rand(100000, 999999);

        $request->validate([
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $phone = preg_replace('/\D/', '', $request->phone);

        if (strlen($phone) === 10) {
            $phone = '91' . $phone;
        } elseif (strlen($phone) === 12 && substr($phone, 0, 2) === '91') {
        } else {
            return response()->json(['error' => 'Invalid phone number format'], 422);
        }

        $email = trim($request->email);

        Otp::updateOrCreate(
            ['email' => $email],
            [
                'phone' => $phone,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10)
            ]
        );

        $smsService = new SmsService();

        $smsSent = $smsService->sendSms($phone, [
            'otp' => $otp,
        ], 'login_otp');

        if (!$smsSent) {
            return response()->json(['error' => 'Failed to send OTP. Please try again.'], 500);
        }


        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'otp' => 'required'
        ]);

        $phone = preg_replace('/\D/', '', $request->phone);

        if (strlen($phone) === 10) {
            $phone = '91' . $phone;
        } elseif (strlen($phone) === 12 && substr($phone, 0, 2) === '91') {
        } else {
            return response()->json(['error' => 'Invalid phone number format'], 422);
        }

        $otpRecord = Otp::where('phone', $phone)
            ->where('otp', $request->otp)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$otpRecord) {
            return response()->json(['error' => 'Invalid or expired OTP'], 422);
        }

        $otpRecord->delete();

        return response()->json(['message' => 'OTP verified']);
    }

    // Login OTP
    public function sendLoginOtp(Request $request, SmsService $smsService)
    {
        $request->validate([
            'name' => ['required', 'regex:/^[A-Za-z\s]{3,}$/'],
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
        ]);

        $otp = rand(100000, 999999);

        Otp::updateOrCreate(
            ['phone' => $request->phone],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10)
            ]
        );

        $smsService = new SmsService();

        $smsSent = $smsService->sendSms($request->phone, [
            'otp' => $otp,
        ], 'login_otp');

        if (!$smsSent) {
            return response()->json(['error' => 'Failed to send OTP. Please try again.'], 500);
        }

        // For testing purposes only — remove 'otp' in production
        return response()->json([
            'message' => 'OTP sent successfully',
            'otp' => $otp
        ]);
    }

    public function verifyLoginOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required'
        ]);

        $otpRecord = Otp::where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('expires_at', '>=', now())
            ->first();

        if (!$otpRecord) {
            return response()->json(['error' => 'Invalid or expired OTP'], 422);
        }
        $isNewUser = false;
        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            $isNewUser = true;
            // User Id
            do {
                $user_id = 'PT' . rand(100000, 999999);
            } while (User::where('user_id', $user_id)->exists());

            // Username
            do {
                $username = 'User' . rand(100000, 999999);
            } while (User::where('username', $username)->exists());

            // Create user
            $user = User::create([
                'user_id' => $user_id,
                'name' => $request->name ?? 'User',
                'phone' => $request->phone,
                'email' => $username . '@example.com',
                'role' => 1,
                'username' => $username,
                'password' => Hash::make($username),
                'show_password' => $username,
            ]);
        }

        Auth::login($user);

        $token = $user->createToken('user_token')->plainTextToken;

        if (session()->has('selected_city') && empty($user->location)) {
            $user->location = session('selected_city');
            $user->save();
        }

        $this->mergeSessionCartToDatabase($user);

        $this->mergeSessionWishlistToDatabase($user);

        $otpRecord->delete();
        if ($isNewUser) {
            sendNotification(
                $user->id,
                'user-registration',
                [
                    'user_name' => $user->name,
                    'date'      => now()->format('d M Y'),
                ]
            );

            sendNotification(
                1,
                'user-registration-admin',
                [
                    'user_name' => $user->name,
                    'date'      => now()->format('d M Y'),
                ]
            );

            $smsService = new SmsService();

            $smsService->sendSms($user->phone, null, 'onboard');
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP verified',
            'redirect' => route('user.dashboard'),
            'auth_token' => $token
        ]);
    }

    private function mergeSessionCartToDatabase($user)
    {
        $sessionCart = session()->get('cart', []);

        foreach ($sessionCart as $entry) {
            if (!isset($entry['item_id'], $entry['item_type'], $entry['quantity'])) {
                continue;
            }

            Cart::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'item_id' => $entry['item_id'],
                    'item_type' => $entry['item_type'],
                ],
                [
                    'quantity' => $entry['quantity'],
                ]
            );
        }

        session()->forget('cart');
    }

    protected function mergeSessionWishlistToDatabase($user)
    {
        $wishlist = session()->get('wishlist', []);

        foreach ($wishlist as $productId) {
            $exists = Wishlist::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->exists();

            if (!$exists) {
                Wishlist::create([
                    'user_id' => $user->id,
                    'product_id' => $productId
                ]);
            }
        }

        session()->forget('wishlist');
    }
}
