<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CorporateHospitalAssistance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorporateHospitalAssistanceController extends Controller
{
    // Corporate Hospital Assistance Index
    public function hospitalAssistanceIndex()
    {
        $hospital_assistance = CorporateHospitalAssistance::first();
        return view('backend.corporate.hospital_assistance.list', compact('hospital_assistance'));
    }

    // Corporate Hospital Assistance Update
    public function hospitalAssistanceUpdate(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $lab_test = CorporateHospitalAssistance::findOrFail($id);

            // Validate all inputs
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'heading' => 'nullable|string|max:255',
                'content' => 'required|string',
                'heading2' => 'nullable|string|max:255',
                'content2' => 'nullable|string',
                'card_title1' => 'nullable|string|max:255',
                'card_content1' => 'nullable|string',
                'card_title2' => 'nullable|string|max:255',
                'card_content2' => 'nullable|string',
                'card_title3' => 'nullable|string|max:255',
                'card_content3' => 'nullable|string',

                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'card_image1' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'card_image2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'card_image3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            // Handle image fields dynamically
            $imageFields = ['image', 'card_image1', 'card_image2', 'card_image3'];

            foreach ($imageFields as $field) {
                if ($request->hasFile($field)) {
                    // Delete old image if exists
                    if ($lab_test->$field && file_exists(public_path($lab_test->$field))) {
                        unlink(public_path($lab_test->$field));
                    }

                    // Store new image
                    $image = $request->file($field);
                    $imageName = time() . '_' . $field . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/hospital_assistance'), $imageName);

                    $lab_test->$field = 'uploads/hospital_assistance/' . $imageName;
                }
            }

            // Assign text fields
            $lab_test->title = $request->title;
            $lab_test->heading = $request->heading;
            $lab_test->content = $request->content;
            $lab_test->heading2 = $request->heading2;
            $lab_test->content2 = $request->content2;

            $lab_test->card_title1 = $request->card_title1;
            $lab_test->card_content1 = $request->card_content1;

            $lab_test->card_title2 = $request->card_title2;
            $lab_test->card_content2 = $request->card_content2;

            $lab_test->card_title3 = $request->card_title3;
            $lab_test->card_content3 = $request->card_content3;

            $lab_test->save();

            DB::commit();

            return response()->json([
                'success' => 'Hospital assistance content updated successfully!',
                'data' => $lab_test
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update hospital assistance content: ' . $e->getMessage()
            ], 500);
        }
    }
}
