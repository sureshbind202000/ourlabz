<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    // Index
    public function index()
    {
        $types = ProductType::all();
        return view('backend.superadmin.product_category.list', compact('types'));
    }

    // List
    public function list()
    {
        $category = ProductCategory::with(['type'])->orderBy('id', 'desc')->get();
        return response()->json($category);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $existingCategory = ProductCategory::where('name', ucwords($request->name))
                ->where('type_id', $request->type_id)
                ->first();

            if ($existingCategory) {
                return response()->json([
                    'error' => "This {$request->name} Category is already registered."
                ], 409);
            }

            $category = ProductCategory::create([
                'type_id' => $request->type_id,
                'slug' => Str::slug($request->name),
                'name' => ucwords($request->name),
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
        $category = ProductCategory::findOrFail($id);

        return response()->json(['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $category = ProductCategory::findOrFail($id);

            $existingCategory = ProductCategory::where('name', ucwords($request->name))->where('type_id', $request->type_id)->first();

            if ($existingCategory) {
                return response()->json(['success' => 'Category updated successfully!', 'data' => $category]);
            }

            $categoryData = [
                'type_id' => $request->type_id,
                'slug' => Str::slug($request->name),
                'name' => ucwords($request->name),
            ];

            $category->update($categoryData);

            DB::commit();
            return response()->json(['success' => 'Category updated successfully!', 'data' => $category]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update category: ' . $e->getMessage()], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        $category = ProductCategory::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found.'], 404);
        }

        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }
}
