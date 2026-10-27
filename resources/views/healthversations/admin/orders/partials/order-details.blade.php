<div class="space-y-6 text-sm">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h4 class="font-semibold text-gray-700 mb-2">Customer</h4>
            <p>{{ $order->customer_name }}</p>
            <p class="text-gray-600">{{ $order->customer_email }}</p>
            <p class="text-gray-600">{{ $order->customer_phone }}</p>
        </div>
        <div>
            <h4 class="font-semibold text-gray-700 mb-2">Order</h4>
            <p><span class="text-gray-500">ID:</span> {{ $order->order_id }}</p>
            <p><span class="text-gray-500">Date:</span> {{ $order->created_at->format('M d, Y H:i') }}</p>
            <p><span class="text-gray-500">Status:</span> {{ ucfirst($order->status) }}</p>
            @if($order->kcb_invoice_number)
                <p><span class="text-gray-500">M-Pesa invoice:</span> {{ $order->kcb_invoice_number }}</p>
            @endif
        </div>
    </div>

    <div>
        <h4 class="font-semibold text-gray-700 mb-2">Delivery</h4>
        @if($order->delivery_method === 'delivery')
            <p>Home delivery — Zone {{ $order->delivery_zone }} (KES {{ number_format($order->delivery_cost, 2) }})</p>
            <p class="text-gray-600">{{ $order->address }}, {{ $order->location }}, {{ $order->subcounty }}, {{ $order->county }}</p>
        @else
            <p>Pickup — TOM MBOYA STREET, STAR MALL, 1st Floor, Shop A17</p>
        @endif
    </div>

    <div>
        <h4 class="font-semibold text-gray-700 mb-2">Items</h4>
        <table class="w-full border text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2">Product</th>
                    <th class="px-3 py-2">Qty</th>
                    <th class="px-3 py-2 text-right">Price</th>
                    <th class="px-3 py-2 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="border-t">
                        <td class="px-3 py-2">{{ $item['product'] ?? '-' }}@if(!empty($item['variant'])) <span class="text-gray-500">({{ $item['variant'] }})</span>@endif</td>
                        <td class="px-3 py-2">{{ $item['quantity'] ?? 1 }}</td>
                        <td class="px-3 py-2 text-right">KES {{ number_format($item['price'] ?? 0, 2) }}</td>
                        <td class="px-3 py-2 text-right">KES {{ number_format($item['total'] ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-3 py-3 text-center text-gray-500">No items recorded.</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="border-t font-semibold">
                    <td colspan="3" class="px-3 py-2 text-right">Grand Total</td>
                    <td class="px-3 py-2 text-right">KES {{ number_format($order->amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if($order->etims_requested)
        <div class="border border-orange-200 bg-orange-50 rounded-lg p-4">
            <h4 class="font-semibold text-orange-800 mb-2"><i class="fas fa-file-invoice mr-1"></i>eTIMS Invoice</h4>
            <p><span class="text-gray-600">KRA PIN:</span> {{ $order->etims_kra_pin }}</p>
            <p><span class="text-gray-600">Invoice name:</span> {{ $order->etims_business_name ?: $order->customer_name }}</p>
            @if($order->etims_invoice_path)
                @if($order->etims_invoice_number)
                    <p><span class="text-gray-600">Invoice number:</span> {{ $order->etims_invoice_number }}</p>
                @endif
                <p><span class="text-gray-600">Sent:</span> {{ optional($order->etims_invoice_sent_at)->format('M d, Y H:i') ?? 'Not emailed yet' }}</p>
                <div class="flex gap-2 mt-3">
                    <a href="{{ route('admin.cart-orders.etims.download', $order->id) }}" class="bg-white border px-3 py-1 rounded text-xs hover:bg-gray-50">
                        <i class="fas fa-download mr-1"></i>Download
                    </a>
                    <form action="{{ route('admin.cart-orders.etims.resend', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-xs">
                            <i class="fas fa-paper-plane mr-1"></i>Resend to customer
                        </button>
                    </form>
                </div>
            @else
                <p class="text-orange-700 mt-2">Awaiting upload — generate the invoice on eTIMS and attach it from the orders list.</p>
            @endif
        </div>
    @endif
</div>
