<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Helpers\AbdmHelper;
use App\Modal\UserAbha;

class AbdmController extends Controller
{

    public function abhaIndex()
    {
        return view('frontend.user.abha_card');
    }

    public function registerHip()
    {
        try {
            $token = AbdmHelper::getAccessToken();

            $payload = [[
                "id" => env('ABDM_SERVICE_ID', 'OUR_LABZ_HIP_001'),
                "name" => env('ABDM_SERVICE_NAME', 'OurLabz HIP'),
                "type" => env('ABDM_SERVICE_TYPE', 'HIP'),
                "active" => true,
                "alias" => [env('ABDM_SERVICE_ALIAS', 'ourlabz')],
                "endpoints" => [[
                    "address" => env('ABDM_LAB_URL') . "/callback",
                    "connectionType" => "https",
                    "use" => "registration"
                ]]
            ]];

            $response = Http::withToken($token)
                ->post(env('ABDM_GATEWAY_BASE') . '/gateway/v1/bridges/addUpdateServices', $payload);

            if ($response->successful()) {
                return response()->json(['success' => true, 'data' => $response->json()]);
            }

            return response()->json([
                'success' => false,
                'message' => '❌ Failed to register HIP',
                'error' => $response->json()
            ], 400);
        } catch (\Exception $e) {
            Log::error('HIP Registration Failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }


    public function getServices()
    {
        $accessToken = AbdmHelper::getAccessToken();

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get(env('ABDM_GATEWAY_BASE') . '/gateway/v1/bridges/getServices');

        return $response->json();
    }

    public function updateBridgeUrl()
    {
        $accessToken = AbdmHelper::getAccessToken();

        $response = Http::withHeaders([
            'accept' => '*/*',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->patch(env('ABDM_GATEWAY_BASE') . '/gateway/v1/bridges', [
            'url' => env('ABDM_LAB_URL'),
        ]);

        return $response->json();
    }

    public function addService()
    {
        $accessToken = AbdmHelper::getAccessToken();

        $data = [[
            "id" => "OUR_LABZ_HIP_001",
            "name" => "OurLabz HIP",
            "type" => "HIP",
            "active" => true,
            "alias" => ["ourlabz"],
            "endpoints" => [
                [
                    "address" => env('ABDM_LAB_URL') . "/callback", // callback endpoint for ABDM notifications
                    "connectionType" => "https",
                    "use" => "registration"
                ]
            ]
        ]];

        $response = Http::withHeaders([
            'accept' => '*/*',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->post(env('ABDM_GATEWAY_BASE') . '/gateway/v1/bridges/addUpdateServices', $data);

        return $response->json();
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'abha_number' => 'nullable|string',
            'mobile' => 'nullable|string',
        ]);

        $token = AbdmHelper::getAccessToken();

        $payload = [
            "authMode" => "MOBILE_OTP",
            "purpose" => "LINK",
        ];

        if (!empty($request->mobile)) {
            $payload["loginHint"] = "MOBILE";
            $payload["loginHintValue"] = $request->mobile;
        } elseif (!empty($request->abha_number)) {
            $payload["healthid"] = $request->abha_number;
        } else {
            return response()->json(['error' => 'ABHA number or mobile is required'], 400);
        }

        $response = Http::withToken($token)
            ->post(env('ABDM_GATEWAY_BASE') . '/gateway/v0.5/users/auth/init', $payload);

        if ($response->successful()) {
            $txnId = $response->json('txnId');
            return response()->json(['success' => true, 'txnId' => $txnId]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to send OTP',
            'error' => $response->json()
        ], 400);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'txnId' => 'required|string',
            'otp' => 'required|string',
        ]);

        $token = AbdmHelper::getAccessToken();

        $payload = [
            'txnId' => $request->txnId,
            'otp' => $request->otp,
        ];

        $response = Http::withToken($token)
            ->post(env('ABDM_GATEWAY_BASE') . '/gateway/v0.5/users/auth/confirm', $payload);

        if ($response->successful()) {
            $data = $response->json();

            UserAbha::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'abha_number' => $data['abhaNumber'] ?? null,
                    'abha_address' => $data['healthId'] ?? null,
                    'health_id_number' => $data['healthIdNumber'] ?? null,
                    'status' => 'verified'
                ]
            );

            return response()->json(['success' => true, 'data' => $data]);
        }

        return response()->json([
            'success' => false,
            'message' => 'OTP verification failed',
            'error' => $response->json()
        ], 400);
    }
}
