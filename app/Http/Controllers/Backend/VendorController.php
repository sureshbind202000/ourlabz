<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\VendorDetail;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVarient;
use App\Models\ProductAdditionalDetail;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    // Index 
    public function index()
    {
        return view('backend.superadmin.vendor.list');
    }

    // List
    public function list()
    {
        $users = User::where('role', 5)->orderBy('id', 'DESC')->get();
        return response()->json($users);
    }

    // Store
    public function store(Request $request)
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

            $businessLicenseImage = null;
            if ($request->hasFile('business_license')) {
                $businessLicenseImage = 'business_license_' . time() . '.' . $request->business_license->extension();
                $businessLicensePath = 'uploads/vendor/' . $businessLicenseImage;
                $request->business_license->move(public_path('uploads/vendor'), $businessLicenseImage);
            }

            $msdsDocumentImage = null;
            if ($request->hasFile('msds_document')) {
                $msdsDocumentImage = 'msds_document_' . time() . '.' . $request->msds_document->extension();
                $msdsDocumentPath = 'uploads/vendor/' . $msdsDocumentImage;
                $request->msds_document->move(public_path('uploads/vendor'), $msdsDocumentImage);
            }

            $importExportLicenseImage = null;
            if ($request->hasFile('import_export_license')) {
                $importExportLicenseImage = 'import_export_license_' . time() . '.' . $request->import_export_license->extension();
                $importExportLicensePath = 'uploads/vendor/' . $importExportLicenseImage;
                $request->import_export_license->move(public_path('uploads/vendor'), $importExportLicenseImage);
            }

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
                'bloog_group' => $request->bloog_group,
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
                'business_license' => $businessLicensePath,
                'msds_document' => $msdsDocumentPath,
                'import_export_license' => $importExportLicensePath,
                'iso_certifications' => $request->iso_certifications,
                'environmental_certificates' => $request->environmental_certificates,
                'primary_categories' => $request->primary_categories,
                'subcategories' => $request->subcategories,
                'custom_equipment_manufacturing' => $request->custom_equipment_manufacturing,
                'oem_odm_capabilities' => $request->oem_odm_capabilities,
                'moq' => $request->moq,
                'lead_time_days' => $request->lead_time_days,
            ]);

            DB::commit();

            return response()->json(['success' => 'Vendor registered successfully!', 'data' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store vendor: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {

        $vendor = User::with(['user_details', 'vendor_details'])->findOrFail($id);
        return response()->json(['vendor' => $vendor]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $vendorDetail = VendorDetail::where('vendor_id', $id)->first();

            // Handle email generation if not provided
            $email = $request->email;
            if (empty($email)) {
                $firstFourDigits = substr($request->phone, 0, 4);
                $username = strtolower(str_replace(' ', '', $request->name));
                $email = $username . $firstFourDigits . '@example.com';

                while (User::where('email', $email)->where('id', '!=', $id)->exists()) {
                    $email = $username . $firstFourDigits . rand(100, 999) . '@example.com';
                }
            }

            // === File Uploads with Deletion ===

            // Profile Image
            if ($request->hasFile('profile')) {
                if ($user->profile && file_exists(public_path($user->profile)) && $user->profile !== 'dummy') {
                    unlink(public_path($user->profile));
                }
                $profileImageName = time() . '.' . $request->profile->extension();
                $request->profile->move(public_path('uploads/vendor'), $profileImageName);
                $profileImagePath = 'uploads/vendor/' . $profileImageName;
            } else {
                $profileImagePath = $user->profile;
            }

            // Business License
            if ($request->hasFile('business_license')) {
                if ($vendorDetail && $vendorDetail->business_license && file_exists(public_path($vendorDetail->business_license))) {
                    unlink(public_path($vendorDetail->business_license));
                }
                $fileName = 'business_license_' . time() . '.' . $request->business_license->extension();
                $request->business_license->move(public_path('uploads/vendor'), $fileName);
                $businessLicensePath = 'uploads/vendor/' . $fileName;
            } else {
                $businessLicensePath = $vendorDetail->business_license ?? null;
            }

            // MSDS Document
            if ($request->hasFile('msds_document')) {
                if ($vendorDetail && $vendorDetail->msds_document && file_exists(public_path($vendorDetail->msds_document))) {
                    unlink(public_path($vendorDetail->msds_document));
                }
                $fileName = 'msds_document_' . time() . '.' . $request->msds_document->extension();
                $request->msds_document->move(public_path('uploads/vendor'), $fileName);
                $msdsDocumentPath = 'uploads/vendor/' . $fileName;
            } else {
                $msdsDocumentPath = $vendorDetail->msds_document ?? null;
            }

            // Import/Export License
            if ($request->hasFile('import_export_license')) {
                if ($vendorDetail && $vendorDetail->import_export_license && file_exists(public_path($vendorDetail->import_export_license))) {
                    unlink(public_path($vendorDetail->import_export_license));
                }
                $fileName = 'import_export_license_' . time() . '.' . $request->import_export_license->extension();
                $request->import_export_license->move(public_path('uploads/vendor'), $fileName);
                $importExportLicensePath = 'uploads/vendor/' . $fileName;
            } else {
                $importExportLicensePath = $vendorDetail->import_export_license ?? null;
            }

            // === Update User ===
            $updateData = [
                'name' => ucwords($request->name),
                'phone' => $request->phone,
                'username' => $request->filled('username') ? $request->username : strtolower(str_replace(' ', '', $request->name)) . $request->phone,
                'email' => $email,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'age' => $request->age,
                'bloog_group' => $request->bloog_group,
                'terms_condition' => $request->has('terms_condition') ? 1 : 0,
                'subscribe' => $request->has('subscribe') ? 1 : 0,
                'designation' => $request->designation,
                'profile' => $profileImagePath ?? 'dummy',
            ];

            // Conditionally add password fields
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
                $updateData['show_password'] = $request->password;
            }

            $user->update($updateData);

            // === Update User Details ===
            UserDetails::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'alternate_phone' => $request->alternate_phone,
                    'address' => $request->address,
                    'city' => ucwords($request->city),
                    'state' => ucwords($request->state),
                    'country' => ucwords($request->country),
                    'pin' => $request->pin,
                ]
            );

            // === Update Vendor Details ===
            VendorDetail::updateOrCreate(
                ['vendor_id' => $user->id],
                [
                    'company_name' => $request->company_name,
                    'company_reg_no' => $request->company_reg_no,
                    'business_type' => $request->business_type,
                    'tin' => $request->tin,
                    'establishment_year' => $request->establishment_year,
                    'business_license' => $businessLicensePath,
                    'msds_document' => $msdsDocumentPath,
                    'import_export_license' => $importExportLicensePath,
                    'iso_certifications' => $request->iso_certifications,
                    'environmental_certificates' => $request->environmental_certificates,
                    'primary_categories' => $request->primary_categories,
                    'subcategories' => $request->subcategories,
                    'custom_equipment_manufacturing' => $request->custom_equipment_manufacturing,
                    'oem_odm_capabilities' => $request->oem_odm_capabilities,
                    'moq' => $request->moq,
                    'lead_time_days' => $request->lead_time_days,
                ]
            );

            DB::commit();

            return response()->json(['success' => 'Vendor updated successfully!', 'data' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update vendor: ' . $e->getMessage()], 500);
        }
    }


    // Delete
    public function destroy($id)
    {
        $vendor = User::find($id);

        if (!$vendor) {
            return response()->json(['success' => false, 'message' => 'Vendor not found.'], 404);
        }

        DB::beginTransaction();

        try {
            // --------------------------------------
            // Delete vendor profile image
            // --------------------------------------
            if ($vendor->profile && $vendor->profile !== 'dummy' && file_exists(public_path($vendor->profile))) {
                @unlink(public_path($vendor->profile));
            }

            // --------------------------------------
            // Delete user details
            // --------------------------------------
            UserDetails::where('user_id', $vendor->id)->delete();

            // --------------------------------------
            // Delete vendor details and their documents
            // --------------------------------------
            $vendorDetail = VendorDetail::where('vendor_id', $vendor->id)->first();
            if ($vendorDetail) {
                $docs = [
                    $vendorDetail->business_license,
                    $vendorDetail->msds_document,
                    $vendorDetail->import_export_license,
                ];

                foreach ($docs as $doc) {
                    if ($doc && file_exists(public_path($doc))) {
                        @unlink(public_path($doc));
                    }
                }

                $vendorDetail->delete();
            }

            // --------------------------------------
            // Delete products and related data
            // --------------------------------------
            $products = Product::where('vendor_id', $vendor->id)->get();

            foreach ($products as $product) {

                // Delete product + variant images (both stored in one table)
                $images = ProductImage::where('product_id', $product->id)
                    ->orWhereIn('varient_id', ProductVarient::where('product_id', $product->id)->pluck('id'))
                    ->get();

                foreach ($images as $image) {
                    if ($image->image && file_exists(public_path($image->image))) {
                        @unlink(public_path($image->image));
                    }
                    $image->delete();
                }

                // Delete variants
                ProductVarient::where('product_id', $product->id)->delete();

                // Delete additional details
                ProductAdditionalDetail::where('product_id', $product->id)->delete();

                // Delete reviews
                ProductReview::where('product_id', $product->id)->delete();

                // Finally delete product
                $product->delete();
            }

            // --------------------------------------
            // Delete vendor record
            // --------------------------------------
            $vendor->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Vendor and all related products deleted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting vendor: ' . $e->getMessage(),
            ], 500);
        }
    }



    //  Profile
    public function profile($userid)
    {
        $vendor = User::where('user_id', $userid)->with(['user_details', 'vendor_details'])->first();
        // dd($user);
        return view('backend.superadmin.vendor.profile', compact('vendor'));
    }

    public function changeStatus(Request $request)
    {
        $vendor = User::find($request->vendor_id);
        if ($vendor) {
            $vendor->status = $request->status;
            $vendor->save();

            // Convert status to label and badge class
            $statusLabel = match ((int) $vendor->status) {
                1 => 'Approved',
                2 => 'Declined',
                0 => 'Pending',
                default => 'Unknown'
            };

            $badgeClass = match ((int) $vendor->status) {
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
}
