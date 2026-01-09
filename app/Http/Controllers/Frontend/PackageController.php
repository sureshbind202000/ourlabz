<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\package;
use App\Models\PackageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    public function labTest(Request $request)
    {
        $query = package::with(['categoryDetails', 'packageReviews', 'parameters'])
            ->select(
                'id',
                'name',
                'type',
                'category',
                'price',
                'regular_price',
                'discount_type',
                'discount_price',
                'corporate_price',
                'corporate_regular_price',
                'corporate_discount_type',
                'corporate_discount',
                'package_icon',
                'slug',
                DB::raw('(SELECT AVG(rating) FROM package_reviews WHERE package_reviews.package_id = packages.id) as avg_rating')
            );

        if ($request->filled('type')) {
            $query->whereIn('type', $request->type);
        }

        if ($request->filled('category')) {
            $categorySlugs = (array) $request->category;
            $categoryIds = PackageCategory::whereIn('slug', $categorySlugs)->pluck('id')->toArray();
            if (!empty($categoryIds)) {
                $query->whereIn('category', $categoryIds);
            }
        }

        if ($request->filled('rating')) {
            $ratings = implode(',', array_map('intval', $request->rating));
            $query->havingRaw('ROUND(avg_rating) IN (' . $ratings . ')');
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'price_low_high':
                    $query->orderBy('price');
                    break;
                case 'price_high_low':
                    $query->orderByDesc('price');
                    break;
                case 'latest':
                    $query->orderByDesc('created_at');
                    break;
            }
        }
       
        $packages = $query->paginate(15);

        $isCorporateUser = auth()->check() && auth()->user()->corporate_id !== null;

        $packages->getCollection()->transform(function ($item) use ($isCorporateUser) {
            // Use corporate prices
            $price = $isCorporateUser ? $item->corporate_price : $item->price;
            $regular_price = $isCorporateUser ? $item->corporate_regular_price : $item->regular_price;
            $discount_type = $isCorporateUser ? $item->corporate_discount_type : $item->discount_type;
            $discount_price = $isCorporateUser ? $item->corporate_discount : $item->discount_price;

            $item->price = $price;
            $item->regular_price = $regular_price;
            $item->discount_type = $discount_type;
            $item->discount_price = $discount_price;

            // Selling price calculation
            $item->selling_price = $price;
            $item->discount_label = null;

            if ($discount_type && $discount_price > 0) {
                if ($discount_type === 'percent') {
                    $item->selling_price = round($price - ($price * $discount_price / 100), 2);
                    $item->discount_label = $discount_price . '% Off';
                } elseif ($discount_type === 'flat') {
                    $item->selling_price = round($price - $discount_price, 2);
                    $item->discount_label = '₹' . number_format($discount_price, 2) . ' Off';
                }
            }

            return $item;
        });
        $cartItems = [];

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->get()->map(function ($cart) {
                return $cart->item_type . '_' . $cart->item_id;
            })->toArray();
        } else {
            $cartItems = array_keys(Session::get('cart', []));
        }

        if ($request->ajax()) {
            return view('frontend.includes.package_list', compact('packages', 'cartItems'))->render();
        }
        

        $types = Cache::remember('types', 3600, fn() => package::select('type')->distinct()->pluck('type'));
        $categories = Cache::remember('categories', 3600, fn() => PackageCategory::all());

        return view('frontend.lab_test', compact('packages', 'types', 'categories', 'cartItems'));
    }
}
