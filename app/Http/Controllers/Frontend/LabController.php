<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\lab;
use App\Models\LabReview;
use App\Models\LabTest;
use App\Models\Module;
use App\Models\NotificationMessage;
use App\Models\package;
use App\Models\User;
use App\Models\UserModulePermission;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LabController extends Controller
{
    // Lab registration
    public function registration()
    {
        $facilities = Facility::where('status', 1)->get();
        return view('frontend.lab.registration', compact('facilities'));
    }

    // Store Registration
    // Store
    public function storeRegistration(Request $request)
    {
        DB::beginTransaction();
        try {

            do {
                $lab_id = 'LAB-' . rand(100000, 999999);
            } while (lab::where('lab_id', $lab_id)->exists());

            do {
                $user_id = 'LAB-U' . rand(100000, 999999);
            } while (User::where('user_id', $user_id)->exists());

            $email = $request->email;

            if (empty($email)) {
                $firstFourDigits = substr($request->phone, 0, 4);
                $username = strtolower(str_replace(' ', '', $request->name)); // Remove spaces
                $email = $username . $firstFourDigits . '@example.com';

                while (lab::where('email', $email)->exists()) {
                    $email = $username . $firstFourDigits . '@example.com';
                }
            }

            $accreditation_detailsPath = null;

            // Accreditation Details
            if ($request->hasFile('accreditation_details')) {
                $accreditation_details = time() . '.' . $request->accreditation_details->extension();
                $accreditation_detailsPath = 'uploads/lab/accreditation_details/' . $accreditation_details;
                $request->accreditation_details->move(public_path('uploads/lab/accreditation_details'), $accreditation_details);
            }

            $data = $request->all();

            $data['lab_id'] = $lab_id;
            $data['accreditation_details'] = $accreditation_detailsPath;
            $data['lab_type'] = $request->filled('lab_type') ? json_encode($request->lab_type) : null;
            $data['slug'] = Str::slug($request->lab_name);

            // Create user
            $lab = lab::create($data);

            // Create user
            $user = User::create([
                'user_id' => $user_id,
                'lab_id' => $lab_id,
                'lab_user_role' => 1,
                'username' => $request->filled('lab_username') ? $request->lab_username : strtolower(str_replace(' ', '', $request->name)) . $request->phone,
                'name' => ucwords($request->name),
                'phone' => $request->phone,
                'email' => $email,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
                'show_password' => $request->password,
                'role' => 2,
                'profile' => 'dummy',
            ]);

            $modules = Module::where('role_id', 2)->get();

            foreach ($modules as $mod) {
                UserModulePermission::create([
                    'user_id'   => $user->id,
                    'module_id' => $mod->id,
                    'can_view'  => true,
                    'can_create' => true,
                    'can_edit'  => true,
                    'can_delete' => true,
                ]);
            }

            // Notification Start
            
            // User
            sendNotification(
                $user->id,
                'lab-registration',
                [
                    'lab_name'  => $lab->lab_name,
                    'user_name' => $user->name,
                    'date'      => now()->format('d M Y'),
                ]
            );

            // Admin
            sendNotification(
                1,
                'lab-registration-admin',
                [
                    'lab_name'  => $lab->lab_name,
                    'user_name' => $user->name,
                    'date'      => now()->format('d M Y'),
                ]
            );
            
            // Notification End

            
            DB::commit();

            $smsService = new SmsService();

            $smsService->sendSms($user->phone, null, 'lab_onboarding');
            
            Auth::login($user);

            return response()->json(['success' => 'Lab added successfully!', 'data' => $lab]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store user: ' . $e->getMessage()], 500);
        }
    }

    public function labProfile(Request $request, $slug, $lab_id)
    {
        
        $dId = decrypt($lab_id);
        $lab = lab::with(['operating_hours',
            'slider' => function ($query) {
                $query->where('is_active', 1);
            },
            'gallery' => function ($query) {
                $query->where('is_active', 1);
            }
        ])->where('slug', $slug)->where('lab_id', $dId)->firstOrFail();
        // Get package types
        $test_types = Package::select('type')->distinct()->pluck('type');

        // Get package IDs linked with this lab
        $packageIds = LabTest::where('lab_id', $dId)->pluck('package_id');

        // Get only the packages linked with this lab
        $packages = Package::with(['categoryDetails', 'parameters'])
            ->whereIn('package_id', $packageIds)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        // If it's an AJAX request for filtered packages by type
        if ($request->ajax()) {
            $type = $request->input('type');

            $query = Package::with(['categoryDetails', 'parameters'])
                ->whereIn('package_id', $packageIds); // Filter by lab-selected packages

            if ($type !== 'All') {
                $query->where('type', $type);
            }

            $items = $query->inRandomOrder()->limit(6)->get();

            // Add icon_url fallback
            $items->transform(function ($item) {
                $item->icon_url = $item->package_icon
                    ? asset($item->package_icon)
                    : ($item->categoryDetails && $item->categoryDetails->category_image
                        ? asset($item->categoryDetails->category_image)
                        : asset('default.png')); // Optional default fallback
                return $item;
            });

            return response()->json($items);
        }

        $reviews = LabReview::where('lab_id', $lab->id)->where('is_active', 1)->orderBy('id', 'DESC')->get();

        $averageRating = number_format($reviews->avg('rating'), 1);
        $totalReviews = $reviews->count();

        return view('frontend.lab.profile', compact('lab', 'test_types', 'packages', 'reviews', 'averageRating', 'totalReviews'));
    }

    // Lab Reviews
    public function labReviewStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
            'website' => 'nullable|prohibited',
        ]);

        // Save the comment
        $review = new LabReview();
        $review->lab_id = $request->lab_id;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return response()->json(['success' => true, 'message' => 'Review submitted successfully.']);
    }
}
