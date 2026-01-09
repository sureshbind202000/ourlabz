<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingBarcode;
use App\Models\BookingTest;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class BarcodeController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'assignments' => 'required|array|min:1',
            'booking_id' => 'required|integer',
        ]);

        $bookingId = $request->booking_id;
        $assignments = $request->assignments;

        // Extract only test IDs (ignore patient IDs now)
        $testIds = [];

        foreach ($assignments as $value) {
            [$patientId, $testId] = explode('_', $value);
            $testIds[] = $testId;
        }

        // Remove duplicates just in case
        $testIds = array_unique($testIds);

        try {
            // Create single combined barcode text
            $barcodeText = "BK{$bookingId}|TID" . implode(',', $testIds);

            $generator = new BarcodeGeneratorPNG();
            $barcode = $generator->getBarcode($barcodeText, $generator::TYPE_CODE_128);

            $base64 = 'data:image/png;base64,' . base64_encode($barcode);

            return response()->json([
                'status' => true,
                'barcodes' => [[
                    'barcode_text' => $barcodeText,
                    'barcode_image' => $base64,
                ]]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Barcode generation failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function scan(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $code = $request->code;

        try {
            // Example: BK12|TID5,6,7
            if (!preg_match('/^BK(\d+)\|TID([\d,]+)$/', $code, $matches)) {
                return response()->json(['status' => false, 'message' => 'Invalid barcode format']);
            }

            $bookingId = $matches[1];
            $testIds = explode(',', $matches[2]);

            $booking = Booking::with('user')->find($bookingId);
            if (!$booking) {
                return response()->json(['status' => false, 'message' => 'Booking not found']);
            }

            $tests = BookingTest::with('package')
                ->whereIn('id', $testIds)
                ->get()
                ->unique(function ($test) {
                    return $test->package_id ?? $test->package->name;
                })
                ->map(function ($test) {
                    return [
                        'id' => $test->id,
                        'name' => $test->package->name ?? 'Unknown Test',
                        'sample_type_specimen' => $test->package->sample_type_specimen ?? 'Unknown Test'
                    ];
                })
                ->values(); // ensure indexed array

            return response()->json([
                'status' => true,
                'booking' => [
                    'id' => $booking->order_id,
                    'user_name' => $booking->user->name,
                    'created_at' => $booking->created_at->format('d M Y, g:i A')
                ],
                'tests' => $tests
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Scan failed',
                'error' => $e->getMessage()
            ]);
        }
    }
}
