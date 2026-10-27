<?php

namespace App\Http\Controllers;

use App\Models\CartOrder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CartOrderController extends Controller
{
    protected $salesEmail = 'sales@healthversation.com';

    public function index(Request $request)
    {
        $query = CartOrder::orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->etims === 'pending') {
            $query->etimsPending();
        } elseif ($request->etims === 'sent') {
            $query->where('etims_requested', true)->whereNotNull('etims_invoice_path');
        } elseif ($request->etims === 'requested') {
            $query->where('etims_requested', true);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();
        $etimsPendingCount = CartOrder::etimsPending()->count();

        return view('healthversations.admin.orders.cart-orders', compact('orders', 'etimsPendingCount'));
    }

    public function update(Request $request, $id)
    {
        $order = CartOrder::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', Rule::in(CartOrder::STATUSES)],
        ]);

        $order->update($validated);

        return back()->with('success', 'Order status updated successfully');
    }

    /**
     * Show order details via AJAX
     */
    public function showDetails($id)
    {
        $order = CartOrder::findOrFail($id);
        $items = is_array($order->items) ? $order->items : (json_decode($order->items, true) ?? []);

        $html = view('healthversations.admin.orders.partials.order-details', compact('order', 'items'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    /**
     * Admin attaches the eTIMS invoice generated on KRA and sends it to the customer and sales.
     */
    public function uploadEtimsInvoice(Request $request, $id)
    {
        $order = CartOrder::findOrFail($id);

        $request->validate([
            'etims_invoice' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'etims_invoice_number' => 'nullable|string|max:100',
        ]);

        // Replace any previously attached invoice
        if ($order->etims_invoice_path) {
            Storage::disk('local')->delete($order->etims_invoice_path);
        }

        $file = $request->file('etims_invoice');
        $path = $file->storeAs(
            'etims-invoices',
            $order->order_id . '-' . time() . '.' . $file->getClientOriginalExtension(),
            'local'
        );

        $order->update([
            'etims_requested' => true,
            'etims_invoice_number' => $request->etims_invoice_number,
            'etims_invoice_path' => $path,
        ]);

        try {
            $this->sendEtimsInvoice($order);
            $order->update(['etims_invoice_sent_at' => now()]);
        } catch (\Exception $e) {
            Log::error("Failed to email eTIMS invoice for order {$order->order_id}: " . $e->getMessage());

            return back()->with('error', 'Invoice saved, but the email could not be sent. Use "Resend" to try again.');
        }

        return back()->with('success', "eTIMS invoice attached and sent to {$order->customer_email}.");
    }

    public function resendEtimsInvoice($id)
    {
        $order = CartOrder::findOrFail($id);

        if (!$order->hasEtimsInvoice()) {
            return back()->with('error', 'No eTIMS invoice has been attached to this order yet.');
        }

        try {
            $this->sendEtimsInvoice($order);
            $order->update(['etims_invoice_sent_at' => now()]);
        } catch (\Exception $e) {
            Log::error("Failed to resend eTIMS invoice for order {$order->order_id}: " . $e->getMessage());

            return back()->with('error', 'The email could not be sent. Please check the mail settings.');
        }

        return back()->with('success', "eTIMS invoice resent to {$order->customer_email}.");
    }

    public function downloadEtimsInvoice($id)
    {
        $order = CartOrder::findOrFail($id);

        return $this->etimsInvoiceDownload($order);
    }

    /**
     * Shared by admin and customer download routes.
     */
    public static function etimsInvoiceDownload(CartOrder $order)
    {
        if (!$order->hasEtimsInvoice() || !Storage::disk('local')->exists($order->etims_invoice_path)) {
            abort(404, 'eTIMS invoice not found.');
        }

        $extension = pathinfo($order->etims_invoice_path, PATHINFO_EXTENSION);

        return Storage::disk('local')->download(
            $order->etims_invoice_path,
            'eTIMS-Invoice-' . $order->order_id . '.' . $extension
        );
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:20',
            'delivery_method' => 'required|in:pickup,delivery',
            'delivery_zone' => ['required_if:delivery_method,delivery', 'nullable', 'string', Rule::in(array_merge(array_keys(CartOrder::DELIVERY_ZONE_RATES), ['B']))],
            'county' => 'required_if:delivery_method,delivery|nullable|string|max:100',
            'subcounty' => 'required_if:delivery_method,delivery|nullable|string|max:100',
            'location' => 'required_if:delivery_method,delivery|nullable|string|max:100',
            'address' => 'required_if:delivery_method,delivery|nullable|string|max:500',
            'payment_method' => 'nullable|in:kcb,iveri',
            'etims_requested' => 'nullable|boolean',
            'etims_kra_pin' => ['required_if:etims_requested,1', 'nullable', 'string', 'regex:/^[AP]\d{9}[A-Z]$/i'],
            'etims_business_name' => 'nullable|string|max:255',
        ], [
            'etims_kra_pin.required_if' => 'Please enter your KRA PIN for the eTIMS invoice.',
            'etims_kra_pin.regex' => 'Enter a valid KRA PIN, e.g. A012345678Z.',
        ]);

        $cartItems = session('cart', []);
        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

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

        $deliveryCost = 0;

        if ($request->delivery_method === 'delivery') {
            $deliveryZone = $request->delivery_zone;
            $deliveryCost = CartOrder::DELIVERY_ZONE_RATES[$deliveryZone] ?? 0;
        } else {
            $deliveryZone = 'B'; // Pickup zone
            $validated['county'] = null;
            $validated['subcounty'] = null;
            $validated['location'] = null;
            $validated['address'] = null;
        }

        $totalAmount = $subtotal + $deliveryCost;
        $etimsRequested = $request->boolean('etims_requested');

        $order = CartOrder::create([
            'order_id' => 'ORD-' . strtoupper(Str::random(10)),
            'amount' => $totalAmount,
            'delivery_cost' => $deliveryCost,
            'delivery_zone' => $deliveryZone,
            'delivery_method' => $request->delivery_method,
            'items' => $items,
            'customer_name' => $request->first_name . ' ' . $request->last_name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'county' => $validated['county'],
            'subcounty' => $validated['subcounty'],
            'location' => $validated['location'],
            'address' => $validated['address'],
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'etims_requested' => $etimsRequested,
            'etims_kra_pin' => $etimsRequested ? strtoupper($request->etims_kra_pin) : null,
            'etims_business_name' => $etimsRequested ? $request->etims_business_name : null,
        ]);

        // A mail failure must not block the customer from paying
        try {
            $this->sendOrderNotifications($order);
        } catch (\Exception $e) {
            Log::error("Order notification failed for {$order->order_id}: " . $e->getMessage());
        }

        $token = $this->generateIveriToken(
            $totalAmount * 100, // Convert to cents
            $request->email
        );

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
            'delivery_zone' => $deliveryZone,
            'delivery_method' => $request->delivery_method
        ]);
    }

    protected function sendOrderNotifications($order)
    {
        $customerEmail = $order->customer_email;
        $itemLines = collect($order->items)->map(function ($item) {
            return "- {$item['product']}" .
                   ($item['variant'] ? " ({$item['variant']})" : '') .
                   " (Qty: {$item['quantity']}) @ KES {$item['price']}";
        })->implode("\n");

        $etimsCustomer = $order->etims_requested
            ? "\n\neTIMS invoice: requested (KRA PIN {$order->etims_kra_pin}). We will email your eTIMS invoice once it has been generated."
            : '';

        $etimsSales = $order->etims_requested
            ? "*** eTIMS INVOICE REQUESTED ***\n" .
              "KRA PIN: {$order->etims_kra_pin}\n" .
              "Business Name: " . ($order->etims_business_name ?: $order->customer_name) . "\n" .
              "Generate the invoice on eTIMS and attach it from the admin Orders page.\n\n"
            : '';

        Mail::raw("Thank you for your order #{$order->order_id}.\n\n" .
                   "Order Summary:\n" .
                   "Amount: KES {$order->amount}\n" .
                   "Delivery: " . ($order->delivery_method === 'pickup' ? 'Pickup' : 'Delivery') . "\n" .
                   "Items:\n" . $itemLines .
                   $etimsCustomer .
                   "\n\nWe'll process your order shortly.",
            function ($message) use ($customerEmail, $order) {
                $message->to($customerEmail)
                        ->subject("Your Healthversation Order #{$order->order_id}");
            });

        Mail::raw("New Order Received #{$order->order_id}\n\n" .
                   $etimsSales .
                   "Customer: {$order->customer_name}\n" .
                   "Email: {$order->customer_email}\n" .
                   "Phone: {$order->customer_phone}\n" .
                   "Amount: KES {$order->amount}\n" .
                   "Delivery: " . ($order->delivery_method === 'pickup' ? 'Pickup' : 'Delivery to ' . $order->delivery_zone) . "\n\n" .
                   ($order->delivery_method === 'delivery' ?
                   "Shipping Address:\n" .
                   "{$order->address}, {$order->location}\n" .
                   "{$order->subcounty}, {$order->county}\n\n" :
                   "Pickup Location: TOM MBOYA STREET, STAR MALL, 1st Floor, Shop A17\n\n") .
                   "Items:\n" . $itemLines,
            function ($message) use ($order) {
                $message->to($this->salesEmail)
                        ->subject(($order->etims_requested ? '[eTIMS] ' : '') . "New Order #{$order->order_id} from {$order->customer_name}");
            });
    }

    /**
     * Email the attached eTIMS invoice to the customer, copying sales.
     */
    protected function sendEtimsInvoice(CartOrder $order)
    {
        $filePath = Storage::disk('local')->path($order->etims_invoice_path);
        $fileName = 'eTIMS-Invoice-' . $order->order_id . '.' . pathinfo($filePath, PATHINFO_EXTENSION);

        Mail::raw("Dear {$order->customer_name},\n\n" .
                   "Please find attached your eTIMS invoice for order #{$order->order_id}.\n\n" .
                   ($order->etims_invoice_number ? "Invoice Number: {$order->etims_invoice_number}\n" : '') .
                   "KRA PIN: {$order->etims_kra_pin}\n" .
                   "Amount: KES {$order->amount}\n\n" .
                   "Thank you for shopping with Healthversation.",
            function ($message) use ($order, $filePath, $fileName) {
                $message->to($order->customer_email)
                        ->cc($this->salesEmail)
                        ->subject("eTIMS Invoice for Order #{$order->order_id}")
                        ->attach($filePath, ['as' => $fileName]);
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
