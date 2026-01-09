<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\lab;
use App\Models\LabOperatingHour;
use App\Models\package;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TestsExport;
use App\Models\Facility;
use App\Models\LabReview;
use App\Models\LabTest;
use App\Models\Module;
use App\Models\UserModulePermission;
use App\Services\SmsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LabController extends Controller
{
    // Index 
    public function index()
    {
        $packages = Package::get(['package_id', 'name']);
        $facilities = Facility::where('status', 1)->get();
        return view('backend.superadmin.labs.list', compact('packages', 'facilities'));
    }

    // List
    public function list()
    {
        $labs = lab::orderBy('id', 'DESC')->get();
        return response()->json($labs);
    }

    // Store
    public function store(Request $request)
    {
        // dd($request);
        // exit();
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
            $lab_licensePath = null;
            $doctor_licensePath = null;
            $lab_logoPath = null;
            $certificationPath = null;

            // Accreditation Details
            if ($request->hasFile('accreditation_details')) {
                $accreditation_details = time() . '.' . $request->accreditation_details->extension();
                $accreditation_detailsPath = 'uploads/lab/accreditation_details/' . $accreditation_details;
                $request->accreditation_details->move(public_path('uploads/lab/accreditation_details'), $accreditation_details);
            }

            // Lab License
            if ($request->hasFile('lab_license')) {
                $lab_license = time() . '.' . $request->lab_license->extension();
                $lab_licensePath = 'uploads/lab/lab_license/' . $lab_license;
                $request->lab_license->move(public_path('uploads/lab/lab_license'), $lab_license);
            }

            // Doctor License
            if ($request->hasFile('doctor_license')) {
                $doctor_license = time() . '.' . $request->doctor_license->extension();
                $doctor_licensePath = 'uploads/lab/doctor_license/' . $doctor_license;
                $request->doctor_license->move(public_path('uploads/lab/doctor_license'), $doctor_license);
            }

            // Lab Logo
            if ($request->hasFile('lab_logo')) {
                $lab_logo = time() . '.' . $request->lab_logo->extension();
                $lab_logoPath = 'uploads/lab/lab_logo/' . $lab_logo;
                $request->lab_logo->move(public_path('uploads/lab/lab_logo'), $lab_logo);
            }

            // Certification
            if ($request->hasFile('certification')) {
                $certification = time() . '.' . $request->certification->extension();
                $certificationPath = 'uploads/lab/certification/' . $certification;
                $request->certification->move(public_path('uploads/lab/certification'), $certification);
            }

            if ($request->hasFile('test_excel')) {
                $file = $request->file('test_excel');
                $data = Excel::toArray([], $file); // returns an array of rows

                if (!empty($data) && isset($data[0])) {
                    foreach ($data[0] as $index => $row) {
                        // Skip the header row
                        if ($index === 0 || empty($row[0])) continue;

                        // Make sure the row has all required columns
                        if (count($row) < 4) continue;

                        LabTest::create([
                            'lab_id'           => $lab_id,
                            'package_id'       => $row[0], // Test ID
                            'test_name'        => $row[1], // Test Name
                            'standard_price'   => $row[2], // Standard Price
                            'corporate_price'  => $row[3], // Corporate Price
                        ]);
                    }
                }
            }

            $days = is_array($request->day) ? $request->day : [$request->day];
            $from_times = is_array($request->from_time) ? $request->from_time : [$request->from_time];
            $to_times = is_array($request->to_time) ? $request->to_time : [$request->to_time];
            $statuses = is_array($request->status) ? $request->status : [$request->status];

            foreach ($days as $key => $day) {
                LabOperatingHour::create([
                    'lab_id' => $lab_id,
                    'day' => $day,
                    'from_time' => $from_times[$key] ?? null,
                    'to_time' => $to_times[$key] ?? null,
                    'status' => $statuses[$key] ?? null,
                ]);
            }

            $data = $request->all();

            $data['lab_id'] = $lab_id;
            $data['accreditation_details'] = $accreditation_detailsPath;
            $data['lab_license'] = $lab_licensePath;
            $data['doctor_license'] = $doctor_licensePath;
            $data['lab_logo'] = $lab_logoPath;
            $data['certification'] = $certificationPath;
            $data['list_of_test_available'] = $request->filled('list_of_test_available') ? json_encode($request->list_of_test_available) : null;
            $data['lab_type'] = $request->filled('lab_type') ? json_encode($request->lab_type) : null;
            $data['slug'] = Str::slug($request->lab_name);

            // Create user
            $lab = lab::create($data);

            // Create user
            $user = User::create([
                'user_id' => $user_id,
                'lab_id' => $lab_id,
                'lab_user_role' => 1,
                'username' => $request->filled('username') ? $request->username : strtolower(str_replace(' ', '', $request->name)) . $request->phone,
                'name' => ucwords($request->name),
                'phone' => $request->phone,
                'email' => $email,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
                'show_password' => $request->password,
                'role' => 2,
                'profile' => 'dummy',
                'status' => 1,
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
            DB::commit();
            return response()->json(['success' => 'Lab added successfully!', 'data' => $lab]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store user: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $lab = Lab::with([
            'users' => function ($q) {
                $q->where('lab_user_role', 1);
            },
            'operating_hours'
        ])->findOrFail($id);

        return response()->json(['lab' => $lab]);
    }

    public function update(Request $request, $id)
    {

        DB::beginTransaction();

        try {
            $lab = Lab::findOrFail($id);
            $user = $lab->users()->where('lab_user_role', 1)->first();

            $email = $request->email;

            if (empty($email)) {
                $firstFourDigits = substr($request->phone, 0, 4);
                $username = strtolower(str_replace(' ', '', $request->name));
                $email = $username . $firstFourDigits . '@example.com';

                while (Lab::where('email', $email)->exists()) {
                    $email = $username . $firstFourDigits . '@example.com';
                }
            }

            $accreditation_detailsPath = $lab->accreditation_details;
            $lab_licensePath = $lab->lab_license;
            $doctor_licensePath = $lab->doctor_license;
            $lab_logoPath = $lab->lab_logo;
            $certificationPath = $lab->certification;

            // Accreditation Details
            if ($request->hasFile('accreditation_details')) {
                if (!empty($lab->accreditation_details) && file_exists(public_path($lab->accreditation_details))) {
                    unlink(public_path($lab->accreditation_details));
                }

                $file = $request->file('accreditation_details');
                $accreditation_details = time() . '.' . $file->getClientOriginalExtension();
                $accreditation_detailsPath = 'uploads/lab/accreditation_details/' . $accreditation_details;
                $file->move(public_path('uploads/lab/accreditation_details'), $accreditation_details);
            }

            // Lab License
            if ($request->hasFile('lab_license')) {
                if (!empty($lab->lab_license) && file_exists(public_path($lab->lab_license))) {
                    unlink(public_path($lab->lab_license));
                }

                $file = $request->file('lab_license');
                $lab_license = time() . '.' . $file->getClientOriginalExtension();
                $lab_licensePath = 'uploads/lab/lab_license/' . $lab_license;
                $file->move(public_path('uploads/lab/lab_license'), $lab_license);
            }

            // Doctor License
            if ($request->hasFile('doctor_license')) {
                if (!empty($lab->doctor_license) && file_exists(public_path($lab->doctor_license))) {
                    unlink(public_path($lab->doctor_license));
                }

                $file = $request->file('doctor_license');
                $doctor_license = time() . '.' . $file->getClientOriginalExtension();
                $doctor_licensePath = 'uploads/lab/doctor_license/' . $doctor_license;
                $file->move(public_path('uploads/lab/doctor_license'), $doctor_license);
            }

            // Lab Logo
            if ($request->hasFile('lab_logo')) {
                if (!empty($lab->lab_logo) && file_exists(public_path($lab->lab_logo))) {
                    unlink(public_path($lab->lab_logo));
                }

                $file = $request->file('lab_logo');
                $lab_logo = time() . '.' . $file->getClientOriginalExtension();
                $lab_logoPath = 'uploads/lab/lab_logo/' . $lab_logo;
                $file->move(public_path('uploads/lab/lab_logo'), $lab_logo);
            }

            // Certification
            if ($request->hasFile('certification')) {
                if (!empty($lab->certification) && file_exists(public_path($lab->certification))) {
                    unlink(public_path($lab->certification));
                }

                $file = $request->file('certification');
                $certification = time() . '.' . $file->getClientOriginalExtension();
                $certificationPath = 'uploads/lab/certification/' . $certification;
                $file->move(public_path('uploads/lab/certification'), $certification);
            }

            if ($request->hasFile('test_excel')) {
                $file = $request->file('test_excel');
                $data = Excel::toArray([], $file); // returns an array of rows

                if (!empty($data) && isset($data[0])) {
                    $rows = $data[0];

                    // Remove existing lab_tests for this lab
                    LabTest::where('lab_id', $lab->lab_id)->delete();

                    foreach ($rows as $index => $row) {
                        // Skip the header row
                        if ($index === 0 || empty($row[0])) continue;

                        // Make sure the row has all required columns
                        if (count($row) < 4) continue;

                        LabTest::create([
                            'lab_id'           => $lab->lab_id,
                            'package_id'       => trim($row[0]), // Test ID
                            'test_name'        => trim($row[1]), // Test Name
                            'standard_price'   => trim($row[2]), // Standard Price
                            'corporate_price'  => trim($row[3]), // Corporate Price
                        ]);
                    }
                }
            }

            $days = is_array($request->day) ? $request->day : [$request->day];
            $from_times = is_array($request->from_time) ? $request->from_time : [$request->from_time];
            $to_times = is_array($request->to_time) ? $request->to_time : [$request->to_time];
            $statuses = is_array($request->status) ? $request->status : [$request->status];

            $existingHours = LabOperatingHour::where('lab_id', $lab->lab_id)->exists();

            if ($existingHours) {
                LabOperatingHour::where('lab_id', $lab->lab_id)->delete();
            }

            // Insert new operating hours
            foreach ($days as $key => $day) {
                LabOperatingHour::create([
                    'lab_id' => $lab->lab_id,
                    'day' => $day,
                    'from_time' => $from_times[$key] ?? null,
                    'to_time' => $to_times[$key] ?? null,
                    'status' => $statuses[$key] ?? null,
                ]);
            }

            $data = $request->all();
            $data['accreditation_details'] = $accreditation_detailsPath;
            $data['lab_license'] = $lab_licensePath;
            $data['doctor_license'] = $doctor_licensePath;
            $data['lab_logo'] = $lab_logoPath;
            $data['certification'] = $certificationPath;
            $data['list_of_test_available'] = $request->filled('list_of_test_available') ? json_encode($request->list_of_test_available) : null;
            $data['lab_type'] = $request->filled('lab_type') ? json_encode($request->lab_type) : null;
            $data['slug'] = Str::slug($request->lab_name);
            // dd( $data);
            // exit();
            $lab->update($data);

            if ($user) {
                $user->update([
                    'username' => $request->filled('username') ? $request->username : strtolower(str_replace(' ', '', $request->name)) . $request->phone,
                    'name' => ucwords($request->name),
                    'phone' => $request->phone,
                    'email' => $email,
                    'gender' => $request->gender,
                ]);

                if ($request->filled('password')) {
                    $user->update([
                        'password' => Hash::make($request->password),
                        'show_password' => $request->password,
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => 'Lab updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update lab: ' . $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'status' => 'required|in:0,1'
        ]);

        $user = User::find($request->id);
        $user->is_active = $request->status;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully.'
        ]);
    }


    // Delete
    public function destroy($id)
    {
        $lab = lab::find($id);

        if (!$lab) {
            return response()->json(['success' => false, 'message' => 'Lab not found.'], 404);
        }

        // Delete the package (triggers the cascade delete)
        $lab->delete();

        return response()->json(['success' => true, 'message' => 'Lab and all related users data deleted successfully.']);
    }

    //  Profile
    public function profile($labid)
    {

        $lab = lab::where('lab_id', $labid)->with(['users', 'lab_tests'])->first();
        $packages = Package::get(['package_id', 'name']);
        $facilities = Facility::where('status', 1)->get();
        return view('backend.superadmin.labs.profile', compact('lab', 'packages', 'facilities'));
    }

    // Lab User Profile
    public function labUserProfile($userid)
    {
        $decrypt_userid = decrypt($userid);
        $user = User::with('user_details')->where('user_id', $decrypt_userid)->first();
        return view('backend.superadmin.labs.users.profile', compact('user'));
    }
    // La User Edit
    public function labUserEdit($id)
    {
        $user = User::with(['user_details'])->findOrFail($id);

        $permissions = DB::table('user_module_permissions')
            ->where('user_id', $id)
            ->get()
            ->keyBy('module_id');

        $permissions = DB::table('user_module_permissions')
            ->where('user_id', $id)
            ->get()
            ->keyBy('module_id');

        $formattedPermissions = [];

        foreach ($permissions as $moduleId => $perm) {
            $formattedPermissions[$moduleId] = [
                'can_view' => $perm->can_view,
                'can_create' => $perm->can_create,
                'can_edit' => $perm->can_edit,
                'can_delete' => $perm->can_delete,
            ];
        }

        return response()->json([
            'user' => $user,
            'permissions' => $formattedPermissions
        ]);
    }

    public function labUserStore(Request $request)
    {
        DB::beginTransaction();
        try {

            do {
                $user_id = 'LAB-U' . rand(100000, 999999);
            } while (User::where('user_id', $user_id)->exists());

            $email = $request->email;

            if (empty($email)) {
                $firstFourDigits = substr($request->phone, 0, 4);
                $username = strtolower(str_replace(' ', '', $request->name)); // Remove spaces
                $email = $username . $firstFourDigits . '@example.com';

                while (User::where('email', $email)->exists()) {
                    $email = $username . $firstFourDigits . '@example.com';
                }
            }

            $profileImage = null;
            if ($request->hasFile('profile')) {
                $profileImage = time() . '.' . $request->profile->extension();
                $imagePath = 'uploads/profile/' . $profileImage;
                $request->profile->move(public_path('uploads/profile'), $profileImage);
            }

            // Create user
            $user = User::create([
                'user_id' => $user_id,
                'lab_id' => $request->lab_id,
                'name' => ucwords($request->name),
                'username' => $request->filled('username') ? $request->username : strtolower(str_replace(' ', '', $request->name)) . $request->phone,
                'phone' => $request->phone,
                'email' => $email,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
                'show_password' => $request->password,
                'role' => 2,
                'lab_user_role' => $request->lab_user_role,
                'profile' => $imagePath ?? 'dummy',
                'status' => 1,
            ]);

            UserDetails::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'city' => ucwords($request->city),
                'state' => ucwords($request->state),
                'country' => ucwords($request->country),
                'pin' => $request->pin,
            ]);

            if ($request->has('modules')) {
                foreach ($request->modules as $mod) {
                    UserModulePermission::create([
                        'user_id' => $user->id,
                        'module_id' => $mod['module_id'],
                        'can_view' => isset($mod['can_view']),
                        'can_create' => isset($mod['can_create']),
                        'can_edit' => isset($mod['can_edit']),
                        'can_delete' => isset($mod['can_delete']),
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => 'User added successfully!', 'data' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store user: ' . $e->getMessage()], 500);
        }
    }

    public function exportTestExcel(Request $request)
    {
        $selectedTestIds = $request->input('test_ids', []);
        $tests = package::whereIn('package_id', $selectedTestIds)->get();

        return Excel::download(new TestsExport($tests), 'tests_template.xlsx');
    }

    public function changeStatus(Request $request)
    {
        $lab = Lab::find($request->lab_id);
        if ($lab) {
            $lab->status = $request->status;
            $lab->save();

            // Convert status to label and badge class
            $statusLabel = match ((int) $lab->status) {
                1 => 'Approved',
                2 => 'Declined',
                0 => 'Pending',
                default => 'Unknown'
            };

            $badgeClass = match ((int) $lab->status) {
                1 => 'bg-success',
                2 => 'bg-danger',
                0 => 'bg-warning',
                default => 'bg-secondary'
            };

            if ((int)$lab->status === 1) {
                // Fetch the user where role=2, user_role_id=1 and belongs to this lab
                $user = User::where('role', 2)
                    ->where('lab_user_role', 1)
                    ->where('lab_id', $lab->lab_id)
                    ->first();

                $user->status = 1;
                $user->save();

                $support_no = '+91-7411727444';

                if ($user && !empty($user->phone)) {
                    $smsService = new SmsService();
                    $smsService->sendSms($user->phone, ['lab_admin_name' => $user->name, 'support_no' => $support_no], 'lab_approval_notification');
                }
            }

            return response()->json([
                'success' => true,
                'new_status_label' => $statusLabel,
                'new_badge_class' => $badgeClass
            ]);
        }

        return response()->json(['success' => false]);
    }

    // Manage Staff
    public function manageStaff()
    {
        $modules = Module::where('role_id', 2)->get();
        return view('backend.superadmin.labs.manage.staff', compact('modules'));
    }

    public function manageStaffList()
    {
        $lab_id = Auth::user()->lab_id;
        $staff = User::where('lab_id', $lab_id)->get();
        foreach ($staff as $st) {
            $st->encrypted_id = encrypt($st->user_id);
        }
        return response()->json($staff);
    }


    // Lab Reviews
    public function LabReviews()
    {
        return view('backend.superadmin.labs.review.list');
    }

    // Review List
    public function LabReviewList()
    {
        $review = LabReview::with(['user:id,id,name'])->orderBy('is_active', 'asc')
            ->latest()
            ->get();
        $review->transform(function ($review) {
            $review->encrypted_id = encrypt($review->doctor_id);
            return $review;
        });
        return response()->json($review);
    }

    // Review Status
    public function toggleLabReviewStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:lab_reviews,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $review = LabReview::findOrFail($request->id);

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
    public function LabReviewDestroy($id)
    {
        try {

            $review = LabReview::findOrFail($id);

            $review->delete();

            return response()->json(['success' => true, 'message' => 'Review deleted successfully.']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Failed to delete review: ' . $e->getMessage()], 500);
        }
    }
}
