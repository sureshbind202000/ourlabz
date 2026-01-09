<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WebTeam;

use Illuminate\Http\Request;


class WebTeamController extends Controller
{
    // Index 
    public function index()
    {
        return view('backend.website.about.teams');
    }

    public function list()
    {
        $teams = WebTeam::orderBy('id', 'DESC')->get();
        return response()->json($teams);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'facebook' => 'nullable|max:255',
            'twitter' => 'nullable|max:255',
            'linkedin' => 'nullable|max:255',
            'youtube' => 'nullable|max:255',
            'is_active' => 'required|boolean',
        ]);

        $team = new WebTeam();

        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->facebook = $request->facebook;
        $team->twitter = $request->twitter;
        $team->linkedin = $request->linkedin;
        $team->youtube = $request->youtube;
        $team->is_active = $request->is_active;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/teams'), $imageName);
            $team->image = '/uploads/teams/' . $imageName;
        }

        $team->save();

        return response()->json(['success' => 'Team member added successfully!']);
    }

    public function edit($id)
    {
        $team = WebTeam::findOrFail($id);
        return response()->json(['team' => $team]);
    }

    public function update(Request $request, $id)
    {
        $team = WebTeam::findOrFail($id);

        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->facebook = $request->facebook;
        $team->twitter = $request->twitter;
        $team->linkedin = $request->linkedin;
        $team->youtube = $request->youtube;

        if ($request->hasFile('image')) {
            if ($team->image && file_exists(public_path($team->image))) {
                unlink(public_path($team->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/teams'), $imageName);
            $team->image = '/uploads/teams/' . $imageName;
        }

        $team->save();

        return response()->json(['success' => 'Team member updated successfully!']);
    }

    public function status(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:web_teams,id',
            'status' => 'required|boolean',
        ]);

        $team = WebTeam::findOrFail($request->id);

        $team->is_active = $request->status;
        $team->save();

        return response()->json(['success' => 'Status updated successfully!']);
    }

    public function destroy($id)
    {
        $team = WebTeam::findOrFail($id);
        if (!empty($team->image) && file_exists(public_path($team->image))) {
            unlink(public_path($team->image));
        }
        $team->delete();

        return response()->json(['success' => 'Team member deleted successfully!']);
    }
}
