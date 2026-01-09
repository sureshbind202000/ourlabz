<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductReviewController extends Controller
{
    // product Reviews
    public function productReviews()
    {
        return view('backend.superadmin.product.product_review');
    }

    public function storeProductReview(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
            'website' => 'nullable|prohibited',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Handle image uploads
        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destination = public_path('review_images');

                // Ensure the directory exists
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }

                $file->move($destination, $filename);
                $imagePaths[] = 'review_images/' . $filename; // Save relative public path
            }
        }


        // Save review
        $review = new ProductReview();
        $review->product_id = $request->product_id;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->images = json_encode($imagePaths);
        $review->save();

        return response()->json(['success' => true, 'message' => 'Review submitted successfully.']);
    }


    // Review List
    public function productReviewList()
    {
        $review = ProductReview::with(['product:id,id,product_name,slug'])->orderBy('is_active', 'asc')
            ->latest()
            ->get();
        return response()->json($review);
    }

    // Product Review Status
    public function toggleProductReviewStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:product_reviews,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $review = ProductReview::findOrFail($request->id);

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
    public function productReviewDestroy($id)
    {
        try {
            $review = ProductReview::findOrFail($id);

            // Decode image JSON safely
            if (!empty($review->images)) {
                $images = json_decode($review->images, true);

                if (is_array($images)) {
                    foreach ($images as $imgPath) {
                        $fullPath = public_path($imgPath);
                        if (File::exists($fullPath)) {
                            File::delete($fullPath);
                        }
                    }
                }
            }

            // Delete review record
            $review->delete();

            return response()->json(['success' => true, 'message' => 'Review and images deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete review: ' . $e->getMessage()
            ], 500);
        }
    }
}
