<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        $productId = $request->product_id;

        if (Auth::check()) {
            $user = Auth::user();

            $existing = Wishlist::where('user_id', $user->id)->where('product_id', $productId)->first();

            if ($existing) {
                $existing->delete();
                return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist']);
            } else {
                Wishlist::create(['user_id' => $user->id, 'product_id' => $productId]);
                return response()->json(['status' => 'added', 'message' => 'Added to wishlist']);
            }
            
        } else {
            $wishlist = session()->get('wishlist', []);
            if (in_array($productId, $wishlist)) {
                $wishlist = array_diff($wishlist, [$productId]);
                session()->put('wishlist', $wishlist);
                return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist']);
            } else {
                $wishlist[] = $productId;
                session()->put('wishlist', $wishlist);
                return response()->json(['status' => 'added', 'message' => 'Added to wishlist']);
            }
        }
    }

    public function index()
    {
        if (Auth::check()) {
            // Logged-in user — load wishlist with related products
            $wishlists = Wishlist::with('product.images')->where('user_id', Auth::id())->get();
        } else {
            // Guest user — get products from session wishlist
            $ids = session('wishlist', []);
            $wishlists = Product::with('images')->whereIn('id', $ids)->get();
        }

        return view('frontend.wishlist.list', compact('wishlists'));
    }


    public function syncWishlistOnLogin()
    {
        $sessionWishlist = session('wishlist', []);
        foreach ($sessionWishlist as $productId) {
            Wishlist::firstOrCreate([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
        }
        session()->forget('wishlist');
        return redirect()->route('wishlist.index');
    }

    public function remove(Request $request)
    {
        $productId = $request->product_id;

        if (Auth::check()) {
            Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $wishlist = session('wishlist', []);
            session(['wishlist' => array_diff($wishlist, [$productId])]);
        }

        return response()->json(['success' => true]);
    }

    public function getCount()
    {
        if (Auth::check()) {
            $count = Wishlist::where('user_id', Auth::id())
                ->count();
        } else {
            $wishlist = Session::get('wishlist', []);
            $count = collect($wishlist)->count();
        }

        return response()->json(['count' => $count]);
    }
}
