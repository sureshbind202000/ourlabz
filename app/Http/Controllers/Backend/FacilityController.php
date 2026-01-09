<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FacilityController extends Controller
{
    // Index
    public function index()
    {
        return view('backend.superadmin.facility.list');
    }

    // List
    public function list()
    {
        $facility = Facility::orderBy('status', 'desc')->get();
        return response()->json($facility);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $existingFacility = Facility::where('facility', ucwords($request->facility))
                ->first();

            if ($existingFacility) {
                return response()->json([
                    'error' => "This {$request->facility} facility is already registered."
                ], 409);
            }

            $facility = Facility::create([
                'slug' => Str::slug($request->facility),
                'facility' => ucwords($request->facility),
            ]);

            DB::commit();

            return response()->json(['success' => 'Facility added successfully!', 'data' => $facility]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store facility: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $facility = Facility::findOrFail($id);

        return response()->json(['facility' => $facility]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $facility = Facility::findOrFail($id);

            $facilityData = [
                'facility' => ucwords($request->facility),
            ];

            $facility->update($facilityData);


            DB::commit();
            return response()->json(['success' => 'Facility updated successfully!', 'data' => $facility]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update facility: ' . $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $facility = Facility::find($request->id);
        if ($facility) {
            $facility->status = $request->status;
            $facility->save();

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    // Delete
    public function destroy($id)
    {
        $facility = Facility::find($id);

        if (!$facility) {
            return response()->json(['success' => false, 'message' => 'Facility not found.'], 404);
        }

        $facility->delete();

        return response()->json(['success' => true, 'message' => 'Facility deleted successfully.']);
    }
}
