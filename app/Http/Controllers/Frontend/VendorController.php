<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\VendorDetail;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    // Registration Form  
    public function vendorRegistration()
    {
        return view('frontend.vendor.registration');
    }

    // Store Vendor
    public function storeVendor(Request $request)
    {
        DB::beginTransaction();
        try {

            do {
                $user_id = 'VEN' . rand(100000, 999999);
            } while (User::where('user_id', $user_id)->exists());

            $email = $request->email;

            if (empty($email)) {
                $firstFourDigits = substr($request->phone, 0, 4);
                $username = strtolower(str_replace(' ', '', $request->name));
                $email = $username . $firstFourDigits . '@example.com';

                while (User::where('email', $email)->exists()) {
                    $email = $username . $firstFourDigits . '@example.com';
                }
            }

            $profileImage = null;
            if ($request->hasFile('profile')) {
                $profileImage = time() . '.' . $request->profile->extension();
                $imagePath = 'uploads/vendor/' . $profileImage;
                $request->profile->move(public_path('uploads/vendor'), $profileImage);
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
                'terms_condition' => $request->has('terms_condition') ? 1 : 0,
                'subscribe' => $request->has('subscribe') ? 1 : 0,
                'designation' => $request->designation,
                'password' => Hash::make($request->password),
                'show_password' => $request->password,
                'role' => 5, // 5 = Vendor
                'profile' => $imagePath ?? 'dummy',
            ]);

            // Contact Information | Address Details
            UserDetails::create([
                'user_id' => $user->id,
                'alternate_phone' => $request->alternate_phone,
                'address' => $request->address,
                'city' => ucwords($request->city),
                'state' => ucwords($request->state),
                'country' => ucwords($request->country),
                'pin' => $request->pin,
            ]);

            // Vendor Details
            VendorDetail::create([
                'vendor_id' => $user->id,
                'company_name' => $request->company_name,
                'company_reg_no' => $request->company_reg_no,
                'business_type' => $request->business_type,
                'tin' => $request->tin,
                'establishment_year' => $request->establishment_year,
            ]);


            DB::commit();

            // Notification Start

            // User
            sendNotification(
                $user->id,
                'vendor-registration',
                [
                    'company_name'  => $request->company_name,
                    'user_name' => $user->name,
                    'date'      => now()->format('d M Y'),
                ]
            );

            // Admin
            sendNotification(
                1,
                'vendor-registration-admin',
                [
                    'company_name'  => $request->company_name,
                    'user_name' => $user->name,
                    'date'      => now()->format('d M Y'),
                ]
            );
            // Notification End
            $smsService = new SmsService();
            $smsService->sendSms($user->phone, null, 'general');

            Auth::login($user);

            return response()->json(['success' => 'Vendor registered successfully!', 'data' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store vendor: ' . $e->getMessage()], 500);
        }
    }
}
