<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomeFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeatureController extends Controller
{
    // index
    public function index()
    {
        $feature = HomeFeature::first();
        return view('backend.website.homepage.feature.list', compact('feature'));
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $feature = HomeFeature::findOrFail($id);

            // Validate inputs
            $validated = $request->validate([
                'icon' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'content' => 'required|string|max:255',
                'icon2' => 'required|string|max:255',
                'title2' => 'required|string|max:255',
                'content2' => 'required|string|max:255',
                'icon3' => 'required|string|max:255',
                'title3' => 'required|string|max:255',
                'content3' => 'required|string|max:255',
                'icon4' => 'required|string|max:255',
                'title4' => 'required|string|max:255',
                'content4' => 'required|string|max:255',
            ]);

            // Update other fields
            $feature->icon = $request->icon;
            $feature->title = $request->title;
            $feature->content = $request->content;
            $feature->icon2 = $request->icon2;
            $feature->title2 = $request->title2;
            $feature->content2 = $request->content2;
            $feature->icon3 = $request->icon3;
            $feature->title3 = $request->title3;
            $feature->content3 = $request->content3;
            $feature->icon4 = $request->icon4;
            $feature->title4 = $request->title4;
            $feature->content4 = $request->content4;

            $feature->save();

            DB::commit();

            return response()->json([
                'success' => 'Feature updated successfully!',
                'data' => $feature
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update feature: ' . $e->getMessage()
            ], 500);
        }
    }
}
