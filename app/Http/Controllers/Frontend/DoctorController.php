<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BookingTest;
use App\Models\DoctorConsultation;
use App\Models\DoctorReview;
use App\Models\Faq;
use App\Models\package;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Speciality;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleCalendarService;
use App\Services\SmsService;

class DoctorController extends Controller
{
    // Doctor Details
    public function doctorDetails($id)
    {
        $doctor_id = decrypt($id);
        $doctor = User::with(['user_details', 'doctor_reviews', 'doctor_details', 'doctor_operating_hours'])->where('id', $doctor_id)->first();
        $doctor_faqs = Faq::where('faq_for', 'Doctor')->get();
        return view('frontend.doctor.details', compact('doctor', 'doctor_faqs'));
    }

    public function index(Request $request)
    {
        $query = User::with(['user_details', 'doctor_reviews', 'doctor_details'])
            ->where('role', 3)
            ->select(
                'users.id',
                'users.name',
                'users.profile',
                'users.user_id',
                DB::raw('(SELECT AVG(rating) FROM doctor_reviews WHERE doctor_reviews.doctor_id = users.id) as avg_rating')
            );

        // Filter: Type (Online, In-Person, Both)
        if ($request->filled('type')) {
            $types = $request->type;
            if (in_array('Online', $types) || in_array('In-Person', $types)) {
                $types[] = 'Both';
            }

            $query->whereHas('doctor_details', function ($q) use ($types) {
                $q->whereIn('consultation_type', array_unique($types));
            });
        }

        // Filter: Specialization (multi-select)
        if ($request->filled('speciality')) {
            $specialitySlugs = Arr::wrap($request->speciality);

            // Get the actual speciality names from slugs
            $specialityNames = Speciality::whereIn('slug', $specialitySlugs)->pluck('speciality')->toArray();

            $query->whereHas('doctor_details', function ($q) use ($specialityNames) {
                $q->where(function ($subQ) use ($specialityNames) {
                    foreach ($specialityNames as $spec) {
                        // Custom raw condition for stringified JSON
                        $subQ->orWhere('specialization', 'LIKE', '%' . $spec . '%');
                    }
                });
            });
        }

        // Filter: Rating
        if ($request->filled('rating')) {
            $ratings = implode(',', array_map('intval', $request->rating));
            $query->havingRaw('ROUND(avg_rating) IN (' . $ratings . ')');
        }

        // Filter: Price range
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereHas('doctor_details', function ($q) use ($request) {
                $q->whereBetween('price', [$request->min_price, $request->max_price]);
            });
        }

        // Filter: Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Search by doctor name
                $q->where('name', 'like', "%{$search}%")

                    // Search by specialization text field (not speciality filter slug)
                    ->orWhereHas('doctor_details', function ($sub) use ($search) {
                        $sub->where('specialization', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Sorting
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'price_low_high':
                    $query->leftJoin('doctor_details as dd', 'users.id', '=', 'dd.doctor_id')
                        ->addSelect('dd.price') // preserve existing select
                        ->orderBy('dd.price', 'asc');
                    break;

                case 'price_high_low':
                    $query->leftJoin('doctor_details as dd', 'users.id', '=', 'dd.doctor_id')
                        ->addSelect('dd.price')
                        ->orderByDesc('dd.price');
                    break;

                case 'latest':
                    $query->orderByDesc('users.created_at');
                    break;
            }
        }

        $doctors = $query->paginate(5);

        if ($request->ajax()) {
            return view('frontend.doctor.doctor_list', compact('doctors'))->render();
        }

        $specialities = Cache::remember('specialities', 3600, fn() => Speciality::all());

        return view('frontend.doctor.index', compact('doctors', 'specialities'));
    }





    // Registration Form  
    public function doctorRegistration()
    {
        return view('frontend.doctor_Registration');
    }

    // Store Doctor
    public function storeDoctor(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'gender' => 'required|in:Male,Female,Other',
                'date_of_birth' => 'required|date',
                'age' => 'required|numeric|min:0',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:15',
                'alternate_phone' => 'nullable|string|max:15',
                'emergency_contact_name' => 'nullable|string|max:255',
                'emergency_contact_phone' => 'nullable|string|max:15',
                'username' => 'required|alpha_num|unique:users,username',
                'password' => 'required|min:6',
                'terms_condition' => 'required|accepted',
                'subscribe' => 'nullable|accepted',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Generate unique doctor user_id
            do {
                $user_id = 'D' . rand(100000, 999999);
            } while (User::where('user_id', $user_id)->exists());

            // Upload profile image if exists
            $imagePath = null;
            if ($request->hasFile('profile')) {
                $name = preg_replace('/\s+/', '', $request->input('name')); // Remove spaces from name
                $profileImage = $name . '_' . time() . '.' . $request->file('profile')->extension();
                $request->file('profile')->move(public_path('uploads/profile'), $profileImage);
                $imagePath = 'uploads/profile/' . $profileImage;
            }

            // Create User
            $user = User::create([
                'user_id' => $user_id,
                'name' => ucwords($validated['name']),
                'phone' => $validated['phone'],
                'username' => $validated['username'], // Corrected
                'email' => $validated['email'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'age' => $validated['age'],
                'terms_condition' => true, // Since already validated
                'subscribe' => $request->has('subscribe') ? 1 : 0,
                'password' => Hash::make($validated['password']),
                'show_password' => $validated['password'],
                'role' => 3,
                'profile' => $imagePath ?? 'dummy',
            ]);

            // Create UserDetails
            UserDetails::create([
                'user_id' => $user->id,
                'alternate_phone' => $validated['alternate_phone'] ?? null,
                'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $validated['emergency_contact_phone'] ?? null,
            ]);

            DB::commit();

            // Notification Start

            // User
            sendNotification(
                $user->id,
                'doctor-registration',
                [
                    'doctor_name'  => $user->name,
                    'date'      => now()->format('d M Y'),
                ]
            );

            // Admin
            sendNotification(
                1,
                'doctor-registration-admin',
                [
                    'doctor_name'  => $user->name,
                    'date'      => now()->format('d M Y'),
                ]
            );

            $smsService = new SmsService();

            $smsService->sendSms($user->phone, [
                'doctor_name' => $user->name
            ], 'doctor_onboarding');

            Auth::login($user);
            return response()->json(['message' => 'Doctor created successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to register doctor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function doctorCheckout(Request $request)
    {
        $total = 0;
        $discount = 0;
        $tax = 0;
        $subtotal = $request->price;
        $total = max(0, $subtotal - $discount + $tax);
        $data = [
            'booking_schedule_for' => $request->booking_schedule_for,
            'booking_scheduler_id' => $request->booking_scheduler_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'discount' => $discount,
            'tax' => $tax,
            'subtotal' => $subtotal,
            'total' => $total,
        ];

        return view('frontend.doctor.checkout', compact('data'));
    }

    public function doctorBooking(Request $request, GoogleCalendarService $googleCalendarService)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $orderId = generateDoctorBookingOrderId();

            // Create Payment
            $payment = Payment::create([
                'type' => 'Doctor',
                'subtotal' => $request->subtotal,
                'discount' => $request->discount,
                'shipping' => 0,
                'tax' => $request->tax,
                'total' => $request->total,
                'order_id' => $orderId,
                'transaction_id' => $request->razorpay_payment_id,
                'payment_status' => 'Paid',
            ]);

            // Prepare Google Meet Event (only if consultation is online)
            $meetingUrl = 'https://meet.google.com/xyz-pqrs-tuv';
            // $meetingUrl = null;
            // if ((int) $request->consultation_type === 2) { // 2 = Online
            //     $startDateTime = \Carbon\Carbon::parse($request->booking_date . ' ' . $request->booking_time, 'Asia/Kolkata');
            //     $endDateTime   = (clone $startDateTime)->addMinutes(30); // 30-min consultation, adjust as needed

            //     $doctor = User::where('user_id', $request->doctor_id)->first();

            //     $meetingUrl = $googleCalendarService->createMeetEvent(
            //         summary: "Consultation with Dr. {$doctor->name}",
            //         startRfc3339: $startDateTime->toRfc3339String(),
            //         endRfc3339: $endDateTime->toRfc3339String(),
            //         attendees: [$doctor->email, $user->email] // doctor + patient emails
            //     );
            // }

            // Create Booking
            $booking = DoctorConsultation::create([
                'user_id' => Auth::id(),
                'doctor_id' => $request->doctor_id,
                'address_id' => $request->address_id,
                'consultation_type' => $request->consultation_type,
                'appointment_date' => $request->booking_date,
                'appointment_time' => $request->booking_time,
                'payment_id' => $payment->id,
                'meeting_url' => $meetingUrl, // <-- Store Google Meet URL
            ]);

            // Prescription Upload
            if ($request->hasFile('prescription_upload')) {
                $file = $request->file('prescription_upload');
                $filename = 'prescription_' . time() . '.pdf';
                $file->move(public_path('uploads/prescriptions'), $filename);

                $booking->prescription_upload = 'uploads/prescriptions/' . $filename;
                $booking->save();
            }

            // Reduce available slots
            Schedule::where('scheduler_id', $request->doctor_id)
                ->where('scheduling_for', $request->consultation_type)
                ->where('date', $request->booking_date)
                ->where('slots', '>', 0)
                ->decrement('slots');

            logConsultationActivity($booking->id, $booking->user_id, 'Consultation Booked');

            DB::commit();

            // Send Notifications
            $doctor = User::where('user_id', $request->doctor_id)->first();
            $consultType = $request->consultation_type == 2 ? 'Online' : 'Offline';

            // Notify User
            sendNotification(
                $user->id,
                'user-consultation-booking',
                [
                    'doctor_name'  => $doctor->name,
                    'doctor_phone' => $doctor->phone,
                    'user_name'    => $user->name,
                    'consultation_type' => $consultType,
                    'appointment_date'  => $request->booking_date,
                    'appointment_time'  => $request->booking_time,
                    'meeting_url'       => $meetingUrl,
                ]
            );

            // Notify Doctor
            sendNotification(
                $doctor->id,
                'doctor-consultation-received',
                [
                    'doctor_name'  => $doctor->name,
                    'user_name'    => $user->name,
                    'user_phone'   => $user->phone,
                    'consultation_type' => $consultType,
                    'appointment_date'  => $request->booking_date,
                    'appointment_time'  => $request->booking_time,
                    'order_id'          => $orderId,
                    'meeting_url'       => $meetingUrl,
                ]
            );

            // $smsService = new SmsService();

            // $smsService->sendSms($doctor->phone, ['doctor_name' => $doctor->name], 'doctor_onboarding');

            return response()->json([
                'success' => true,
                'message' => 'Booking stored successfully.',
                'meeting_url' => $meetingUrl,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function freeDoctorBooking(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();

            // Fetch Home address (type = 1) for logged-in user
            $homeAddress = UserAddress::where('user_id', $user->id)
                ->where('type', 1)
                ->first();

            if (!$homeAddress) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please add a Home address to continue booking.',
                    'redirect_url' => route('user.addresses')
                ], 422);
            }

            $orderId = generateDoctorBookingOrderId();

            // Create Payment
            $payment = Payment::create([
                'type' => 'Doctor',
                'subtotal' => 0,
                'discount' => 0,
                'shipping' => 0,
                'tax' => 0,
                'total' => 0,
                'order_id' => $orderId,
                'transaction_id' => $orderId,
                'payment_status' => 'Paid',
            ]);

            // Create Booking
            $booking = DoctorConsultation::create([
                'user_id' => $user->id,
                'doctor_id' => $request->doctor_id,
                'address_id' => $homeAddress->id,
                'consultation_type' => $request->consultation_type,
                'payment_id' => $payment->id,
                'meeting_url' => 'https://meet.example.com/doctor-consultation-link',
            ]);

            if ($request->has('prescription_upload')) {
                $file = $request->prescription_upload;

                $filename = 'prescription_' . time() . '.pdf';
                $path = $file->storeAs('uploads/prescriptions', $filename, 'public');

                $booking->prescription_upload = $path;
                $booking->save();
            }

            $fromTime = date('H:i:s', strtotime($request->booking_time));

            logConsultationActivity($booking->id, $booking->user_id, 'Consultation Booked');

            DB::commit();


            return response()->json(['success' => true, 'message' => 'Booking request sent successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function certifiedFreeDoctorBooking(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();

            // Fetch Home address (type = 1) for logged-in user
            $homeAddress = UserAddress::where('user_id', $user->id)
                ->where('type', 1)
                ->first();

            $bookingTest = BookingTest::findOrFail($request->test_id);
            $doctor =  User::find($bookingTest->certify_id);

            if (!$homeAddress) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please add a Home address to continue booking.',
                    'redirect_url' => route('user.addresses')
                ], 422);
            }

            $orderId = generateDoctorBookingOrderId();

            // Create Payment
            $payment = Payment::create([
                'type' => 'Doctor',
                'subtotal' => 0,
                'discount' => 0,
                'shipping' => 0,
                'tax' => 0,
                'total' => 0,
                'order_id' => $orderId,
                'transaction_id' => $orderId,
                'payment_status' => 'Paid',
            ]);

            // Create Booking
            $booking = DoctorConsultation::create([
                'user_id' => $user->id,
                'doctor_id' => $doctor->user_id,
                'address_id' => $homeAddress->id,
                'consultation_type' => $request->consultation_type,
                'payment_id' => $payment->id,
                'booking_test_id' => $bookingTest->id,
                'meeting_url' => 'https://meet.example.com/doctor-consultation-link',
            ]);

            if ($request->has('prescription_upload')) {
                $file = $request->prescription_upload;

                $filename = 'prescription_' . time() . '.pdf';
                $path = $file->storeAs('uploads/prescriptions', $filename, 'public');

                $booking->prescription_upload = $path;
                $booking->save();
            }

            $fromTime = date('H:i:s', strtotime($request->booking_time));

            logConsultationActivity($booking->id, $booking->user_id, 'Consultation Booked');
            $bookingTest->free_consultation = 0;
            $bookingTest->save();
            DB::commit();

            // Notifications

            $package = package::where('package_id', $bookingTest->package_id)->first();

            // User
            sendNotification(
                $user->id,
                'user-free-consultation-request',
                [
                    'order_id' => $payment->order_id,
                    'user_name' => $user->name,
                    'test_name' => $package->name,
                    'date'      => now()->format('d-m-Y / h:i A'),
                ]
            );

            // Doctor
            sendNotification(
                $doctor->id,
                'doctor-free-consultation-request-received',
                [
                    'doctor_name' => $doctor->name,
                    'order_id' => $payment->order_id,
                    'user_name' => $user->name,
                    'test_name' => $package->name,
                    'date'      => now()->format('d-m-Y / h:i A'),
                ]
            );

            // Notification End

            return response()->json(['success' => true, 'message' => 'Booking request sent successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    public function getAvailableDates(Request $request)
    {
        $schedulingFor = $request->input('scheduling_for');
        $scheduler_id = $request->input('scheduler_id');

        $dates = Schedule::select('date', DB::raw('MIN(day) as day'))
            ->where('scheduler_id', $scheduler_id)
            ->where('scheduling_for', $schedulingFor)
            ->whereDate('date', '>=', now())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($dates);
    }

    public function getAvailableSlots(Request $request)
    {
        $schedulingFor = $request->input('scheduling_for');
        $date = $request->input('date');
        $scheduler_id = $request->input('scheduler_id');

        // Get slots
        $slots = Schedule::where('scheduling_for', $schedulingFor)
            ->where('scheduler_id', $scheduler_id)
            ->whereDate('date', $date)
            ->orderBy('from_time')
            ->get();

        $grouped = [
            'morning' => [],
            'afternoon' => [],
            'evening' => [],
        ];

        foreach ($slots as $slot) {
            $time = Carbon::parse($slot->from_time);
            $formatted = $time->format('h:i A');

            $slotData = [
                'time' => $formatted,
                'available_slots' => $slot->slots ?? 0 // fallback to 0 if null
            ];

            if ($time->hour < 12) {
                $grouped['morning'][] = $slotData;
            } elseif ($time->hour < 17) {
                $grouped['afternoon'][] = $slotData;
            } else {
                $grouped['evening'][] = $slotData;
            }
        }

        return response()->json($grouped);
    }

    // Doctor Reviews
    public function doctorReviewStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
            'website' => 'nullable|prohibited',
        ]);

        // Save the comment
        $review = new DoctorReview();
        $review->doctor_id = $request->doctor_id;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return response()->json(['success' => true, 'message' => 'Review submitted successfully.']);
    }

    public function doctorBookingCancel(Request $request)
    {
        $request->validate([
            'consultation_id' => 'required|exists:doctor_consultations,id',
            'reason' => 'required|string|max:500',
        ]);

        $consultation = DoctorConsultation::find($request->consultation_id);

        if ($consultation->status == 1 || $consultation->status == 2) {
            return response()->json(['message' => 'Consultation cannot be cancelled at this stage.'], 400);
        }

        $refundAmount = 0;
        if ($consultation->payment->payment_status == 'Paid') {
            $refundAmount = $consultation->payment->total; // Full refund before Consultation
        }

        $consultation->update([
            'status' => 2,
            'cancel_reason' => $request->reason,
            'cancelled_by' => auth()->id(),
            'cancelled_at' => now(),
            'refund_amount' => $refundAmount,
        ]);

        // Log Consultation booking activity

        logConsultationActivity($consultation->id, $consultation->user_id, 'Consultation Cancelled', '#' . $consultation->payment->order_id . ' cancelled by user.');

        return response()->json(['message' => 'Booking cancelled successfully.']);
    }
}
