<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Requisite;

class RequisiteController extends Controller
{
    public function Requisites()
    {
        $requisites = Requisite::all(); // All rows fetch karega
        return view('backend.superadmin.test.requestige.list', compact('requisites'));
    }
    public function getRequisites()
    {
        $requisites = Requisite::all();
        return response()->json($requisites);
    }
    // Method to store requisites
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'nullable|image|mimes:png,|max:2048'
        ]);

        $imagePath = null;

        // ---- Upload to public/uploads/requisites ----
        if ($request->hasFile('icon')) {

            $filename = time() . '.' . $request->file('icon')->getClientOriginalExtension();

            // folder: public/uploads/requisites
            $request->file('icon')->move(public_path('uploads/requisites'), $filename);

            // save path for database
            $imagePath = 'uploads/requisites/' . $filename;
        }

        // ---- Save to database ----
        Requisite::create([
            'name' => $request->name,
            'icon' => $imagePath
        ]);

        return response()->json([
            'status' => true,
            'message' => "Requisite saved successfully!"
        ]);
    }
    // GET Edit – Return requisite data for modal
    public function edit($id)
    {
        $requisite = Requisite::find($id);

        if (!$requisite) {
            return response()->json(['error' => 'Requisite not found'], 404);
        }

        return response()->json([
            'requisite' => [
                'id' => $requisite->id,
                'name' => $requisite->name,
                'icon' => $requisite->icon ?: 'dummy',
            ]
        ]);
    }

    // PUT/POST Update Requisite
    public function update(Request $request, $id)
    {
        $requisite = Requisite::find($id);
        if (!$requisite) {
            return response()->json(['error' => 'Requisite not found'], 404);
        }

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'icon' => 'nullable|image|mimes:png|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed!',
                'errors' => $e->errors()
            ], 422);
        }

        $requisite->name = $request->name;

        // Upload new icon if exists
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($requisite->icon && file_exists(public_path($requisite->icon))) {
                unlink(public_path($requisite->icon));
            }

            $file = $request->file('icon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/requisites/'), $filename);
            $requisite->icon = 'uploads/requisites/' . $filename;
        }

        $requisite->save();

        return response()->json(['success' => 'Requisite updated successfully']);
    }

    public function destroy($id)
    {
        $requisite = Requisite::find($id);

        if (!$requisite) {
            return response()->json([
                'success' => false,
                'message' => 'Requisite not found'
            ]);
        }

        // Delete image if exists
        if ($requisite->icon && file_exists(public_path($requisite->icon))) {
            unlink(public_path($requisite->icon));
        }

        // Delete the requisite
        $requisite->delete();

        return response()->json(['success' => true]);
    }
}
