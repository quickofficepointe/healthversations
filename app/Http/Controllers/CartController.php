<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $totalKES = 0;
        $totalUSD = 0;
        $itemCount = 0;
        $total = 0;

        foreach ($cartItems as $item) {
            if (isset($item['price']) && isset($item['quantity'])) {
                $total += $item['price'] * $item['quantity'];
            }
        }

        foreach ($cartItems as &$item) {
            $totalKES += $item['price_kes'] * $item['quantity'];
            $totalUSD += $item['price_usd'] * $item['quantity'];
            $itemCount += $item['quantity'];
            // Add unit price to each item for frontend
            $item['unit_price_kes'] = $item['price_kes'];
            $item['unit_price_usd'] = $item['price_usd'];
        }

        return view('frontendviews.cart.index', compact('cartItems', 'totalKES', 'totalUSD', 'itemCount', 'total'));
    }

    public function add(Request $request)
    {
        $currency = $request->input('currency', session('currency', 'kes'));
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $variant = $request->variant_id ? ProductVariant::find($request->variant_id) : null;

        // Validate variant belongs to product
        if ($variant && $variant->product_id != $product->id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid product variant'
            ], 400);
        }

        // Check stock
        if ($variant) {
            if ($variant->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available for this variant'
                ], 400);
            }
        } else {
            if ($product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available'
                ], 400);
            }
        }

        $cart = session()->get('cart', []);
        $cartKey = $this->generateCartKey($product->id, $variant ? $variant->id : null);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = [
                "product_id" => $product->id,
                "variant_id" => $variant ? $variant->id : null,
                "name" => $product->product_name,
                "variant_name" => $variant ? $variant->display_name : null,
                "quantity" => $request->quantity,
                "price_kes" => $variant ? $variant->price_kes : $product->price_kes,
                "price_usd" => $variant ? $variant->price_usd : $product->price_usd,
                "price" => $variant ? ($currency === 'kes' ? $variant->price_kes : $variant->price_usd)
                              : ($currency === 'kes' ? $product->price_kes : $product->price_usd),
                "image" => asset(''.$product->cover_image),
                "slug" => $product->slug,
                "id" => $cartKey
            ];
        }

        session()->put('cart', $cart);

        // Calculate new totals
        $cartTotal = $this->calculateCartTotal($cart);
        $itemTotal = $cart[$cartKey]['price_kes'] * $cart[$cartKey]['quantity'];

        return response()->json([
            'success' => true,
            'cart_count' => $this->getCartItemCount($cart),
            'cart_total' => $cartTotal,
            'item_total' => $itemTotal,
            'unit_price' => $cart[$cartKey]['price_kes'],
            'message' => 'Product added to cart'
        ]);
    }

    public function update(Request $request, $cartKey)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$cartKey])) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart'
            ], 404);
        }

        // Check stock
        $item = $cart[$cartKey];
        if ($item['variant_id']) {
            $variant = ProductVariant::find($item['variant_id']);
            if ($variant && $variant->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available for this variant'
                ], 400);
            }
        } else {
            $product = Product::find($item['product_id']);
            if ($product && $product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available'
                ], 400);
            }
        }

        // Update quantity
        $cart[$cartKey]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        // Calculate updated values
        $unitPriceKES = $cart[$cartKey]['price_kes'];
        $itemTotalKES = $unitPriceKES * $request->quantity;
        $cartTotalKES = $this->calculateCartTotal($cart);
        $cartItemCount = $this->getCartItemCount($cart);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'unit_price' => $unitPriceKES,
            'item_total' => $itemTotalKES,
            'cart_total' => $cartTotalKES,
            'cart_count' => $cartItemCount,
            'quantity' => $request->quantity
        ]);
    }

    public function remove($cartKey)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);

            $cartTotal = $this->calculateCartTotal($cart);
            $cartItemCount = $this->getCartItemCount($cart);

            return response()->json([
                'success' => true,
                'cart_count' => $cartItemCount,
                'cart_total' => $cartTotal,
                'message' => 'Product removed successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }

    public function checkout()
    {
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Verify stock before checkout
        foreach ($cartItems as $key => $item) {
            if ($item['variant_id']) {
                $variant = ProductVariant::find($item['variant_id']);
                if (!$variant || $variant->stock < $item['quantity']) {
                    return redirect()->route('cart.index')->with('error', "{$item['name']} - {$item['variant_name']} is out of stock or no longer available");
                }
            } else {
                $product = Product::find($item['product_id']);
                if (!$product || $product->stock < $item['quantity']) {
                    return redirect()->route('cart.index')->with('error', "{$item['name']} is out of stock or no longer available");
                }
            }
        }

        $totalKES = 0;
        $totalUSD = 0;
        foreach ($cartItems as $item) {
            $totalKES += $item['price_kes'] * $item['quantity'];
            $totalUSD += $item['price_usd'] * $item['quantity'];
        }

        return view('frontendviews.orders.index', compact('cartItems', 'totalKES', 'totalUSD'));
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully');
    }

    /**
     * Generate a unique cart key for product/variant combination
     */
    private function generateCartKey($productId, $variantId = null)
    {
        return $variantId ? "{$productId}_{$variantId}" : "{$productId}";
    }

    /**
     * Calculate total item count in cart
     */
    private function getCartItemCount($cart)
    {
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Calculate total cart value in KES
     */
    private function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price_kes'] * $item['quantity'];
        }
        return $total;
    }
}
