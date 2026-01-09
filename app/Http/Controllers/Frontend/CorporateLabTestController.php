<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CorporateLabTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorporateLabTestController extends Controller
{
    // Lab test Index
    public function labTestIndex()
    {
        $lab_test = CorporateLabTest::first();
        return view('backend.corporate.lab_test.list', compact('lab_test'));
    }

    // Lab Test Update
    public function labTestUpdate(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $lab_test = CorporateLabTest::findOrFail($id);

            // Validate inputs
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            if ($request->hasFile('image')) {
                
                if ($lab_test->image && file_exists(public_path($lab_test->image))) {
                    unlink(public_path($lab_test->image));
                }

                // Store new image
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/lab_test'), $imageName);

                $lab_test->image = 'uploads/lab_test/' . $imageName;
            }

            // Assign other fields
            $lab_test->title = $request->title;
            $lab_test->content = $request->content;
            $lab_test->save();

            DB::commit();

            return response()->json([
                'success' => 'Lab test content updated successfully!',
                'data' => $lab_test
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update lab test content: ' . $e->getMessage()
            ], 500);
        }
    }
}
