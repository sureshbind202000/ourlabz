<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AbdmHelper
{
    public static function getAccessToken()
    {
        // Check if token exists in cache
        if (Cache::has('abdm_token')) {
            return Cache::get('abdm_token');
        }

        // Otherwise, request a new token
        $response = Http::withHeaders([
    'Content-Type' => 'application/json',
    'Accept' => 'application/json',
    'User-Agent' => 'OurLabz-ABDM-Sandbox-Client/1.0',
])->post(env('ABDM_GATEWAY_BASE') . '/gateway/v0.5/sessions', [
    'clientId' => env('ABDM_BRIDGE_ID'),
    'clientSecret' => env('ABDM_CLIENT_SECRET'),
]);

        if (!$response->successful()) {
            \Log::error('ABDM token API failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }

        $data = $response->json();

        if (!isset($data['accessToken'])) {
            throw new \Exception('Failed to get ABDM token');
        }

        // Store token in cache for 19 minutes (ABDM tokens expire in 20)
        Cache::put('abdm_token', $data['accessToken'], now()->addMinutes(19));

        return $data['accessToken'];
    }
}
