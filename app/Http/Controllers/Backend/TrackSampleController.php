<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingTest;
use App\Models\lab;
use App\Models\TrackBookingStatus;
use App\Models\TrackSample;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TrackSampleController extends Controller
{
    // Store Assignment
    public function store(Request $request)
    {
        $request->validate([
            'phlebotomist_id' => 'required',
            'assignments' => 'required|array',
            'note' => 'nullable|string',
            'booking_id' => 'required|exists:bookings,id',
            'booking_user_id' => 'required',
            'booking_order_id' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->assignments as $assignment) {
                [$patient_id, $booking_test_id] = explode('_', $assignment);

                // Ensure test exists and belongs to the booking
                $test = BookingTest::where('id', $booking_test_id)
                    ->where('booking_id', $request->booking_id)
                    ->firstOrFail();

                TrackSample::updateOrCreate(
                    [
                        'booking_id' => $request->booking_id,
                        'patient_id' => $patient_id,
                        'test_id'    => $test->id,
                    ],
                    [
                        'user_id'   => $request->booking_user_id,
                        'package_id' => $test->package_id,
                        'agent_id'  => $request->phlebotomist_id,
                        'note'      => $request->note,
                        'status'    => 0,
                        'order_id'  => $request->booking_order_id,
                    ]
                );

                // Handle booking status tracking
                $existingTracking = TrackBookingStatus::where('booking_patient_id', $patient_id)->first();

                if ($existingTracking) {

                    // Update existing tracking status
                    $existingTracking->update([
                        'status' => 2,
                        'title'  => 'Collection Scheduled',
                    ]);
                } else {

                    // Generate unique tracking ID
                    do {
                        $trackingId = Str::upper(Str::random(10));
                    } while (TrackBookingStatus::where('tracking_id', $trackingId)->exists());

                    TrackBookingStatus::create([
                        'tracking_id'         => $trackingId,
                        'booking_patient_id'  => $patient_id,
                        'status'              => 2,
                        'title'               => 'Collection Scheduled',
                    ]);
                }
            }

            DB::commit();

            // ✅ Notifications after commit
            $user = User::find($request->booking_user_id);
            $phlebotomist = User::where('user_id', $request->phlebotomist_id)->first();

            // Notify User
            sendNotification(
                $user->id,
                'assign-phlebotomist-to-user',
                [
                    'user_name'          => $user->name,
                    'phlebotomist_name'  => $phlebotomist->name,
                    'phlebotomist_phone' => $phlebotomist->phone,
                    'order_id'           => $request->booking_order_id,
                    'date'               => now()->format('d M Y'),
                ]
            );

            // Notify Phlebotomist
            sendNotification(
                $phlebotomist->id,
                'new-collection-assigned',
                [
                    'phlebotomist_name'  => $phlebotomist->name,
                    'user_name'          => $user->name,
                    'user_phone'         => $user->phone,
                    'order_id'           => $request->booking_order_id,
                    'date'               => now()->format('d M Y'),
                ]
            );

            logBookingActivity(
                $request->booking_id,
                'Phlebotomist Assigned',
                'Phlebotomist ' . $phlebotomist->name . ' (' . $phlebotomist->phone . ') assigned for booking #' . $request->booking_order_id . '.'
            );


            return response()->json([
                'status' => true,
                'message' => 'Phlebotomist assigned successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to assign phlebotomist. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Fetch Phlebotomist
    public function getPhlebotomistInfo($booking_id)
    {
        $sample = TrackSample::where('booking_id', $booking_id)->where('status', '!=', 5)->first();
        $status = Booking::find($booking_id);
        $track_status = $status?->track_status ?? 0;
        if ($sample) {
            $user = User::select('name', 'phone')->where('user_id', $sample->agent_id)->first();

            return response()->json([
                'assigned' => true,
                'phlebotomist' => [
                    'name' => $user->name ?? 'N/A',
                    'phone' => $user->phone ?? 'N/A'
                ],
                'track_status' => $track_status,
            ]);
        }

        return response()->json(['assigned' => false, 'track_status' => $track_status]);
    }

    // Upload Sample
    public function uploadSample(Request $request)
    {
        $request->validate([
            'track_sample_id' => 'required|exists:track_samples,id',
            'sample_image.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $sample = TrackSample::findOrFail($request->track_sample_id);

        if ($request->hasFile('sample_image')) {
            $images = [];

            foreach ($request->file('sample_image') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('uploads/sample_images');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);
                $images[] = 'uploads/sample_images/' . $filename;
            }

            // Because of casts, sample_image is always array or null
            $existing = $sample->sample_image ?? [];

            // Merge with new
            $sample->sample_image = array_merge($existing, $images);
            $sample->status = 1;

            logBookingActivity(
                $sample->booking_id,
                'Sample Collected',
                '#' . $sample->order_id . ' Sample collected and images uploaded.'
            );

            $sample->save();

            // Notifications

            $labAdmin = User::where('lab_id', auth()->user()->lab_id)->where('lab_user_role', 1)->first();
            $lab = lab::where('lab_id', auth()->user()->lab_id)->first();
            $booking = Booking::find($sample->booking_id);
            $user = User::find($booking->user_id);

            // Lab 
            sendNotification(
                $labAdmin->id,
                'phlebotomist-sample-upload',
                [
                    'lab_name' => $lab->lab_name,
                    'phlebotomist_name' => auth()->user()->name,
                    'order_id' => $booking->order_id,
                    'user_name' => $user->name,
                    'date'      => $booking->booking_date . ' / ' . $booking->time_slot,
                ]
            );

            $smsService = new SmsService();

            $smsService->sendSms($user->phone, [
                'user_name' => $user->name,
                'lab_name' => $lab->lab_name,
                'booking_id' => $booking->order_id
            ], 'sample_collected');

            // Notification End
        }

        return response()->json([
            'success' => true,
            'message' => 'Sample uploaded successfully!'
        ]);
    }

    public function deleteSample($id, Request $request)
    {
        $sample = TrackSample::find($id);

        if ($sample && !empty($sample->sample_image)) {
            $images = $sample->sample_image; // already cast to array

            // If a specific image is passed for deletion
            if ($request->has('image')) {
                $imageToDelete = $request->image;

                if (in_array($imageToDelete, $images)) {
                    $imagePath = public_path($imageToDelete);

                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }

                    // Remove from array
                    $images = array_filter($images, fn($img) => $img !== $imageToDelete);
                }
            } else {
                // If no specific image, delete all
                foreach ($images as $img) {
                    $imagePath = public_path($img);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                }
                $images = [];
            }

            // Update sample
            $sample->sample_image = $images; // empty array if all deleted
            $sample->status = empty($images) ? 0 : $sample->status;
            $sample->save();

            // Update related booking if all deleted
            if (empty($images)) {
                $booking = Booking::find($sample->booking_id);
                if ($booking) {
                    $booking->track_status = 1;
                    $booking->save();
                }
            }

            logBookingActivity(
                $sample->booking_id,
                'Sample Deleted',
                '#' . $sample->order_id . (empty($images) ? ' All Sample Images Deleted.' : ' Sample Image Deleted.')
            );
        }

        return response()->json(['success' => true]);
    }


    // Final Submit
    public function finalSubmit($id)
    {
        $sample_id = decrypt($id);
        $sample = TrackSample::find($sample_id);

        if ($sample) {
            $sample->status = 2;
            $sample->save();

            $booking = Booking::find($sample->booking_id);
            if ($booking) {
                $booking->track_status = 3;
                $booking->save();
            }

            $tracking = TrackBookingStatus::where('booking_patient_id', $sample->patient_id)->first();
            if ($tracking) {
                $tracking->collection_status = 3;
                $tracking->save();
            }

            logBookingActivity($sample->booking_id, 'Sample Submitted', '#' . $sample->order_id . ' Sample finalized and sent to lab.');
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'sample_id' => 'required|exists:track_samples,id',
            'status'    => 'required|in:3,4,5',
            'reason'    => 'nullable|string|max:500'
        ]);

        $sample = TrackSample::findOrFail($request->sample_id);

        if ($request->status == 4) {
            // ❌ Rejected
            $sample->update([
                'status' => 4,
                'reason' => $request->reason ?? 'Rejected without reason'
            ]);

            logBookingActivity(
                $sample->booking_id,
                'Sample Rejected',
                '#' . $sample->order_id . ' ' . ($request->reason ?? 'Rejected without reason')
            );
        } elseif ($request->status == 3) {
            // ✅ Accepted
            $sample->update(['status' => 3]);

            logBookingActivity(
                $sample->booking_id,
                'Sample Accepted',
                '#' . $sample->order_id . ' Sample accepted by lab.'
            );

            $tracking = TrackBookingStatus::where('booking_patient_id', $sample->patient_id)->first();

            if ($tracking) {
                $tracking->update([
                    'status' => 3,
                    'title'  => 'Sample Collected & Received at Lab',
                ]);
            } else {
                // fallback if no tracking_id exists
                do {
                    $newTrackingId = Str::upper(Str::random(10));
                } while (TrackBookingStatus::where('tracking_id', $newTrackingId)->exists());

                TrackBookingStatus::create([
                    'tracking_id'         => $newTrackingId,
                    'booking_patient_id'  => $sample->patient_id,
                    'status'              => 3,
                    'title'               => 'Sample Collected & Received at Lab',
                ]);
            }

            // Notifications

            $booking = Booking::find($sample->booking_id);
            $lab = lab::where('lab_id', $booking->lab_id)->first();
            $phlebotomist = User::where('user_id', $sample->agent_id)->first();

            // Lab 
            sendNotification(
                $phlebotomist->id,
                'lab-accepted-phlebotomist',
                [
                    'lab_name' => $lab->lab_name,
                    'phlebotomist_name' => $phlebotomist->name,
                    'order_id' => $booking->order_id,
                    'date'      => $booking->booking_date . ' / ' . $booking->time_slot,
                ]
            );

            $smsService = new SmsService();

            $smsService->sendSms($booking->user->phone, [
                'user_name' => $booking->user->name,
                'booking_id' => $booking->order_id,
                'lab_name' => $lab->lab_name,
                'date' => now()->addDay()->toDateString(),
            ], 'test_in_progress');

            // Notification End
        } elseif ($request->status == 5) {

            // ❌ Collection Rejected for same order_id & agent
            $samples = TrackSample::where('id', $sample->id)
                ->where('agent_id', auth()->user()->user_id)
                ->first();
            $samples->update([
                'status' => 5,
                'reason' => $request->reason ?? 'Collection rejected without reason'
            ]);
            logBookingActivity(
                $sample->booking_id,
                'Collection Rejected',
                '#' . $sample->order_id . ' Collection rejected by phlebotomist.'
            );

            // Notifications

            $labAdmin = User::where('lab_id', auth()->user()->lab_id)->where('lab_user_role', 1)->first();
            $lab = lab::where('lab_id', auth()->user()->lab_id)->first();
            $booking = Booking::find($samples->booking_id);
            $user = User::find($booking->user_id);

            // Lab 
            sendNotification(
                $labAdmin->id,
                'phlebotomist-reject-collection',
                [
                    'lab_name' => $lab->lab_name,
                    'phlebotomist_name' => auth()->user()->name,
                    'order_id' => $booking->order_id,
                    'user_name' => $user->name,
                    'reason' => $request->reason,
                    'date'      => $booking->booking_date . ' / ' . $booking->time_slot,
                ]
            );

            // Notification End

        }

        return response()->json([
            'success' => true,
            'message' => 'Sample status updated successfully.'
        ]);
    }
}
