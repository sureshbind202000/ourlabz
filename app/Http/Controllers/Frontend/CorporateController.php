<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CorporateAbout;
use App\Models\CorporateBanner;
use App\Models\CorporateDetail;
use App\Models\CorporateDoctorConsult;
use App\Models\CorporateLabTest;
use App\Models\CorporateService;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\CorporateWellnessProgram;
use App\Models\Speciality;
use App\Models\package;
use App\Models\Cart;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CorporateController extends Controller
{


    // Registration Form  
    public function corporateRegistration()
    {
        return view('frontend.corporate.registration');
    }


    // Store Corporate
    public function storeCorporate(Request $request)
    {
        DB::beginTransaction();
        try {

            do {
                $user_id = 'CORP' . rand(100000, 999999);
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
                'alternate_phone' => $request->alternate_phone,
            ]);

            // Corporate Details
            $company = CorporateDetail::create([
                'corporate_id' => $user->user_id,
                'company_name' => $request->company_name,
                'company_reg_no' => $request->company_reg_no,
                'company_size' => $request->company_size,
                'establishment_year' => $request->establishment_year,
                'website_url' => $request->website_url,
            ]);

            DB::commit();

            // Notification Start

            // User
            sendNotification(
                $user->id,
                'corporate-registration',
                [
                    'company_name'  => $company->company_name,
                    'user_name' => $user->name,
                    'date'      => now()->format('d M Y'),
                ]
            );

            // Admin
            sendNotification(
                1,
                'corporate-registration-admin',
                [
                    'company_name'  => $company->company_name,
                    'user_name' => $user->name,
                    'date'      => now()->format('d M Y'),
                ]
            );

            $smsService = new SmsService();

            $smsService->sendSms($user->phone, null, 'corporate_onboarding');

            // Notification End

            Auth::login($user);

            return response()->json(['success' => 'Corporate registered successfully!', 'data' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store corporate: ' . $e->getMessage()], 500);
        }
    }

    // Corporate Index
    public function index()
    {
        $banners = CorporateBanner::where('status', 1)->orderBy('id', 'DESC')->get();
        $about = CorporateAbout::first();
        $service = CorporateService::first();
        $wellnessprograms = CorporateWellnessProgram::where('status', 1)->orderBy('id', 'DESC')->get();
        return view('frontend.corporate.index', compact('banners', 'about', 'service', 'wellnessprograms'));
    }

    // Corporate Services
    public function corporateServices()
    {
        $service = CorporateService::first();
        return view('frontend.corporate.services', compact('service'));
    }

    // Corporate Wellness
    public function corporateWellness($slug)
    {
        $detail = CorporateWellnessProgram::where('slug', $slug)->firstOrFail();
        return view('frontend.corporate.wellness_detail', compact('detail'));
    }

    public function corporateHospitalAssistance()
    {
        return view('frontend.corporate.hospital_assistance');
    }

    // Corporate Services
    public function corporateDoctorConsult()
    {
        $doctor_consult = CorporateDoctorConsult::first();
        $specialities = Speciality::orderByRaw('status = 1 DESC')->get();
        return view('frontend.corporate.doctor_consult', compact('doctor_consult', 'specialities'));
    }

    public function corporateLabTest()
    {
        $lab_test = CorporateLabTest::first();
        $test_types = package::select('type')->distinct()->pluck('type');
        $packages = package::with(['categoryDetails', 'parameters'])->inRandomOrder()->limit(6)->get();
        $cartItems = [];

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->get()->map(function ($cart) {
                return $cart->item_type . '_' . $cart->item_id;
            })->toArray();
        } else {
            $cartItems = array_keys(Session::get('cart', []));
        }
        return view('frontend.corporate.lab_test', compact('lab_test', 'packages', 'test_types', 'cartItems'));
    }
}
