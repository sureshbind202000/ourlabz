<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CorporateAbout;
use App\Models\CorporateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorporateAboutController extends Controller
{
    // index
    public function index()
    {
        $about = CorporateAbout::first();
        return view('backend.corporate.about.list', compact('about'));
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $about = CorporateAbout::findOrFail($id);

            // Validate inputs
            $validated = $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'title' => 'required|string|max:255',
                'heading' => 'required|string|max:255',
                'content' => 'required',
            ]);

            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if (!empty($about->image) && file_exists(public_path($about->image))) {
                    unlink(public_path($about->image));
                }

                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('uploads/corporate/about');

                // Ensure the folder exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);
                $about->image = 'uploads/corporate/about/' . $filename;
            }

            // Update other fields
            $about->title = $request->title;
            $about->heading = $request->heading;
            $about->content = $request->content;

            $about->save();

            DB::commit();

            return response()->json([
                'success' => 'About updated successfully!',
                'data' => $about
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update about: ' . $e->getMessage()
            ], 500);
        }
    }


    // Service Index
    public function serviceIndex()
    {
        $service = CorporateService::first();
        return view('backend.corporate.service.list', compact('service'));
    }

    // Service Update
    public function serviceUpdate(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $service = CorporateService::findOrFail($id);

            // Validate inputs
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'heading' => 'required|string|max:255',

                'banner' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'image2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'image3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'image4' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'image5' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

                'name' => 'required|string|max:255',
                'name2' => 'required|string|max:255',
                'name3' => 'required|string|max:255',
                'name4' => 'required|string|max:255',
                'name5' => 'required|string|max:255',

                'content' => 'required',
                'content2' => 'required',
                'content3' => 'required',
                'content4' => 'required',
                'content5' => 'required',
            ]);

            // Helper to handle image upload + delete old image
            $uploadImage = function ($field) use ($request, $service) {
                if ($request->hasFile($field)) {
                    // Delete old image if it exists
                    if (!empty($service->$field) && file_exists(public_path($service->$field))) {
                        unlink(public_path($service->$field));
                    }

                    $file = $request->file($field);
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('uploads/corporate/service');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    $file->move($destinationPath, $filename);
                    return 'uploads/corporate/service/' . $filename;
                }
                return null;
            };

            // Upload and assign images (with deletion of old ones)
            if ($path = $uploadImage('banner')) $service->banner = $path;
            if ($path = $uploadImage('image')) $service->image = $path;
            if ($path = $uploadImage('image2')) $service->image2 = $path;
            if ($path = $uploadImage('image3')) $service->image3 = $path;
            if ($path = $uploadImage('image4')) $service->image4 = $path;
            if ($path = $uploadImage('image5')) $service->image5 = $path;

            // Assign all other text fields
            $service->title = $request->title;
            $service->heading = $request->heading;

            $service->name = $request->name;
            $service->name2 = $request->name2;
            $service->name3 = $request->name3;
            $service->name4 = $request->name4;
            $service->name5 = $request->name5;

            $service->content = $request->content;
            $service->content2 = $request->content2;
            $service->content3 = $request->content3;
            $service->content4 = $request->content4;
            $service->content5 = $request->content5;

            $service->save();

            DB::commit();

            return response()->json([
                'success' => 'Service updated successfully!',
                'data' => $service
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update service: ' . $e->getMessage()
            ], 500);
        }
    }
}
