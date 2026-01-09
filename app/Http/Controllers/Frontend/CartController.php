<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BookingPatient;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\package;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $type = $request->item_type; // Only 'package'
        $itemId = $request->item_id;
        $patientId = $request->patients_id; // single patient id as string or null
        $modelClass = $type === 'package' ? package::class : '';

        if (!class_exists($modelClass)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid item type']);
        }

        if (Auth::check()) {

            // 1️⃣ Determine patient(s) to add
            if ($patientId) {
                $patientId = (int) $patientId;

                $patientIds = BookingPatient::where('user_id', Auth::id())
                    ->where(function ($q) {
                        $q->whereNull('booking_id')->orWhere('booking_id', '');
                    })
                    ->where('id', $patientId)
                    ->pluck('id')
                    ->toArray();
            } else {
                $patientIds = BookingPatient::where('user_id', Auth::id())
                    ->where(function ($q) {
                        $q->whereNull('booking_id')->orWhere('booking_id', '');
                    })
                    ->pluck('id')
                    ->toArray();
            }

            // if (empty($patientIds)) {
            //     return response()->json(['status' => 'error', 'message' => 'No valid patients found for this user']);
            // }

            // 2️⃣ Check if same package already exists in cart
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('item_type', $modelClass)
                ->where('item_id', $itemId)
                ->first();

            if ($cartItem) {
                // ✅ Merge new patient(s) into existing row
                $existingPatients = $cartItem->patients_id ?? [];
                if (!is_array($existingPatients)) $existingPatients = [$existingPatients];

                $mergedPatients = array_values(array_unique(array_merge($existingPatients, $patientIds)));

                $cartItem->patients_id = $mergedPatients;
                $cartItem->quantity = count($mergedPatients);
                $cartItem->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Item updated in cart for new patient(s)',
                    'patients_id' => $mergedPatients,
                    'quantity' => $cartItem->quantity
                ]);
            }

            // 3️⃣ If not exists → create new cart row
            Cart::create([
                'user_id' => Auth::id(),
                'item_type' => $modelClass,
                'item_id' => $itemId,
                'patients_id' => $patientIds,
                'quantity' => count($patientIds),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Item added to cart',
                'patients_id' => $patientIds, // ✅ ADD THIS
                'quantity' => count($patientIds)
            ]);
        } else {
            // ❌ Session cart (guest)
            $cart = Session::get('cart', []);
            $key = $modelClass . '_' . $itemId;

            if (isset($cart[$key])) {
                // Already in session cart → increment qty
                $cart[$key]['quantity'] = ($cart[$key]['quantity'] ?? 1) + 1;
                Session::put('cart', $cart);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Item quantity updated in cart',
                    'quantity' => $cart[$key]['quantity']
                ]);
            }

            // Add new session cart item
            $cart[$key] = [
                'item_type' => $modelClass,
                'item_id' => $itemId,
                'quantity' => 1,
            ];

            Session::put('cart', $cart);


            return response()->json(['status' => 'success', 'message' => 'Item added to cart']);
        }
    }


    public function updateQty(Request $request)
    {
        $type = $request->item_type;
        $itemId = $request->item_id;
        $quantity = max(1, (int)$request->quantity); // at least 1
        $modelClass = $type === 'package' ? package::class : '';

        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('item_type', $modelClass)
                ->where('item_id', $itemId)
                ->update(['quantity' => $quantity]);
        } else {
            $cart = Session::get('cart', []);
            $key = $modelClass . '_' . $itemId;
            if (isset($cart[$key])) {
                $cart[$key]['quantity'] = $quantity;
                Session::put('cart', $cart);
            }
        }

        return response()->json(['status' => 'success']);
    }


    public function viewCart()
    {
        $items = [];

        $isCorporateUser = Auth::check() && Auth::user()->corporate_id !== null;


        if (Auth::check()) {

            $patientIds = BookingPatient::where('user_id', Auth::id())
                ->where(function ($q) {
                    $q->whereNull('booking_id')->orWhere('booking_id', '');
                })
                ->pluck('id')
                ->toArray();

            Cart::where('user_id', Auth::id())
                ->where('item_type', package::class)
                ->get()
                ->each(function ($cartItem) use ($patientIds) {

                    if (empty($patientIds)) return;

                    $existing = $cartItem->patients_id ?? [];
                    if (!is_array($existing)) $existing = [$existing];

                    $merged = array_values(array_unique(array_merge($existing, $patientIds)));

                    $cartItem->patients_id = $merged;
                    $cartItem->quantity = count($merged);
                    $cartItem->save();
                });
        }
        if (Auth::check()) {
            $items = Cart::with([
                'item' => function ($morphTo) {
                    $morphTo->morphWith([
                        package::class => ['categoryDetails'],
                    ]);
                }
            ])
                ->where('user_id', Auth::id())
                ->where('item_type', package::class) // ✅ Only Packages
                ->get()
                ->map(function ($cartItem) use ($isCorporateUser) {
                    $item = $cartItem->item;

                    if ($item && $isCorporateUser) {
                        $item->price = $item->corporate_price;
                        $item->regular_price = $item->corporate_regular_price;
                        $item->discount_type = $item->corporate_discount_type;
                        $item->discount_price = $item->corporate_discount;
                    }

                    return [
                        'item' => $item,
                        'type' => 'package',
                        'quantity' => $cartItem->quantity,
                    ];
                });
        } else {
            $cart = Session::get('cart', []);

            foreach ($cart as $entry) {
                if (!isset($entry['item_type']) || $entry['item_type'] !== package::class) {
                    continue; // ✅ Skip if not a Package
                }

                $model = package::with('categoryDetails')->find($entry['item_id']);

                if ($model) {
                    // Guest users are never corporate
                    $model->price = $model->price;
                    $model->regular_price = $model->regular_price;
                    $model->discount_type = $model->discount_type;
                    $model->discount_price = $model->discount_price;

                    $items[] = [
                        'item' => $model,
                        'type' => 'package',
                        'quantity' => $entry['quantity'],
                    ];
                }
            }
        }

        return view('frontend.cart.index', compact('items'));
    }



    public function removeItem(Request $request)
    {
        $itemId = $request->item_id;

        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('item_type', package::class)
                ->where('item_id', $itemId)
                ->delete();
        } else {
            $cart = Session::get('cart', []);
            $key = package::class . '_' . $itemId;

            if (isset($cart[$key])) {
                unset($cart[$key]);
                Session::put('cart', $cart);
            }
        }

         $appliedCouponCode = session('applied_coupon');

            if ($appliedCouponCode) {
                $coupon = Coupon::where('code', $appliedCouponCode)->first();

                $cartTotal = $this->getCartTotal();

                if ($coupon && $coupon->min_cart_amount > $cartTotal) {
                    session()->forget('applied_coupon');
                }
            }


        return response()->json(['status' => 'success', 'message' => 'Item removed from cart']);
    }

    public function getCount()
    {
        if (Auth::check()) {
            $count = Cart::where('user_id', Auth::id())
                ->where('item_type', package::class)
                ->count();
        } else {
            $cart = Session::get('cart', []);
            $count = collect($cart)->where('item_type', package::class)->count();
        }

        return response()->json(['count' => $count]);
    }

    public function getCombinedCartCount()
    {
        try {
            $productCount = 0;
            $testCount = 0;

            if (Auth::check()) {
                $productCount = Cart::where('user_id', Auth::id())
                    ->where('item_type', Product::class)
                    ->count();

                $testCount = Cart::where('user_id', Auth::id())
                    ->where('item_type', package::class)
                    ->count();
            } else {
                $cart = Session::get('cart', []);
                foreach ($cart as $entry) {
                    if (isset($entry['item_type']) && $entry['item_type'] === Product::class) {
                        $productCount++;
                    } elseif (isset($entry['item_type']) && $entry['item_type'] === package::class) {
                        $testCount++;
                    }
                }
            }

            return response()->json([
                'totalcartcount'     => $productCount + $testCount,
                'product_cart_count' => $productCount,    // ✅ Added
                'lab_cart_count'     => $testCount        // ✅ Added
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function getCartTotal()
    {
        $total = 0;
        $count = 0;

        // Logged in user cart
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->get();

            foreach ($cart as $item) {
                $model = $item->item_type;
                $obj = $model::find($item->item_id);

                if ($obj) {
                    // Determine price based on model (Product vs Package)
                    $price = $model === Product::class
                        ? ($obj->selling_price ?? 0)
                        : ($obj->price ?? 0);

                    $total += $price * $item->quantity;
                    $count += $item->quantity;
                }
            }
        }
        // Guest User Cart (session)
        else {
            $cart = session()->get('cart', []);

            foreach ($cart as $item) {
                $model = $item['item_type'];
                $obj = $model::find($item['item_id']);

                if ($obj) {
                    $price = $model === Product::class
                        ? ($obj->selling_price ?? 0)
                        : ($obj->price ?? 0);

                    $total += $price * $item['quantity'];
                    $count += $item['quantity'];
                }
            }
        }

        return response()->json([
            'total' => number_format($total, 2, '.', ''),
            'count' => $count
        ]);
    }

    // Fetch Mobile Cart Items
    public function fetchMobileCartItems()
    {
        $items = [];
        $total = 0;
        $count = 0;

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->get();
        } else {
            $cart = session('cart', []);
        }

        foreach ($cart as $key => $c) {

            $model = Auth::check() ? $c->item_type : $c['item_type'];
            $itemId = Auth::check() ? $c->item_id : $c['item_id'];
            $quantity = Auth::check() ? $c->quantity : 1;

            $obj = $model::find($itemId);
            if (!$obj) continue;

            $price = $model === Product::class ? ($obj->selling_price ?? 0) : ($obj->price ?? 0);
            $name  = $model === Product::class ? ($obj->product_name ?? '') : ($obj->name ?? '');

            if ($model === package::class) {
                $icon = $obj->package_icon
                    ? asset($obj->package_icon)
                    : ($obj->categoryDetails && $obj->categoryDetails->category_image
                        ? asset($obj->categoryDetails->category_image)
                        : asset('default.png'));

                $image = $icon;
            } else {
                $firstImage = optional($obj->images->first())->image ?? null;
                $image = $firstImage ? asset($firstImage) : asset('assets/img/product/default.png');
            }

            $items[] = [
                'id'    => Auth::check() ? $c->id : $key,
                'name'  => $name,
                'price' => $price,
                'img'   => $image,
                'model' => class_basename($model),
                'qty'   => $quantity
            ];

            $total += ($price * $quantity);
            $count += $quantity;
        }

        return response()->json([
            'items' => $items,
            'total' => number_format($total, 2),
            'count' => $count,
        ]);
    }

    // Mobile cart remove
    public function removeMobileCart(Request $request)
    {
        $itemId = $request->id;

        if (Auth::check()) {
            // Remove from DB cart
            Cart::where('id', $itemId)->where('user_id', Auth::id())->delete();
        } else {
            // Remove from session cart
            $cart = session()->get('cart', []);
            if (isset($cart[$itemId])) {
                unset($cart[$itemId]);
                session()->put('cart', $cart);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Item removed']);
    }
}
