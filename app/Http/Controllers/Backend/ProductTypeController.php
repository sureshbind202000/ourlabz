<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductTypeController extends Controller
{
    // Index
    public function index()
    {
        return view('backend.superadmin.product_type.list');
    }

    // List
    public function list()
    {
        $type = ProductType::orderBy('id', 'desc')->get();
        return response()->json($type);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $existingType = ProductType::where('name', ucwords($request->name))->first();

            if ($existingType) {
                return response()->json([
                    'error' => "This {$request->name} type is already exist. "
                ], 409);
            }

            $type = ProductType::create([
                'slug' => Str::slug($request->name),
                'name' => ucwords($request->name),
            ]);

            DB::commit();

            return response()->json(['success' => 'Type added successfully!', 'data' => $type]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store type: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $type = ProductType::findOrFail($id);

        return response()->json(['type' => $type]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $type = ProductType::findOrFail($id);

            $existingType = ProductType::where('name', ucwords($request->name))->first();

            if ($existingType) {
                return response()->json(['success' => 'Type updated successfully!', 'data' => $type]);
            }

            $typeData = [
                'slug' => Str::slug($request->name),
                'name' => ucwords($request->category_name),
            ];

            $type->update($typeData);


            DB::commit();
            return response()->json(['success' => 'Type updated successfully!', 'data' => $type]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update type: ' . $e->getMessage()], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        $type = ProductType::find($id);

        if (!$type) {
            return response()->json(['success' => false, 'message' => 'Type not found.'], 404);
        }

        $type->delete();

        return response()->json(['success' => true, 'message' => 'Type deleted successfully.']);
    }
}
