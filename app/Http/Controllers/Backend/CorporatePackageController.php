<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CorporatePackage;
use App\Models\package;
use App\Models\Payment;
use App\Models\CorporateDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class CorporatePackageController extends Controller
{
    public function index()
    {
        $packages = package::where('type', 'Package')->get();
        $tests = package::where('type', 'Test')->get();
        $corporates = User::where('role', 4)->get();
        return view('backend.superadmin.packages.corporate.list', compact('corporates', 'packages', 'tests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_ids' => 'array|nullable',
            'test_ids' => 'array|nullable',
            'name' => 'required|string',
            'no_of_employee' => 'nullable|integer|min:1',
            'price' => 'required|numeric',
            'discount_type' => 'nullable|string',
            'discount' => 'nullable|numeric',
            'total_price' => 'required|numeric',
            'coupon' => 'nullable|string',
        ]);
        if (empty($request->package_ids) && empty($request->test_ids)) {
            return response()->json([
                'message' => 'At least one Package or Test must be selected.'
            ], 422);
        }
        do {
            $generatedId = 'P' . rand(100000, 999999);
        } while (CorporatePackage::where('p_id', $generatedId)->exists());
        CorporatePackage::create([
            'p_id' => $generatedId,
            'corporate_id' => $request->c_id ?? 0,
            'package_ids' => $validated['package_ids'] ?? [],
            'test_ids' => $validated['test_ids'] ?? [],
            'name' => $validated['name'],
            'no_of_employee' => $validated['no_of_employee'] ?? null,
            'price' => $validated['price'],
            'discount_type' => $validated['discount_type'] ?? null,
            'discount' => $validated['discount'] ?? 0,
            'total_price' => $validated['total_price'],
            'coupon' => $validated['coupon'] ?? null,
        ]);
        return response()->json(['success', 'Corporate Package created successfully.']);
    }

    public function list()
    {
        $user = auth()->user();

        // Fetch packages with corporate admin + details
        $query = CorporatePackage::with(['corporateAdmin.corporate_details','payment']);

        // If corporate user, only show their own packages
        if ($user->role == 4) {
            $query->where('corporate_id', $user->id);
        }

        $packages = $query->latest()->get();

        $result = [];

        foreach ($packages as $corp) {
            $packageIds = $corp->package_ids ?? [];
            $testIds = $corp->test_ids ?? [];

            // Optional: fetch package/test names
            $packageNames = Package::whereIn('id', $packageIds)->pluck('name')->toArray();
            $testNames = Package::whereIn('id', $testIds)->pluck('name')->toArray();

            $corporateAdmin = $corp->corporateAdmin;
            $corporateDetails = $corporateAdmin?->corporate_details;
            $corporatePackagePayment = $corp->payment;

            $result[] = [
                'id' => $corp->id,
                'corporate_id' => $corp->corporate_id,
                'name' => $corp->name,
                'price' => $corp->price,
                'total_price' => $corp->total_price,
                'discount' => $corp->discount,
                'discount_type' => $corp->discount_type,
                'type' => 'Corporate',
                'p_id' => $corp->p_id,
                'package_names' => implode(', ', $packageNames),
                'test_names' => implode(', ', $testNames),
                'created_at' => $corp->created_at,
                'status' => $corp->status,
                'no_of_employee' => $corp->no_of_employee,
                'coupon' => $corp->coupon,

                // Add corporate admin info
                'corporate_admin_name' => $corporateAdmin?->name,
                'corporate_admin_phone' => $corporateAdmin?->phone,
                'corporate_company_name' => $corporateDetails?->company_name,
                'corporate_package_payment_status' => $corporatePackagePayment?->payment_status,
            ];
        }

        return response()->json($result);
    }


    public function assignPackageToCorporate(Request $request)
    {
        $request->validate([
            'corporate_id' => 'required',
            'no_of_employee' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'discount_type' => 'nullable|in:flat,percent',
            'discount' => 'nullable|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
        ]);

        $alreadyAssigned = CorporatePackage::where('corporate_id', $request->corporate_id)
            ->where('id', $request->package_id)
            ->exists();

        if ($alreadyAssigned) {
            return response()->json([
                'sucess' => false,
                'message' => 'This package is already assigned to the selected corporate.',
            ]);
        } else {
            $package = CorporatePackage::where('id', $request->package_id)->first();
            $package->corporate_id =  $request->corporate_id;
            $package->no_of_employee =  $request->no_of_employee;
            $package->discount_type =  $request->discount_type;
            $package->discount =  $request->discount;
            $package->total_price =  $request->total_price;
            $package->save();
        }

        return response()->json(['success' => true, 'message' => 'Package assigned successfully.']);
    }

    public function toggleStatus(Request $request, $id)
    {
        $package = CorporatePackage::findOrFail($id);

        $package->status = $request->status;
        $package->save();

        $statusText = $request->status ? 'activated' : 'deactivated';

        return response()->json([
            'success' => true,
            'message' => "Package has been {$statusText} successfully."
        ]);
    }

    public function edit($id)
    {
        $pack = CorporatePackage::find($id);
        return response()->json(['package' => $pack]);
    }

    public function update(Request $request)
    {
        $id = $request->edit_id;
        $package = CorporatePackage::findOrFail($id);

        $package->name = $request->edit_name;
        $package->price = $request->edit_price;
        $package->discount_type = $request->edit_discount_type;
        $package->discount = $request->edit_discount;
        $package->total_price = $request->edit_total_price;
        $package->no_of_employee = $request->edit_no_of_employee;

        $package->package_ids = $request->edit_package_ids;
        $package->test_ids = $request->edit_test_ids;
        $package->save();

        return response()->json([
            'status' => true,
            'message' => 'Package updated successfully',
        ]);
    }

    public function corpIndex()
    {
        $packages = package::where('type', 'Package')->get();
        $tests = package::where('type', 'Test')->get();
        $corporates = User::where('role', 4)->get();
        return view('backend.superadmin.corporates.packages.list', compact('corporates', 'packages', 'tests'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:corporate_packages,id',
            'coupon_code' => 'required|string'
        ]);

        $package = CorporatePackage::find($request->package_id);

        // Example dummy logic (replace with real validation logic)
        if ($request->coupon_code === 'DISCOUNT50') {
            $package->discount = 50;
            $package->discount_type = 'flat';
            $package->total_price = max(0, $package->price - 50);
            $package->coupon = $request->coupon_code;
            $package->save();

            return response()->json(['message' => 'Coupon applied successfully!']);
        }

        return response()->json(['message' => 'Invalid coupon code.'], 422);
    }

    public function destroy($id)
    {
        try {
            $package = CorporatePackage::find($id);

            if (!$package) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Corporate package not found.'
                ], 404);
            }

            $package->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Corporate package deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong while deleting the package.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function purchase(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = auth()->user();

            $payment = Payment::create([
                'type'           => 'Corporate Package',
                'subtotal'       => $request->amount,
                'total'          => $request->amount,
                'order_id'       => $request->corporate_package_id,
                'transaction_id' => $request->razorpay_payment_id,
                'payment_status' => $request->payment_status ?? 'Paid',
                'user_id' => $user->id,
            ]);

            $corporateDetail = CorporateDetail::where('corporate_id', $user->user_id)->first();

            if (!$corporateDetail) {
                throw new Exception("Corporate profile not found for this user.");
            }

            // 3️⃣ Update corporate package list
            $packageIds = $corporateDetail->corporate_package_id ?? [];
            $packageIds[] = $request->corporate_package_id;
            $corporateDetail->corporate_package_id = array_unique($packageIds);
            $corporateDetail->save();

            DB::commit();

            return response()->json([
                'success'    => true,
                'message'    => 'Package purchased successfully!',
                'payment_id' => $payment->id,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            \Log::error('Corporate Package Purchase Error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment: ' . $e->getMessage(),
            ], 500);
        }
    }
}
