<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ShiprocketService
{
    protected $baseUrl;
    protected $email;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = 'https://apiv2.shiprocket.in/v1/external';
        $this->email = env('SHIPROCKET_EMAIL');
        $this->password = env('SHIPROCKET_PASSWORD');
    }

    /**
     * Get Shiprocket Auth Token and cache it
     */
    public function getToken()
    {
        if (Cache::has('shiprocket_token')) {
            return Cache::get('shiprocket_token');
        }

        $response = Http::post("{$this->baseUrl}/auth/login", [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($response->failed()) {
            throw new \Exception('Shiprocket authentication failed: ' . $response->body());
        }

        $token = $response->json()['token'] ?? null;

        if ($token) {
            // Cache token for 9 hours (Shiprocket token is valid ~10 hours)
            Cache::put('shiprocket_token', $token, now()->addHours(9));
        }

        return $token;
    }

    /**
     * Get Shipping Rate (lowest available courier)
     *
     * @param string $pickupPincode
     * @param string $deliveryPincode
     * @param float $weight
     * @return float
     */
    public function getShippingRate($pickupPincode, $deliveryPincode, $weight = 0.5)
    {
        $token = $this->getToken();

        $response = Http::withToken($token)
            ->get("{$this->baseUrl}/courier/serviceability/", [
                'pickup_postcode' => $pickupPincode,
                'delivery_postcode' => $deliveryPincode,
                'weight' => $weight,
                'cod' => 0, // 0 = prepaid, 1 = COD
            ]);

        if ($response->successful()) {
            $data = $response->json();

            if (!empty($data['data']['available_courier_companies'])) {
                // Return the lowest rate courier
                $lowest = collect($data['data']['available_courier_companies'])->sortBy('rate')->first();
                return $lowest['rate'] ?? 0;
            }
        }

        return 0;
    }

    /**
     * Create Order in Shiprocket
     *
     * @param array $orderData
     * @return array
     */
    public function createOrder(array $orderData)
    {
        $token = $this->getToken();

        $response = Http::withToken($token)
            ->post("{$this->baseUrl}/orders/create/adhoc", $orderData);

        if ($response->failed()) {
            throw new \Exception('Failed to create Shiprocket order: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Track Shipment by AWB number
     *
     * @param string $awb
     * @return array
     */
    public function trackShipment($awb)
    {
        $token = $this->getToken();

        $response = Http::withToken($token)
            ->get("{$this->baseUrl}/courier/track/awb/$awb");

        if ($response->failed()) {
            throw new \Exception('Failed to track shipment: ' . $response->body());
        }

        return $response->json();
    }
}
