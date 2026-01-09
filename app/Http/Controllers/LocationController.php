<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{

    public function searchCity(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return response()->json([]);
        }

        $apiKey = config('services.google.maps_key'); // stored in .env
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($query) . "&key=" . $apiKey;

        $response = Http::get($url)->json();

        if ($response['status'] !== 'OK' || empty($response['results'])) {
            return response()->json([]);
        }

        $cities = collect($response['results'])->map(function ($item) {
            $name = $item['formatted_address'];
            $lat = $item['geometry']['location']['lat'];
            $lon = $item['geometry']['location']['lng'];

            // Try to extract city/town/village from address_components
            foreach ($item['address_components'] as $component) {
                if (
                    in_array("locality", $component['types']) ||
                    in_array("administrative_area_level_2", $component['types'])
                ) {
                    $name = $component['long_name'];
                    break;
                }
            }

            return [
                'name' => $name,
                'lat' => $lat,
                'lon' => $lon,
            ];
        });

        return response()->json($cities);
    }


    public function getCity(Request $request)
    {

        if (auth()->check() && auth()->user()->location) {
            $city = auth()->user()->location;

            // Store in session for quick access
            session(['selected_city' => $city]);

            return response()->json([
                'city' => $city,
                'from' => 'database/session',
            ]);
        }

        $lat = $request->lat;
        $lng = $request->lng;

        $apiKey = config('services.google.maps_key'); // store API key in .env
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key={$apiKey}";

        $response = Http::timeout(5)->get($url)->json();

        if ($response['status'] === 'OK' && count($response['results']) > 0) {
            $city = null;
            foreach ($response['results'][0]['address_components'] as $component) {
                if (in_array("locality", $component['types'])) {
                    $city = $component['long_name'];
                    break;
                }
            }

            return response()->json([
                'city' => $city ?? 'Unknown',
                'from' => 'google_api',
            ]);
        }

        return response()->json(['city' => null], 400);
    }

    public function setCity(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255',
        ]);

        $city = $request->city;

        // Store in session
        session(['selected_city' => $city]);

        // Store in database if user is logged in
        if (auth()->check()) {
            $user = auth()->user();
            $user->location = $city;
            $user->save();
        }

        return response()->json([
            'success' => true,
            'city' => $request->city,
            'message' => 'City updated successfully',
        ]);
    }
}
