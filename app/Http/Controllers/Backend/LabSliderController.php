<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LabSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LabSliderController extends Controller
{
    // index
    public function index()
    {
        return view('backend.superadmin.labs.slider.list');
    }

    // List
    public function list()
    {
        $user = Auth::user();
        $slider = LabSlider::where('lab_id',$user->lab_id)->orderBy('id', 'desc')->get();
        return response()->json($slider);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $request->validate([
                'name' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $sliderImage = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/lab_sliders/' . $sliderImage;
                $request->image->move(public_path('uploads/lab_sliders'), $sliderImage);
            }

            // Create slider
            $slider = LabSlider::create([
                'lab_id' => auth()->user()->lab_id,
                'name' => ucwords($request->name),
                'image' => $imagePath,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Slider added successfully!',
                'data' => $slider
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to store slider: ' . $e->getMessage()
            ], 500);
        }
    }

    // Edit
    public function edit($id)
    {
        $slider = LabSlider::findOrFail($id);

        return response()->json(['slider' => $slider]);
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $slider = LabSlider::findOrFail($id);

            // Validate inputs
            $validated = $request->validate([
                'name' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
            ]);

            // Handle image upload (delete old if exists)
            if ($request->hasFile('image')) {
                if ($slider->image && file_exists(public_path($slider->image))) {
                    unlink(public_path($slider->image));
                }

                $imageName = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/lab_sliders/' . $imageName;
                $request->image->move(public_path('uploads/lab_sliders'), $imageName);

                $slider->image = $imagePath;
            }

            // Update other fields
            $slider->name = $request->name;

            $slider->save();

            DB::commit();

            return response()->json([
                'success' => 'Slider updated successfully!',
                'data' => $slider
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update slider: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update active status
    public function toggleStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:lab_sliders,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $slider = LabSlider::findOrFail($request->id);

            $slider->is_active = $request->status;
            $slider->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $slider
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update slider: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        try {
            $slider = LabSlider::findOrFail($id);

            // Optionally delete image file
            if ($slider->image && file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }

            $slider->delete();

            return response()->json(['success' => true, 'message' => 'Slider deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete slider: ' . $e->getMessage()], 500);
        }
    }
}
