<?php

namespace App\Http\Controllers;  // ← YEH NAMESPACE IMPORTANT HAI (Admin nahi)

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer',
                'format'     => 'required|string',
                'price'      => 'required|numeric',
                'qty'        => 'nullable|integer|min:1',
            ]);

            $product = Product::findOrFail($request->product_id);
            $cart = Session::get('cart', []);
            
            $key = 'p' . $product->id . '_' . str_replace(' ', '_', strtolower($request->format));
            $qty = max(1, (int) ($request->qty ?? 1));

            if (isset($cart[$key])) {
                $cart[$key]['qty'] += $qty;
            } else {
                $cart[$key] = [
                    'id'              => $product->id,
                    'name'            => $product->name . ' — ' . $request->format,
                    'qty'             => $qty,
                    'baseprice'       => (float) $request->price,
                    'variation_price' => 0,
                    'variation'       => [],
                    'mat_language'    => $request->format,
                    'slug'            => $product->slug,
                ];
            }

            Session::put('cart', $cart);

            $count = collect($cart)->filter(fn($v) => is_array($v) && isset($v['qty']))->sum('qty');
            $total = collect($cart)->filter(fn($v) => is_array($v) && isset($v['baseprice']))
                ->sum(fn($v) => $v['baseprice'] * $v['qty']);

            return response()->json([
                'success' => true,
                'message' => $product->name . ' added to cart',
                'count'   => $count,
                'total'   => number_format($total, 2),
                'cart'    => $this->cartItems($cart),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function removeFromCart(Request $request)
    {
        try {
            $request->validate(['key' => 'required|string']);

            $cart = Session::get('cart', []);
            unset($cart[$request->key]);
            Session::put('cart', $cart);

            $count = collect($cart)->filter(fn($v) => is_array($v) && isset($v['qty']))->sum('qty');
            $total = collect($cart)->filter(fn($v) => is_array($v) && isset($v['baseprice']))
                ->sum(fn($v) => $v['baseprice'] * $v['qty']);

            return response()->json([
                'success' => true,
                'count'   => $count,
                'total'   => number_format($total, 2),
                'cart'    => $this->cartItems($cart),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getCartData()
{
    $cart = Session::get('cart', []);
    
    // Log cart data for debugging
    \Log::info('Cart data requested:', $cart);
    
    $count = collect($cart)->filter(fn($v) => is_array($v) && isset($v['qty']))->sum('qty');
    $total = collect($cart)->filter(fn($v) => is_array($v) && isset($v['baseprice']))
        ->sum(fn($v) => $v['baseprice'] * $v['qty']);

    $items = $this->cartItems($cart);

    return response()->json([
        'count' => $count,
        'total' => number_format($total, 2),
        'cart'  => $items,
    ]);
}

private function cartItems(array $cart): array
{
    $items = [];
    foreach ($cart as $key => $v) {
        if (!is_array($v) || !isset($v['id'])) continue;
        $items[] = array_merge($v, ['key' => $key]);
    }
    return $items;
}
}