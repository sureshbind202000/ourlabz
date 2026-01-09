<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Cart;
use App\Models\HomeBrand;
use App\Models\HomeFeature;
use App\Models\HomeTestimonial;
use App\Models\Offer;
use App\Models\Faq;
use App\Models\package;
use App\Models\PackageCategory;
use App\Models\PackageReview;
use App\Models\Product;
use App\Models\HomeVideo;
use App\Models\Speciality;
use App\Models\WebAbout;
use App\Models\WebTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $banners = Banner::with(['product', 'product.images'])->where('status', 1)->get();

        $category_by_organ = PackageCategory::whereIn('type', ['Organ', 'Both'])
            ->orderByRaw('status = 1 DESC')
            ->get();

        $category_by_disease = PackageCategory::whereIn('type', ['Disease', 'Both'])
            ->orderByRaw('status = 1 DESC')
            ->get();

        $test_types = package::select('type')->distinct()->pluck('type');

        $packages = package::with(['categoryDetails', 'parameters'])->latest()->limit(6)->get();

        $isCorporateUser = auth()->check() && auth()->user()->corporate_id !== null;

        $packages->transform(function ($item) use ($isCorporateUser) {
            $item->price = $isCorporateUser ? $item->corporate_price : $item->price;
            $item->regular_price = $isCorporateUser ? $item->corporate_regular_price : $item->regular_price;
            $item->discount_type = $isCorporateUser ? $item->corporate_discount_type : $item->discount_type;
            $item->discount_price = $isCorporateUser ? $item->corporate_discount : $item->discount_price;
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
            $type = $request->input('type');

            $query = package::with(['categoryDetails', 'parameters']);

            if ($type !== 'All') {
                $query->where('type', $type);
            }

            $items = $query->latest()->limit(6)->get();

            $items->transform(function ($item) use ($isCorporateUser, $cartItems) {
                $item->icon_url = $item->package_icon
                    ? asset($item->package_icon)
                    : ($item->categoryDetails && $item->categoryDetails->category_image
                        ? asset($item->categoryDetails->category_image)
                        : asset('default.png'));

                $item->price = $isCorporateUser ? $item->corporate_price : $item->price;
                $item->regular_price = $isCorporateUser ? $item->corporate_regular_price : $item->regular_price;
                $item->discount_type = $isCorporateUser ? $item->corporate_discount_type : $item->discount_type;
                $item->discount_price = $isCorporateUser ? $item->corporate_discount : $item->discount_price;

                // check if already in cart
                $key = get_class($item) . '_' . $item->id;
                $item->in_cart = in_array($key, $cartItems);

                // get cart quantity
                $quantity = 1;
                if ($item->in_cart) {
                    if (Auth::check()) {
                        $cartRow = \App\Models\Cart::where('user_id', Auth::id())
                            ->where('item_type', get_class($item))
                            ->where('item_id', $item->id)
                            ->first();
                        $quantity = $cartRow ? $cartRow->quantity : 1;
                    } else {
                        $cartRow = Session::get("cart.$key");
                        $quantity = $cartRow['quantity'] ?? 1;
                    }
                }
                $item->quantity = $quantity;

                return $item;
            });

            return response()->json($items);
        }


        $offers = Offer::where('page', 'homepage')->where('is_active', 1)->orderBy('id', 'DESC')->get();
        $feature = HomeFeature::first();
        $brands = HomeBrand::where('is_active', 1)->orderBy('sort_order', 'asc')->get();
        $testimonials = HomeTestimonial::where('is_active', 1)->orderBy('sort_order', 'asc')->get();

        $blogs = Blog::withCount('comments')->where('is_active', 1)->orderBy('id', 'desc')->inRandomOrder()->limit(3)->get();
        $videos = HomeVideo::where('is_active', 1)->orderBy('id', 'desc')->inRandomOrder()->limit(3)->get();

        $products = Product::with('images', 'productType', 'reviews')
            ->inRandomOrder()
            ->where('status', 1)
            ->whereIn('product_for', ['user', 'both'])
            ->whereHas('productType', fn($q) => $q->where('slug', "products"))
            ->limit(10)
            ->get();

        $equipments = Product::with('images', 'productType', 'reviews')
            ->inRandomOrder()
            ->where('status', 1)
            ->whereIn('product_for', ['user', 'both'])
            ->whereHas('productType', fn($q) => $q->where('slug', "equipments"))
            ->limit(10)
            ->get();



        return view('frontend.index', compact(
            'banners',
            'category_by_organ',
            'category_by_disease',
            'test_types',
            'packages',
            'offers',
            'feature',
            'brands',
            'testimonials',
            'blogs',
            'videos',
            'products',
            'equipments',
            'cartItems'
        ));
    }

    public function checkup()
    {
        return view('frontend.checkup');
    }

    public function testDetails($slug)
    {
        $package = package::with(['requisites', 'parameters', 'faqs'])->where('slug', $slug)->first();
        if ($package) {
            $related_packages = package::with(['categoryDetails', 'parameters'])->where('category', $package->category)->inRandomOrder()->limit(3)->get();
            $package_reviews = PackageReview::where('package_id', $package->id)->where('is_active', 1)->get();
            $average_rating = $package_reviews->avg('rating');

            $cartItems = [];

            if (Auth::check()) {
                $cartItems = Cart::where('user_id', Auth::id())->get()->map(function ($cart) {
                    return $cart->item_type . '_' . $cart->item_id;
                })->toArray();
            } else {
                $cartItems = array_keys(Session::get('cart', []));
            }

            return view('frontend.test.index', compact('package', 'related_packages', 'package_reviews', 'average_rating', 'cartItems'));
        } else {
            abort(404, 'Test Details not found');
        }
    }
    public function contact()
    {
        return view('frontend.contact');
    }
    public function about()
    {
        $about = WebAbout::first();
        $testimonials = HomeTestimonial::where('is_active', 1)->orderBy('sort_order', 'asc')->get();
        $brands = HomeBrand::where('is_active', 1)->orderBy('sort_order', 'asc')->get();
        $feature = HomeFeature::first();
        $videos = HomeVideo::where('is_active', 1)->orderBy('id', 'desc')->get();
        $teams = WebTeam::where('is_active', 1)->orderBy('id', 'desc')->get();
        return view('frontend.about', compact('brands', 'feature', 'videos', 'testimonials', 'about', 'teams'));
    }

    public function login()
    {
        return view('frontend.login');
    }
    public function register()
    {
        return view('frontend.register');
    }
    public function forgot()
    {
        return view('frontend.forgot');
    }
    public function faq()
    {
        $faqs = Faq::where('faq_for', 'Website')->where('is_active', 1)->orderBy('id', 'desc')->get();
        return view('frontend.faq', compact('faqs'));
    }
    public function blog()
    {
        $blogs = Blog::withCount('comments')
            ->where('is_active', 1)
            ->orderBy('id', 'desc')
            ->paginate(6);
        return view('frontend.blog', compact('blogs'));
    }
    public function blogDetails($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        $blog->increment('views');
        $blog_comments = BlogComment::where('blog_id', $blog->id)->where('is_active', 1)->get();
        return view('frontend.blogDetails', compact('blog', 'blog_comments'));
    }

    public function coming()
    {
        return view('frontend.coming');
    }


    public function checkoutcomplete()
    {
        return view('frontend.checkout-complete');
    }

    public function product($slug)
    {
        $product = Product::with([
            'images',
            'specifications',
            'productCategory',
            'reviews' => fn($q) => $q->where('is_active', 1),
            'variants.images',
        ])->where('slug', $slug)->firstOrFail();

        // Inject average rating and review count manually
        $product->avg_rating = $product->reviews->avg('rating') ?? rand(3, 5);
        $product->review_count = $product->reviews->count();

        // Combine main product images + all variant images
        $allImages = $product->images->pluck('image')->toArray(); // main images

        foreach ($product->variants as $variant) {
            foreach ($variant->images as $vImage) {
                if (!in_array($vImage->image, $allImages)) {
                    $allImages[] = $vImage->image;
                }
            }
        }

        $product->all_images = $allImages;

        $relatedProducts = Product::with('images')
            ->where('status', 1)
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('frontend.product', compact('product', 'relatedProducts'));
    }



    public function category($type)
    {
        $category = PackageCategory::whereIn('type', [$type, 'Both'])->orderByRaw('status = 1 DESC')->get();
        return view('frontend.category', compact('category', 'type'));
    }

    public function doctor_category()
    {
        $specialities = Speciality::orderByRaw('status = 1 DESC')->get();
        return view('frontend.doctor_category', compact('specialities'));
    }

    public function compare()
    {
        return view('frontend.compare');
    }

    public function payment()
    {
        return view('frontend.payment');
    }

    public function userRegistration()
    {
        return view('frontend.user_Registration');
    }

    public function productViewcart()
    {
        return view('frontend.product_viewcart');
    }

    // Smart Search
    public function smartSearch(Request $request)
    {
        $search = trim($request->get('q'));

        if (!$search) {
            return redirect()->back()->with('error', 'Please enter something to search.');
        }

        // Split the search into individual keywords
        $keywords = preg_split('/\s+/', $search);

        // --- Search Products ---
        $productQuery = Product::where('status', 1);
        $productQuery->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                $q->orWhere('product_name', 'like', "%{$word}%");
                $q->orWhere('short_desc', 'like', "%{$word}%");
                $q->orWhere('long_desc', 'like', "%{$word}%");
                $q->orWhere('slug', 'like', "%{$word}%");
                $q->orWhere('brand', 'like', "%{$word}%");
                $q->orWhere('selling_price', 'like', "%{$word}%");
                $q->orWhere('bulk_selling_price', 'like', "%{$word}%");
            }
        });
        $productCount = $productQuery->count();

        // --- Search Lab Tests ---
        $labTestQuery = package::query();
        $labTestQuery->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                $q->orWhere('name', 'like', "%{$word}%");
                $q->orWhere('type', 'like', "%{$word}%");
                $q->orWhere('slug', 'like', "%{$word}%");
                $q->orWhere('about_test', 'like', "%{$word}%");
                $q->orWhere('department_category', 'like', "%{$word}%");
            }
        });
        $labTestCount = $labTestQuery->count();

        // --- Smart Decision Logic ---
        if ($productCount > 0 && $labTestCount === 0) {
            // Only products found
            return redirect()->route('shop', ['search' => $search]);
        } elseif ($labTestCount > 0 && $productCount === 0) {
            // Only lab tests found
            return redirect()->route('lab.test', ['search' => $search]);
        } else {
            // Both types found — show combined results
            $products = $productQuery->limit(10)->get();
            $labTests = $labTestQuery->limit(10)->get();

            return view('frontend.search_results', compact('search', 'products', 'labTests'));
        }
    }
}
