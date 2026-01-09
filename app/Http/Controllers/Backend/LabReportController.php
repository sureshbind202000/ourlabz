<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingPatient;
use App\Models\BookingTest;
use App\Models\ReportLayout;
use Illuminate\Http\Request;

class LabReportController extends Controller
{
    // Index
    public function index()
    {
        return view('backend.superadmin.labs.reports.list');
    }

    public function store(Request $request)
    {
        $request->validate([
            'header' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'footer' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        try {
            $lab_id = auth()->user()->lab_id ?? 1; // Replace with actual lab_id logic

            // Check and delete previous layout for this lab
            $existingLayout = ReportLayout::where('lab_id', $lab_id)->first();
            if ($existingLayout) {
                // Delete old files from public path
                foreach (['header', 'footer'] as $file) {
                    if (!empty($existingLayout->$file) && file_exists(public_path($existingLayout->$file))) {
                        unlink(public_path($existingLayout->$file));
                    }
                }

                // Delete DB record
                $existingLayout->delete();
            }

            // Handle new file uploads
            $paths = [];
            foreach (['header', 'footer'] as $file) {
                if ($request->hasFile($file)) {
                    $filename = time() . '_' . $file . '.' . $request->file($file)->getClientOriginalExtension();
                    $request->file($file)->move(public_path('uploads/layouts'), $filename);
                    $paths[$file] = 'uploads/layouts/' . $filename;
                }
            }

            // Save new layout to DB
            ReportLayout::create([
                'lab_id' => $lab_id,
                'header' => $paths['header'],
                'footer' => $paths['footer'],
                'status' => 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Layout uploaded and saved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function preview(Request $request)
    {
        $lab_id = auth()->user()->lab_id ?? 1;

        $layout = ReportLayout::where('lab_id', $lab_id)->first();

        if (!$layout) {
            return response()->json([
                'success' => false,
                'html' => '<p class="text-center mt-5">No layout uploaded yet.</p>'
            ]);
        }

        $html = view('backend.superadmin.labs.reports.preview', compact('layout'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
    // Verifi Certify Index
    public function verifyCertify()
    {
        return view('backend.superadmin.labs.reports.verify_certify');
    }

    // Verifi Certify Completed Index
    public function verifyCertifyCompleted()
    {
        return view('backend.superadmin.labs.reports.verify_certify_completed');
    }

    // Verifi Certify List
    public function verifyCertifyList()
    {
        $tests = BookingTest::with(['patient', 'package'])
            ->where('fwd_id', auth()->user()->id)
            ->where(function ($q) {
                $q->where('verify', 'Not Verified')
                    ->orWhere('certify', 'Not Certified');
            })
            ->orderBy('id', 'DESC')
            ->get();
        return response()->json($tests);
    }
    // Verifi Certify Completed List
    public function verifyCertifyCompletedList()
    {
        $tests = BookingTest::with(['patient', 'package'])->where('fwd_id', auth()->user()->id)->where('verify', 'Verified')->Where('certify', 'Certified')->orderBy('id', 'DESC')->get();
        return response()->json($tests);
    }

    public function allReport()
    {
        return view('backend.superadmin.labs.reports.all_report');
    }

    public function allReportList()
    {
        $user = auth()->user();

        $bookings = Booking::with([
            'user',
            'patients.test.package',   // attach test directly to patient
            'patients.trackBooking',   // attach tracking directly to patient
        ])->orderBy('created_at', 'desc');

        if ($user->role == 2) {
            $bookings->where('lab_id', $user->lab_id);
        }

        $bookings = $bookings->get();

        $rows = [];
        $counter = 1;

        foreach ($bookings as $booking) {
            foreach ($booking->patients as $patient) {
                $test  = $patient->test; // ✅ directly linked test
                $track = $patient->trackBooking; // ✅ directly linked tracking

                $rows[] = [
                    'sr_no'       => $counter++,
                    'patient'     => ($booking->user ? $booking->user->user_id : '-') . ' - ' . $patient->name,
                    'tracking_id' => $track->tracking_id ?? '-',
                    'test'        => $test?->package->name ?? $test?->name ?? '-',
                    'report'      => $test && $test->report_file ? asset($test->report_file) : null,
                    'status'      => $track->title ?? 'Not Started',
                    'date'        => $booking->created_at->format('d/m/Y'),
                ];
            }
        }

        return response()->json($rows);
    }
}
