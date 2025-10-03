<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\product;
use App\Models\productvariant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
public function showOrderPage($slug)
{
    try {
        $quantity = max(1, (int)request('quantity', 1));
        $orderType = request('order_type', 'delivery');

        $product = Product::with('variants')
            ->where('slug', $slug)
            ->firstOrFail();

        // Handle variant selection
        $variant = null;
        if ($variantId = request('variant_id')) {
            $variant = ProductVariant::find($variantId);
            if (!$variant || $variant->product_id != $product->id) {
                throw new \Exception('Invalid product variant selected');
            }
        }

        // Validate stock
        $availableStock = $variant ? $variant->stock : $product->stock;
        if ($availableStock < $quantity) {
            throw new \Exception('Not enough stock available');
        }

        // Calculate totals
        $priceKES = $variant ? $variant->price_kes : $product->price_kes;
        $totalKES = $priceKES * $quantity;
        if ($orderType === 'delivery') {
            $totalKES += 300; // Delivery fee
        }

        return view('frontendviews.orders.index', [
            'product' => $product,
            'variant' => $variant,
            'quantity' => $quantity,
            'totalKES' => $totalKES,
            'price_kes' => $priceKES,
            'variant_name' => $variant?->display_name,
            'order_type' => $orderType,
            'applicationId' => config('services.iveri.application_id')
        ]);

    } catch (ModelNotFoundException $e) {
        return redirect()->route('products.index')
            ->with('error', 'Product not found');
    } catch (\Exception $e) {
        return redirect()->route('product.show', $slug)
            ->with('error', $e->getMessage());
    }
}
protected function calculateTotals(Product $product, ?ProductVariant $variant, int $quantity, string $orderType): array
{
    $priceKES = $variant ? $variant->price_kes : $product->price_kes;
    $priceUSD = $variant ? $variant->price_usd : $product->price_usd;

    $subtotalKES = $priceKES * $quantity;
    $subtotalUSD = $priceUSD * $quantity;

    // Add delivery fee if needed
    if ($orderType === 'delivery') {
        $deliveryFee = 300; // KSH
        return [
            'kes' => $subtotalKES + $deliveryFee,
            'usd' => $subtotalUSD + ($deliveryFee / 100) // Assuming 1 USD = 100 KSH
        ];
    }

    return [
        'kes' => $subtotalKES,
        'usd' => $subtotalUSD
    ];
}


    public function index()
    {
        $orders = order::with(['product', 'variant'])->latest()->get();
        return view('healthversations.admin.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'order_type' => 'required|in:pickup,delivery',
            'quantity' => 'required|integer|min:1',
            'total_price_kes' => 'required|numeric|min:0',
            'total_price_usd' => 'required|numeric|min:0',
            'payment_code' => 'required|string|max:255',
            'pickup_date' => 'nullable|date|required_if:order_type,pickup',
            'pickup_time' => 'nullable|string|required_if:order_type,pickup',
            'county' => 'nullable|string|max:255|required_if:order_type,delivery',
            'subcounty' => 'nullable|string|max:255|required_if:order_type,delivery',
            'location' => 'nullable|string|max:255|required_if:order_type,delivery',
            'address' => 'nullable|string|max:255|required_if:order_type,delivery',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Verify product/variant stock
        $product = product::find($validated['product_id']);
        $variant = $validated['variant_id'] ? ProductVariant::find($validated['variant_id']) : null;

        if ($variant) {
            if ($variant->stock < $validated['quantity']) {
                return back()->with('error', 'Selected variant is out of stock');
            }
            // Update variant stock
            $variant->decrement('stock', $validated['quantity']);
        } else {
            if ($product->stock < $validated['quantity']) {
                return back()->with('error', 'Product is out of stock');
            }
            // Update product stock
            $product->decrement('stock', $validated['quantity']);
        }

        // Generate tracking ID
        $validated['tracking_id'] = 'ORD-' . strtoupper(uniqid());

        $order = Order::create($validated);

        // Clear cart if this was from cart checkout
        if ($request->session()->has('cart')) {
            $request->session()->forget('cart');
        }

        return redirect()->route('order.track', ['tracking_id' => $order->tracking_id])
            ->with('success', "Order #{$order->tracking_id} placed successfully!");
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->status = $order->status == 'delivered' ? 'not_delivered' : 'delivered';
        $order->save();

        return back()->with('success', 'Order status updated successfully!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Restore stock if order is being deleted
        if ($order->variant_id) {
            ProductVariant::where('id', $order->variant_id)
                ->increment('stock', $order->quantity);
        } else {
            Product::where('id', $order->product_id)
                ->increment('stock', $order->quantity);
        }

        $order->delete();

        return back()->with('success', 'Order deleted successfully!');
    }

    public function track(Request $request)
    {
        $trackingId = $request->query('tracking_id');

        if (!$trackingId) {
            return view('frontendviews.orders.track');
        }

        $order = Order::with(['product', 'variant'])
            ->where('tracking_id', $trackingId)
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found. Please check your tracking ID.');
        }

        return view('frontendviews.orders.track', compact('order'));
    }
}
