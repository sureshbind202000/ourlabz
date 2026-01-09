<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\lab;
use App\Models\User;
use App\Models\UserBookingPreference;
use App\Models\UserDetails;
use App\Models\UserDocuments;
use App\Models\UserInsurancePayment;
use App\Models\UserMedicalInformation;
use App\Models\UserModulePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Index 
    public function index()
    {
        return view('backend.superadmin.users.list');
    }

    // List
    public function list()
    {
        $users = User::where('role', 1)->orderBy('id', 'DESC')->get();
        return response()->json($users);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            do {
                $user_id = 'PT' . rand(100000, 999999);
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
                'role' => 1,
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
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
            ]);
            // Medical Information
            UserMedicalInformation::create([
                'user_id' => $user->id,
                'medical_condition' => json_encode($request->medical_condition),
                'allergies' => json_encode($request->allergies),
                'current_medications' => $request->current_medications,
                'family_doctor_name_contact' => $request->family_doctor_name_contact,
            ]);
            // // Booking Preferences
            // UserBookingPreference::create([
            //     'user_id' => $user->id,
            //     'preferred_test_type' => json_encode($request->preferred_test_type),
            //     'preferred_lab_clinic' => json_encode($request->preferred_lab_clinic),
            //     'preferred_date_time' => $request->preferred_date_time,
            //     'sample_collecton_mode' => $request->sample_collecton_mode,
            // ]);
            // // Insurance & Payment
            // UserInsurancePayment::create([
            //     'user_id' => $user->id,
            //     'insurance_provider' => $request->insurance_provider,
            //     'insurance_policy_number' => $request->insurance_policy_number,
            //     'payment_preference' => $request->payment_preference,
            //     'discount_code' => $request->discount_code,
            // ]);

            // $id_proofImage = null;
            // if ($request->hasFile('id_proof')) {
            //     $id_proofImage = time() . '.' . $request->id_proof->extension();
            //     $id_proofPath = 'uploads/id_proof/' . $id_proofImage;
            //     $request->id_proof->move(public_path('uploads/id_proof'), $id_proofImage);
            // }

            // $insurance_cardImage = null;
            // if ($request->hasFile('insurance_card')) {
            //     $insurance_cardImage = time() . '.' . $request->insurance_card->extension();
            //     $insurance_cardPath = 'uploads/insurance_card/' . $insurance_cardImage;
            //     $request->insurance_card->move(public_path('uploads/insurance_card'), $insurance_cardImage);
            // }

            // $doctor_prescriptionImage = null;
            // if ($request->hasFile('doctor_prescription')) {
            //     $doctor_prescriptionImage = time() . '.' . $request->doctor_prescription->extension();
            //     $doctor_prescriptionPath = 'uploads/doctor_prescription/' . $doctor_prescriptionImage;
            //     $request->doctor_prescription->move(public_path('uploads/doctor_prescription'), $doctor_prescriptionImage);
            // }

            // // Uploads & Documents
            // UserDocuments::create([
            //     'user_id' => $user->id,
            //     'id_proof' => $id_proofPath,
            //     'id_proof_type' => $request->id_proof_type,
            //     'insurance_card' => $insurance_cardPath,
            //     'doctor_prescription' => $doctor_prescriptionPath,
            // ]);

            DB::commit();

            return response()->json(['success' => 'User added successfully!', 'data' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store user: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $user = User::with(['user_details', 'medical_information', 'booking_preference', 'insurance_payment', 'documents'])->findOrFail($id);

        return response()->json(['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            // Generate email if it's empty
            $email = $request->email;
            if (empty($email)) {
                $firstFourDigits = substr($request->phone, 0, 4);
                $username = strtolower(preg_replace('/\s+/', '', $request->name));
                $email = $username . $firstFourDigits . '@example.com';

                $count = 1;
                while (User::where('email', $email)->where('id', '!=', $user->id)->exists()) {
                    $email = $username . $firstFourDigits . $count . '@example.com';
                    $count++;
                }
            }

            $userData = [
                'name' => ucwords($request->name),
                'email' => $email,
                'username' => $request->filled('username') ? $request->username : strtolower(str_replace(' ', '', $request->name)) . $request->phone,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth ?? '',
                'age' => $request->age ?? '',
                'blood_group' => $request->blood_group ?? '',
                'terms_condition' => $request->has('terms_condition') ? 1 : 0,
                'subscribe' => $request->has('subscribe') ? 1 : 0,
                'lab_user_role' => $request->lab_user_role ?? 0,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
                $userData['show_password'] = $request->password;
            }

            if ($request->hasFile('profile')) {
                if ($user->profile && file_exists(public_path($user->profile))) {
                    unlink(public_path($user->profile));
                }

                $profileImage = time() . '.' . $request->profile->extension();
                $imagePath = 'uploads/profile/' . $profileImage;
                $request->profile->move(public_path('uploads/profile'), $profileImage);
                $userData['profile'] = $imagePath;
            }

            $user->update($userData);


            UserModulePermission::where('user_id', $user->id)->delete();

            // ✅ Insert new permissions
            if ($request->has('modules')) {
                foreach ($request->modules as $moduleData) {
                    UserModulePermission::create([
                        'user_id'    => $user->id,
                        'module_id'  => $moduleData['module_id'],
                        'can_view'   => isset($moduleData['can_view']) ? 1 : 0,
                        'can_create' => isset($moduleData['can_create']) ? 1 : 0,
                        'can_edit'   => isset($moduleData['can_edit']) ? 1 : 0,
                        'can_delete' => isset($moduleData['can_delete']) ? 1 : 0,
                    ]);
                }
            }


            // Update or Create: UserDetails
            UserDetails::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'address' => $request->address ?? '',
                    'city' => ucwords($request->city) ?? '',
                    'state' => ucwords($request->state) ?? '',
                    'country' => ucwords($request->country) ?? '',
                    'pin' => $request->pin ?? '',
                    'google_map_location' => $request->google_map_location ?? '',
                    'alternate_phone' => $request->alternate_phone ?? '',
                    'emergency_contact_name' => $request->emergency_contact_name ?? '',
                    'emergency_contact_phone' => $request->emergency_contact_phone ?? '',
                ]
            );

            // Update or Create: UserMedicalInformation
            UserMedicalInformation::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'medical_condition' => json_encode($request->medical_condition) ?? '',
                    'allergies' => json_encode($request->allergies) ?? '',
                    'current_medications' => $request->current_medications ?? '',
                    'family_doctor_name_contact' => $request->family_doctor_name_contact ?? '',
                ]
            );

            // // Update or Create: UserBookingPreference
            // UserBookingPreference::updateOrCreate(
            //     ['user_id' => $user->id],
            //     [
            //         'preferred_test_type' => json_encode($request->preferred_test_type) ?? '',
            //         'preferred_lab_clinic' => json_encode($request->preferred_lab_clinic) ?? '',
            //         'preferred_date_time' => $request->preferred_date_time ?? '',
            //         'sample_collecton_mode' => $request->sample_collecton_mode ?? '',
            //     ]
            // );

            // // Update or Create: UserInsurancePayment
            // UserInsurancePayment::updateOrCreate(
            //     ['user_id' => $user->id],
            //     [
            //         'insurance_provider' => $request->insurance_provider ?? '',
            //         'insurance_policy_number' => $request->insurance_policy_number ?? '',
            //         'payment_preference' => $request->payment_preference ?? '',
            //         'discount_code' => $request->discount_code ?? '',
            //     ]
            // );

            // // Handle document updates
            // $existingDocuments = UserDocuments::where('user_id', $user->id)->first();

            // $id_proofPath = $existingDocuments->id_proof ?? null;
            // if ($request->hasFile('id_proof')) {
            //     if ($id_proofPath && file_exists(public_path($id_proofPath))) {
            //         unlink(public_path($id_proofPath));
            //     }
            //     $id_proofImage = time() . '_id.' . $request->id_proof->extension();
            //     $id_proofPath = 'uploads/id_proof/' . $id_proofImage;
            //     $request->id_proof->move(public_path('uploads/id_proof'), $id_proofImage);
            // }

            // $insurance_cardPath = $existingDocuments->insurance_card ?? null;
            // if ($request->hasFile('insurance_card')) {
            //     if ($insurance_cardPath && file_exists(public_path($insurance_cardPath))) {
            //         unlink(public_path($insurance_cardPath));
            //     }
            //     $insurance_cardImage = time() . '_insurance.' . $request->insurance_card->extension();
            //     $insurance_cardPath = 'uploads/insurance_card/' . $insurance_cardImage;
            //     $request->insurance_card->move(public_path('uploads/insurance_card'), $insurance_cardImage);
            // }

            // $doctor_prescriptionPath = $existingDocuments->doctor_prescription ?? null;
            // if ($request->hasFile('doctor_prescription')) {
            //     if ($doctor_prescriptionPath && file_exists(public_path($doctor_prescriptionPath))) {
            //         unlink(public_path($doctor_prescriptionPath));
            //     }
            //     $doctor_prescriptionImage = time() . '_prescription.' . $request->doctor_prescription->extension();
            //     $doctor_prescriptionPath = 'uploads/doctor_prescription/' . $doctor_prescriptionImage;
            //     $request->doctor_prescription->move(public_path('uploads/doctor_prescription'), $doctor_prescriptionImage);
            // }

            // // Update or Create: UserDocuments
            // UserDocuments::updateOrCreate(
            //     ['user_id' => $user->id],
            //     [
            //         'id_proof' => $id_proofPath,
            //         'id_proof_type' => $request->id_proof_type ?? '',
            //         'insurance_card' => $insurance_cardPath,
            //         'doctor_prescription' => $doctor_prescriptionPath,
            //     ]
            // );

            DB::commit();
            return response()->json(['success' => 'User updated successfully!', 'data' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update user: ' . $e->getMessage()], 500);
        }
    }


    // Delete
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User and related data deleted successfully.']);
    }

    //  Profile
    public function profile($userid)
    {
        $user = User::where('user_id', $userid)->with(['user_details'])->first();
        // dd($user);
        return view('backend.superadmin.users.profile', compact('user'));
    }
}
