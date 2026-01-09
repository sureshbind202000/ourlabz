<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomeVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoContoller extends Controller
{
    // index
    public function index()
    {
        return view('backend.website.homepage.video.list');
    }

    // List
    public function list()
    {
        $video = HomeVideo::orderBy('sort_order', 'asc')->get();
        return response()->json($video);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required',
                'link' => 'required|string|max:255',
                'sort_order' => 'nullable',
            ]);

            // Create banner
            $video = HomeVideo::create([
                'title' => ucwords($request->title),
                'content' => $request->content,
                'link' => $request->link,
                'popup_link' => $request->popup_link,
                'sort_order' => $request->sort_order ?? 0,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Video link added successfully!',
                'data' => $video
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to store video link: ' . $e->getMessage()
            ], 500);
        }
    }

    // Edit
    public function edit($id)
    {
        $video = HomeVideo::findOrFail($id);

        return response()->json(['video' => $video]);
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $video = HomeVideo::findOrFail($id);

            // Validate inputs
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required',
                'link' => 'required|string|max:255',
                'sort_order' => 'nullable',
            ]);

            // Update other fields
            $video->title = ucwords($request->title);
            $video->content = $request->content;
            $video->link = $request->link;
            $video->popup_link = $request->popup_link;
            $video->sort_order = $request->sort_order ?? 0;

            $video->save();

            DB::commit();

            return response()->json([
                'success' => 'Video link updated successfully!',
                'data' => $video
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update video link: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update active status
    public function toggleStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:home_videos,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $video = HomeVideo::findOrFail($request->id);

            $video->is_active = $request->status;
            $video->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $video
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
            $video = HomeVideo::findOrFail($id);

            $video->delete();

            return response()->json(['success' => true, 'message' => 'Video link deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete video link: ' . $e->getMessage()], 500);
        }
    }
}
