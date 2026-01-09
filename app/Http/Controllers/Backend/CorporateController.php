<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Imports\CorporateEmployeeImport;
use App\Models\CorporateDetail;
use App\Models\lab;
use App\Models\User;
use App\Models\Payment;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class CorporateController extends Controller
{
    // Index
    public function index()
    {
        $labs = lab::with(['lab_tests'])->orderBy('id', 'DESC')->get();
        return view('backend.superadmin.corporates.list', compact('labs'));
    }

    public function list()
    {
        $corporates = User::where('role', 4)->orderBy('id', 'DESC')->get();
        return response()->json($corporates);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            do {
                $user_id = 'CORP' . rand(100000, 999999);
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
            // Personal Details | Login & Account
            // Create user
            $user = User::create([
                'user_id' => $user_id,
                'name' => ucwords($request->name),
                'phone' => $request->phone,
                'username' => $request->filled('username') ? $request->username : strtolower(str_replace(' ', '', $request->name)) . $request->phone,
                'email' => $email,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'age' => $request->age,
                'blood_group' => $request->blood_group,
                'terms_condition' => $request->has('terms_condition') ? 1 : 0,
                'subscribe' => $request->has('subscribe') ? 1 : 0,
                'password' => Hash::make($request->password),
                'show_password' => $request->password,
                'role' => 4, // 4 = Corporate
                'profile' => $imagePath ?? 'dummy',
            ]);

            // Contact Information | Address Details
            UserDetails::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'city' => ucwords($request->city),
                'state' => ucwords($request->state),
                'country' => ucwords($request->country),
                'pin' => $request->pin,
                'google_map_location' => $request->google_map_location,
                'alternate_phone' => $request->alternate_phone,
            ]);

            $company_reg_certImage = null;
            if ($request->hasFile('company_reg_cert')) {
                $company_reg_certImage = time() . '.' . $request->company_reg_cert->extension();
                $company_reg_certPath = 'uploads/company_reg_cert/' . $company_reg_certImage;
                $request->company_reg_cert->move(public_path('uploads/company_reg_cert'), $company_reg_certImage);
            }

            $employee_listImage = null;
            if ($request->hasFile('employee_list')) {
                $employee_listImage = time() . '.' . $request->employee_list->extension();
                $employee_listPath = 'uploads/employee_list/' . $employee_listImage;
                $request->employee_list->move(public_path('uploads/employee_list'), $employee_listImage);
            }

            $authorization_letterImage = null;
            if ($request->hasFile('authorization_letter')) {
                $authorization_letterImage = time() . '.' . $request->authorization_letter->extension();
                $authorization_letterPath = 'uploads/authorization_letter/' . $authorization_letterImage;
                $request->authorization_letter->move(public_path('uploads/authorization_letter'), $authorization_letterImage);
            }

            // Corporate Details
            CorporateDetail::create([
                'corporate_id' => $user->user_id,
                'company_name' => $request->company_name,
                'company_reg_no' => $request->company_reg_no,
                'industry_type' => $request->industry_type,
                'company_size' => $request->company_size,
                'establishment_year' => $request->establishment_year,
                'website_url' => $request->website_url,
                'no_of_emp_for_test' => $request->no_of_emp_for_test,
                'on_site_test' => $request->on_site_test,
                'home_sample_collection' => $request->home_sample_collection,
                'frequency_of_testing' => $request->frequency_of_testing,
                'billing_contact_name' => $request->billing_contact_name,
                'billing_contact_email' => $request->billing_contact_email,
                'company_gst' => $request->company_gst,
                'prefer_payment_method' => $request->prefer_payment_method,
                'bank_account_no' => $request->bank_account_no,
                'ifsc' => $request->ifsc,
                'subscription_plan' => $request->subscription_plan,
                'company_reg_cert' => $company_reg_certPath,
                'employee_list' => $employee_listPath,
                'authorization_letter' => $authorization_letterPath,
            ]);

            DB::commit();

            return response()->json(['success' => 'Corporate added successfully!', 'data' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store corporate: ' . $e->getMessage()], 500);
        }
    }

    // Edit
    public function edit($id)
    {
        $corporate = User::with(['corporate_details', 'user_details'])->findOrFail($id);
        return response()->json(['corporate' => $corporate]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $corporateDetail = CorporateDetail::where('corporate_id', $user->user_id)->first();
            $userDetails = UserDetails::where('user_id', $user->id)->first();

            $email = $request->email;
            if (empty($email)) {
                $firstFourDigits = substr($request->phone, 0, 4);
                $username = strtolower(str_replace(' ', '', $request->name));
                $email = $username . $firstFourDigits . '@example.com';
            }

            if ($request->hasFile('profile')) {
                if ($user->profile && $user->profile !== 'dummy' && File::exists(public_path($user->profile))) {
                    File::delete(public_path($user->profile));
                }
                $profileImage = time() . '.' . $request->profile->extension();
                $imagePath = 'uploads/profile/' . $profileImage;
                $request->profile->move(public_path('uploads/profile'), $profileImage);
                $user->profile = $imagePath;
                $user->save();
            }

            // Update User
            $user->update([
                'name' => ucwords($request->name),
                'phone' => $request->phone,
                'username' => $request->filled('username') ? $request->username : strtolower(str_replace(' ', '', $request->name)) . $request->phone,
                'email' => $email,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'age' => $request->age,
                'blood_group' => $request->blood_group,
                'terms_condition' => $request->has('terms_condition') ? 1 : 0,
                'subscribe' => $request->has('subscribe') ? 1 : 0,
            ]);

            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                    'show_password' => $request->password,
                ]);
            }

            // Update UserDetails
            $userDetails->update([
                'address' => $request->address,
                'city' => ucwords($request->city),
                'state' => ucwords($request->state),
                'country' => ucwords($request->country),
                'pin' => $request->pin,
                'google_map_location' => $request->google_map_location,
                'alternate_phone' => $request->alternate_phone,
            ]);

            // Upload documents
            if ($request->hasFile('company_reg_cert')) {
                if ($corporateDetail->company_reg_cert && File::exists(public_path($corporateDetail->company_reg_cert))) {
                    File::delete(public_path($corporateDetail->company_reg_cert));
                }
                $filename = time() . '.' . $request->company_reg_cert->extension();
                $path = 'uploads/company_reg_cert/' . $filename;
                $request->company_reg_cert->move(public_path('uploads/company_reg_cert'), $filename);
                $corporateDetail->company_reg_cert = $path;
            }

            if ($request->hasFile('employee_list')) {
                if ($corporateDetail->employee_list && File::exists(public_path($corporateDetail->employee_list))) {
                    File::delete(public_path($corporateDetail->employee_list));
                }
                $filename = time() . '.' . $request->employee_list->extension();
                $path = 'uploads/employee_list/' . $filename;
                $request->employee_list->move(public_path('uploads/employee_list'), $filename);
                $corporateDetail->employee_list = $path;
            }


            if ($request->hasFile('authorization_letter')) {
                if ($corporateDetail->authorization_letter && File::exists(public_path($corporateDetail->authorization_letter))) {
                    File::delete(public_path($corporateDetail->authorization_letter));
                }
                $filename = time() . '.' . $request->authorization_letter->extension();
                $path = 'uploads/authorization_letter/' . $filename;
                $request->authorization_letter->move(public_path('uploads/authorization_letter'), $filename);
                $corporateDetail->authorization_letter = $path;
            }


            // Update CorporateDetails
            $corporateDetail->update([
                'company_name' => $request->company_name,
                'company_reg_no' => $request->company_reg_no,
                'industry_type' => $request->industry_type,
                'company_size' => $request->company_size,
                'establishment_year' => $request->establishment_year,
                'website_url' => $request->website_url,
                'no_of_emp_for_test' => $request->no_of_emp_for_test,
                'on_site_test' => $request->on_site_test,
                'home_sample_collection' => $request->home_sample_collection,
                'frequency_of_testing' => $request->frequency_of_testing,
                'billing_contact_name' => $request->billing_contact_name,
                'billing_contact_email' => $request->billing_contact_email,
                'company_gst' => $request->company_gst,
                'prefer_payment_method' => $request->prefer_payment_method,
                'bank_account_no' => $request->bank_account_no,
                'ifsc' => $request->ifsc,
                'subscription_plan' => $request->subscription_plan,
            ]);

            $corporateDetail->save();
            DB::commit();

            return response()->json(['success' => 'Corporate updated successfully!', 'data' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update corporate: ' . $e->getMessage()], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Corporate not found.'], 404);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'Corporate and related data deleted successfully.']);
    }

    public function changeStatus(Request $request)
    {

        $corporate = User::find($request->corporate_id);

        if ($corporate) {
            $corporate->status = $request->status;
            $corporate->save();

            // Convert status to label and badge class
            $statusLabel = match ((int) $corporate->status) {
                1 => 'Approved',
                2 => 'Declined',
                0 => 'Pending',
                default => 'Unknown'
            };

            $badgeClass = match ((int) $corporate->status) {
                1 => 'bg-success',
                2 => 'bg-danger',
                0 => 'bg-warning',
                default => 'bg-secondary'
            };

            return response()->json([
                'success' => true,
                'new_status_label' => $statusLabel,
                'new_badge_class' => $badgeClass
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function profile($id)
    {
        $user = User::with(['user_details', 'corporate_details'])
            ->where('user_id', $id)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Corporate not found.'
            ], 404);
        }

        return view('backend.superadmin.corporates.profile', compact('user'));
    }
    public function empList()
    {
        return view('backend.superadmin.corporates.employee.list');
    }
    public function empStore(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();

        do {
            $user_id = $request->corp_id . 'U-' . rand(100000, 999999);
        } while (User::where('user_id', $user_id)->exists());

        do {
            $username = 'User' . rand(100000, 999999);
        } while (User::where('username', $username)->exists());

        $user = User::create([
            'user_id' => $user_id,
            'corporate_id' => $request->corporate_id,
            'name' => $request->name ?? 'User',
            'phone' => $request->phone,
            'email' => $request->email ?? ($username . '@example.com'),
            'role' => 1,
            'username' => $username,
            'password' => Hash::make($username),
            'show_password' => $username,
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('user.dashboard')
        ]);
    }

    public function getEmpList()
    {
        $user = auth()->user();
        $employees = User::where('role', 1)->where('corporate_id', $user->id)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $employees
        ]);
    }
    public function empEdit(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        return response()->json($user);
    }
    public function corpEmpList($id)
    {
        return view('backend.superadmin.corporates.corpemplist', compact('id'));
    }
    public function getCorpEmpList(Request $request)
    {
        $request->validate([
            'corpId' => 'required|string'
        ]);

        $corp = User::where('user_id', $request->corpId)->first();

        if (!$corp) {
            return response()->json([
                'success' => false,
                'message' => 'Corporate user not found.'
            ], 404);
        }

        $employees = User::where('corporate_id', $corp->id)->get();

        return response()->json([
            'success' => true,
            'data' => $employees
        ]);
    }
    public function corpEmpProfile($userid)
    {
        $user = User::where('user_id', $userid)->with(['user_details'])->first();
        // dd($user);
        return view('backend.superadmin.corporates.employee.profile', compact('user'));
    }
    public function importEmployees(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'wallet_amount' => 'required|numeric|min:0'
        ]);

        $corporate = auth()->user();
        $walletAmountPerEmployee = $request->wallet_amount;

        $rows = Excel::toArray([], $request->file('file'));
        $employeeRows = collect($rows[0])->filter(function ($row) {
            return !empty($row[0]) && $row[0] !== 'Name';
        });

        $totalRequired = $employeeRows->count() * $walletAmountPerEmployee;

        if ($corporate->wallet < $totalRequired) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient wallet balance to distribute funds to employees.',
            ], 422);
        }

        $corporate->wallet -= $totalRequired;
        $corporate->save();

        Excel::import(new CorporateEmployeeImport($corporate->user_id, $walletAmountPerEmployee), $request->file('file'));

        return response()->json([
            'success' => true,
            'message' => 'Employees imported and wallet amount distributed successfully.',
        ]);
    }

    public function payments()
    {
        return view('backend.superadmin.corporates.payment.list');
    }

    public function paymentsList()
    {
        $payments = Payment::where('user_id',auth()->user()->id)->orderBy('id','DESC')->get();

        return response()->json([
            'success' => true,
            'payments'    => $payments
        ]);
    }
}
