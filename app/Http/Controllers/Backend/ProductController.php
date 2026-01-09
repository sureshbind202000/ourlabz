<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PackageCategory;
use App\Models\Product;
use App\Models\ProductAdditionalDetail;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductSubCategory;
use App\Models\ProductType;
use App\Models\ProductVarient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // List
    public function index()
    {
        $productTypes = ProductType::orderBy('id', 'DESC')->get(['id', 'slug', 'name']);
        return view('backend.superadmin.product.list', compact('productTypes'));
    }

    public function addProduct()
    {
        $auth = auth()->user();
        $productTypes = ProductType::orderBy('name', 'asc')->get();
        $attributes = ProductAttribute::with('values')->get();
        return view('backend.superadmin.product.add', compact('productTypes', 'attributes'));
    }

    public function getCategories(Request $request)
    {
        $categories = ProductCategory::where('type_id', $request->type_id)->get(['id', 'name']);
        return response()->json($categories);
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = ProductSubCategory::where('category_id', $request->category_id)->get(['id', 'name']);
        return response()->json($subcategories);
    }

    // Store Product
    public function storeProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_identification_no' => 'required|string|max:255|unique:products',
            'short_desc' => 'required|string',
            'long_desc' => 'required|string',
            'regular_price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:percent,fixed',
            'bulk_regular_price' => 'nullable|numeric',
            'bulk_discount' => 'nullable|numeric',
            'bulk_discount_type' => 'nullable|in:percent,fixed',
            'bulk_moq' => 'nullable|integer',
            'tags' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // 🔁 Normalize checkbox & optional values
            $shipping = $request->input('shipping') ? 1 : 0;
            $in_stock = $request->input('in_stock') ? 1 : 0;

            // 🟢 Store product
            $product = Product::create([
                'vendor_id' => auth()->id() ?? 1,
                'product_id' => strtoupper(uniqid('PRD')),
                'slug' => Str::slug($request->product_name) . '-' . time(),
                'product_name' => $request->product_name,
                'varient' => $request->varient ?? 0,
                'brand' => $request->brand,
                'product_identification_no' => $request->product_identification_no,
                'short_desc' => $request->short_desc,
                'long_desc' => $request->long_desc,
                'type' => $request->product_type,
                'category' => $request->product_category,
                'sub_category' => $request->product_subcategory,
                'regular_price' => $request->regular_price,
                'discount' => $request->discount,
                'discount_type' => $request->discount_type,
                'selling_price' => $request->final_price,
                'bulk_regular_price' => $request->bulk_regular_price,
                'bulk_discount' => $request->bulk_discount,
                'bulk_discount_type' => $request->bulk_discount_type,
                'bulk_selling_price' => $request->bulk_final_price,
                'bulk_moq' => $request->bulk_moq,
                'country_of_origin' => $request->country_of_origin,
                'release_date' => Carbon::createFromFormat('d/m/y', $request->release_date)->format('d/m/Y'),
                'warranty' => $request->warranty,
                'shipping' => $shipping,
                'tags' => $request->tags,
                'stock' => $request->stock ?? 0,
                'in_stock' => $in_stock,
                'product_for' => $request->product_for,
                'weight' => $request->product_weight,
            ]);

            // 🟢 Store specifications
            if ($request->has('specifications')) {
                foreach ($request->input('specifications') as $spec) {
                    if (!empty($spec['label']) && !empty($spec['property'])) {
                        ProductAdditionalDetail::create([
                            'product_id' => $product->id,
                            'label' => $spec['label'],
                            'property' => $spec['property']
                        ]);
                    }
                }
            }

            // 🟢 Store images (using public_path)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $filename = time() . '-' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $destinationPath = public_path('products');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $img->move($destinationPath, $filename);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => 'products/' . $filename
                    ]);
                }
            }

            if ($request->has('variants')) {
                $variants = $request->input('variants');

                // Decode JSON if it's a string
                if (is_string($variants)) {
                    $variants = json_decode($variants, true);
                }

                if (is_array($variants)) {
                    foreach ($variants as $index => $variantData) {

                        Log::info("Variant data #{$index}", $variantData);
                        // Skip empty variants
                        if (empty($variantData['product_identification_no']) && empty($variantData['regular_price'])) {
                            continue;
                        }

                        $varientName = $variantData['varient_name'] ?? "Variant " . ($index + 1);
                        $productIdNo = $variantData['product_identification_no'] ?? null;
                        $regularPrice = $variantData['regular_price'] ?? null;

                        if (!$productIdNo || !$regularPrice) {
                            Log::warning("Skipping variant due to missing required fields", ['variant' => $variantData]);
                            continue;
                        }

                        $variant = ProductVarient::create([
                            'product_id' => $product->id,
                            'varient_id' => strtoupper(uniqid('PRDV')),
                            'varient_name' => $varientName,
                            'variation_values' => isset($variantData['variation_values'])
                                ? (is_array($variantData['variation_values'])
                                    ? $variantData['variation_values']
                                    : json_decode($variantData['variation_values'], true))
                                : null,
                            'product_identification_no' => $productIdNo,
                            'regular_price' => $regularPrice,
                            'discount' => $variantData['discount'] ?? null,
                            'discount_type' => $variantData['discount_type'] ?? null,
                            'selling_price' => $variantData['final_price'] ?? null,
                            'bulk_regular_price' => $variantData['bulk_regular_price'] ?? null,
                            'bulk_discount' => $variantData['bulk_discount'] ?? null,
                            'bulk_discount_type' => $variantData['bulk_discount_type'] ?? null,
                            'bulk_selling_price' => $variantData['bulk_final_price'] ?? null,
                            'bulk_moq' => $variantData['bulk_moq'] ?? null,
                            'release_date' => !empty($variantData['release_date']) ? Carbon::createFromFormat('Y-m-d', $variantData['release_date'])->format('Y-m-d') : null,
                            'warranty' => $variantData['warranty'] ?? null,
                            'stock' => $variantData['stock'] ?? 0,
                            'in_stock' => $variantData['in_stock'] ?? $in_stock,
                        ]);

                        $images = $request->file("variants.{$index}.images");
                        if (!empty($images)) {
                            foreach ($images as $img) {
                                $filename = time() . '-' . uniqid() . '.' . $img->getClientOriginalExtension();
                                $destinationPath = public_path('products/variants');
                                if (!file_exists($destinationPath)) mkdir($destinationPath, 0755, true);
                                $img->move($destinationPath, $filename);

                                ProductImage::create([
                                    'varient_id' => $variant->id,
                                    'image' => 'products/variants/' . $filename,
                                ]);
                            }
                        }
                    }
                }
            }



            DB::commit();

            return response()->json(['message' => 'Product created successfully.'], 201);
        } catch (\Exception $e) {
            Log::error('Product creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(), // optional: log request data for debugging
            ]);
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Product List
    public function productList()
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        $authRole = $user->role;
        $authId = $user->id;

        $query = Product::with(['productType', 'productCategory', 'productSubCategory','images'])
            ->orderBy('id', 'DESC');

        if ($authRole == 5) {
            $query->where('vendor_id', $authId);
        }

        $products = $query->get();

        $products->each(function ($product) {
            $product->encrypted_id = encrypt($product->id);
        });

        return response()->json($products);
    }


    public function getRejectionReason($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'reason' => $product->rejection_reason ?? 'Not provided.'
        ]);
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2',
            'rejection_reason' => 'nullable|string|max:255'
        ]);

        $product = Product::findOrFail($id);
        $product->status = $request->status;

        if ($request->status == 2) {
            $product->rejection_reason = $request->rejection_reason;
        } else {
            $product->rejection_reason = null;
        }

        $product->save();

        return response()->json(['success' => true]);
    }

    public function changeVarientStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2',
            'rejection_reason' => 'nullable|string|max:255'
        ]);

        $varient = ProductVarient::findOrFail($id);
        $varient->status = $request->status;

        if ($request->status == 2) {
            $varient->rejection_reason = $request->rejection_reason;
        } else {
            $varient->rejection_reason = null;
        }

        $varient->save();

        return response()->json(['success' => true]);
    }

    public function editProduct($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid product ID');
        }

        $product = Product::with([
            'productType',
            'productCategory',
            'productSubCategory',
            'images',
            'specifications',
            'variants.images'
        ])->findOrFail($id);

        $types = ProductType::all();
        $categories = ProductCategory::all();
        $subcategories = ProductSubCategory::all();
        $attributes = ProductAttribute::all();

        return view('backend.superadmin.product.edit', compact('product', 'types', 'categories', 'subcategories', 'attributes'));
    }


    public function updateProduct(Request $request, $id)
    {
        $product = Product::with('variants')->findOrFail($id);

        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_identification_no' => "required|string|max:255|unique:products,product_identification_no,$id",
            'short_desc' => 'required|string',
            'long_desc' => 'required|string',
            'regular_price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:percent,flat',
            'bulk_regular_price' => 'nullable|numeric',
            'bulk_discount' => 'nullable|numeric',
            'bulk_discount_type' => 'nullable|in:percent,flat',
            'bulk_moq' => 'nullable|integer',
            'tags' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $shipping = $request->input('shipping', 0);
            $in_stock = $request->input('in_stock', 0);

            // Update main product
            $product->update([
                'product_name' => $request->product_name,
                'varient' => $request->varient ?? 0,
                'brand' => $request->brand,
                'product_identification_no' => $request->product_identification_no,
                'short_desc' => $request->short_desc,
                'long_desc' => $request->long_desc,
                'type' => $request->product_type,
                'category' => $request->product_category,
                'sub_category' => $request->product_subcategory,
                'regular_price' => $request->regular_price,
                'discount' => $request->discount,
                'discount_type' => $request->discount_type,
                'selling_price' => $request->final_price,
                'bulk_regular_price' => $request->bulk_regular_price,
                'bulk_discount' => $request->bulk_discount,
                'bulk_discount_type' => $request->bulk_discount_type,
                'bulk_selling_price' => $request->bulk_final_price,
                'bulk_moq' => $request->bulk_moq,
                'country_of_origin' => $request->country_of_origin,
                'release_date' => !empty($request->release_date) ? Carbon::createFromFormat('d/m/y', $request->release_date)->format('d/m/Y') : null,
                'warranty' => $request->warranty,
                'shipping' => $shipping,
                'tags' => $request->tags,
                'stock' => $request->stock ?? 0,
                'in_stock' => $in_stock,
                'product_for' => $request->product_for,
                'weight' => $request->product_weight,
            ]);

            // Handle variants
            if ($request->has('variants')) {
                $variants = $request->input('variants');

                if (is_string($variants)) {
                    $variants = json_decode($variants, true);
                }

                if (is_array($variants)) {
                    foreach ($variants as $index => $variantData) {

                        // Skip empty variants
                        if (empty($variantData['product_identification_no']) && empty($variantData['regular_price'])) {
                            continue;
                        }

                        $varientId = $variantData['id'] ?? null;

                        // Prepare data
                        $variantFields = [
                            'product_id' => $product->id,
                            'varient_name' => $variantData['varient_name'] ?? "Variant " . ($index + 1),
                            'variation_values' => isset($variantData['variation_values'])
                                ? (is_array($variantData['variation_values'])
                                    ? $variantData['variation_values']
                                    : json_decode($variantData['variation_values'], true))
                                : null,
                            'product_identification_no' => $variantData['product_identification_no'] ?? null,
                            'regular_price' => $variantData['regular_price'] ?? null,
                            'discount' => $variantData['discount'] ?? null,
                            'discount_type' => $variantData['discount_type'] ?? null,
                            'selling_price' => $variantData['final_price'] ?? null,
                            'bulk_regular_price' => $variantData['bulk_regular_price'] ?? null,
                            'bulk_discount' => $variantData['bulk_discount'] ?? null,
                            'bulk_discount_type' => $variantData['bulk_discount_type'] ?? null,
                            'bulk_selling_price' => $variantData['bulk_final_price'] ?? null,
                            'bulk_moq' => $variantData['bulk_moq'] ?? null,
                            'release_date' => !empty($variantData['release_date']) ? Carbon::createFromFormat('Y-m-d', $variantData['release_date'])->format('Y-m-d') : null,
                            'warranty' => $variantData['warranty'] ?? null,
                            'stock' => $variantData['stock'] ?? 0,
                            'in_stock' => $variantData['in_stock'] ?? $in_stock,
                        ];

                        if ($varientId) {
                            // Update existing variant
                            $variant = ProductVarient::find($varientId);
                            if ($variant) {
                                $variant->update($variantFields);
                            } else {
                                // Variant ID sent but not found, create new
                                $variantFields['varient_id'] = strtoupper(uniqid('PRDV'));
                                $variant = ProductVarient::create($variantFields);
                            }
                        } else {
                            // New variant
                            $variantFields['varient_id'] = strtoupper(uniqid('PRDV'));
                            $variant = ProductVarient::create($variantFields);
                        }

                        // Handle images
                        $images = $request->file("variants.{$index}.images");
                        if (!empty($images)) {
                            foreach ($images as $img) {
                                $filename = time() . '-' . uniqid() . '.' . $img->getClientOriginalExtension();
                                $destinationPath = public_path('products/variants');
                                if (!file_exists($destinationPath)) mkdir($destinationPath, 0755, true);
                                $img->move($destinationPath, $filename);

                                ProductImage::create([
                                    'varient_id' => $variant->id,
                                    'image' => 'products/variants/' . $filename,
                                ]);
                            }
                        }
                    }
                }
            }

            // Update product specifications
            ProductAdditionalDetail::where('product_id', $product->id)->delete();
            if ($request->has('specifications')) {
                foreach ($request->input('specifications') as $spec) {
                    if (!empty($spec['label']) && !empty($spec['property'])) {
                        ProductAdditionalDetail::create([
                            'product_id' => $product->id,
                            'label' => $spec['label'],
                            'property' => $spec['property']
                        ]);
                    }
                }
            }

            // Upload new product images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $filename = time() . '-' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $destinationPath = public_path('products');
                    if (!file_exists($destinationPath)) mkdir($destinationPath, 0755, true);
                    $img->move($destinationPath, $filename);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => 'products/' . $filename
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Product updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }



    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);

        // Delete file from storage
        $imagePath = public_path($image->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Delete from database
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

        DB::beginTransaction();

        try {
            // 1. Delete related product variants
            $variants = ProductVarient::where('product_id', $product->id)->get();

            foreach ($variants as $variant) {
                // Delete variant images
                $images = ProductImage::where('varient_id', $variant->id)->get();

                foreach ($images as $img) {
                    $imagePath = public_path($img->image);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                    $img->delete();
                }

                // Delete the variant
                $variant->delete();
            }

            // 3. Delete main product images (not tied to variant)
            $productImages = ProductImage::where('product_id', $product->id)
                ->whereNull('varient_id') // ensure main images only
                ->get();

            foreach ($productImages as $img) {
                $imagePath = public_path($img->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                $img->delete();
            }

            // 4. Delete additional details (if relation exists)
            if (method_exists($product, 'additionalDetails')) {
                $product->additionalDetails()->delete();
            }


            // 6. Finally, delete the product
            $product->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Product and related data deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }



    // Product Varients
    public function varientProduct($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid product ID');
        }

        $product = (object)[
            'id' => $id,
            'encrypted_id' => $encryptedId
        ];
        return view('backend.superadmin.product.varient_list', compact('product'));
    }

    public function varientProductAdd($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid product ID');
        }

        $product_id = $id;
        $attribute_ids = ProductAttributeValue::where('product_id', $product_id)->pluck('attribute_id');
        $attributes = ProductAttribute::whereIn('id', $attribute_ids)->get();

        return view('backend.superadmin.product.varient_add', compact('product_id', 'attributes'));
    }

    public function varientProductStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_identification_no' => 'required|string|max:255|unique:product_varients,product_identification_no',
            'regular_price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:percent,fixed',
            'bulk_regular_price' => 'nullable|numeric',
            'bulk_discount' => 'nullable|numeric',
            'bulk_discount_type' => 'nullable|in:percent,fixed',
            'bulk_moq' => 'nullable|integer',
            'release_date' => 'required|date_format:d/m/y',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $in_stock = $request->has('in_stock') ? 1 : 0;

            // 🟢 Create product variant
            $variant = ProductVarient::create([
                'product_id' => $request->product_id,
                'varient_id' => strtoupper(uniqid('PRDV')),
                'product_identification_no' => $request->product_identification_no,
                'regular_price' => $request->regular_price,
                'discount' => $request->discount,
                'discount_type' => $request->discount_type,
                'selling_price' => $request->final_price,
                'bulk_regular_price' => $request->bulk_regular_price,
                'bulk_discount' => $request->bulk_discount,
                'bulk_discount_type' => $request->bulk_discount_type,
                'bulk_selling_price' => $request->bulk_final_price,
                'bulk_moq' => $request->bulk_moq,
                'release_date' => Carbon::createFromFormat('d/m/y', $request->release_date)->format('d/m/Y'),
                'warranty' => $request->warranty,
                'stock' => $request->stock ?? 0,
                'in_stock' => $in_stock,
            ]);

            // 🟢 Store attribute values for this variant
            if ($request->has('variants')) {
                foreach ($request->input('variants') as $variantInput) {
                    if (!empty($variantInput['attribute']) && !empty($variantInput['property'])) {
                        // Find the existing attribute
                        $attribute = ProductAttribute::where('name', $variantInput['attribute'])
                            ->where('vendor_id', auth()->user()->id)
                            ->first();

                        if ($attribute) {
                            ProductAttributeValue::create([
                                'product_id'   => $request->product_id,
                                'attribute_id' => $attribute->id,
                                'value'        => $variantInput['property'],
                                'varient_id'   => $variant->id,
                            ]);
                        } else {
                        }
                    }
                }
            }

            // 🟢 Upload variant images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $filename = time() . '-' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $destinationPath = public_path('products');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $img->move($destinationPath, $filename);

                    ProductImage::create([
                        'varient_id' => $variant->id,
                        'image' => 'products/' . $filename,
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Product variant created successfully.'], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Product Varient List
    public function varientProductList($id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $query = ProductVarient::where('product_id', $id)->orderBy('id', 'DESC');

        $varients = $query->get();

        $varients->each(function ($varient) {
            $varient->encrypted_id = encrypt($varient->id);
        });

        return response()->json($varients);
    }

    public function editVarientProduct($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId); // 🔓 Decrypt the ID
        } catch (\Exception $e) {
            abort(404, 'Invalid Varient ID');
        }

        $auth = auth()->user();

        $varient = ProductVarient::with([
            'images'
        ])->findOrFail($id);

        $attribute_ids =  ProductAttributeValue::where('varient_id', $id)->pluck('attribute_id');
        $attributes = ProductAttribute::where('vendor_id', $auth->id)->whereIn('id', $attribute_ids)->get();

        return view('backend.superadmin.product.varient_edit', compact('varient', 'attributes'));
    }

    public function updateVarientProduct(Request $request, $id)
    {
        $request->validate([
            'product_identification_no' => "required|string|max:255|unique:product_varients,product_identification_no,{$id}",
            'regular_price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:percent,fixed',
            'bulk_regular_price' => 'nullable|numeric',
            'bulk_discount' => 'nullable|numeric',
            'bulk_discount_type' => 'nullable|in:percent,fixed',
            'bulk_moq' => 'nullable|integer',
            'release_date' => 'required|date_format:d/m/y',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {

            $in_stock = (int) $request->input('in_stock');

            // 🔄 Update variant
            $variant = ProductVarient::findOrFail($id);
            $variant->update([
                'varient_name' => $request->varient_name,
                'product_identification_no' => $request->product_identification_no,
                'regular_price' => $request->regular_price,
                'discount' => $request->discount,
                'discount_type' => $request->discount_type,
                'selling_price' => $request->final_price,
                'bulk_regular_price' => $request->bulk_regular_price,
                'bulk_discount' => $request->bulk_discount,
                'bulk_discount_type' => $request->bulk_discount_type,
                'bulk_selling_price' => $request->bulk_final_price,
                'bulk_moq' => $request->bulk_moq,
                'release_date' => Carbon::createFromFormat('d/m/y', $request->release_date)->format('d/m/Y'),
                'warranty' => $request->warranty,
                'stock' => $request->stock ?? 0,
                'in_stock' => $in_stock,
            ]);

            // 🔁 Update or create variant attribute values
            if ($request->has('variants')) {
                foreach ($request->input('variants') as $variantInput) {
                    if (!empty($variantInput['attribute']) && !empty($variantInput['property'])) {
                        // Find attribute by name and vendor
                        $attribute = ProductAttribute::where('name', $variantInput['attribute'])
                            ->where('vendor_id', auth()->user()->id)
                            ->first();

                        if ($attribute) {
                            // Check if value already exists for this variant and attribute
                            ProductAttributeValue::updateOrCreate(
                                [
                                    'product_id'   => $request->product_id,
                                    'attribute_id' => $attribute->id,
                                    'varient_id'   => $variant->id,
                                ],
                                [
                                    'value' => $variantInput['property'],
                                ]
                            );
                        }
                    }
                }
            }


            // 📷 Optional: upload new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $filename = time() . '-' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $destinationPath = public_path('products');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $img->move($destinationPath, $filename);

                    ProductImage::create([
                        'varient_id' => $variant->id,
                        'image' => 'products/' . $filename,
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Product variant updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getVarientRejectionReason($id)
    {
        $varient = ProductVarient::findOrFail($id);

        return response()->json([
            'reason' => $varient->rejection_reason ?? 'Not provided.'
        ]);
    }

    public function destroyVarient($id)
    {
        DB::beginTransaction();

        try {
            $variant = ProductVarient::findOrFail($id);

            // 🧹 Delete variant images and remove files
            $images = ProductImage::where('varient_id', $variant->id)->get();

            foreach ($images as $image) {
                $imagePath = public_path($image->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                $image->delete();
            }

            // 🧹 Delete the variant
            $variant->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Product variant and related data deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
