<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingPatient;
use App\Models\BookingTest;
use App\Models\DoctorConsultation;
use App\Models\Order;
use App\Models\Prescription;
use App\Models\TrackBookingStatus;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use DateTime;

class UserController extends Controller
{
    public function dashboard()
    {

        $user = Auth::user();

        // Total test bookings
        $bookingCount = Booking::where('user_id', $user->id)->count();

        // Total product orders
        $orderCount = Order::where('user_id', $user->id)->count();

        $walletBalance = $user->wallet ?? 0.00;

        $freeConsultationCount = BookingTest::whereHas('booking', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('free_consultation', 1)->count();

        return view('frontend.user.dashboard', compact('bookingCount', 'orderCount', 'walletBalance', 'freeConsultationCount'));
    }

    public function profile()
    {
        return view('frontend.user.profile');
    }

    public function profileUpdate(Request $request)
    {
        try {

            // Validate the request
            $validator = Validator::make($request->all(), [
                'id'  => 'required|exists:users,id',
                'name'  => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'date_of_birth' => 'required|date',
                'age' => 'required|integer|min:0|max:150',
                'gender' => 'required|in:Male,Female,Other',
                'blood_group' => 'required|string|max:5',
                'alternate_phone' => 'required|string|max:20',
                'emergency_contact_name' => 'string|max:255',
                'emergency_contact_phone' => 'string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the user
            $user = User::findOrFail($request->id);

            // Update user
            $user->update($request->only([
                'name',
                'email',
                'phone',
                'date_of_birth',
                'gender',
                'blood_group',
                'age',
            ]));

            // Update user_details
            $user->user_details()->updateOrCreate(
                ['user_id' => $user->id],
                $request->only(['alternate_phone', 'emergency_contact_name', 'emergency_contact_phone'])
            );

            return response()->json([
                'message' => 'Profile updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // User Primary Address Update
    public function primaryAddressUpdate(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'id'  => 'required|exists:users,id',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'country' => 'required|string|max:100',
                'pin' => 'required|digits_between:4,10',
                'google_map_location' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the user
            $user = User::findOrFail($request->id);

            // Format inputs to Title Case
            $formattedData = [
                'address' => $request->address,
                'city' => ucwords($request->city),
                'state' => ucwords($request->state),
                'country' => ucwords($request->country),
                'pin' => $request->pin,
                'google_map_location' => $request->google_map_location,
            ];

            // Update or create user_details
            $user->user_details()->updateOrCreate(
                ['user_id' => $user->id],
                $formattedData
            );

            return response()->json([
                'message' => 'Primary address updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Update User Medical Information
    public function updateMedicalInformation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:users,id',
                'medical_condition' => 'required|array|min:1',
                'medical_condition.*' => 'string|max:100',

                'allergies' => 'nullable|array',
                'allergies.*' => 'string|max:100',

                'current_medications' => 'nullable|string|max:1000',
                'family_doctor_name_contact' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = User::findOrFail($request->id);

            $user->medical_information()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'medical_condition' => json_encode($request->medical_condition),
                    'allergies' => json_encode($request->allergies),
                    'current_medications' => $request->current_medications,
                    'family_doctor_name_contact' => $request->family_doctor_name_contact,
                ]
            );

            return response()->json([
                'message' => 'Medical information updated successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'old-password' => 'required|string',
            'new-password' => 'required|string|min:6|confirmed',
        ], [
            'new-password.confirmed' => 'New password and confirmation do not match.'
        ]);

        $user = User::findOrFail($request->id);

        if (!Hash::check($request->input('old-password'), $user->password)) {
            return response()->json([
                'message' => 'The old password is incorrect.'
            ], 422);
        }

        $user->password = Hash::make($request->input('new-password'));
        $user->show_password = $request->input('new-password');
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully.'
        ]);
    }

    // Update Profile Image
    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = auth()->user();

        // Delete old profile image if it exists
        if (!empty($user->profile) && file_exists(public_path($user->profile))) {
            unlink(public_path($user->profile));
        }

        // Save new image
        $file = $request->file('profile_image');
        $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $uploadPath = 'uploads/profile/' . $filename;
        $file->move(public_path('uploads/profile'), $filename);

        // Update DB
        $user->profile = $uploadPath;
        $user->save();

        return response()->json([
            'message' => 'Profile image updated successfully!',
            'image_url' => asset($uploadPath),
        ]);
    }

    // User Addesses List
    public function userAddresses()
    {
        return view('frontend.user.address_list');
    }

    // Fetch Addresses
    public function userAddressesShow()
    {
        $user = auth()->user();

        $primaryAddress = $user->user_details ? $user->user_details->only(['address', 'city', 'state', 'country', 'pin', 'google_map_location']) : [];

        $addresses = $user->user_addresses->map(function ($address) {
            return collect($address)->only(['id', 'address', 'city', 'state', 'country', 'pin', 'google_map_location', 'type']);
        });

        return response()->json([
            'primary' => $primaryAddress,
            'addresses' => $addresses
        ]);
    }

    // Delete Address
    public function deleteAddress(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:user_addresses,id',
        ]);

        try {
            $address = UserAddress::findOrFail($request->id);

            if ($address->user_id !== auth()->id()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }

            $address->delete();

            return response()->json(['message' => 'Address deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete address.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // User Support
    public function userSuppport()
    {
        return view('frontend.user.support');
    }

    public function track_order()
    {
        return view('frontend.user.track_order');
    }

    public function live_tracking()
    {
        $bookings = Booking::with(['patients', 'patients.trackBooking', 'patients.test.package'])
            ->where('user_id', Auth::id())
            ->get();

        $patientIds = $bookings->pluck('patients.*.id')->flatten();

        $trackings = TrackBookingStatus::with(['trackSample.phlebotomist', 'patient', 'patient.test.package'])->whereIn('booking_patient_id', $patientIds)
            ->where('collection_status', 1)
            ->get();

        return view('frontend.user.live_tracking', compact('trackings'));
    }

    public function trackBookingStatus(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string'
        ]);

        $statuses = TrackBookingStatus::where('tracking_id', $request->tracking_id)
            ->orderBy('status')
            ->get();

        if ($statuses->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No tracking found for this ID.'
            ]);
        }

        $latest = $statuses->last();

        return response()->json([
            'status' => true,
            'status_code' => (int) $latest->status,
            'title' => $latest->title,
            'steps' => $statuses->mapWithKeys(function ($s) {
                return [
                    $s->status => [
                        'title' => $s->title,
                        'date' => $s->updated_at->format('d M Y, h:i A'),
                    ]
                ];
            }),
        ]);
    }


    public function trackOrderView($tracking_id)
    {
        // Fetch all statuses with this tracking ID
        $statuses = TrackBookingStatus::where('tracking_id', $tracking_id)
            ->orderBy('status')
            ->get();

        if ($statuses->isEmpty()) {
            abort(404, 'Invalid Tracking ID');
        }

        $latest = $statuses->last();

        return view('frontend.user.track_order', [
            'tracking_id' => $tracking_id,
            'status_code' => (int) $latest->status,
            'status_title' => $latest->title,
            'steps' => $statuses->keyBy('status'), // for JS timeline rendering
        ]);
    }
    // User Booking List
    public function booking_list()
    {
        $orders = Booking::where('booking_type', 'test')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return view('frontend.user.booking_list', compact('orders'));
    }

    public function booking_details($id)
    {
        $dId = decrypt($id);
        $detail = Booking::with(['user', 'tests.package', 'patients', 'bookingAddress'])->where('id', $dId)->first();
        return view('frontend.user.booking_detail', compact('detail'));
    }

    // User Order List
    public function order_list()
    {
        $detail = Order::with(['user', 'vendor', 'address', 'items'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('frontend.user.order_list', compact('detail'));
    }

    public function order_details($id)
    {
        $dId = decrypt($id);
        $detail = Order::with(['user', 'vendor', 'address', 'items'])->where('id', $dId)->first();
        return view('frontend.user.order_detail', compact('detail'));
    }

    public function downloadReport($tracking_id)
    {
        $patient = TrackBookingStatus::where('tracking_id', $tracking_id)->firstOrFail();

        $test = BookingTest::where('booking_patient_id', $patient->booking_patient_id)
            ->whereNotNull('report_file')
            ->latest()
            ->first();

        if (!$test) {
            abort(404, 'Report not available.');
        }

        $filePath = public_path($test->report_file);

        if (!file_exists($filePath)) {
            abort(404, 'Report file not found.');
        }

        return response()->download($filePath);
    }


    public function allReports()
    {
        $user = auth()->user();
        $reports = [];

        $bookingIds = Booking::where('booking_type', 'test')
            ->where('user_id', $user->id)
            ->pluck('id');

        $patients = BookingPatient::whereIn('booking_id', $bookingIds)->get();
        $tests = BookingTest::with(['package'])
            ->whereIn('booking_id', $bookingIds)
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($patients as $patient) {
            foreach ($tests as $test) {
                if (
                    $patient->id == $test->booking_patient_id &&
                    $test->verify == 'Verified' &&
                    $test->certify == 'Certified'
                ) {
                    $reports[] = (object) [
                        'source' => 'Local',
                        'name'   => $patient->name,
                        'test'   => $test->package->name ?? 'N/A',
                        'report' => $test->report_file ?? null,
                        'date'   => $test->updated_at->format('d/m/Y'),
                    ];
                }
            }
        }

        usort($reports, function ($a, $b) {
            $aTime = DateTime::createFromFormat('d/m/Y', $a->date);
            $bTime = DateTime::createFromFormat('d/m/Y', $b->date);

            return $bTime->getTimestamp() <=> $aTime->getTimestamp();
        });

        return view('frontend.user.reports_list', compact('reports'));

    }


    public function allConsultations()
    {
        $user = Auth::user();
        $consultations = DoctorConsultation::with(['user', 'prescriptions', 'doctor', 'payment'])->where('user_id', $user->id)->orderBy('id', 'DESC')->get();
        $freeConsultationCount = BookingTest::whereHas('booking', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('free_consultation', 1)->count();

        return view('frontend.user.consultation_list', compact('consultations', 'freeConsultationCount'));
    }

    public function consultationDetails($id)
    {
        $dId = decrypt($id);
        $user = Auth::user();
        $consultation = DoctorConsultation::with(['user', 'prescriptions', 'doctor', 'payment', 'address'])->where('id', $dId)->orderBy('id', 'DESC')->first();

        return view('frontend.user.consultation_detail', compact('consultation'));
    }

    public function downloadTextPrescription($id)
    {
        $prescription = Prescription::findOrFail($id);

        $user = User::find($prescription->consultation->user_id);

        if (!$prescription->written_prescription) {
            abort(404, 'No written prescription found.');
        }

        // Wrap the stored HTML inside a minimal layout for PDF rendering
        $html = '
        <html>
            <head>
                <meta charset="utf-8">
                <style>
                    body { font-family: DejaVu Sans, sans-serif; font-size: 14px; color: #333; line-height: 1.6; }
                    h1, h2, h3, h4 { color: #007bff; margin-bottom: 8px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                    th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
                    ul, ol { margin: 10px 0; padding-left: 20px; }
                </style>
            </head>
            <body>
                ' . $prescription->written_prescription . '
            </body>
        </html>
    ';

        $pdf = Pdf::loadHTML($html)->setPaper('A4', 'portrait');

        return $pdf->download('Prescription_' . $user->user_id . '.pdf');
    }

    public function freeConsultationTests()
    {
        $user = Auth::user();

        $tests = BookingTest::with(['package', 'patient']) // assuming BookingTest -> test() relation exists
            ->whereHas('booking', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('free_consultation', 1)
            ->orderBy('id', 'DESC')
            ->get();

        return view('frontend.user.free_consultation_tests', compact('tests'));
    }

    public function freeConsultationDoctors($testId)
    {
        $user = auth()->user();
        $test = BookingTest::with('package')->findOrFail($testId);

        // Decode package specialties
        $specialities = $test->package->consultant_category ?? null;

        if (is_string($specialities)) {
            $specialities = json_decode($specialities, true);
        }

        // If null or empty, return empty collection
        if (empty($specialities)) {
            $doctors = collect(); // empty collection
        } else {
            $doctors = User::with(['user_details'])->where('role', 3)
                ->whereHas('doctor_details', function ($query) use ($specialities) {
                    $query->where(function ($q) use ($specialities) {
                        foreach ($specialities as $speciality) {
                            $q->orWhere('specialization', 'like', "%$speciality%");
                        }
                    });
                })
                ->get();
        }

        return view('frontend.user.free_consultation_doctors', compact('doctors'));
    }
}
