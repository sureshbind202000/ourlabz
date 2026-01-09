<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PackageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PackageCategoryController extends Controller
{
    // Index
    public function index()
    {
        return view('backend.superadmin.category.list');
    }

    // List
    public function list()
    {
        $category = PackageCategory::orderBy('status', 'desc')->get();
        return response()->json($category);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $existingCategory = PackageCategory::where('category_name', ucwords($request->category_name))
                ->where('type', ucwords($request->type))
                ->first();

            if ($existingCategory) {
                return response()->json([
                    'error' => "This {$request->category_name} Category is already registered with " . ucwords($request->type)
                ], 409);
            }
            $categoryImage = null;
            if ($request->hasFile('category_image')) {
                $categoryImage = time() . '.' . $request->category_image->extension();
                $imagePath = 'uploads/package_category_image/' . $categoryImage;
                $request->category_image->move(public_path('uploads/package_category_image'), $categoryImage);
            }

            $category = PackageCategory::create([
                'slug' => Str::slug($request->category_name),
                'type' => ucwords($request->type),
                'category_name' => ucwords($request->category_name),
                'sort' => $request->sort,
                'category_image' => $imagePath ?? 'dummy',
            ]);

            DB::commit();

            return response()->json(['success' => 'Category added successfully!', 'data' => $category]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store category: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $category = PackageCategory::findOrFail($id);

        return response()->json(['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $category = PackageCategory::findOrFail($id);

            $categoryData = [
                'type' => ucwords($request->type),
                'category_name' => ucwords($request->category_name),
                'sort' => $request->sort,
            ];

            if ($request->hasFile('category_image')) {
                if ($category->category_image && file_exists(public_path($category->category_image))) {
                    unlink(public_path($category->category_image));
                }

                $categoryImage = time() . '.' . $request->category_image->extension();
                $imagePath = 'uploads/package_category_image/' . $categoryImage;
                $request->category_image->move(public_path('uploads/package_category_image'), $categoryImage);
                $categoryData['category_image'] = $imagePath;
            }

            $category->update($categoryData);


            DB::commit();
            return response()->json(['success' => 'Category updated successfully!', 'data' => $category]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update category: ' . $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $category = PackageCategory::find($request->id);
        if ($category) {
            $category->status = $request->status;
            $category->save();

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

     // Delete
    public function destroy($id)
    {
        $category = PackageCategory::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found.'], 404);
        }

        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }
}
