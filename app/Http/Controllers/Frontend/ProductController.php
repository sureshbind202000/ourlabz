<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function shop(Request $request)
    {
        // Include reviews for average rating
        $query = Product::with(['productCategory', 'productSubCategory', 'reviews'])
            ->where('status', 1);

        // Filter by Product Type
        if ($request->filled('type')) {
            $query->whereIn('type', $request->input('type'));
        }

        // Filter by Product Category
        if ($request->filled('category')) {
            $query->whereHas('productCategory', function ($q) use ($request) {
                $q->whereIn('slug', $request->input('category'));
            });
        }

        // Filter by Product Subcategory
        if ($request->filled('subcategory')) {
            $query->whereHas('productSubCategory', function ($q) use ($request) {
                $q->whereIn('slug', $request->input('subcategory'));
            });
        }

        // Apply filters for rounded average rating
        if ($request->filled('rating')) {
            $ratings = array_map('intval', $request->input('rating'));
            $query->whereHas('reviews', function ($q) use ($ratings) {
                $q->select(DB::raw('AVG(rating) as avg_rating'))
                    ->havingRaw('ROUND(AVG(rating)) IN (' . implode(',', $ratings) . ')');
            });
        }

        // Price Filter
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('selling_price', [
                $request->input('min_price'),
                $request->input('max_price')
            ]);
        }

        // Sorting
        switch ($request->input('sort_by')) {
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_low_high':
                $query->orderBy('selling_price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('selling_price', 'desc');
                break;
            case 'rating_high_low':
                // Sort manually using reviews count and average
                $query->withCount(['reviews as avg_rating' => function ($q) {
                    $q->select(DB::raw('coalesce(avg(rating), 0)'));
                }])->orderByDesc('avg_rating');
                break;
        }

        // Final Pagination
        $products = $query->paginate(9);

        // Inject avg_rating manually
        $products->getCollection()->transform(function ($product) {
            $avg = $product->reviews->avg('rating');
            $product->avg_rating = $avg && $avg > 0 ? round($avg, 1) : rand(3, 5);
            return $product;
        });

        // AJAX load
        if ($request->ajax()) {
            return view('frontend.shop.product_list', compact('products'))->render();
        }

        // Filters
        $types = ProductType::all();
        $categories = ProductCategory::all();
        $subcategories = ProductSubCategory::all();

        return view('frontend.shop.list', compact('products', 'types', 'categories', 'subcategories'));
    }
}
