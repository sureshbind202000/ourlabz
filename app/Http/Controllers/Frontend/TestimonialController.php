<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Models\HomeTestimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
{
    // index
    public function index()
    {
        return view('backend.website.homepage.testimonial.list');
    }

    // List
    public function list()
    {
        $testimonial = HomeTestimonial::orderBy('sort_order', 'asc')->get();
        return response()->json($testimonial);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
                'rating' => 'required',
                'message' => 'required|string',
                'sort_order' => 'nullable',
            ]);

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $bannerImage = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/testimonials/' . $bannerImage;
                $request->image->move(public_path('uploads/testimonials'), $bannerImage);
            }

            // Create testimonials
            $testimonial = HomeTestimonial::create([
                'name' => ucwords($request->name),
                'title' => ucwords($request->title),
                'image' => $imagePath,
                'rating' => $request->rating,
                'message' => $request->message,
                'sort_order' => $request->sort_order ?? 0,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Testimonial added successfully!',
                'data' => $testimonial
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to store testimonial: ' . $e->getMessage()
            ], 500);
        }
    }

    // Edit
    public function edit($id)
    {
        $testimonial = HomeTestimonial::findOrFail($id);

        return response()->json(['testimonial' => $testimonial]);
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $testimonial = HomeTestimonial::findOrFail($id);

            // Validate inputs
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'rating' => 'required',
                'message' => 'required|string',
                'sort_order' => 'nullable',
            ]);

            // Handle image upload (delete old if exists)
            if ($request->hasFile('image')) {
                if ($testimonial->image && file_exists(public_path($testimonial->image))) {
                    unlink(public_path($testimonial->image));
                }

                $imageName = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/testimonials/' . $imageName;
                $request->image->move(public_path('uploads/testimonials'), $imageName);

                $testimonial->image = $imagePath;
            }

            // Update other fields
            $testimonial->name = $request->name;
            $testimonial->title = $request->title;
            $testimonial->rating = $request->rating;
            $testimonial->message = $request->message;
            $testimonial->sort_order = $request->sort_order ?? 0;

            $testimonial->save();

            DB::commit();

            return response()->json([
                'success' => 'Testimonial updated successfully!',
                'data' => $testimonial
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update testimonial: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update active status
    public function toggleStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:home_testimonials,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $testimonial = HomeTestimonial::findOrFail($request->id);

            $testimonial->is_active = $request->status;
            $testimonial->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $testimonial
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    

    // Delete
    public function destroy($id)
    {
        try {
            $testimonial = HomeTestimonial::findOrFail($id);

            // Optionally delete image file
            if ($testimonial->image && file_exists(public_path($testimonial->image))) {
                unlink(public_path($testimonial->image));
            }

            $testimonial->delete();

            return response()->json(['success' => true, 'message' => 'Testimonial deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete testimonial: ' . $e->getMessage()], 500);
        }
    }
}
