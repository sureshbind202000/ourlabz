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
        'test_ids'   => 'required|array|min:1',
        'booking_id'=> 'required|integer',
    ]);

    $barcodes = [];
    $generator = new BarcodeGeneratorPNG();

    foreach ($request->test_ids as $testId) {

        $test = BookingTest::where('id', $testId)
            ->where('booking_id', $request->booking_id)
            ->first();

        // ❌ Test not found
        if (!$test) {
            continue;
        }

        // ❌ Barcode already generated
        if ($test->is_barcode == 1) {
            continue;
        }

        // ✅ Unique barcode per test
        $barcodeText = 'BK' . $test->booking_id . '-T' . $test->id;

        $barcodeImage = $generator->getBarcode(
            $barcodeText,
            $generator::TYPE_CODE_128
        );

        $base64 = 'data:image/png;base64,' . base64_encode($barcodeImage);

        // ✅ Update DB
        $test->update([
            'barcode'    => $base64,
            'is_barcode' => 1,
        ]);

        $barcodes[] = [
            'test_id'       => $test->id,
            'patient_id'    => $test->booking_patient_id,
            'test_name'     => $test->package->name ?? 'Test',
            'barcode_text'  => $barcodeText,
            'barcode_image' => $base64,
        ];
    }

    if (count($barcodes) === 0) {
        return response()->json([
            'status' => false,
            'message'=> 'Selected tests already have barcodes'
        ]);
    }

    return response()->json([
        'status'   => true,
        'barcodes' => $barcodes
    ]);
}

    // public function generate(Request $request)
    // {
    //     $request->validate([
    //         'test_ids' => 'required|array|min:1',
    //         'booking_id' => 'required|integer',
    //     ]);

    //     $bookingId = $request->booking_id;
    //     $testIds = $request->test_ids;

    //     // Extract only test IDs (ignore patient IDs now)
    //     $testIds = [];

    //     foreach ($testIds as $value) {
    //         $testIds[] = $value;
    //     }

    //     // Remove duplicates just in case
    //     $testIds = array_unique($testIds);

    //     try {
    //         // Create single combined barcode text
    //         $barcodeText = "BK{$bookingId}|TID" . implode(',', $testIds);

    //         $generator = new BarcodeGeneratorPNG();
    //         $barcode = $generator->getBarcode($barcodeText, $generator::TYPE_CODE_128);

    //         $base64 = 'data:image/png;base64,' . base64_encode($barcode);

    //         return response()->json([
    //             'status' => true,
    //             'barcodes' => [[
    //                 'barcode_text' => $barcodeText,
    //                 'barcode_image' => $base64,
    //             ]]
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Barcode generation failed.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

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
