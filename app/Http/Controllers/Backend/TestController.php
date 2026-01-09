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

class TestController extends Controller
{
     // Index 
    public function index()
    {
        $PackageCategory = PackageCategory::orderBy('id', 'DESC')->get(['id', 'category_name', 'category_image']);
        $consultant_categories = Speciality::orderBy('speciality')->get();
        return view('backend.superadmin.test.list', compact('PackageCategory', 'consultant_categories'));
    }

    // List
    public function list()
    {
         $packages = package::with(['categoryDetails'])
        ->where('type', 'Test')  // Filter packages by type 'Tests'
        ->orderBy('id', 'DESC')
        ->get(['id', 'package_id', 'name', 'price', 'type', 'created_at', 'category', 'is_draft']);
        return response()->json($packages);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            // Generate a unique package_id
            do {
                $package_id = 'P' . rand(100000, 999999);
            } while (package::where('package_id', $package_id)->exists());

            $packageIcon = null;

            if ($request->file('package_icon')) {
                $package_icon = $request->file('package_icon');
                $packageIcon = time() . '.' . $package_icon->extension();
                $iconPath = 'uploads/package_icon/' . $packageIcon;
                $package_icon->move(public_path('uploads/package_icon'), $packageIcon);
            }

            // Generate slug from title
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;

            // Ensure unique slug
            while (package::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            dd($slug);
            $consultantCategories = $request->consultant_category ?? null;
            // Create the package
            $package = package::create(array_merge(
                $request->except(['icon', 'requisite_name', 'parameter_name', 'parameter_content', 'no_of_parameter', 'question', 'answer']),
                ['package_id' => $package_id, 'package_icon' => $iconPath, 'slug' => $slug, 'consultant_category' => $consultantCategories, 'free_consultation' => $request->free_consultation]
            ));

            // Normalize inputs to arrays
            $icons = is_array($request->icon) ? $request->icon : [$request->icon];
            $requisite_names = is_array($request->requisite_name) ? $request->requisite_name : [$request->requisite_name];

            $parameter_names = is_array($request->parameter_name) ? $request->parameter_name : [$request->parameter_name];
            $parameter_contents = is_array($request->parameter_content) ? $request->parameter_content : [$request->parameter_content];
            $no_of_parameters = is_array($request->no_of_parameter) ? $request->no_of_parameter : [$request->no_of_parameter];

            $questions = is_array($request->question) ? $request->question : [$request->question];
            $answers = is_array($request->answer) ? $request->answer : [$request->answer];

            // Store package requisites
            foreach ($icons as $key => $icon) {
                packageRequisites::create([
                    'package_id' => $package->id,
                    'icon' => $icon,
                    'name' => $requisite_names[$key] ?? null,
                ]);
            }

            // Store package parameters
            foreach ($parameter_names as $key => $name) {
                packageListOfParameter::create([
                    'package_id' => $package->id,
                    'name' => $name,
                    'content' => $parameter_contents[$key] ?? null,
                    'no_of_parameter' => $no_of_parameters[$key] ?? 1,
                ]);
            }

            // Store package faqs
            foreach ($questions as $key => $question) {
                packageFaq::create([
                    'package_id' => $package->id,
                    'question' => $question,
                    'answer' => $answers[$key] ?? null,
                ]);
            }

            DB::commit();
            return response()->json(['success' => 'Package added successfully!', 'data' => $package]);
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json(['error' => 'Failed to store package: ' . $e->getMessage()], 500);
        }
    }


    public function edit($id)
    {
        $package = package::with(['requisites', 'parameters', 'faqs', 'categoryDetails'])->findOrFail($id);

        return response()->json(['package' => $package]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $package = package::findOrFail($id);

            $packageIcon = $package->package_icon;

            // Initialize $iconPath to null or the existing value
            $iconPath = $packageIcon;

            // Check if a new icon is being uploaded
            if ($request->hasFile('edit_package_icon')) {
                // Delete the old icon from the file system if it exists
                if ($packageIcon && file_exists(public_path('uploads/package_icon/' . $packageIcon))) {
                    unlink(public_path('uploads/package_icon/' . $packageIcon));
                }

                // Handle the new icon upload
                $package_icon = $request->file('edit_package_icon');
                $packageIcon = time() . '.' . $package_icon->extension();
                $iconPath = 'uploads/package_icon/' . $packageIcon;

                // Move the uploaded file to the correct directory
                $package_icon->move(public_path('uploads/package_icon'), $packageIcon);
            }
            // ✅ Update package details (excluding related fields)
            $package->update([
                'category' => $request->category,
                'name' => $request->edit_name,
                'package_icon' => $iconPath,
                'about_test' => $request->edit_about_test,
                'list_of_parameters_note' => $request->edit_list_of_parameters_note,
                'test_preparation' => $request->edit_test_preparation,
                'why_this_test' => $request->edit_why_this_test,
                'interpretations' => $request->edit_interpretations,
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
                'price' => $request->edit_price,
                'regular_price' => $request->edit_regular_price,
                'discount_type' => $request->edit_discount_type,
                'discount_price' => $request->edit_discount_price,
                'corporate_regular_price' => $request->edit_corporate_regular_price,
                'corporate_discount_type' => $request->edit_corporate_discount_type,
                'corporate_discount' => $request->edit_corporate_discount,
                'corporate_price' => $request->edit_corporate_price,
                'is_prescription' => $request->edit_is_prescription,
                'type' => $request->edit_type,
                'free_consultation' => $request->free_consultation,
                'consultant_category' => $request->consultant_category ?? null,
            ]);

            // ✅ Fix: Only delete old data if new data exists
            if ($request->has('edit_icon') && $request->has('edit_requisite_name')) {
                packageRequisites::where('package_id', $package->id)->delete();
                foreach ($request->edit_icon as $key => $icon) {
                    if (!empty($icon) && !empty($request->edit_requisite_name[$key])) {
                        packageRequisites::create([
                            'package_id' => $package->id,
                            'icon' => $icon,
                            'name' => $request->edit_requisite_name[$key],
                        ]);
                    }
                }
            }

            if ($request->has('edit_parameter_name') && $request->has('edit_parameter_content')) {
                packageListOfParameter::where('package_id', $package->id)->delete();
                foreach ($request->edit_parameter_name as $key => $parameter_name) {
                    if (!empty($parameter_name)) {
                        packageListOfParameter::create([
                            'package_id' => $package->id,
                            'name' => $parameter_name,
                            'content' => $request->edit_parameter_content[$key] ?? null,
                            'no_of_parameter' => $request->edit_no_of_parameter[$key] ?? null,
                        ]);
                    }
                }
            }

            if ($request->has('edit_question') && $request->has('edit_answer')) {
                packageFaq::where('package_id', $package->id)->delete();
                foreach ($request->edit_question as $key => $question) {
                    if (!empty($question) && !empty($request->edit_answer[$key])) {
                        packageFaq::create([
                            'package_id' => $package->id,
                            'question' => $question,
                            'answer' => $request->edit_answer[$key],
                        ]);
                    }
                }
            }

            // ✅ Commit transaction
            DB::commit();

            return response()->json(['success' => 'Package updated successfully!', 'data' => $package]);
        } catch (\Exception $e) {
            // ❌ Rollback if anything fails
            DB::rollBack();
            return response()->json(['error' => 'Failed to update package: ' . $e->getMessage()], 500);
        }
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
