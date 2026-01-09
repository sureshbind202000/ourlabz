<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TrackBookingLog;
use App\Models\TrackBookingStatus;
use App\Models\TrackSample;
use App\Models\TrackSampleLog;
use Illuminate\Http\Request;

class SampleCollectionController extends Controller
{
    // index 
    public function index()
    {
        return view('backend.superadmin.labs.sample_collection.list');
    }

    public function sampleCollectionList()
    {
        $samplecollection = TrackSample::with(['booking', 'user', 'booking_patient'])->where('agent_id', auth()->user()->user_id)->whereNotIn('status', [3, 4, 5])->orderBy('id', 'DESC')->get();
        foreach ($samplecollection as $sample) {
            $sample->encrypted_id = encrypt($sample->id);
        }
        return response()->json($samplecollection);
    }

    public function sampleCollectionCompleted()
    {
        return view('backend.superadmin.labs.sample_collection.completed');
    }

    public function sampleCollectionCompletedList()
    {
        $samplecollection = TrackSample::with(['booking', 'user', 'booking_patient'])->where('agent_id', auth()->user()->user_id)->where('status', 3)->orderBy('id', 'DESC')->get();
        foreach ($samplecollection as $sample) {
            $sample->encrypted_id = encrypt($sample->id);
        }
        return response()->json($samplecollection);
    }

    public function sampleCollectionProfile($id)
    {
        $dId = decrypt($id);
        $detail = TrackSample::with(['booking', 'user', 'booking_patient', 'booking_patient.trackBooking', 'booking.bookingAddress', 'bookingTest.package.requisites', 'booking_patient.trackBooking'])->where('id', $dId)->first();
        $logs = TrackBookingLog::with('user')
            ->where('booking_id', $detail->booking_id)
            ->latest()
            ->get();
        // dd($detail->bookingTest);
        return view('backend.superadmin.labs.sample_collection.profile', compact('detail', 'logs'));
    }

    public function verifyCollectionOtp(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required',
            'otp' => 'required|digits:6',
        ]);

        $tracking = TrackBookingStatus::where('booking_patient_id', $request->tracking_id)->first();

        if (!$tracking) {
            return response()->json(['success' => false, 'message' => 'Tracking not found']);
        }

        if ($tracking->otp != $request->otp) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP']);
        }

        $tracking->otp_verified_at = now();
        
        $tracking->save();

        return response()->json(['success' => true, 'message' => 'OTP verified successfully']);
    }
}
