<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CorporateWellnessProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorporateWellnessProgramController extends Controller
{
    // index
    public function index()
    {
        return view('backend.corporate.wellness.list');
    }

    // List
    public function list()
    {
        $wellness = CorporateWellnessProgram::orderBy('status', 'desc')->get();

        foreach ($wellness as $well) {
            $well->encrypted_id = encrypt($well->id); 
        }
        return response()->json($wellness);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate (optional, but good practice)
            $request->validate([
                'title' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
                'contents' => 'required|array|min:1',
                'contents.*' => 'string'
            ]);

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $wellnessImage = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/wellness/' . $wellnessImage;
                $request->image->move(public_path('uploads/wellness'), $wellnessImage);
            }

            // Create wellness
            $wellness = CorporateWellnessProgram::create([
                'title' => ucwords($request->title),
                'image' => $imagePath,
                'content' => $request->contents,
                'description' => $request->description,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Wellness program added successfully!',
                'data' => $wellness
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to store wellness program: ' . $e->getMessage()
            ], 500);
        }
    }

    // Edit
    public function edit($id)
    {
        $wellness = CorporateWellnessProgram::findOrFail($id);

        return response()->json(['wellness' => $wellness]);
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $wellness = CorporateWellnessProgram::findOrFail($id);

            $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'contents' => 'required|array|min:1',
                'contents.*' => 'string',
            ]);

            // Handle image update
            if ($request->hasFile('image')) {
                if ($wellness->image && file_exists(public_path($wellness->image))) {
                    unlink(public_path($wellness->image));
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/wellness'), $imageName);
                $wellness->image = 'uploads/wellness/' . $imageName;
            }

            // Update title and content
            $wellness->title = ucwords($request->title);
            $wellness->content = $request->contents;
            $wellness->description = $request->description;

            $wellness->save();

            DB::commit();

            return response()->json([
                'success' => 'Wellness program updated successfully!',
                'data' => $wellness
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Failed to update wellness program: ' . $e->getMessage()
            ], 500);
        }
    }


    // Delete
    public function destroy($id)
    {
        try {
            $wellness = CorporateWellnessProgram::findOrFail($id);

            // Optionally delete image file
            if ($wellness->image && file_exists(public_path($wellness->image))) {
                unlink(public_path($wellness->image));
            }

            $wellness->delete();

            return response()->json(['success' => true, 'message' => 'Wellness program deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete Wellness program: ' . $e->getMessage()], 500);
        }
    }

    // Status
    public function toggleStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:corporate_wellness_programs,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $wellness = CorporateWellnessProgram::findOrFail($request->id);
            $wellness->status = $request->status;   // make sure you have a `status` column
            $wellness->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $wellness
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function wellnessDetails()
    {
        return view('backend.corporate.wellness.details');
    }
}
