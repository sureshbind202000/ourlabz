<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BookingTest;
use App\Models\DoctorConsultation;
use App\Models\DoctorDetails;
use App\Models\DoctorOperatingHour;
use App\Models\DoctorReview;
use App\Models\DoctorSignature;
use App\Models\package;
use App\Models\Payment;
use App\Models\Prescription;
use App\Models\ReferredConsultation;
use App\Models\Speciality;
use App\Models\User;
use App\Models\UserDetails;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\GoogleCalendarService;



class DoctorController extends Controller
{
    // Index
    public function index()
    {
        $speciality = Speciality::all();
        return view('backend.superadmin.doctors.list', compact('speciality'));
    }

    public function list()
    {
       $doctors = User::with(['doctor_details'])
        ->where('role', 3)
        ->orderBy('id', 'DESC')
        ->get()
        ->map(function ($doc) {
            $doc->price = $doc->doctor_details->price ?? 0;
            return $doc;
        });
      
        return response()->json($doctors);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            do {
                $user_id = 'D' . rand(100000, 999999);
            } while (User::where('user_id', $user_id)->exists());


            $username = $request->filled('username') ? $request->username : strtolower(str_replace(' ', '', $request->name)) . $request->phone;
            if (User::where('username', $username)->exists()) {
                return response()->json(['error' => 'Username already exists!'], 409);
            }
            $email = $request->email;

            if (empty($email)) {
                $firstFourDigits = substr($request->phone, 0, 4);
                $username = strtolower(str_replace(' ', '', $request->name)); // Remove spaces
                $email = $username . $firstFourDigits . '@example.com';

                while (User::where('email', $email)->exists()) {
                    $email = $username . $firstFourDigits . '@example.com';
                }
            }
            if (User::where('email', $email)->exists()) {
                return response()->json(['error' => 'Email already exists!'], 409);
            }
            $profileImage = null;
            if ($request->hasFile('profile')) {
                $profileImage = time() . '.' . $request->profile->extension();
                $imagePath = 'uploads/profile/' . $profileImage;
                $request->profile->move(public_path('uploads/profile'), $profileImage);
            }
            // Personal Details | Login & Account
            // Create user
            $user = User::create([
                'user_id' => $user_id,
                'name' => ucwords($request->name),
                'phone' => $request->phone,
                'username' => $request->filled('username') ? $request->username : strtolower(str_replace(' ', '', $request->name)) . $request->phone,
                'email' => $email,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'age' => $request->age,
                'blood_group' => $request->blood_group,
                'terms_condition' => $request->has('terms_condition') ? 1 : 0,
                'subscribe' => $request->has('subscribe') ? 1 : 0,
                'password' => Hash::make($request->password),
                'show_password' => $request->password,
                'role' => 3,
                'profile' => $imagePath ?? 'dummy',
            ]);

            // Contact Information | Address Details
            UserDetails::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'city' => ucwords($request->city),
                'state' => ucwords($request->state),
                'country' => ucwords($request->country),
                'pin' => $request->pin,
                'google_map_location' => $request->google_map_location,
                'alternate_phone' => $request->alternate_phone,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
            ]);

            $id_proofImage = null;
            if ($request->hasFile('id_proof')) {
                $id_proofImage = time() . '.' . $request->id_proof->extension();
                $id_proofPath = 'uploads/id_proof/' . $id_proofImage;
                $request->id_proof->move(public_path('uploads/id_proof'), $id_proofImage);
            }

            $medical_degree_certificateImage = null;
            if ($request->hasFile('medical_degree_certificate')) {
                $medical_degree_certificateImage = time() . '.' . $request->medical_degree_certificate->extension();
                $medical_degree_certificatePath = 'uploads/medical_degree_certificate/' . $medical_degree_certificateImage;
                $request->medical_degree_certificate->move(public_path('uploads/medical_degree_certificate'), $medical_degree_certificateImage);
            }

            $medical_licenseImage = null;
            if ($request->hasFile('medical_license')) {
                $medical_licenseImage = time() . '.' . $request->medical_license->extension();
                $medical_licensePath = 'uploads/medical_license/' . $medical_licenseImage;
                $request->medical_license->move(public_path('uploads/medical_license'), $medical_licenseImage);
            }

            // Doctor Details
            DoctorDetails::create([
                'doctor_id' => $user->id,
                'about' => $request->about,
                'medical_license_number' => $request->medical_license_number,
                'license_issue_authority' => $request->license_issue_authority,
                'specialization' => $request->specialization,
                'qualification' => $request->qualification,
                'year_of_experience' => $request->year_of_experience,
                'affiliated_hospital_clinic_name' => $request->affiliated_hospital_clinic_name,
                'hospital_clinic_address' => $request->hospital_clinic_address,
                'consultation_type' => $request->consultation_type,
                'account_number' => $request->account_number,
                'ifsc_code' => $request->ifsc_code,
                'account_holder_name' => $request->account_holder_name,
                'upi_id' => $request->upi_id,
                'tin' => $request->tin,
                'medical_degree_certificate' => $medical_degree_certificatePath,
                'medical_license' => $medical_licensePath,
                'id_proof' => $id_proofPath,
                'id_type' => $request->id_type,
                'price' => $request->price,
            ]);

            $days = is_array($request->day) ? $request->day : [$request->day];
            $from_times = is_array($request->from_time) ? $request->from_time : [$request->from_time];
            $to_times = is_array($request->to_time) ? $request->to_time : [$request->to_time];
            $statuses = is_array($request->status) ? $request->status : [$request->status];

            foreach ($days as $key => $day) {
                DoctorOperatingHour::create([
                    'doctor_id' => $user->id,
                    'day' => $day,
                    'from_time' => $from_times[$key] ?? null,
                    'to_time' => $to_times[$key] ?? null,
                    'status' => $statuses[$key] ?? null,
                ]);
            }

            DB::commit();

            return response()->json(['success' => 'User added successfully!', 'data' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store user: ' . $e->getMessage()], 500);
        }
    }

    // Edit
    public function edit($id)
    {
        $doctor = User::with(['user_details', 'doctor_details', 'doctor_operating_hours'])->findOrFail($id);
        return response()->json(['doctor' => $doctor]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            // Delete & Update profile image
            if ($request->hasFile('profile')) {
                if ($user->profile && file_exists(public_path($user->profile)) && $user->profile !== 'dummy') {
                    unlink(public_path($user->profile));
                }

                $profileImage = time() . '.' . $request->profile->extension();
                $request->profile->move(public_path('uploads/profile'), $profileImage);
                $user->profile = 'uploads/profile/' . $profileImage;
            }

            // Update basic user info
            $user->update([
                'name' => ucwords($request->name),
                'phone' => $request->phone,
                'username' => $request->filled('username') ? $request->username : strtolower(str_replace(' ', '', $request->name)) . $request->phone,
                'email' => $request->email,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'age' => $request->age,
                'blood_group' => $request->blood_group,
                'terms_condition' => $request->has('terms_condition') ? 1 : 0,
                'subscribe' => $request->has('subscribe') ? 1 : 0,
            ]);

            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                    'show_password' => $request->password,
                ]);
            }

            // Update UserDetails
            UserDetails::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'address' => $request->address,
                    'city' => ucwords($request->city),
                    'state' => ucwords($request->state),
                    'country' => ucwords($request->country),
                    'pin' => $request->pin,
                    'google_map_location' => $request->google_map_location,
                    'alternate_phone' => $request->alternate_phone,
                    'emergency_contact_name' => $request->emergency_contact_name,
                    'emergency_contact_phone' => $request->emergency_contact_phone,
                ]
            );

            $doctorDetails = DoctorDetails::where('doctor_id', $user->id)->first();

            // File update helpers
            $uploadAndReplace = function ($fileKey, $oldPath, $folder) use ($request) {
                if ($request->hasFile($fileKey)) {
                    if ($oldPath && file_exists(public_path($oldPath))) {
                        unlink(public_path($oldPath));
                    }
                    $fileName = time() . '.' . $request->$fileKey->extension();
                    $request->$fileKey->move(public_path("uploads/{$folder}"), $fileName);
                    return "uploads/{$folder}/" . $fileName;
                }
                return $oldPath;
            };

            $medical_degree_certificatePath = $uploadAndReplace('medical_degree_certificate', $doctorDetails?->medical_degree_certificate, 'medical_degree_certificate');
            $medical_licensePath = $uploadAndReplace('medical_license', $doctorDetails?->medical_license, 'medical_license');
            $id_proofPath = $uploadAndReplace('id_proof', $doctorDetails?->id_proof, 'id_proof');

            // Update or Create Doctor Details
            DoctorDetails::updateOrCreate(
                ['doctor_id' => $user->id],
                [
                    'about' => $request->about,
                    'medical_license_number' => $request->medical_license_number,
                    'license_issue_authority' => $request->license_issue_authority,
                    'specialization' => $request->specialization,
                    'qualification' => $request->qualification,
                    'year_of_experience' => $request->year_of_experience,
                    'affiliated_hospital_clinic_name' => $request->affiliated_hospital_clinic_name,
                    'hospital_clinic_address' => $request->hospital_clinic_address,
                    'consultation_type' => $request->consultation_type,
                    'account_number' => $request->account_number,
                    'ifsc_code' => $request->ifsc_code,
                    'account_holder_name' => $request->account_holder_name,
                    'upi_id' => $request->upi_id,
                    'tin' => $request->tin,
                    'medical_degree_certificate' => $medical_degree_certificatePath,
                    'medical_license' => $medical_licensePath,
                    'id_proof' => $id_proofPath,
                    'id_type' => $request->id_type,
                    'price' => $request->price,
                ]
            );

            // Replace operating hours
            DoctorOperatingHour::where('doctor_id', $user->id)->delete();

            $days = is_array($request->day) ? $request->day : [$request->day];
            $from_times = is_array($request->from_time) ? $request->from_time : [$request->from_time];
            $to_times = is_array($request->to_time) ? $request->to_time : [$request->to_time];
            $statuses = is_array($request->status) ? $request->status : [$request->status];

            foreach ($days as $key => $day) {
                DoctorOperatingHour::create([
                    'doctor_id' => $user->id,
                    'day' => $day,
                    'from_time' => $from_times[$key] ?? null,
                    'to_time' => $to_times[$key] ?? null,
                    'status' => $statuses[$key] ?? null,
                ]);
            }

            DB::commit();
            return response()->json(['success' => 'Doctor updated successfully!', 'data' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update doctor: ' . $e->getMessage()], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Doctor not found.'], 404);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'Doctor and related data deleted successfully.']);
    }

    public function changeStatus(Request $request)
    {

        $doctor = User::find($request->doctor_id);

        if ($doctor) {
            $doctor->status = $request->status;
            $doctor->save();

            // Convert status to label and badge class
            $statusLabel = match ((int) $doctor->status) {
                1 => 'Approved',
                2 => 'Declined',
                0 => 'Pending',
                default => 'Unknown'
            };

            $badgeClass = match ((int) $doctor->status) {
                1 => 'bg-success',
                2 => 'bg-danger',
                0 => 'bg-warning',
                default => 'bg-secondary'
            };

            if ((int)$doctor->status === 1) {

                $support_no = '+91-7411727444';

                if ($doctor && !empty($doctor->phone)) {
                    $smsService = new SmsService();
                    $smsService->sendSms($doctor->phone, ['doctor_name' => $doctor->name], 'doctor_approval_notification');
                }
            }

            return response()->json([
                'success' => true,
                'new_status_label' => $statusLabel,
                'new_badge_class' => $badgeClass
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function doctorReviews()
    {
        return view('backend.superadmin.doctors.review');
    }

    // Review List
    public function doctorReviewList()
    {
        $review = DoctorReview::with(['user:id,id,name'])->orderBy('is_active', 'asc')
            ->latest()
            ->get();
        $review->transform(function ($review) {
            $review->encrypted_id = encrypt($review->doctor_id);
            return $review;
        });
        return response()->json($review);
    }

    // Review Status
    public function toggleDoctorReviewStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:doctor_reviews,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $review = DoctorReview::findOrFail($request->id);

            $review->is_active = $request->status;
            $review->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $review
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete
    public function doctorReviewDestroy($id)
    {
        try {

            $review = DoctorReview::findOrFail($id);

            $review->delete();

            return response()->json(['success' => true, 'message' => 'Review deleted successfully.']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Failed to delete review: ' . $e->getMessage()], 500);
        }
    }
    public function viewBooking()
    {
        $doctor = Auth::user();
        $users = User::where('role', 1)->get();
        return view('backend.superadmin.doctors.booking.list', compact('doctor', 'users'));
    }
    public function getBooking()
    {
        $doctorId = auth()->id();
        $user = User::find($doctorId);

        $bookings = DoctorConsultation::with([
            'user',
            'referred.referredToUser'
        ])
            ->where('doctor_id', $user->user_id)
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bookings);
    }

    public function viewCompletedBooking()
    {
        return view('backend.superadmin.doctors.booking.complete_list');
    }

    public function getCompletedBooking()
    {
        $doctorId = auth()->id();
        $user = User::find($doctorId);

        $bookings = DoctorConsultation::with([
            'user',
            'referred.referredToUser'
        ])
            ->where('doctor_id', $user->user_id)
            ->whereIn('status', [1, 2])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bookings);
    }

    public function bookingProfile($id)
    {
        $booking = DoctorConsultation::with([
            'user',
            'payment',
            'address',
            'prescriptions' => function ($q) {
                $q->latest();
            },
            'activityLogs.user'
        ])->findOrFail($id);

        return view('backend.superadmin.doctors.booking.profile', compact('booking'));
    }

    public function submitPrescription(Request $request, $id)
    {
        $request->validate([
            'written_prescription' => 'nullable|string',
            'prescription_upload' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $prescription = new Prescription();
        $prescription->doctor_consultation_id = $id;
        if ($request->submit_type == 'written' || $request->submit_type == 'both') {
            $prescription->written_prescription = $request->written_prescription;
        }
        $doctor_consultation = DoctorConsultation::with(['doctor', 'payment'])->where('id', $id)->first();
        if ($doctor_consultation) {
            $doctor_consultation->status = 1;
            $doctor_consultation->save();
        }
        if ($request->submit_type == 'upload_file' || $request->submit_type == 'both') {
            if ($request->hasFile('prescription_upload')) {
                $file = $request->file('prescription_upload');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destination = public_path('uploads/prescriptions');

                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }

                $file->move($destination, $filename);
                $prescription->file_prescription = 'uploads/prescriptions/' . $filename;
            }
        }
        logConsultationActivity($id, auth()->user()->id, 'Prescribed By Doctor');
        $prescription->save();

        // Notifications
        $user = User::find($doctor_consultation->user_id);
        if (!empty($doctor_consultation->booking_test_id)) {
            $bookingTest = BookingTest::find($doctor_consultation->booking_test_id);
            $package = package::where('package_id', $bookingTest->package_id)->first();
            // User
            sendNotification(
                $user->id,
                'user-prescription-received',
                [
                    'order_id' => $doctor_consultation->payment->order_id,
                    'doctor_name' => $doctor_consultation->doctor->name,
                    'user_name' => $user->name,
                    'test_name' => $package->name,
                    'date'      => now()->format('d-m-Y / h:i A'),
                ]
            );
        } else {

            sendNotification(
                $user->id,
                'user-prescription-received-from-doctor',
                [
                    'order_id' => $doctor_consultation->payment->order_id,
                    'doctor_name' => $doctor_consultation->doctor->name,
                    'user_name' => $user->name,
                    'date'      => now()->format('d-m-Y / h:i A'),
                ]
            );
        }


        // Notification End

        return back()->with('success', 'Prescription saved successfully.');
    }

    public function profile($doctorid)
    {
        $doctor = User::where('user_id', $doctorid)->with(['doctor_details', 'user_details', 'operating_hours'])->first();
        $speciality = Speciality::all();
        return view('backend.superadmin.doctors.profile', compact('doctor', 'speciality'));
    }
    public function refList()
    {
        return view('backend.superadmin.doctors.referring_doctor.list');
    }
    public function referingListView()
    {
        $doctors = User::where('role', 3)->where('refering_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return response()->json($doctors);
    }
    // Store
    public function referingDoctorStore(Request $request)
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

            do {
                $user_id = 'D' . rand(100000, 999999);
            } while (User::where('user_id', $user_id)->exists());

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
                'terms_condition' => true,
                'subscribe' => $request->has('subscribe') ? 1 : 0,
                'password' => Hash::make($validated['password']),
                'show_password' => $validated['password'],
                'role' => 3,
                'profile' => $imagePath ?? 'dummy',
                'refering_id' => auth()->user()->id,
            ]);

            // Create UserDetails
            UserDetails::create([
                'user_id' => $user->id,
                'alternate_phone' => $validated['alternate_phone'] ?? null,
                'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $validated['emergency_contact_phone'] ?? null,
            ]);

            DB::commit();
            return response()->json(['message' => 'Doctor created successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to register doctor: ' . $e->getMessage()
            ], 500);
        }
    }
    public function refer(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'booking_id' => 'required|exists:doctor_consultations,id',
        ]);

        $referred = ReferredConsultation::where('referred_consultation', $request->booking_id)
            ->where('referred_to', $request->doctor_id)
            ->first();

        if ($referred) {
            // Update existing referral
            $referred->notes = $request->notes;
            $referred->referred_by = auth()->user()->id;
            $referred->save();

            $message = 'Referral updated successfully!';
        } else {
            // Create new referral
            $referred = new ReferredConsultation();
            $referred->referred_by = auth()->user()->id;
            $referred->referred_to = $request->doctor_id;
            $referred->referred_consultation = $request->booking_id;
            $referred->notes = $request->notes;
            $referred->save();

            $message = 'Booking referred successfully!';
        }
        logConsultationActivity($request->booking_id, auth()->user()->id, 'Consultation Referred');
        return response()->json(['message' => $message]);
    }
    public function toggleStatus(Request $request, $id)
    {
        $booking = DoctorConsultation::findOrFail($id);

        $booking->status = $request->status;
        $booking->save();

        $statusLabel = match ((int) $booking->status) {
            0 => 'Confirmed',
            1 => 'Completed',
            default => 'Unknown',
        };

        logConsultationActivity(
            $booking->id,
            auth()->user()->id,
            "Consultation status changed to {$statusLabel}"
        );

        return response()->json([
            'message' => 'Booking status updated successfully.',
        ]);
    }

    // Report Doctor Signature Index
    public function reportSignatureIndex()
    {
        return view('backend.superadmin.doctors.signature.list');
    }

    public function upload(Request $request)
    {
        $user = Auth::user();

        // Permission check: Doctor or Lab Doctor
        $isDoctor = $user->role == 3;
        $isLabDoctor = $user->role == 2 && $user->lab_user_role == 5;

        if (!($isDoctor || $isLabDoctor)) {
            return response()->json([
                'message' => 'Only Doctors allowed to upload their signature.'
            ], 403);
        }

        // Validate PNG file (max 2MB)
        $request->validate([
            'signature' => 'required|image|mimes:png|max:2048'
        ]);

        // Generate unique name
        $file = $request->file('signature');
        $filename = uniqid('signature_') . '.png';
        $destination = public_path('uploads/doctor-signatures');

        // Create directory if not exists
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // Delete old signature if it exists
        $existing = DoctorSignature::where('doctor_id', $user->id)->first();
        if ($existing && file_exists(public_path($existing->signature))) {
            @unlink(public_path($existing->signature)); // delete old file
        }

        // Move new file to destination
        $file->move($destination, $filename);

        // Save path in DB (relative to public/)
        $relativePath = 'uploads/doctor-signatures/' . $filename;

        DoctorSignature::updateOrCreate(
            ['doctor_id' => $user->id],
            ['signature' => $relativePath]
        );

        return response()->json([
            'message' => 'Signature uploaded successfully.',
            'path' => asset($relativePath)
        ]);
    }


    // Free Consultation Pending
    public function viewFreeConsultBooking()
    {
        return view('backend.superadmin.doctors.free_consult.list');
    }

    public function viewFreeConsultBookingList()
    {
        $doctorId = auth()->id();
        $user = User::find($doctorId);

        $bookings = DoctorConsultation::with([
            'user',
            'referred.referredToUser'
        ])
            ->where('doctor_id', $user->user_id)
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($booking) {
                $booking->encrypted_id = encrypt($booking->id);
                return $booking;
            });

        return response()->json($bookings);
    }

    // Free Consultation Completed
    public function viewFreeConsultBookingCompleted()
    {
        return view('backend.superadmin.doctors.free_consult.completed');
    }

    public function viewFreeConsultBookingCompletedList()
    {
        $doctorId = auth()->id();
        $user = User::find($doctorId);

        $bookings = DoctorConsultation::with([
            'user',
            'referred.referredToUser'
        ])
            ->where('doctor_id', $user->user_id)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($booking) {
                $booking->encrypted_id = encrypt($booking->id);
                return $booking;
            });

        return response()->json($bookings);
    }


    public function updateFreeConsultSchedule(Request $request)
    {
        $consult = DoctorConsultation::find($request->booking_id);
        if ($consult) {
            $formattedTime = date("h:i A", strtotime($request->appointment_time));
            $consult->appointment_date = $request->appointment_date;
            $consult->appointment_time = $formattedTime;
            $consult->save();

            $bookingTest = BookingTest::find($consult->booking_test_id);
            // Notifications
            $user = User::find($consult->user_id);
            $payment = Payment::find($consult->payment_id);
            $package = package::where('package_id', $bookingTest->package_id)->first();

            // User
            sendNotification(
                $user->id,
                'user-free-consultation-scheduled',
                [
                    'order_id' => $payment->order_id,
                    'user_name' => $user->name,
                    'test_name' => $package->name,
                    'appointment_date' => $consult->appointment_date,
                    'appointment_time' => $consult->appointment_time,
                    'date'      => now()->format('d-m-Y / h:i A'),
                ]
            );

            // Notification End
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function freeConslutBookingProfile($id)
    {
        $dId = decrypt($id);
        $booking = DoctorConsultation::with([
            'user',
            'payment',
            'address',
            'prescriptions' => function ($q) {
                $q->latest();
            },
            'activityLogs.user'
        ])->findOrFail($dId);

        return view('backend.superadmin.doctors.free_consult.profile', compact('booking'));
    }

    public function doctorSelfBooking(Request $request, GoogleCalendarService $googleCalendarService)
    {
        DB::beginTransaction();

        try {
            $user = User::where('user_id', $request->patient)->first();
            $orderId = generateDoctorBookingOrderId();

            // Create Payment
            $payment = Payment::create([
                'type' => 'Doctor',
                'subtotal' => $request->subtotal,
                'discount' => $request->discount ?? 0.00,
                'shipping' => 0,
                'tax' => $request->tax ?? 0.00,
                'total' => $request->total_amount,
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
                'user_id' => $user->id,
                'doctor_id' => $request->doctor_id,
                'address_id' => $request->address,
                'consultation_type' => $request->consult_mode,
                'appointment_date' => $request->date,
                'appointment_time' => $request->time,
                'payment_id' => $payment->id,
                'meeting_url' => $meetingUrl, // <-- Store Google Meet URL
            ]);

            // Prescription Upload
            if ($request->hasFile('prescription')) {
                $file = $request->file('prescription');
                $filename = 'prescription_' . time() . '.pdf';
                $file->move(public_path('uploads/prescriptions'), $filename);

                $booking->prescription_upload = 'uploads/prescriptions/' . $filename;
                $booking->save();
            }

            logConsultationActivity($booking->id, $booking->user_id, 'Consultation Booked');

            DB::commit();

            // Send Notifications
            $doctor = User::where('user_id', $request->doctor_id)->first();
            $consultType = $request->consult_mode == 2 ? 'Online' : 'Offline';

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
}
