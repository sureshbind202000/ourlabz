<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSubCategoryController extends Controller
{
    // Index
    public function index()
    {
        $productTypes = ProductType::all();
        $categories = ProductCategory::all();
        return view('backend.superadmin.product_sub_category.list', compact('categories', 'productTypes'));
    }

    // List
    public function list()
    {
        $sub_category = ProductSubCategory::with(['category'])->orderBy('id', 'desc')->get();
        return response()->json($sub_category);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $existingSubCategory = ProductSubCategory::where('name', ucwords($request->name))
                ->where('category_id', $request->category_id)
                ->first();

            if ($existingSubCategory) {
                return response()->json([
                    'error' => "This {$request->name} Sub-Category is already registered."
                ], 409);
            }

            $sub_category = ProductSubCategory::create([
                'category_id' => $request->category_id,
                'slug' => Str::slug($request->name),
                'name' => ucwords($request->name),
            ]);

            DB::commit();

            return response()->json(['success' => 'Sub-Category added successfully!', 'data' => $sub_category]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store sub-category: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $sub_category = ProductSubCategory::with('category.type')->findOrFail($id);

        return response()->json([
            'sub_category' => $sub_category,
            'type_id' => $sub_category->category->type_id ?? null
        ]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $sub_category = ProductSubCategory::findOrFail($id);

            $existingSubCategory = ProductSubCategory::where('name', ucwords($request->name))->where('category_id', $request->category_id)->first();

            if ($existingSubCategory) {
                return response()->json(['success' => 'Sub-Category updated successfully!', 'data' => $sub_category]);
            }

            $subCategoryData = [
                'category_id' => $request->category_id,
                'slug' => Str::slug($request->name),
                'name' => ucwords($request->name),
            ];

            $sub_category->update($subCategoryData);

            DB::commit();
            return response()->json(['success' => 'Sub-Category updated successfully!', 'data' => $sub_category]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update sub-category: ' . $e->getMessage()], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        $sub_category = ProductSubCategory::find($id);

        if (!$sub_category) {
            return response()->json(['success' => false, 'message' => 'Sub-Category not found.'], 404);
        }

        $sub_category->delete();

        return response()->json(['success' => true, 'message' => 'Sub-Category deleted successfully.']);
    }
}
