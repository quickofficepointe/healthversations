<?php

namespace App\Http\Controllers;

use App\Models\CartOrder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartOrderController extends Controller
{
    public function index()
    {
        $cartOrders = CartOrder::orderBy('created_at', 'desc')->paginate(10);
        return view('healthversations.admin.products.index', compact('cartOrders'));
    }

    public function update(Request $request, $id)
    {
        $order = CartOrder::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,completed,failed'
        ]);

        $order->update($validated);

        return redirect()->route('admin.cart-orders.index')
            ->with('success', 'Order status updated successfully');
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:20',
            'county' => 'required|string|max:100',
            'subcounty' => 'required|string|max:100',
            'location' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'delivery_method' => 'required|in:pickup,delivery',
            'delivery_zone' => 'required_if:delivery_method,delivery|string|max:1',
        ]);

        // Get cart items from session
        $cartItems = session('cart', []);
        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

        // Calculate total amount
        $subtotal = 0;
        $items = [];
        foreach ($cartItems as $item) {
            $itemTotal = $item['price_kes'] * $item['quantity'];
            $subtotal += $itemTotal;

            $items[] = [
                'product' => $item['name'],
                'variant' => $item['variant_name'] ?? null,
                'quantity' => $item['quantity'],
                'price' => $item['price_kes'],
                'total' => $itemTotal
            ];
        }

        // Calculate delivery cost
        $deliveryCost = 0;
        $deliveryZone = null;

        if ($request->delivery_method === 'delivery') {
            $zoneRates = [
                'A' => 150, 'J' => 350, 'D' => 400, 'F' => 400,
                'K' => 400, 'N' => 400, 'G' => 450, 'M' => 450,
                'H' => 600, 'O' => 650, 'P' => 800, 'R' => 900, 'Q' => 1350
            ];

            $deliveryZone = $request->delivery_zone;
            $deliveryCost = $zoneRates[$deliveryZone] ?? 0;
        } else {
            $deliveryZone = 'B'; // Pickup zone
        }

        $totalAmount = $subtotal + $deliveryCost;

        // Create order record
        $order = CartOrder::create([
            'order_id' => 'ORD-' . Str::random(10),
            'amount' => $totalAmount,
            'subtotal' => $subtotal,
            'delivery_cost' => $deliveryCost,
            'delivery_zone' => $deliveryZone,
            'delivery_method' => $request->delivery_method,
            'items' => $items,
            'customer_name' => $request->first_name . ' ' . $request->last_name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'county' => $request->county,
            'subcounty' => $request->subcounty,
            'location' => $request->location,
            'address' => $request->address,
            'status' => 'pending'
        ]);

        // Send email notifications
        $this->sendOrderNotifications($order);

        // Generate iVeri token
        $token = $this->generateIveriToken(
            $totalAmount * 100, // Convert to cents
            $request->email
        );

        // Return JSON response for AJAX handling
        return response()->json([
            'success' => true,
            'order_id' => $order->order_id,
            'amount' => $totalAmount,
            'currency' => 'KES',
            'token' => $token,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'delivery_cost' => $deliveryCost,
            'delivery_zone' => $deliveryZone
        ]);
    }

    protected function sendOrderNotifications($order)
    {
        $customerEmail = $order->customer_email;
        $salesEmail = 'sales@healthversation.com';

        // Customer email
        Mail::raw("Thank you for your order #{$order->order_id}.\n\n" .
                   "Order Summary:\n" .
                   "Amount: KES {$order->amount}\n" .
                   "Delivery: " . ($order->delivery_method === 'pickup' ? 'Pickup' : 'Delivery') . "\n" .
                   "Items:\n" .
                   collect($order->items)->map(function($item) {
                       return "- {$item['product']}" .
                              ($item['variant'] ? " ({$item['variant']})" : '') .
                              " (Qty: {$item['quantity']}) @ KES {$item['price']}";
                   })->implode("\n") .
                   "\n\nWe'll process your order shortly.",
            function ($message) use ($customerEmail, $order) {
                $message->to($customerEmail)
                        ->subject("Your Healthversation Order #{$order->order_id}");
            });

        // Sales team email
        Mail::raw("New Order Received #{$order->order_id}\n\n" .
                   "Customer: {$order->customer_name}\n" .
                   "Email: {$order->customer_email}\n" .
                   "Phone: {$order->customer_phone}\n" .
                   "Amount: KES {$order->amount}\n" .
                   "Delivery: " . ($order->delivery_method === 'pickup' ? 'Pickup' : 'Delivery to ' . $order->delivery_zone) . "\n\n" .
                   "Shipping Address:\n" .
                   "{$order->address}, {$order->location}\n" .
                   "{$order->subcounty}, {$order->county}\n\n" .
                   "Items:\n" .
                   collect($order->items)->map(function($item) {
                       return "- {$item['product']}" .
                              ($item['variant'] ? " ({$item['variant']})" : '') .
                              " (Qty: {$item['quantity']}) @ KES {$item['price']}";
                   })->implode("\n"),
            function ($message) use ($salesEmail, $order) {
                $message->to($salesEmail)
                        ->subject("New Order #{$order->order_id} from {$order->customer_name}");
            });
    }

    protected function generateIveriToken($amount, $email)
    {
        $secret = config('services.iveri.secret');
        $time = time();
        $resource = '/Lite/Authorise.aspx';
        $appId = config('services.iveri.app_id', '3a7f44fd-4bb4-432c-b483-32e5a19e100d');

        $tokenData = $secret . $time . $resource . $appId . $amount . $email;

        return 'x:' . $time . '-' . hash('sha256', $tokenData);
    }
}
