<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\package;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductCartController extends Controller
{
    public function addToCart(Request $request)
    {
        $itemId = $request->item_id;
        $quantity = max(1, (int) $request->quantity);
        $modelClass = Product::class;

        if (!class_exists($modelClass)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid item type']);
        }

        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('item_type', $modelClass)
                ->where('item_id', $itemId)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'item_type' => $modelClass,
                    'item_id' => $itemId,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            $cart = Session::get('cart', []);
            $key = $modelClass . '_' . $itemId;

            if (isset($cart[$key])) {
                $cart[$key]['quantity']++;
            } else {
                $cart[$key] = [
                    'item_type' => $modelClass,
                    'item_id' => $itemId,
                    'quantity' => $quantity,
                ];
            }

            Session::put('cart', $cart);
        }

        return response()->json(['status' => 'success', 'message' => 'Product added to cart']);
    }

    public function viewCart()
    {
        $items = [];

        if (Auth::check()) {
            $items = Cart::with([
                'item' => function ($morphTo) {
                    $morphTo->morphWith([
                        Product::class => ['productType', 'productCategory', 'productSubCategory', 'images'],
                    ]);
                }
            ])
                ->where('user_id', Auth::id())
                ->where('item_type', Product::class) // ✅ Only include Product items
                ->get()
                ->map(function ($cartItem) {
                    return [
                        'item' => $cartItem->item,
                        'type' => 'Product',
                        'quantity' => $cartItem->quantity,
                    ];
                })->toArray();
        } else {
            $cart = Session::get('cart', []);

            foreach ($cart as $entry) {
                if (!isset($entry['item_type']) || $entry['item_type'] !== Product::class) {
                    continue; // ✅ Skip if not a Product
                }

                $model = Product::with(['productType', 'productCategory', 'productSubCategory', 'images'])
                    ->find($entry['item_id']);

                if ($model) {
                    $items[] = [
                        'item' => $model,
                        'type' => 'Product',
                        'quantity' => $entry['quantity']
                    ];
                }
            }
        }

        return view('frontend.cart.product_cart', compact('items'));
    }

    public function removeFromCart(Request $request)
    {
        $itemId = $request->item_id;
        $type = $request->item_type;
        $modelClass = $type === 'Product' ? Product::class : null;

        if (!$modelClass) {
            return response()->json(['status' => 'error', 'message' => 'Invalid item type']);
        }

        $removed = false;

        if (Auth::check()) {
            $removed = Cart::where('user_id', Auth::id())
                ->where('item_id', $itemId)
                ->where('item_type', $modelClass)
                ->delete();
        } else {
            $cart = Session::get('cart', []);
            $key = $modelClass . '_' . $itemId;

            if (isset($cart[$key])) {
                unset($cart[$key]);
                Session::put('cart', $cart);
                $removed = true;
            }
        }

        if ($removed) {
            return response()->json(['status' => 'success', 'message' => 'Item removed from cart.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Failed to remove item.']);
    }

    public function getCount()
    {
        if (Auth::check()) {
            $count = Cart::where('user_id', Auth::id())
                ->where('item_type', Product::class)
                ->count();
        } else {
            $cart = Session::get('cart', []);
            $count = collect($cart)->where('item_type', Product::class)->count();
        }

        return response()->json(['count' => $count]);
    }

    public function updateQuantity(Request $request)
    {
        $itemId = $request->item_id;
        $quantity = max(1, (int) $request->quantity);
        $itemType = $request->item_type === 'Product' ? Product::class : null;

        if (!$itemType) {
            return response()->json(['status' => 'error', 'message' => 'Invalid item type'], 400);
        }

        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('item_type', $itemType)
                ->where('item_id', $itemId)
                ->update(['quantity' => $quantity]);
        } else {
            $cart = Session::get('cart', []);
            $key = $itemType . '_' . $itemId;

            if (isset($cart[$key])) {
                $cart[$key]['quantity'] = $quantity;
                Session::put('cart', $cart);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Quantity updated!']);
    }
}
