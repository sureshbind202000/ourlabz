<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingPatient;
use App\Models\BookingTest;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\lab;
use App\Models\LabTest;
use App\Models\package;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\TrackBookingStatus;
use App\Models\User;
use App\Models\UserAddress;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function bookingForm()
    {
        $labs = lab::all();
        return view('frontend.booking', compact('labs'));
    }

    // Fetch Lab Test According to Lab
    public function getTestsByLab($lab_id)
    {
        $tests = LabTest::where('lab_id', $lab_id)
            ->select('package_id', 'test_name')
            ->distinct()
            ->get();

        return response()->json($tests);
    }

    // Fetch Lab Test Price According to Package
    public function getTestPriceByPackage($package_id)
    {
        $test_price = package::where('package_id', $package_id)->first();

        return response()->json($test_price->price);
    }

    public function storeUserAddress(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pin' => 'required',
            'google_map_location' => 'nullable',
            'type' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        $address = UserAddress::create([
            'user_id' => auth()->id(),
            'address' => $request->address,
            'city' => ucwords($request->city),
            'state' => ucwords($request->state),
            'country' => ucwords($request->country),
            'pin' => $request->pin,
            'google_map_location' => $request->google_map_location,
            'type' => $request->type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json($address);
    }

    public function updateUserAddress(Request $request, $id)
    {
        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pin' => 'required',
            'google_map_location' => 'required',
            'type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $address = UserAddress::findOrFail($id);

        $address->update($request->all());

        return response()->json($address);
    }

    public function getUserAddresses()
    {
        $addresses = UserAddress::where('user_id', auth()->id())->get();

        return response()->json($addresses);
    }

    public function getSchedulesByLab($labId, $sampleCollection)
    {
        $schedules = Schedule::where('scheduler_id', $labId)
            ->where('scheduling_for', $sampleCollection)
            ->orderBy('date')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'date' => $s->date,
                    'from_time' => $s->from_time,
                    'to_time' => $s->to_time,
                    'time_category' => $this->getTimeCategory($s->from_time),
                    'day' => \Carbon\Carbon::parse($s->date)->format('l')
                ];
            });

        return response()->json($schedules);
    }

    private function getTimeCategory($time)
    {
        $hour = (int) \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('H');

        return match (true) {
            $hour < 12 => 'Morning',
            $hour < 17 => 'Afternoon',
            default => 'Evening',
        };
    }

    public function bookingStore(Request $request)
    {
        DB::beginTransaction();
        // dd($request);
        // exit();

        try {

            $user = Auth::user();
            $orderId = generateUniqueOrderId();

            // Fallbacks for missing numeric values
            $subtotal = is_numeric($request->subtotal) ? $request->subtotal : 0;
            // $discount = is_numeric($request->discount) ? $request->discount : 0;
            $discount = is_numeric($request->coupon_discount) ? $request->coupon_discount : 0;
            $tax = is_numeric($request->tax) ? $request->tax : 0;
            $total = is_numeric($request->total_amount) ? $request->total_amount : 0;

            $lab = Lab::where('lab_id', $request->lab_id)->firstOrFail();
            $labuser = User::where('lab_id', $request->lab_id)->first();

            // ✅ Create main booking
            $booking = Booking::create([
                'user_id'           => $user->id,
                'booking_type'      => 'test',
                'lab_id'            => $request->lab_id,
                'booking_date'      => $request->date,
                'time_slot'         => $request->time,
                'address'           => $request->address,
                'booking_for'       => 'Self',
                'status'            => 'Confirmed',
                'payment_status'    => $request->payment_status ?? 'Pending',
                'sample_collection' => $request->schedule_for == 1 ? 1 : 0,
                'sub_total'         => $subtotal,
                'discount'          => $discount,
                'shipping'          => 0,
                'tax'               => $tax,
                'total_amount'      => $total,
                'order_id'          => $orderId,
            ]);

            $bookingTime = Carbon::createFromFormat('h:i A', $request->time)
                ->format('H:i:s');
            Schedule::where('scheduler_id', $request->lab_id)
                ->where('date', $request->date)
                ->where('from_time', '<=', $bookingTime)
                ->where('status', 1)
                ->update([
                    'status' => 0
                ]);

            // ✅ Packages & Patients
            foreach ($request->packages ?? [] as $pkgIndex => $package) {
                foreach ($package['patients'] ?? [] as $patientIndex => $patient) {
                    // Create booking patient
                    $bookingPatient = BookingPatient::where('id', $patient['id'])
                        ->where('user_id', auth()->id()) // safety check
                        ->first();

                    if (!$bookingPatient) {
                        continue;
                    }

                    $bookingPatient->update([
                        'booking_id' => $booking->id,
                        // 'name'       => $patient['name'],
                        // 'phone'      => $patient['phone'],
                        // 'email'      => $patient['email'],
                        // 'gender'     => $patient['gender'],
                        // 'dob'        => $patient['dob'],
                        // 'age'        => $patient['age'],
                        // 'relation'   => $patient['relation'],
                    ]);

                    // Handle prescription file (if uploaded)
                    if ($request->hasFile("packages.$pkgIndex.patients.$patientIndex.prescription")) {

                        $file = $request->file("packages.$pkgIndex.patients.$patientIndex.prescription");
                        $fileName = 'prescription_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $destinationPath = public_path('uploads/prescriptions');
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }
                        $file->move($destinationPath, $fileName);
                        $bookingPatient->update([
                            'prescription' => 'uploads/prescriptions/' . $fileName,
                        ]);
                    }

                    // Create booking test
                    BookingTest::create([
                        'booking_id'          => $booking->id,
                        'booking_patient_id'  => $bookingPatient->id,
                        'package_id'          => $package['package_id'] ?? null,
                        'price_at_booking_time' => $package['price'] ?? 0,
                    ]);

                    // Tracking record
                    TrackBookingStatus::create([
                        'tracking_id'         => Str::upper(Str::random(10)),
                        'booking_patient_id'  => $bookingPatient->id,
                        'status'              => 1,
                        'title'               => 'Booking Confirmed',
                    ]);
                }
            }

            $appliedCoupon = null;
            $couponCode = null;
            $couponType = null;
            if (session()->has('applied_coupon')) {
                $appliedCoupon= Coupon::where('code', session('applied_coupon'))->first();
                $couponCode = $appliedCoupon->code;
                if($appliedCoupon->discount_type == 'percentage') {
                    $couponType = 'percent';
                }
                if($appliedCoupon->discount_type == 'flat') {
                    $couponType = 'flat';
                }
            }


            // ✅ Payment record
            Payment::create([
                'type'           => 'Lab',
                'subtotal'       => $subtotal,
                'coupon'         => $couponCode,
                'discount'       => $discount,
                'discount_type'  => $couponType,
                'total'          => $total,
                'order_id'       => $booking->id,
                'transaction_id' => $request->razorpay_payment_id ?? null,
                'payment_status' => $request->payment_status ?? 'Paid',
            ]);

            if (session()->has('applied_coupon')) {
                session()->forget('applied_coupon');
            }

            // ✅ Notifications
            $allTestNames = collect($request->packages)
                ->map(fn($pkg) => $pkg['name'] ?? 'Test')
                ->implode(', ');

            DB::commit();

            // Clear cart (lab packages)
            Cart::where('user_id', $user->id)
                ->where('item_type', 'App\\Models\\Package')
                ->delete();

            // User Notification
            sendNotification(
                $user->id,
                'user-test-booking',
                [
                    'test_name' => $allTestNames,
                    'user_name' => $user->name,
                    'lab_name'  => $lab->lab_name,
                    'date'      => $request->date . ' / ' . $request->time,
                ]
            );

            // Lab Notification
            if ($labuser) {
                sendNotification(
                    $labuser->id,
                    'lab-booking-received',
                    [
                        'test_name' => $allTestNames,
                        'user_name' => $user->name,
                        'lab_name'  => $lab->lab_name,
                        'date'      => $request->date . ' / ' . $request->time,
                    ]
                );
            }

            if ($user && !empty($user->phone)) {

                $smsService = new SmsService();
                $smsService->sendSms($user->phone, ['user_name' => $user->name, 'lab_name' => $lab->lab_name, 'date_time' => $request->date . ' / ' . $request->time], 'offline_lab_booking_confirmation');
            }

            return response()->json(['success' => true, 'message' => 'Booking completed successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function fetchlabs(Request $request)
    {
        $addressId = $request->address_id;
        if (!$addressId) {
            return response()->json([]);
        }

        $address = UserAddress::find($addressId);
        if (!$address) {
            return response()->json([]);
        }

        $city = trim($address->city);
        $lat  = $address->latitude;
        $lng  = $address->longitude;

        if (!$city || !$lat || !$lng) {
            return response()->json([]);
        }

        $labs = Lab::select(
            'id',
            'lab_id',
            'lab_logo',
            'lab_name',
            'street_address',
            'city',
            'state',
            'postal_code',
            'google_map_location',
            'home_sample_collection',
            DB::raw("
                (6371 * acos(
                    cos(radians($lat)) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians($lng)) +
                    sin(radians($lat)) *
                    sin(radians(latitude))
                )) AS distance
            ")
        )
            ->whereRaw('LOWER(TRIM(city)) = ?', [strtolower($city)])
            ->orderBy('distance', 'asc')
            ->paginate(10); // 🔥 pagination
        // dd($labs);
        // exit();
        return response()->json($labs);
    }

    public function getAvailableDates(Request $request)
    {
        $schedulingFor = $request->input('scheduling_for');
        $scheduler_id = $request->input('scheduler_id');

        $dates = Schedule::select('date', DB::raw('MIN(DAYNAME(date)) as day'))
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
                'available_slots' => $slot->slots ?? 0,
                'status'          => (int) $slot->status,
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

    public function cancelBooking(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'reason' => 'required|string|max:500',
        ]);

        $booking = Booking::find($request->booking_id);

        if ($booking->status == 'Cancelled' || $booking->status == 'Completed') {
            return response()->json(['message' => 'Booking cannot be cancelled at this stage.'], 400);
        }

        // Optional: restrict if already collected
        if ($booking->track_status >= 3) {
            return response()->json(['message' => 'Sample already collected. Cannot cancel.'], 400);
        }

        $refundAmount = 0;
        if ($booking->payment_status == 'Paid') {
            $refundAmount = $booking->total_amount; // Full refund before sample collection
        }

        $booking->update([
            'status' => 'Cancelled',
            'cancel_reason' => $request->reason,
            'cancelled_by' => auth()->id(),
            'cancelled_at' => now(),
            'refund_amount' => $refundAmount,
        ]);

        // Log booking activity
        logBookingActivity($booking->id, 'Booking Cancelled', '#' . $booking->order_id . ' cancelled by user.');

        return response()->json(['message' => 'Booking cancelled successfully.']);
    }

    public function getPatientInfo($id)
    {
        $user = User::with('user_addresses')->where('user_id', $id)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'name'      => $user->name,
                'gender'    => $user->gender,
                'dob'       => $user->date_of_birth,
                'age'       => $user->age,
                'phone'     => $user->phone,
                'addresses' => $user->user_addresses->map(function ($address) {
                    return [
                        'id'   => $address->id,
                        'full' => $address->address . ', ' . $address->city . ', ' . $address->pin,
                    ];
                }),
            ],
        ]);
    }

    public function getTestsPrices(Request $request)
    {
        $ids = $request->input('test_ids', []);
        $patientId = $request->input('patient_id');

        if (empty($ids)) {
            return response()->json(['tests' => []]);
        }

        // Get the patient
        $patient = User::where('user_id', $patientId)->first();

        // Fetch tests
        $tests = package::whereIn('package_id', $ids)
            ->select('package_id', 'name', 'price', 'corporate_price')
            ->get()
            ->map(function ($test) use ($patient) {
                // Decide which price to show
                if ($patient && $patient->corporate_id) {
                    $test->final_price = $test->corporate_price ?? $test->price;
                } else {
                    $test->final_price = $test->price;
                }
                return $test;
            });

        return response()->json(['tests' => $tests]);
    }
}
