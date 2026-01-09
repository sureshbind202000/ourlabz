<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SpecialityController extends Controller
{
    // Index
    public function index()
    {
        return view('backend.superadmin.speciality.list');
    }

    // List
    public function list()
    {
        $speciality = Speciality::orderBy('status', 'desc')->get();
        return response()->json($speciality);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $existingSpeciality = Speciality::where('speciality', ucwords($request->speciality))
                ->first();

            if ($existingSpeciality) {
                return response()->json([
                    'error' => "This {$request->speciality} speciality is already registered."
                ], 409);
            }
            $specialityImage = null;
            if ($request->hasFile('image')) {
                $specialityImage = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/speciality/' . $specialityImage;
                $request->image->move(public_path('uploads/speciality'), $specialityImage);
            }

            $speciality = Speciality::create([
                'slug' => Str::slug($request->speciality),
                'speciality' => ucwords($request->speciality),
                'short_order' => $request->short_order,
                'image' => $imagePath ?? 'dummy',
            ]);

            DB::commit();

            return response()->json(['success' => 'Speciality added successfully!', 'data' => $speciality]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store speciality: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $speciality = Speciality::findOrFail($id);

        return response()->json(['speciality' => $speciality]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $speciality = Speciality::findOrFail($id);

            $specialityData = [
                'speciality' => ucwords($request->speciality),
                'short_order' => $request->short_order,
            ];

            if ($request->hasFile('image')) {
                if ($speciality->image && file_exists(public_path($speciality->image))) {
                    unlink(public_path($speciality->image));
                }

                $specialityImage = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/speciality/' . $specialityImage;
                $request->image->move(public_path('uploads/speciality'), $specialityImage);
                $specialityData['image'] = $imagePath;
            }

            $speciality->update($specialityData);


            DB::commit();
            return response()->json(['success' => 'Speciality updated successfully!', 'data' => $speciality]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update speciality: ' . $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $speciality = Speciality::find($request->id);
        if ($speciality) {
            $speciality->status = $request->status;
            $speciality->save();

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

     // Delete
    public function destroy($id)
    {
        $speciality = Speciality::find($id);

        if (!$speciality) {
            return response()->json(['success' => false, 'message' => 'Speciality not found.'], 404);
        }

        $speciality->delete();

        return response()->json(['success' => true, 'message' => 'Speciality deleted successfully.']);
    }
}
