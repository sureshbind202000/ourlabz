<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PolicyPage;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Cart;
use App\Models\HomeBrand;
use App\Models\HomeFeature;
use App\Models\HomeTestimonial;
use App\Models\Offer;
use App\Models\Faq;
use App\Models\package;
use App\Models\PackageCategory;
use App\Models\PackageReview;
use App\Models\Product;
use App\Models\HomeVideo;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PolicyController extends Controller
{
    // index
    public function index()
    {
        return view('backend.website.policy_page.list');
    }

    // List
    public function list()
    {
        $policies = PolicyPage::orderBy('id', 'desc')->get();
        return response()->json($policies);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
        ]);

        // Check if that policy already exists
        $exists = PolicyPage::where('title', $request->title)->exists();

        if ($exists) {
            return response()->json([
                'error' => 'This policy page already exists!'
            ], 422);
        }

        PolicyPage::create([
            'title'   => $request->title,
            'content' => $request->content,
            'status'  => 1,
        ]);

        return response()->json([
            'success' => 'Policy page successfully added!'
        ]);
    }

    // Edit
    public function edit($id)
    {
        $policy = PolicyPage::findOrFail($id);

        return response()->json(['policy' => $policy]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
        ]);

        // Prevent duplicate title during update
        $exists = PolicyPage::where('title', $request->title)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return response()->json([
                'error' => 'This policy title already exists!'
            ], 422);
        }

        $policy = PolicyPage::findOrFail($id);

        $policy->update([
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        return response()->json(['success' => 'Policy updated successfully!']);
    }

    public function show($slug)
    {
        $policy = PolicyPage::where('slug', $slug)->firstOrFail();
        return view('frontend.policy.show', compact('policy'));
    }

    public function status(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:policy_pages,id',
            'status' => 'required|boolean',
        ]);

        $policy = PolicyPage::findOrFail($request->id);
        $policy->status = $request->status;
        $policy->save();

        return response()->json(['success' => 'Status updated successfully!']);
    }

    public function destroy($id)
    {
        $policy = PolicyPage::findOrFail($id);
        $policy->delete();

        return response()->json(['success' => 'Policy page deleted successfully!']);
    }
}
