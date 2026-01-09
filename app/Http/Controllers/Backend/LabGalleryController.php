<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LabGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LabGalleryController extends Controller
{
    // index
    public function index()
    {
        return view('backend.superadmin.labs.gallery.list');
    }

    // List
    public function list()
    {
        $user = Auth::user();
        $gallery = LabGallery::where('lab_id',$user->lab_id)->orderBy('id', 'desc')->get();
        return response()->json($gallery);
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
                $galleryImage = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/lab_gallery/' . $galleryImage;
                $request->image->move(public_path('uploads/lab_gallery'), $galleryImage);
            }

            // Create gallery
            $gallery = LabGallery::create([
                'lab_id' => auth()->user()->lab_id,
                'name' => ucwords($request->name),
                'image' => $imagePath,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Gallery added successfully!',
                'data' => $gallery
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to store gallery: ' . $e->getMessage()
            ], 500);
        }
    }

    // Edit
    public function edit($id)
    {
        $gallery = LabGallery::findOrFail($id);

        return response()->json(['gallery' => $gallery]);
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $gallery = LabGallery::findOrFail($id);

            // Validate inputs
            $validated = $request->validate([
                'name' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
            ]);

            // Handle image upload (delete old if exists)
            if ($request->hasFile('image')) {
                if ($gallery->image && file_exists(public_path($gallery->image))) {
                    unlink(public_path($gallery->image));
                }

                $imageName = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/lab_gallery/' . $imageName;
                $request->image->move(public_path('uploads/lab_gallery'), $imageName);

                $gallery->image = $imagePath;
            }

            // Update other fields
            $gallery->name = $request->name;

            $gallery->save();

            DB::commit();

            return response()->json([
                'success' => 'Gallery updated successfully!',
                'data' => $gallery
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update gallery: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update active status
    public function toggleStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:lab_galleries,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $gallery = LabGallery::findOrFail($request->id);

            $gallery->is_active = $request->status;
            $gallery->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $gallery
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update gallery: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        try {
            $gallery = LabGallery::findOrFail($id);

            // Optionally delete image file
            if ($gallery->image && file_exists(public_path($gallery->image))) {
                unlink(public_path($gallery->image));
            }

            $gallery->delete();

            return response()->json(['success' => true, 'message' => 'Gallery deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete gallery: ' . $e->getMessage()], 500);
        }
    }
}
