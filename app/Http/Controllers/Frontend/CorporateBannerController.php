<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CorporateBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorporateBannerController extends Controller
{
    // index
    public function index()
    {
        return view('backend.corporate.banner.list');
    }

    // List
    public function list()
    {
        $banner = CorporateBanner::orderBy('status', 'desc')->get();
        return response()->json($banner);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate (optional, but good practice)
            $request->validate([
                'name' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'heading' => 'nullable|string|max:255',
                'paragraph' => 'nullable|string',
                'button_text' => 'nullable|string|max:255',
                'button_link' => 'nullable|max:255',
                'button_text2' => 'nullable|string|max:255',
                'button_link2' => 'nullable|max:255',
                'sort' => 'nullable|integer',
            ]);

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $bannerImage = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/banners/' . $bannerImage;
                $request->image->move(public_path('uploads/banners'), $bannerImage);
            }

            // Create banner
            $banner = CorporateBanner::create([
                'name' => $request->name,
                'image' => $imagePath,
                'heading' => ucwords($request->heading),
                'heading2' => ucwords($request->heading2),
                'heading3' => ucwords($request->heading3),
                'paragraph' => $request->paragraph,
                'button_text' => ucwords($request->button_text),
                'button_link' => $request->button_link,
                'button_text2' => ucwords($request->button_text2),
                'button_link2' => $request->button_link2,
                'sort' => $request->sort ?? 0,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Banner added successfully!',
                'data' => $banner
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
        $banner = CorporateBanner::findOrFail($id);

        return response()->json(['banner' => $banner]);
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $banner = CorporateBanner::findOrFail($id);

            // Validate (add more rules if needed)
            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            // Handle image update
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/banners'), $imageName);
                $banner->image = 'uploads/banners/' . $imageName;
            }

            // Update other fields
            $banner->name = $request->name;
            $banner->heading = $request->heading;
            $banner->heading2 = $request->heading2;
            $banner->heading3 = $request->heading3;
            $banner->paragraph = $request->paragraph;
            $banner->button_text = $request->button_text;
            $banner->button_link = $request->button_link;
            $banner->button_text2 = $request->button_text2;
            $banner->button_link2 = $request->button_link2;
            $banner->sort = $request->sort ?? 0;
            $banner->save();

            DB::commit();

            return response()->json(['success' => 'Banner updated successfully!', 'data' => $banner]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update banner: ' . $e->getMessage()], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        try {
            $banner = CorporateBanner::findOrFail($id);

            // Optionally delete image file
            if ($banner->image && file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }

            $banner->delete();

            return response()->json(['success' => true, 'message' => 'Banner deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete banner: ' . $e->getMessage()], 500);
        }
    }

    // Status
    public function toggleStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:corporate_banners,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $banner = CorporateBanner::findOrFail($request->id);
            $banner->status = $request->status;   // make sure you have a `status` column
            $banner->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $banner
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }
    // Product Status
    public function toggleProductStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:banners,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $banner = CorporateBanner::findOrFail($request->id);
            $banner->product_id = $request->status;
            $banner->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product status updated successfully.',
                'data'    => $banner
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }
}
