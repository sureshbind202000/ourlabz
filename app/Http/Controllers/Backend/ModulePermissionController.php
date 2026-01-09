<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModulePermissionController extends Controller
{
  public function index()
  {
    return view('backend.superadmin.modules.list');
  }

  public function store(Request $request)
  {
    $request->validate([
      'role_id'   => 'required|integer|min:0',
      'modules'   => 'required|array|min:1',
      'modules.*' => 'required|string|max:255',
    ]);

    $roleId      = $request->role_id;
    $savedCount  = 0;

    foreach ($request->modules as $name) {
      $slug = Str::slug($name);

      // Skip if this slug already exists for this role_id
      if (Module::where('role_id', $roleId)->where('slug', $slug)->exists()) {
        continue;
      }

      Module::create([
        'role_id' => $roleId,
        'name'    => $name,
        'slug'    => $slug,
      ]);

      $savedCount++;
    }

    return redirect()
      ->back()
      ->with('success', $savedCount
        ? "Saved {$savedCount} module(s) for role {$roleId}."
        : 'No new modules were added (duplicates skipped).');
  }
}
