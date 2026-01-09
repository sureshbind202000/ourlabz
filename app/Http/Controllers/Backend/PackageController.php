<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\package;
use App\Models\PackageCategory;
use App\Models\packageFaq;
use App\Models\packageListOfParameter;
use App\Models\packageRequisites;
use App\Models\PackageReview;
use App\Models\Speciality;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    // Index 
    public function index()
    {
        $PackageCategory = PackageCategory::orderBy('id', 'DESC')->get(['id', 'category_name', 'category_image']);
        $consultant_categories = Speciality::orderBy('speciality')->get();
        return view('backend.superadmin.packages.list', compact('PackageCategory', 'consultant_categories'));
    }

    // List
    public function list()
    {

        $packages = package::with(['categoryDetails'])
            ->where('type', 'Package')
            ->orderBy('id', 'DESC')
            ->get(['id', 'package_id', 'name', 'price', 'type', 'created_at', 'category', ' $is_draft']);
        return response()->json($packages);
    }

    // Store
    public function store(Request $request)
    {

        // try {
        $step = $request->step_id;   // current form step

        $draftId = $request->draft_id; // hidden input that holds draft package id
        $packageIcon = null;
        $iconPath = null;

        // If no draftID, create new draft record
        if (!$draftId) {

            $request->validate([
                'name' => 'required|string|min:3',
                'package_icon' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                'category' => 'required',
                'type' => 'required',
                'about_test' => 'required|string',
            ]);


            if ($request->hasFile('package_icon')) {
                $package_icon = $request->file('package_icon');
                $packageIcon = time() . '.' . $package_icon->extension();
                $iconPath = 'uploads/package_icon/' . $packageIcon;
                $package_icon->move(public_path('uploads/package_icon'), $packageIcon);
            }
            // create minimal draft entry
            $package = Package::create([
                'package_id' => 'P' . rand(100000, 999999),
                'name' => $request->name,
                'package_icon' => $iconPath,
                'slug' => Str::slug($request->name),
                'category' => $request->category,
                'type' => $request->type,
                'about_test' => $request->about_test,
                'is_draft' => 1,
                'status' => 0,
            ]);
        } else {
            // Get existing draft
            $package = Package::where('id', $draftId)->first();
            // dd($package, $step);
            if (!$package) {
                return response()->json(['error' => 'Draft not found'], 404);
            }
            // Update the step fields
            switch ($step) {

                case 1:
                    $request->validate([
                        'name' => 'required|string|min:3',
                        'package_icon' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                        'category' => 'required',
                        'type' => 'required',
                        'about_test' => 'required|string',
                    ]);
                    if ($request->hasFile('package_icon')) {
                        $package_icon = $request->file('package_icon');
                        $packageIcon = time() . '.' . $package_icon->extension();
                        $iconPath = 'uploads/package_icon/' . $packageIcon;
                        $package_icon->move(public_path('uploads/package_icon'), $packageIcon);
                    }
                    $package->update([
                        'name' => $request->name,
                        'package_icon' => $iconPath,
                        'slug' => Str::slug($request->name),
                        'category' => $request->category,
                        'about_test' => $request->about_test,
                    ]);
                    break;

                case 2:

                    $request->validate([
                        'icon' => 'required|array',
                        'icon.*' => 'required|string',
                        'requisite_name' => 'required|array',
                        'requisite_name.*' => 'required|string',
                    ], [
                        'icon.required' => 'At least one icon is required',
                        'icon.*.required' => 'Icon is required',
                        'requisite_name.required' => 'At least one requisite name is required',
                        'requisite_name.*.required' => 'Requisite name is required',
                    ]);


                    if (!$package) {
                        return response()->json(['error' => 'Draft not found'], 404);
                    }
                    // Delete old requisites for this package (optional, if you want to replace them)
                    // Normalize inputs to arrays
                    $icons = is_array($request->icon) ? $request->icon : [$request->icon];
                    $requisite_names = is_array($request->requisite_name) ? $request->requisite_name : [$request->edit_requisite_name];
                    // Insert each requisite
                    foreach ($icons as $key => $icon) {
                        PackageRequisites::create([
                            'package_id' => $draftId,
                            'icon' => $icon,
                            'name' => $requisite_names[$key] ?? null,
                        ]);
                    }

                    break;

                case 3:
                    $request->validate([
                        'parameter_name' => 'required|array',
                        'parameter_name.*' => 'required|string',
                        'parameter_content' => 'required|array',
                        'parameter_content.*' => 'required|string',
                    ]);



                    $package->update([
                        'list_of_parameters_note' => $request->list_of_parameters_note,
                    ]);
                    // -------------------------------------------
                    // ✅ INSERT INTO package_list_of_parameters
                    // -------------------------------------------

                    $names    = $request->parameter_name;       // array
                    $contents = $request->parameter_content;    // array
                    $counts   = $request->no_of_parameter;      // array

                    if ($names && count($names) > 0) {

                        foreach ($names as $index => $name) {

                            if (!$name) continue; // skip empty rows

                            \DB::table('package_list_of_parameters')->insert([
                                'package_id'      => $package->id,               // package/draft id
                                'name'            => $name,
                                'content'         => $contents[$index] ?? '',
                                'no_of_parameter' => $counts[$index] ?? 0,
                                'created_at'      => now(),
                                'updated_at'      => now(),
                            ]);
                        }
                    }

                    break;


                case 4:


                    $request->validate([
                        'test_preparation' => 'required|string',
                        'why_this_test' => 'required|string',
                    ]);
                    $package->update([
                        'why_this_test'       => $request->why_this_test,
                        'interpretations'     => $request->interpretations,
                        'test_preparation'        => $request->test_preparation,
                    ]);

                    break;
                case 5:
                    // dd($request);
                    $request->validate([

                        'measures' => 'required|string',
                        'identifies' => 'required|string',
                        'sample_type_specimen' => 'required|string',
                        'method' => 'required|string',
                        'tat' => 'required|numeric|min:1',
                        'recommendation_of_age' => 'required|string',
                        'stability_room' => 'required|string',
                        'stability_refrigerated' => 'required|string',
                        'stability_frozen' => 'required|string',

                    ]);
                    $package->update([
                        'department_category' => $request->department_category,
                        'measures' => $request->measures,
                        'identifies' => $request->identifies,
                        'sample_type_specimen' => $request->sample_type_specimen,
                        'method' => $request->method,
                        'tat' => $request->tat,
                        'recommendation_of_age' => $request->recommendation_of_age,
                        'stability_room' => $request->stability_room,
                        'stability_refrigerated' => $request->stability_refrigerated,
                        'stability_frozen' => $request->stability_frozen,
                        'reports_within' => $request->reports_within,
                        'is_prescription' => $request->is_prescription,

                    ]);
                    break;
                case 6:
                    // dd($request);

                    $request->validate([
                        'regular_price' => 'required|numeric|min:0',
                        'discount_type' => 'nullable|string',
                    ]);
                    $consultant = $request->consultant_category;

                    if (!empty($consultant)) {

                        // If input is a single comma string
                        if (is_string($consultant)) {
                            $consultant = array_map('trim', explode(',', $consultant));
                        }

                        // If input is array but values contain comma-separated strings
                        if (is_array($consultant)) {
                            $final = [];
                            foreach ($consultant as $c) {
                                if (!empty($c)) {
                                    $parts = array_map('trim', explode(',', $c));
                                    foreach ($parts as $p) {
                                        if ($p !== '') {
                                            $final[] = $p;
                                        }
                                    }
                                }
                            }
                            $consultant = $final;
                        }
                    }
                    $package->update([
                        'regular_price' => $request->regular_price,
                        'discount_type' => $request->discount_type,
                        'discount_price' => $request->discount_price,
                        'price' => $request->price,
                        'corporate_regular_price' => $request->corporate_regular_price,
                        'corporate_discount_type' => $request->corporate_discount_type,
                        'corporate_discount' => $request->corporate_discount,
                        'corporate_price' => $request->corporate_price,
                        'free_consultation' => $request->free_consultation,
                        'consultant_category' => $consultant,



                    ]);
                    break;
                case 7:

                    $request->validate([
                        'question' => 'required|array',
                        'question.*' => 'required|string',
                        'answer' => 'required|array',
                        'answer.*' => 'required|string',
                    ]);
                    // dd($request);
                    // exit();
                    $questions = $request->question;   // array
                    $answers   = $request->answer;     // array
                    $package_id = $package->id;        // actual package id


                    PackageFaq::where('package_id', $package_id)->delete();

                    if (!empty($questions) && is_array($questions)) {
                        foreach ($questions as $index => $q) {

                            $a = $answers[$index] ?? null;

                            if ($q && $a) {
                                PackageFaq::create([
                                    'package_id' => $package_id,
                                    'question'   => $q,
                                    'answer'     => $a,

                                ]);
                            }
                        }
                    }

                    // return response()->json(['success' => 'Package updated as a draft  successfully!', 'data' => $package]);
                    break;

                case 8:
                    // dd($request);
                    // exit();
                    $request->validate([
                        'question' => 'required|array',
                        'question.*' => 'required|string',
                        'answer' => 'required|array',
                        'answer.*' => 'required|string',
                    ]);
                    $questions = $request->question;   // array
                    $answers   = $request->answer;     // array
                    $package_id = $package->id;        // actual package id


                    PackageFaq::where('package_id', $package_id)->delete();

                    if (!empty($questions) && is_array($questions)) {
                        foreach ($questions as $index => $q) {

                            $a = $answers[$index] ?? null;

                            if ($q && $a) {
                                PackageFaq::create([
                                    'package_id' => $package_id,
                                    'question'   => $q,
                                    'answer'     => $a,

                                ]);
                            }
                        }
                    }

                    $package->update([
                        'is_draft' => 0,

                    ]);

                    return response()->json(['success' => 'Package updated successfully!', 'data' => $package]);
                    break;

                case "publish":
            }
        }
        DB::commit();

        return response()->json([
            'success' => "Step Saved!",
            'draft_id' => $package->id
        ]);
    }



    public function edit($id)
    {
        $package = package::with(['requisites', 'parameters', 'faqs', 'categoryDetails'])->findOrFail($id);

        return response()->json(['package' => $package]);
    }

    public function update(Request $request, $id)
    {
        // DB::beginTransaction();

        $step = $request->editstep_id; // current form step

        $package = Package::find($id);
        if (!$package) {
            return response()->json(['error' => 'Package not found'], 404);
        }
        //  dd($request);
        //                 exit();
        $packageIcon = null;
        $iconPath = null;
        // dd($step);
        switch ($step) {
            case 1:

                $request->validate([
                    'edit_name' => 'required|string|min:3',
                    'category' => 'required',
                    'edit_type' => 'required',
                    'edit_about_test' => 'required|string',
                ]);
                if ($request->hasFile('edit_package_icon')) {
                    $package_icon = $request->file('edit_package_icon');
                    $packageIcon = time() . '.' . $package_icon->extension();
                    $iconPath = 'uploads/package_icon/' . $packageIcon;
                    $package_icon->move(public_path('uploads/package_icon'), $packageIcon);
                }

                $package->update([
                    'name' => $request->edit_name,
                    'package_icon' => $iconPath ?? $package->package_icon,
                    'slug' => Str::slug($request->edit_name),
                    'category' => $request->category,
                    'about_test' => $request->edit_about_test,
                ]);
                break;

            case 2:
                //    dd($request);

                $request->validate([
                    'edit_icon' => 'required|array',
                    'edit_icon.*' => 'required|string',
                    'edit_requisite_name' => 'required|array',
                    'edit_requisite_name.*' => 'required|string',
                ]);


                $icons = is_array($request->edit_icon) ? $request->edit_icon : [$request->edit_icon];
                $requisite_names = is_array($request->edit_requisite_name) ? $request->edit_requisite_name : [$request->edit_requisite_name];

                // Delete old requisites
                PackageRequisites::where('package_id', $package->id)->delete();

                foreach ($icons as $key => $icon) {
                    PackageRequisites::create([
                        'package_id' => $package->id,
                        'icon' => $icon,
                        'name' => $requisite_names[$key] ?? null,
                    ]);
                }
                break;

            case 3:
                $request->validate([
                    'edit_parameter_name' => 'required|array',
                    'edit_parameter_name.*' => 'required|string',
                    'edit_parameter_content' => 'required|array',
                    'edit_parameter_content.*' => 'required|string',
                ]);

                $package->update(['list_of_parameters_note' => $request->edit_list_of_parameters_note]);

                $names    = $request->edit_parameter_name;
                $contents = $request->edit_parameter_content;
                $counts   = $request->edit_no_of_parameter;

                if ($names && count($names) > 0) {
                    // Optional: delete old parameters first
                    DB::table('package_list_of_parameters')->where('package_id', $package->id)->delete();

                    foreach ($names as $index => $name) {
                        if (!$name) continue;

                        DB::table('package_list_of_parameters')->insert([
                            'package_id' => $package->id,
                            'name' => $name,
                            'content' => $contents[$index] ?? '',
                            'no_of_parameter' => $counts[$index] ?? 0,

                        ]);
                    }
                }
                break;

            case 4:
                $request->validate([
                    'edit_test_preparation' => 'required|string',
                    'edit_why_this_test' => 'required|string',
                ]);
                $package->update([
                    'why_this_test' => $request->edit_why_this_test,
                    'interpretations' => $request->edit_interpretations,
                    'test_preparation' => $request->edit_test_preparation,
                ]);
                break;

            case 5:
                //  dd($request);
                $request->validate([

                    'edit_measures' => 'required|string',
                    'edit_identifies' => 'required|string',
                    'edit_sample_type_specimen' => 'required|string',
                    'edit_method' => 'required|string',
                    'edit_tat' => 'required|numeric|min:1',
                    'edit_recommendation_of_age' => 'required|string',
                    'edit_stability_room' => 'required|string',
                    'edit_stability_refrigerated' => 'required|string',
                    'edit_stability_frozen' => 'required|string',

                ]);


                $package->update([
                    'department_category' => $request->edit_department_category,
                    'measures' => $request->edit_measures,
                    'identifies' => $request->edit_identifies,
                    'sample_type_specimen' => $request->edit_sample_type_specimen,
                    'method' => $request->edit_method,
                    'tat' => $request->edit_tat,
                    'recommendation_of_age' => $request->edit_recommendation_of_age,
                    'stability_room' => $request->edit_stability_room,
                    'stability_refrigerated' => $request->edit_stability_refrigerated,
                    'stability_frozen' => $request->edit_stability_frozen,
                    'reports_within' => $request->edit_reports_within,
                    'is_prescription' => $request->edit_is_prescription,
                ]);
                break;

            case 6:
                //  dd($request);
                $request->validate([
                    'edit_regular_price' => 'required|numeric|min:0',
                    'edit_discount_type' => 'nullable|string',
                ]);
                $consultant = $request->consultant_category ?? [];
                if (is_string($consultant)) {
                    $consultant = array_map('trim', explode(',', $consultant));
                } elseif (is_array($consultant)) {
                    $final = [];
                    foreach ($consultant as $c) {
                        if (!empty($c)) {
                            $parts = array_map('trim', explode(',', $c));
                            foreach ($parts as $p) {
                                if ($p !== '') $final[] = $p;
                            }
                        }
                    }
                    $consultant = $final;
                }

                $package->update([
                    'regular_price' => $request->edit_regular_price,
                    'discount_type' => $request->edit_discount_type,
                    'discount_price' => $request->edit_discount_price,
                    'price' => $request->edit_price,
                    'corporate_regular_price' => $request->edit_corporate_regular_price,
                    'corporate_discount_type' => $request->edit_corporate_discount_type,
                    'corporate_discount' => $request->edit_corporate_discount,
                    'corporate_price' => $request->edit_corporate_price,
                    'free_consultation' => $request->free_consultation,
                    'consultant_category' => $consultant,
                ]);
                break;
            case 7:


                $request->validate([
                    'edit_question' => 'required|array',
                    'edit_question.*' => 'required|string',
                    'edit_answer' => 'required|array',
                    'edit_answer.*' => 'required|string',
                ]);
                // Correct fields
                $questions = $request->edit_question;
                $answers   = $request->edit_answer;

                $package_id = $package->id;

                // Delete old FAQs
                $ress = packageFaq::where('package_id', $id)->delete();


                // Save new FAQs
                if (!empty($questions) && is_array($questions)) {

                    foreach ($questions as $index => $q) {

                        $a = $answers[$index] ?? null;

                        if ($q && $a) {

                            $res = packageFaq::create([
                                'package_id' => $id,
                                'question'   => $q,
                                'answer'     => $a,
                            ]);
                        }
                    }
                }


                // Update draft

                return response()->json(['success' => 'Package updated successfully!', 'data' => $package]);
                break;


            case 8:
                // Correct fields
              
                $request->validate([
                    'edit_question' => 'required|array',
                    'edit_question.*' => 'required|string',
                    'edit_answer' => 'required|array',
                    'edit_answer.*' => 'required|string',
                ]);
               
                  $questions = $request->edit_question;
                $answers   = $request->edit_answer;
                $package_id = $package->id;

                // Delete old FAQs
                 packageFaq::where('package_id', $id)->delete();


                // Save new FAQs
                if (!empty($questions) && is_array($questions)) {

                    foreach ($questions as $index => $q) {

                        $a = $answers[$index] ?? null;

                        if ($q && $a) {

                            $res = packageFaq::create([
                                'package_id' => $id,
                                'question'   => $q,
                                'answer'     => $a,
                            ]);
                        }
                    }
                }

                $package->update([
                    'is_draft' => 0,
                ]);
                // Update draft

                return response()->json(['success' => 'Package Active successfully!', 'data' => $package]);
                break;

            case "publish":
        }

        // DB::commit();

        return response()->json([
            'success' => "Update Successfuly",
            'package_id' => $package->id
        ]);
    }

    // Delete
    public function destroy($id)
    {
        $package = Package::find($id);

        if (!$package) {
            return response()->json(['success' => false, 'message' => 'Package not found.'], 404);
        }

        // Delete the package (triggers the cascade delete)
        $package->delete();

        return response()->json(['success' => true, 'message' => 'Package and related data deleted successfully.']);
    }

    // Search
    public function search(Request $request)
    {
        $query = $request->input('query');
        $packages = package::where('type', 'Test')->where('name', 'LIKE', "%{$query}%")->pluck('name', 'id');

        return response()->json($packages);
    }

    public function getPackageParameters(Request $request)
    {
        $packageName = $request->input('package_name');

        // Get package ID from name
        $package = package::where('name', $packageName)->first();

        if (!$package) {
            return response()->json([]);
        }

        // Fetch parameters for the selected package
        $parameters = packageListOfParameter::where('package_id', $package->id)
            ->get(['name', 'content', 'no_of_parameter']);

        return response()->json($parameters);
    }

    // Package Reviews
    public function packagereviews()
    {
        return view('backend.superadmin.packages.package_review');
    }

    public function storePackageReview(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
            'website' => 'nullable|prohibited',
        ]);

        // Save the comment
        $review = new PackageReview();
        $review->package_id = $request->package_id;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return response()->json(['success' => true, 'message' => 'Review submitted successfully.']);
    }

    // Review List
    public function packageReviewList()
    {
        $review = PackageReview::with(['package:id,id,name,slug'])->orderBy('is_active', 'asc')
            ->latest()
            ->get();
        return response()->json($review);
    }

    // Package Review Status
    public function togglePackageReviewStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:package_reviews,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $review = PackageReview::findOrFail($request->id);

            $review->is_active = $request->status;
            $review->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $review
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
    public function packageReviewDestroy($id)
    {
        try {
            $review = PackageReview::findOrFail($id);

            $review->delete();

            return response()->json(['success' => true, 'message' => 'Review deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete review: ' . $e->getMessage()], 500);
        }
    }
}
