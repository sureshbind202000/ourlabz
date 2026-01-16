<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingPatient;
use App\Models\BookingTest;
use App\Models\DoctorSignature;
use App\Models\lab;
use App\Models\package;
use App\Models\ReferedTest;
use App\Models\ReportLayout;
use App\Models\TrackBookingLog;
use App\Models\TrackBookingStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;
use App\Services\SmsService;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LabBookingController extends Controller
{
    // Patient Bookings
    public function index()
    {

        $lab = lab::where('lab_id', auth()->user()->lab_id)->first();
        $users = User::where('role', 1)->get();
        $tests = package::all();
        return view('backend.superadmin.labs.bookings.list', compact('lab', 'users', 'tests'));
    }

    public function completedIndex()
    {
        return view('backend.superadmin.labs.bookings.completed');
    }

    // Patient Booking List
    public function list(Request $request)
    {
        try {
            $authUser = auth()->user();

            if ($authUser->role == 2) {
                $labId = $authUser->lab_id;

                $query = Booking::with(['user', 'tests.package', 'patients'])
                    ->where('lab_id', $labId)
                    ->where('booking_type', 'test')
                    ->whereNotIn('status', ['Completed', 'Cancelled'])
                    ->whereHas('user')
                    ->orderBy('id', 'DESC');

                if(isset($request->is_emergency) && $request->is_emergency == 1){
                    $query->where('is_emergency', 1);
                }

                if(isset($request->is_read) && $request->is_read == 0){
                    $query->where('is_read', 0);
                }

                if(isset($request->in_progress) && $request->in_progress == 1){
                    $query->where('status', 'In Progress');

                }

                    $bookings = $query->get();

                foreach ($bookings as $booking) {
                    $booking->encrypted_id = encrypt($booking->id);
                }

                return response()->json($bookings);
            }

            return response()->json(['message' => 'Unauthorized'], 403);
        } catch (\Throwable $e) {
            // \Log::error('Booking List Error: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function toggleEmergency(Request $request)
    {
        Booking::where('id', $request->booking_id)
            ->update(['is_emergency' => $request->is_emergency]);

        return response()->json(['success' => true]);
    }


    public function completedList()
    {
        try {
            $authUser = auth()->user();

            if ($authUser->role == 2) {
                $labId = $authUser->lab_id;

                $bookings = Booking::with(['user', 'tests.package', 'patients'])
                    ->where('lab_id', $labId)
                    ->where('booking_type', 'test')
                    ->whereIn('status', ['Completed', 'Cancelled'])
                    ->whereHas('user')
                    ->orderBy('id', 'DESC')
                    ->get();

                foreach ($bookings as $booking) {
                    $booking->encrypted_id = encrypt($booking->id);
                }

                return response()->json($bookings);
            }

            return response()->json(['message' => 'Unauthorized'], 403);
        } catch (\Throwable $e) {
            // \Log::error('Booking List Error: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    // Booking Details
    public function profile($id)
    {
        $booking_id = decrypt($id);
        $details = Booking::with(['user', 'tests.package', 'patients', 'trackSamples'])->where('id', $booking_id)->first();
        $lab_phlebotomist = User::where('lab_id', auth()->user()->lab_id)->where('lab_user_role', 4)->where('status', 1)->get();
        $logs = TrackBookingLog::with('user')
            ->where('booking_id', $booking_id)
            ->latest()
            ->get();

        $auth = auth()->user();
        if ($auth->role  == 2) {
            $refering_id = User::where('lab_id', $auth->lab_id)->where('lab_user_role', 1)->pluck('id');
        }
        $refering_lab_admin = User::where('role', 2)->where('lab_user_role', 1)->where('refering_id', $refering_id)->first();
        $refering_labs = collect();
        if ($refering_lab_admin) {
            $refering_labs = lab::where('lab_id', $refering_lab_admin->lab_id)->select(['id', 'lab_name', 'lab_id'])->orderBy('id', 'DESC')->get();
        }
        $refering_tests = ReferedTest::where('refered_by_id', $auth->lab_id)->orderBy('id', 'DESC')->get();
        $doctors = User::where('role', 2)->where('lab_id', $auth->lab_id)->where('lab_user_role', 5)->where('status', 1)->get();

        // update is_read status to 1 (read)
        if ($details->is_read == 0) {
            $details->is_read = 1;
            $details->save();
        }

        return view('backend.superadmin.labs.bookings.profile', compact('details', 'lab_phlebotomist', 'logs', 'refering_labs', 'refering_tests', 'doctors'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Delete related data first
            BookingPatient::where('booking_id', $id)->delete();
            BookingTest::where('booking_id', $id)->delete();

            // Delete the main booking
            Booking::where('id', $id)->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Upload Manual Report
    public function uploadManualReport(Request $request)
    {
        $request->validate([
            'report_file' => 'required|file|mimes:pdf|max:10240',
            'report_type' => 'required',
            'patient_id' => 'required',
        ]);

        $lab_id = auth()->user()->lab_id;
        $report_layout = ReportLayout::where('lab_id', $lab_id)->first();

        $pdfFile = $request->file('report_file');
        $tempPath = $pdfFile->getPathname();

        if (!$report_layout || !$report_layout->header || !$report_layout->footer) {
            return response()->json([
                'message' => 'Please add header and footer in report layout before uploading any report.'
            ], 422);
        }

        $headerImagePath = public_path($report_layout->header);
        $footerImagePath = public_path($report_layout->footer);

        if (!file_exists($headerImagePath) || !file_exists($footerImagePath)) {
            return response()->json([
                'message' => 'Please add header and footer in report layout before uploading any report.'
            ], 422);
        }

        [$headerImgWidth, $headerImgHeight] = getimagesize($headerImagePath);
        [$footerImgWidth, $footerImgHeight] = getimagesize($footerImagePath);

        $fpdi = new Fpdi();
        $pageCount = $fpdi->setSourceFile($tempPath);

        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($templateId);

            // Calculate image height to maintain aspect ratio based on PDF width
            $headerHeight = ($headerImgHeight / $headerImgWidth) * $size['width'];
            $footerHeight = ($footerImgHeight / $footerImgWidth) * $size['width'];

            $newPageWidth = $size['width'];
            $newPageHeight = $headerHeight + $size['height'] + $footerHeight;

            // Create a new taller page
            $fpdi->AddPage('', [$newPageWidth, $newPageHeight]);

            // Insert header at top
            $fpdi->Image($headerImagePath, 0, 0, $newPageWidth);

            // Insert original PDF content below the header
            $fpdi->useTemplate($templateId, 0, $headerHeight, $size['width'], $size['height']);

            // Insert footer at bottom
            $fpdi->Image($footerImagePath, 0, $headerHeight + $size['height'], $newPageWidth);
        }

        $outputFileName = 'report_' . time() . '.pdf';
        $outputDir = public_path('manual_reports');
        $outputPath = $outputDir . '/' . $outputFileName;

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $fpdi->Output($outputPath, 'F');
        $booking_test = BookingTest::where('booking_patient_id', $request->patient_id)->first();
        if (!$booking_test) {
            return response()->json(['message' => 'Booking test not found for the given patient ID.'], 404);
        }
        $booking_test->report_type = $request->report_type;
        $booking_test->report_file = 'manual_reports/' . $outputFileName;
        $booking_test->save();
        $booking = Booking::find($booking_test->booking_id);
        logBookingActivity($booking->id, 'Report Uploaded', '#' . $booking->order_id . ' Manual report uploaded.');
        return response()->json([
            'message' => 'PDF uploaded successfully with header & footer added (no overlap).',
            'file_url' => asset('manual_reports/' . $outputFileName),
        ]);
    }

    public function uploadAutoReport(Request $request)
    {
        $request->validate([
            'patient_id' => 'required'
        ]);

        $user = auth()->user();

        $patient = BookingPatient::find($request->patient_id);
        if (!$patient) {
            return response()->json(['message' => 'Patient not found.'], 404);
        }

        // Fetch booking test
        $booking_test = BookingTest::with('package')
            ->where('booking_patient_id', $patient->id)
            ->first();

        if (!$booking_test) {
            return response()->json(['message' => 'Test not found for patient.'], 404);
        }

        $testName = $booking_test->package->name;


        /* ============================================================
       GET CORRECT MOBILE NUMBER (FIX)
    ============================================================ */

        // Clean + detect correct patient mobile number
        $mobile = preg_replace('/[^0-9]/', '', (
            $patient->mobile
            ?? $patient->phone
            ?? $patient->contact
            ?? $patient->mobile_no
            ?? $user->mobile
            ?? null
        ));

        if (!$mobile || strlen($mobile) < 10) {
            return response()->json(['message' => 'Valid patient mobile not available.'], 422);
        }

        // Use last 10 digits only
        $mobile = substr($mobile, -10);


        /* ============================================================
       CALL SOLARLIMS API USING CURL (WORKING FIX)
    ============================================================ */

        try {
            $apiUrl = "https://solarlims.in/api/LabReports/getpatientlabreports?MobileNo={$mobile}";

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => [
                    "User-Agent: Mozilla/5.0",
                    "Accept: application/json",
                ],
            ]);

            $response = curl_exec($curl);
            $status   = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($status !== 200 || !$response) {
                return response()->json(['message' => 'Failed to fetch report from external server.'], 422);
            }

            $data = json_decode($response, true);

            if (empty($data['success']) || empty($data['data'])) {
                return response()->json(['message' => 'No reports available for this patient.'], 404);
            }

            // Match report by test name
            $matched = collect($data['data'])->first(function ($item) use ($testName) {
                return stripos($item['testName'] ?? '', $testName) !== false;
            });

            if (!$matched) {
                return response()->json(['message' => 'No matching report found for this test.'], 404);
            }

            $pdfUrl = 'https://solarlims.in/uploads/' . ltrim($matched['pdfFile'], '/');
        } catch (\Exception $e) {
            return response()->json(['message' => 'External server error.'], 500);
        }


        /* ============================================================
       DOWNLOAD PDF
    ============================================================ */

        $outputDir = public_path('auto_reports');
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $outputFileName = 'auto_report_' . time() . '.pdf';
        $outputPath = $outputDir . '/' . $outputFileName;

        try {
            file_put_contents($outputPath, file_get_contents($pdfUrl));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to download report PDF.'], 422);
        }


        /* ============================================================
       SAVE IN DATABASE
    ============================================================ */

        $booking_test->report_type = 'auto';
        $booking_test->report_file = 'auto_reports/' . $outputFileName;
        $booking_test->save();

        logBookingActivity(
            $booking_test->booking_id,
            'Auto Report Uploaded',
            '#' . $booking_test->booking->order_id . ' Auto report uploaded.'
        );


        return response()->json([
            'message' => 'Auto report uploaded successfully.',
            'file_url' => asset('auto_reports/' . $outputFileName),
        ]);
    }

    public function deleteReport($id)
    {
        $bookingTest = BookingTest::findOrFail($id);

        if ($bookingTest->report_file && file_exists(public_path($bookingTest->report_file))) {
            unlink(public_path($bookingTest->report_file));
        }

        $bookingTest->report_type = null;
        $bookingTest->report_file = null;
        $bookingTest->verify = 'Not Verified';
        $bookingTest->certify = 'Not Certified';
        $bookingTest->save();

        $booking = Booking::find($bookingTest->booking_id);

        if ($booking->track_status) {
            $booking->track_status = 3;
            $booking->save();
        }
        logBookingActivity($booking->id, 'Report Uploaded', '#' . $booking->order_id . ' Report deleted.');
        return response()->json(['status' => true, 'message' => 'Report deleted successfully.']);
    }


    public function verifyReport(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:booking_tests,id',
        ]);

        $user = auth()->user();

        $isDoctor = $user->role == 3;
        $isLabDoctor = $user->role == 2 && $user->lab_user_role == 5;

        if (!($isDoctor || $isLabDoctor)) {
            return response()->json([
                'message' => 'Only Doctors are allowed to verify reports.'
            ], 403);
        }

        $bookingTest = BookingTest::find($request->test_id);
        $bookingTest->verify = 'Verified';
        $bookingTest->verify_id = $user->id;
        $bookingTest->save();

        $booking = Booking::find($bookingTest->booking_id);

        // Get associated patient
        $patient = BookingPatient::find($bookingTest->booking_patient_id);

        // Handle booking status tracking
        $existingTracking = TrackBookingStatus::where('booking_patient_id', $patient->id)->first();

        if ($existingTracking) {

            // Update existing tracking status
            $existingTracking->update([
                'status' => 4,
                'title'  => 'Report Ready',
            ]);
        } else {

            // Generate unique tracking ID
            do {
                $trackingId = Str::upper(Str::random(10));
            } while (TrackBookingStatus::where('tracking_id', $trackingId)->exists());

            TrackBookingStatus::create([
                'tracking_id'         => $trackingId,
                'booking_patient_id'  => $patient->id,
                'status'              => 4,
                'title'               => 'Report Ready',
            ]);
        }


        logBookingActivity($booking->id, 'Report Verified', '#' . $booking->order_id . ' Report verified.');

        // Notifications
        $doctor = $user; // logged-in doctor who verified the report
        $lab = lab::where('lab_id', $booking->lab_id)->first();
        $labAdmin = User::where('lab_id', $booking->lab_id)->where('role', 2)->where('lab_user_role', 1)->first();
        // Lab Doctor
        sendNotification(
            $labAdmin->id,
            'lab-doctor-verified-report',
            [
                'doctor_name' => $doctor->name,
                'order_id' => $booking->order_id,
                'user_name' => $patient->name,
                'lab_name' => $lab->lab_name,
                'date'      => now()->format('d-m-Y / h:i A'),
            ]
        );

        // Notification End

        return response()->json(['message' => 'Report marked as verified.']);
    }

    public function certifyReport(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:booking_tests,id',
        ]);

        $user = auth()->user();

        $isDoctor = $user->role == 3;
        $isLabDoctor = $user->role == 2 && $user->lab_user_role == 5;

        if (!($isDoctor || $isLabDoctor)) {
            return response()->json([
                'message' => 'Only Doctors are allowed to certify reports.'
            ], 403);
        }

        $bookingTest = BookingTest::find($request->test_id);
        $bookingTest->certify = 'Certified';
        $bookingTest->certify_id = $user->id;
        if (package::where('package_id', $bookingTest->package_id)->where('free_consultation', 'Yes')->exists()) {
            $bookingTest->free_consultation = 1;
        }

        try {
            if ($bookingTest->report_type == 'Manual' && $bookingTest->report_file) {
                $newPath = $this->addSignatureToPdf($bookingTest->report_file);
                $bookingTest->report_file = $newPath;
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

        $bookingTest->save();

        $booking = Booking::find($bookingTest->booking_id);

        // Get associated patient
        $patient = BookingPatient::find($bookingTest->booking_patient_id);

        // Handle booking status tracking
        $existingTracking = TrackBookingStatus::where('booking_patient_id', $patient->id)->first();

        if ($existingTracking) {

            // Update existing tracking status
            $existingTracking->update([
                'status' => 5,
                'title'  => 'Report Delivered',
            ]);
        } else {

            // Generate unique tracking ID
            do {
                $trackingId = Str::upper(Str::random(10));
            } while (TrackBookingStatus::where('tracking_id', $trackingId)->exists());

            TrackBookingStatus::create([
                'tracking_id'         => $trackingId,
                'booking_patient_id'  => $patient->id,
                'status'              => 5,
                'title'               => 'Report Delivered',
            ]);
        }

        logBookingActivity($booking->id, 'Report Certified', '#' . $booking->order_id . ' Report certified.');

        // Notifications
        $doctor = $user; // logged-in doctor who verified the report
        $lab = lab::where('lab_id', $booking->lab_id)->first();
        $labAdmin = User::where('lab_id', $booking->lab_id)->where('role', 2)->where('lab_user_role', 1)->first();

        // Lab Doctor
        sendNotification(
            $labAdmin->id,
            'lab-doctor-certified-report',
            [
                'doctor_name' => $doctor->name,
                'order_id' => $booking->order_id,
                'user_name' => $patient->name,
                'lab_name' => $lab->lab_name,
                'date'      => now()->format('d-m-Y / h:i A'),
            ]
        );

        // User
        $bookingUser = $booking->user;
        sendNotification(
            $bookingUser->id,
            'lab-doctor-certified-report-to-user',
            [
                'order_id' => $booking->order_id,
                'user_name' => $patient->name,
                'date'      => now()->format('d-m-Y / h:i A'),
            ]
        );

        // Notification End
        $bookingTests = BookingTest::where('booking_id', $booking->id)->get();

        if ($bookingTests->count() > 0 && $bookingTests->every(fn($test) => $test->verify === "Verified" && $test->certify === "Certified")) {

            $booking->status = 'Completed';
            $booking->save();
        }

        return response()->json(['message' => 'Report marked as certified.']);
    }

    protected function addSignatureToPdf($relativeReportPath)
    {
        $fullPath = public_path($relativeReportPath);
        $directory = dirname($relativeReportPath);
        $originalName = basename($relativeReportPath);

        $newFileName = 'signed_' . uniqid() . '.pdf';
        $newRelativePath = $directory . '/' . $newFileName;
        $newFullPath = public_path($newRelativePath);

        $lab_id = auth()->user()->lab_id;
        $report_layout = ReportLayout::where('lab_id', $lab_id)->first();
        $doctorId = auth()->id();
        $doctorSignature = DoctorSignature::where('doctor_id', $doctorId)->first();

        if (!$doctorSignature || !file_exists(public_path($doctorSignature->signature))) {
            throw new \Exception('Doctor signature is missing. Please upload signature.');
        }

        $signaturePath = public_path($doctorSignature->signature);
        $signaturePath = $this->ensurePng($signaturePath);

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($fullPath);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            if ($pageNo === $pageCount) {
                $width = $size['width'];
                $height = $size['height'];
                $pdf->Image(str_replace('\\', '/', $signaturePath), $width - 50, $height - 80, 40);
            }
        }

        $pdf->Output($newFullPath, 'F');

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        return $newRelativePath;
    }

    protected function ensurePng($path)
    {
        $imageInfo = getimagesize($path);

        // If already PNG, return as is
        if ($imageInfo['mime'] === 'image/png') {
            return $path;
        }

        // Convert to PNG
        $image = imagecreatefromstring(file_get_contents($path));
        $newFileName = 'signature_' . uniqid() . '.png';
        $newRelativePath = 'uploads/layouts/' . $newFileName;
        $newPath = public_path($newRelativePath);

        imagepng($image, $newPath);
        imagedestroy($image);

        // Delete old signature
        if (file_exists($path)) {
            unlink($path);
        }

        // Update report_layout table
        $lab_id = auth()->user()->lab_id;
        $reportLayout = ReportLayout::where('lab_id', $lab_id)->first();
        if ($reportLayout) {
            $reportLayout->signature = $newRelativePath;
            $reportLayout->save();
        }

        return $newPath;
    }

    public function forward(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:booking_tests,id',
            'doctor_id' => 'required|exists:users,id'
        ]);

        $test = BookingTest::findOrFail($request->test_id);
        $test->fwd_id = $request->doctor_id;
        $test->save();

        $doctor = User::findOrFail($request->doctor_id);
        $patient = BookingPatient::findOrFail($test->booking_patient_id);
        $lab = lab::where('lab_id', $doctor->lab_id)->first();
        $booking = Booking::findOrFail($patient->booking_id);

        // Notifications

        // Lab Doctor
        sendNotification(
            $doctor->id,
            'lab-send-report-to-doctor',
            [
                'doctor_name' => $doctor->name,
                'order_id' => $booking->order_id,
                'user_name' => $patient->name,
                'lab_name' => $lab->lab_name,
                'date'      => now()->format('d-m-Y / h:i A'),
            ]
        );

        // Notification End


        return response()->json(['message' => 'Report successfully forwarded to ' . $doctor->name . '.']);
    }

    public function labBookingStore(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = User::where('user_id', $request->patient)->first();
            $orderId = generateUniqueOrderId();

            // Fallbacks for missing numeric values
            $subtotal = is_numeric($request->subtotal) ? $request->subtotal : 0;
            $discount = is_numeric($request->discount) ? $request->discount : 0;
            $tax = is_numeric($request->tax) ? $request->tax : 0;
            $total = is_numeric($request->total_amount) ? $request->total_amount : 0;

            $lab = lab::where('lab_id', $request->lab_id)->firstOrFail();
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

            // ✅ Packages & Patients
            $bookingPatient = BookingPatient::create([
                'booking_id' => $booking->id,
                'name'       => $request->name,
                'phone'      => $request->phone,
                'email'      => $user->email ?? null,
                'gender'     => $request->gender,
                'dob'        => $request->dob,
                'age'        => $user->age ?? null,
                'relation'   => 'Self',
            ]);

            foreach ($request->booking_test ?? [] as $packageId) {
                $package = package::find($packageId);

                BookingTest::create([
                    'booking_id'            => $booking->id,
                    'booking_patient_id'    => $bookingPatient->id,
                    'package_id'            => $packageId,
                    'price_at_booking_time' => $package->price ?? 0,
                ]);
            }

            if ($request->hasFile('prescription')) {
                $file = $request->file('prescription');
                $fileName = 'prescription_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/prescriptions'), $fileName);
                $bookingPatient->update([
                    'prescription' => 'uploads/prescriptions/' . $fileName,
                ]);
            }

            TrackBookingStatus::create([
                'tracking_id'         => Str::upper(Str::random(10)),
                'booking_patient_id'  => $bookingPatient->id,
                'status'              => 1,
                'title'               => 'Booking Confirmed',
            ]);

            // ✅ Payment record
            Payment::create([
                'type'           => 'Lab',
                'subtotal'       => $subtotal,
                'coupon'         => $request->coupon ?? null,
                'discount'       => $discount,
                'discount_type'  => $request->discount_type ?? null,
                'total'          => $total,
                'order_id'       => $booking->id,
                'transaction_id' => $request->razorpay_payment_id ?? null,
                'payment_status' => $request->payment_status ?? 'Paid',
            ]);

            // ✅ Notifications
            $allTestNames = collect($request->packages)
                ->map(fn($pkg) => $pkg['name'] ?? 'Test')
                ->implode(', ');

            DB::commit();

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

            if ($user && !empty($user->phone && $booking->sample_collection == 0)) {

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
}
