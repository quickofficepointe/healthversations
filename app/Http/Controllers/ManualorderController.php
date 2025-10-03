<?php

namespace App\Http\Controllers;

use App\Models\manualorder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ManualorderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

// Validate the incoming request
public function store(Request $request)
{
$validated = $request->validate([
    'product_id' => 'required|exists:products,id',
    'quantity' => 'required|integer|min:1',
    'total_price' => 'required|numeric|min:0',
    'payment_code' => 'required|string',
    'name' => 'required|string|max:255',
    'email' => 'required|email',
    'phone' => 'required|string|max:20',
    'order_type' => 'required|in:pickup,delivery',
    'pickup_date' => 'nullable|date|required_if:order_type,pickup',
    'pickup_time' => 'nullable|date_format:H:i|required_if:order_type,pickup',
    'county' => 'nullable|string|required_if:order_type,delivery',
    'subcounty' => 'nullable|string|required_if:order_type,delivery',
    'location' => 'nullable|string|required_if:order_type,delivery',
    'address' => 'nullable|string|required_if:order_type,delivery',
    'latitude' => 'nullable|numeric|required_if:order_type,delivery',
    'longitude' => 'nullable|numeric|required_if:order_type,delivery',
]);

// Generate Unique Tracking ID (8 Alphanumeric Characters)
$tracking_id = 'HV' . strtoupper(substr(md5(uniqid()), 0, 6));

// Create New Order
$order = ManualOrder::create([
    'tracking_id' => $tracking_id,
    'product_id' => $validated['product_id'],
    'quantity' => $validated['quantity'],
    'total_price' => $validated['total_price'],
    'payment_code' => $validated['payment_code'],
    'name' => $validated['name'],
    'email' => $validated['email'],
    'phone' => $validated['phone'],
    'order_type' => $validated['order_type'],
    'pickup_date' => $validated['order_type'] === 'pickup' ? $validated['pickup_date'] : null,
    'pickup_time' => $validated['order_type'] === 'pickup' ? $validated['pickup_time'] : null,
    'county' => $validated['order_type'] === 'delivery' ? $validated['county'] : null,
    'subcounty' => $validated['order_type'] === 'delivery' ? $validated['subcounty'] : null,
    'location' => $validated['order_type'] === 'delivery' ? $validated['location'] : null,
    'address' => $validated['order_type'] === 'delivery' ? $validated['address'] : null,
    'latitude' => $validated['order_type'] === 'delivery' ? $validated['latitude'] : null,
    'longitude' => $validated['order_type'] === 'delivery' ? $validated['longitude'] : null,
    'status' => 'pending', // Default status
]);

// Send Raw Email with Tracking ID
Mail::raw("Hello {$order->name},\n\nThank you for your order! Your tracking ID is: {$tracking_id}\nYou can use this ID to track your order status.\n\nBest Regards,\nHealth Versation Team", function ($message) use ($order) {
    $message->to($order->email)
            ->subject('Your Order Tracking ID');
});

return response()->json([
    'message' => 'Order placed successfully!',
    'tracking_id' => $tracking_id,
]);
}


    /**
     * Display the specified resource.
     */
    public function show(manualorder $manualorder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(manualorder $manualorder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, manualorder $manualorder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(manualorder $manualorder)
    {
        //
    }
}
