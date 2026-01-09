<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BookingTest;
use App\Models\Facility;
use App\Models\lab;
use App\Models\package;
use App\Models\ReferedTest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReferingLabController extends Controller
{
    // Index 
    public function index()
    {
        $packages = package::get(['package_id', 'name']);
        $facilities = Facility::where('status', 1)->get();
        return view('backend.superadmin.labs.refering_lab.list', compact('packages', 'facilities'));
    }

    // List
    public function list()
    {
        $auth = auth()->user();
        if ($auth->role  == 2) {
            $refering_id = User::where('lab_id', $auth->lab_id)->where('lab_user_role', 1)->pluck('id');
        }
        $refering_lab_admin = User::where('role', 2)->where('lab_user_role', 1)->where('refering_id', $refering_id)->first();
        $labs = lab::where('lab_id', $refering_lab_admin->lab_id)->orderBy('id', 'DESC')->get();
        return response()->json($labs);
    }

    // Store
    public function store(Request $request)
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
            $data['website_url'] = url('/');
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
                'refering_id' => auth()->user()->id,
            ]);

            DB::commit();

            // Notification Start
            $refLab = lab::where('lab_id', auth()->user()->lab_id)->first();
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

            sendNotification(
                1,
                'lab-registration-admin',
                [
                    'lab_name'  => $lab->lab_name,
                    'user_name' => $user->name,
                    'date'      => now()->format('d M Y'),
                ]
            );

            sendNotification(
                1,
                'new-referring-lab-added',
                [
                    'lab_name'  => $lab->lab_name,
                    'added_by' => $refLab->lab_name,
                    'date'      => now()->format('d M Y'),
                ]
            );

            // Notification End

            return response()->json(['success' => 'Refering Lab added successfully!', 'data' => $lab]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to Refering Lab: ' . $e->getMessage()], 500);
        }
    }

    public function assignReferedTest(Request $request)
    {
        $request->validate([
            'refered_lab_id' => 'required',
            'assignments' => 'required|array',
            'note' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->assignments as $assignment) {
                [$patient_id, $booking_test_id] = explode('_', $assignment);

                // Ensure test exists and belongs to the booking
                $test = BookingTest::where('id', $booking_test_id)
                    ->firstOrFail();

                ReferedTest::create([
                    'refered_by_id'   => auth()->user()->lab_id,
                    'refered_lab_id'      => $request->refered_lab_id,
                    'refered_test_id'   => $test->id,
                    'note'      => $request->note,
                    'status'       => 0,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Tests assigned to refering lab successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to assign test to refering lab. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Refered tests index
    public  function referedTests()
    {
        return view('backend.superadmin.labs.refering_lab.test');
    }

    public function referedTestList()
    {
        $auth = auth()->user();
        $refered_tests = ReferedTest::with(['lab', 'test.package', 'test.patient'])->where('refered_by_id', $auth->lab_id)->get();
        return response()->json($refered_tests);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:refered_tests,id',
            'status' => 'required|in:0,1,2,3',
        ]);

        $refer = ReferedTest::find($request->id);
        $refer->status = $request->status;
        $refer->save();

        return response()->json(['message' => 'Status updated successfully']);
    }

    public function destroy($id)
    {
        $refer = ReferedTest::findOrFail($id);
        $refer->delete();

        return response()->json(['message' => 'Referred test deleted successfully']);
    }
}
