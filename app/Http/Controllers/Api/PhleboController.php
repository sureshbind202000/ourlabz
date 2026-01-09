<?php

namespace App\Http\Controllers\Api;

use App\Events\LocationUpdated;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TrackBookingStatus;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhleboController extends Controller
{

    public function startCollection($trackingId)
    {
        $otp = random_int(100000, 999999);

        $tracking = TrackBookingStatus::with(['trackSample', 'trackSample.phlebotomist'])->where('tracking_id', $trackingId)->firstOrFail();

        if ($tracking->collection_status == 1) {
            return response()->json([
                'success' => true,
                'message' => 'Collection already started'
            ]);
        }

        $tracking->collection_status = 1;
        $tracking->otp = $otp;
        $tracking->save();

        // ✅ Notifications after commit
        $user = User::find($tracking->trackSample->user_id);
        $phlebotomist = User::where('user_id', $tracking->trackSample->agent_id)->first();

        // Notify User
        sendNotification(
            $user->id,
            'phlebotomist-start-collection',
            [
                'user_name'          => $user->name,
                'phlebotomist_name'  => $phlebotomist->name,
                'phlebotomist_phone' => $phlebotomist->phone,
                'order_id'           => $tracking->trackSample->order_id,
                'date'               => now()->format('d M Y'),
            ]
        );

        logBookingActivity(
            $tracking->trackSample->booking_id,
            'Phlebotomist Start Collection',
            'Phlebotomist ' . $phlebotomist->name . ' (' . $phlebotomist->phone . ') has been started collection for booking #' . $tracking->trackSample->order_id . '.'
        );

        $smsService = new SmsService();

        $smsService->sendSms($user->phone, ['ph_name' => $phlebotomist->name, 'otp' => $otp], 'blood_collection');

        return response()->json(['success' => true, 'message' => 'Collection started']);
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user(); // the phlebotomist

        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->last_location_update = now();
        $user->save();

        broadcast(new LocationUpdated($user->id, $request->latitude, $request->longitude))->toOthers();

        return response()->json(['status' => 'Location updated']);
    }

    public function trackPhlebo($trackingId)
    {
        $tracking = TrackBookingStatus::with(['trackSample', 'trackSample.phlebotomist'])
            ->where('tracking_id', $trackingId)
            ->first();

        if (!$tracking) {
            return response()->json(['error' => 'Tracking not found'], 404);
        }

        $trackSample = $tracking->trackSample;

        if (!$trackSample || !$trackSample->phlebotomist) {
            return response()->json(['error' => 'Phlebotomist not assigned'], 404);
        }

        return response()->json([
            'latitude' => $trackSample->phlebotomist->latitude,
            'longitude' => $trackSample->phlebotomist->longitude,
            'last_location_update' => $trackSample->phlebotomist->last_location_update,
            'phlebotomist_id' => $trackSample->phlebotomist->id,
            'collection_status' => $tracking->collection_status,
        ]);
    }
}
