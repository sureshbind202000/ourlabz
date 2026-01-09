<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomeBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    // index
    public function index()
    {
        return view('backend.website.homepage.brand.list');
    }

    // List
    public function list()
    {
        $brand = HomeBrand::orderBy('sort_order', 'asc')->get();
        return response()->json($brand);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $request->validate([
                'name' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'link' => 'nullable|string|max:255',
                'sort_order' => 'nullable',
            ]);

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $bannerImage = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/brands/' . $bannerImage;
                $request->image->move(public_path('uploads/brands'), $bannerImage);
            }

            // Create banner
            $brand = HomeBrand::create([
                'name' => strtoupper($request->name),
                'image' => $imagePath,
                'link' => strtoupper($request->link),
                'sort_order' => $request->sort_order ?? 0,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Brand added successfully!',
                'data' => $brand
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to store banner: ' . $e->getMessage()
            ], 500);
        }
    }

    // Edit
    public function edit($id)
    {
        $brand = HomeBrand::findOrFail($id);

        return response()->json(['brand' => $brand]);
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $brand = HomeBrand::findOrFail($id);

            // Validate inputs
            $validated = $request->validate([
                'name' => 'required',
                'link' => 'nullable',
                'sort_order' => 'nullable|integer',
                'image' => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
            ]);

            // Handle image upload (delete old if exists)
            if ($request->hasFile('image')) {
                if ($brand->image && file_exists(public_path($brand->image))) {
                    unlink(public_path($brand->image));
                }

                $imageName = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/brands/' . $imageName;
                $request->image->move(public_path('uploads/brands'), $imageName);

                $brand->image = $imagePath;
            }

            // Update other fields
            $brand->name = $request->name;
            $brand->link = $request->link;
            $brand->sort_order = $request->sort_order ?? 0;

            $brand->save();

            DB::commit();

            return response()->json([
                'success' => 'Brand updated successfully!',
                'data' => $brand
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update brand: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update active status
    public function toggleStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:home_brands,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $brand = HomeBrand::findOrFail($request->id);

            $brand->is_active = $request->status;
            $brand->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $brand
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
    public function destroy($id)
    {
        try {
            $brand = HomeBrand::findOrFail($id);

            // Optionally delete image file
            if ($brand->image && file_exists(public_path($brand->image))) {
                unlink(public_path($brand->image));
            }

            $brand->delete();

            return response()->json(['success' => true, 'message' => 'Brand deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete brand: ' . $e->getMessage()], 500);
        }
    }
}
