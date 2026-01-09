<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    // index
    public function index()
    {
        return view('backend.website.homepage.offer.list');
    }

    // List
    public function list($page)
    {
        $offer = Offer::where('page', $page)->orderBy('id', 'desc')->get();
        return response()->json($offer);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'type' => 'required|in:slider,content,timed_slider',
                'title' => 'nullable|string|max:255',
                'content' => 'nullable|string',
                'link' => 'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'timer_end_at' => 'nullable|date|required_if:type,timed_slider',
                'is_active' => 'nullable|boolean',
                'sort_order' => 'nullable|integer',
                'page' => 'nullable|string|max:100',
            ]);

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $offerImage = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/offers/' . $offerImage;
                $request->image->move(public_path('uploads/offers'), $offerImage);
            }

            $isActive = $request->is_active ?? true;
            if ($request->type === 'content' && $isActive) {
                Offer::where('type', 'content')->where('page', 'homepage')->update(['is_active' => 0]);
            }

            // Create offer
            $offer = Offer::create([
                'type' => $request->type,
                'title' => ucwords($request->title),
                'content' => $request->content,
                'image' => $imagePath,
                'link' => $request->link,
                'timer_end_at' => $request->type === 'timed_slider' ? $request->timer_end_at : null,
                'is_active' => $isActive,
                'sort_order' => $request->sort_order ?? 0,
                'page' => $request->page,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Offer added successfully!',
                'data' => $offer
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to store offer: ' . $e->getMessage()
            ], 500);
        }
    }

    // Edit
    public function edit($id)
    {
        $offer = Offer::findOrFail($id);

        return response()->json(['offer' => $offer]);
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $offer = Offer::findOrFail($id);

            // Validate inputs
            $validated = $request->validate([
                'type' => 'required|in:slider,content,timed_slider',
                'title' => 'nullable|string|max:255',
                'link' => 'nullable',
                'content' => 'nullable|string',
                'timer_end_at' => 'nullable|date',
                'sort_order' => 'nullable|integer',
                'is_active' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,webp,jpg|max:2048',
            ]);

            // Handle image upload (delete old if exists)
            if ($request->hasFile('image')) {
                if ($offer->image && file_exists(public_path($offer->image))) {
                    unlink(public_path($offer->image));
                }

                $imageName = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/offers/' . $imageName;
                $request->image->move(public_path('uploads/offers'), $imageName);

                $offer->image = $imagePath;
            }

            // If activating a "content" type, deactivate all other content offers
            if ($request->type === 'content' && $request->is_active == 1) {
                Offer::where('type', 'content')
                    ->where('page', 'homepage')
                    ->where('id', '!=', $id)
                    ->update(['is_active' => 0]);
            }

            // Update other fields
            $offer->type = $request->type;
            $offer->title = $request->title;
            $offer->link = $request->link;
            $offer->content = $request->content;
            $offer->timer_end_at = $request->timer_end_at;
            $offer->sort_order = $request->sort_order ?? 0;
            $offer->is_active = $request->is_active;

            $offer->save();

            DB::commit();

            return response()->json([
                'success' => 'Offer updated successfully!',
                'data' => $offer
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update offer: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update active status
    public function toggleStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:offers,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $offer = Offer::findOrFail($request->id);

            if ($offer->type === 'content' && $request->status == 1) {
                Offer::where('type', 'content')
                    ->where('page', 'homepage')
                    ->where('id', '!=', $offer->id)
                    ->update(['is_active' => 0]);
            }

            $offer->is_active = $request->status;
            $offer->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $offer
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
            $offer = Offer::findOrFail($id);

            // Optionally delete image file
            if ($offer->image && file_exists(public_path($offer->image))) {
                unlink(public_path($offer->image));
            }

            $offer->delete();

            return response()->json(['success' => true, 'message' => 'Offer deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete offer: ' . $e->getMessage()], 500);
        }
    }
}
