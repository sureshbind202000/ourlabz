<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WebAbout;

use Illuminate\Http\Request;


class WebAboutController extends Controller
{
    // Index 
    public function index()
    {
        $about = WebAbout::first();
        return view('backend.website.about.about', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $about = WebAbout::findOrFail($id);

        // Validate input
        $request->validate([
            'heading' => 'required|string|max:255',
            'about_content' => 'required|string',
            'primary_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'secondary_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'experience_years' => 'nullable|integer|min:0',
            'keypoints' => 'nullable|array',
            'keypoints.*' => 'nullable|string|max:255',
            'link' => 'nullable|max:255',
            'total_sales' => 'nullable|integer|min:0',
            'happy_clients' => 'nullable|integer|min:0',
            'team_workers' => 'nullable|integer|min:0',
            'win_awards' => 'nullable|integer|min:0',
        ]);

        // Update images if uploaded
        if ($request->hasFile('primary_image')) {
            $primaryImage = $request->file('primary_image');
            $primaryImageName = time() . '_primary.' . $primaryImage->getClientOriginalExtension();
            $primaryImage->move(public_path('uploads/about'), $primaryImageName);
            $about->primary_image = 'uploads/about/' . $primaryImageName;
        }

        if ($request->hasFile('secondary_image')) {
            $secondaryImage = $request->file('secondary_image');
            $secondaryImageName = time() . '_secondary.' . $secondaryImage->getClientOriginalExtension();
            $secondaryImage->move(public_path('uploads/about'), $secondaryImageName);
            $about->secondary_image = 'uploads/about/' . $secondaryImageName; 
        }

        // Update other fields
        $about->heading = $request->heading;
        $about->about_content = $request->about_content;
        $about->experience_years = $request->experience_years ?? 0;
        $about->link = $request->link ?? null;
        $about->keypoints = $request->keypoints ?? null;
        $about->total_sales = $request->total_sales ?? 0;
        $about->happy_clients = $request->happy_clients ?? 0;
        $about->team_workers = $request->team_workers ?? 0;
        $about->win_awards = $request->win_awards ?? 0;

        $about->save();

        return response()->json([
            'success' => 'Website About section updated successfully!'
        ]);
    }
}
