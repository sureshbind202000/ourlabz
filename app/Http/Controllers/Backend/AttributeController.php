<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    // Index
    public function index()
    {
        return view('backend.superadmin.attributes.list');
    }

    // List
    public function list()
    {
        $attribute = ProductAttribute::orderBy('id', 'desc')->get();
        return response()->json($attribute);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validation
            $request->validate([
                'name' => 'required|string|max:255',
                'values' => 'required|array|min:1',
                'values.*' => 'required|string|max:255',
            ]);

            // Check if attribute name already exists
            $existingAttribute = ProductAttribute::where('name', ucwords($request->name))->first();

            if ($existingAttribute) {
                return response()->json([
                    'error' => "This {$request->name} Attribute is already registered."
                ], 409);
            }

            // Create the main attribute
            $attribute = ProductAttribute::create([
                'name' => ucwords($request->name),
            ]);

            // Store attribute values
            foreach ($request->values as $value) {
                $attribute->values()->create([
                    'value' => ucwords($value),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => 'Attribute added successfully!',
                'data' => $attribute->load('values')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to store attribute: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $attribute = ProductAttribute::with('values')->findOrFail($id);

        return response()->json(['attribute' => $attribute]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Validation
            $request->validate([
                'name' => 'required|string|max:255',
                'values' => 'required|array|min:1',
                'values.*' => 'required|string|max:255',
            ]);

            $attribute = ProductAttribute::findOrFail($id);

            // Check for duplicate name (ignore current attribute)
            $existingAttribute = ProductAttribute::where('name', ucwords($request->name))
                ->where('id', '!=', $id)
                ->first();

            if ($existingAttribute) {
                return response()->json([
                    'error' => "The attribute name '{$request->name}' is already registered."
                ], 409);
            }

            // Update attribute name
            $attribute->update([
                'name' => ucwords($request->name),
            ]);

            // Handle attribute values
            $newValues = collect($request->values)->map(fn($v) => ucwords($v))->unique();

            // Delete old values not in request
            $attribute->values()->whereNotIn('value', $newValues)->delete();

            // Add new values (skip duplicates)
            foreach ($newValues as $value) {
                $attribute->values()->firstOrCreate(['value' => $value]);
            }

            DB::commit();

            return response()->json([
                'success' => 'Attribute updated successfully!',
                'data' => $attribute->load('values')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update attribute: ' . $e->getMessage()
            ], 500);
        }
    }


    // Delete
    public function destroy($id)
    {
        $attribute = ProductAttribute::find($id);

        if (!$attribute) {
            return response()->json(['success' => false, 'message' => 'Attribute not found.'], 404);
        }

        $attribute->delete();

        return response()->json(['success' => true, 'message' => 'Attribute deleted successfully.']);
    }

    public function getValues($id)
    {
        $attribute = ProductAttribute::with('values')->findOrFail($id);
        return response()->json([
            'values' => $attribute->values
        ]);
    }
}
