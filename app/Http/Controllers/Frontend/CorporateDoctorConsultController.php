<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CorporateDoctorConsult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorporateDoctorConsultController extends Controller
{
    // doctor Index
    public function doctorIndex()
    {
        $doctor = CorporateDoctorConsult::first();
        return view('backend.corporate.doctor_consult.list', compact('doctor'));
    }

    // doctor Update
    public function doctorUpdate(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $doctor = CorporateDoctorConsult::findOrFail($id);

            // Validate inputs
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            if ($request->hasFile('image')) {
                
                if ($doctor->image && file_exists(public_path($doctor->image))) {
                    unlink(public_path($doctor->image));
                }

                // Store new image
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/consultation'), $imageName);

                $doctor->image = 'uploads/consultation/' . $imageName;
            }

            // Assign other fields
            $doctor->title = $request->title;
            $doctor->content = $request->content;
            $doctor->save();

            DB::commit();

            return response()->json([
                'success' => 'Doctor Consultation updated successfully!',
                'data' => $doctor
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update doctor consultation: ' . $e->getMessage()
            ], 500);
        }
    }
}
