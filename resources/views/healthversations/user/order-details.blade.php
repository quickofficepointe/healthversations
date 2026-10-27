@extends('healthversations.user.layout.userlayout')

@section('title', 'Order ' . $order->order_id . ' - Health Versation')
@section('page-title', 'Order Details')

@section('content')
<div class="space-y-6">
    <a href="{{ route('user.orders') }}" class="text-primary-600 text-sm hover:underline">← Back to orders</a>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">{{ $order->order_id }}</h2>
                <p class="text-sm text-gray-500">Placed {{ $order->created_at->format('M d, Y \a\t H:i') }}</p>
            </div>
            <span class="status-badge status-{{ strtolower($order->status ?? 'pending') }} self-start">{{ ucfirst($order->status ?? 'Pending') }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Qty</th>
                        <th class="px-4 py-2 text-right">Price</th>
                        <th class="px-4 py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($order->items ?? [] as $item)
                        <tr>
                            <td class="px-4 py-2">{{ $item['product'] ?? '-' }}@if(!empty($item['variant'])) <span class="text-gray-500">({{ $item['variant'] }})</span>@endif</td>
                            <td class="px-4 py-2">{{ $item['quantity'] ?? 1 }}</td>
                            <td class="px-4 py-2 text-right">KES {{ number_format($item['price'] ?? 0, 2) }}</td>
                            <td class="px-4 py-2 text-right">KES {{ number_format($item['total'] ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t">
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-right text-gray-600">Delivery</td>
                        <td class="px-4 py-2 text-right">KES {{ number_format($order->delivery_cost, 2) }}</td>
                    </tr>
                    <tr class="font-semibold">
                        <td colspan="3" class="px-4 py-2 text-right">Total</td>
                        <td class="px-4 py-2 text-right">KES {{ number_format($order->amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 text-sm">
            <h3 class="font-semibold text-gray-800 mb-3">Delivery</h3>
            @if($order->delivery_method === 'delivery')
                <p>Home delivery (Zone {{ $order->delivery_zone }})</p>
                <p class="text-gray-600 mt-1">{{ $order->address }}, {{ $order->location }}<br>{{ $order->subcounty }}, {{ $order->county }}</p>
            @else
                <p>Pickup</p>
                <p class="text-gray-600 mt-1">TOM MBOYA STREET, STAR MALL, 1st Floor, Shop A17</p>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 text-sm">
            <h3 class="font-semibold text-gray-800 mb-3">eTIMS Invoice</h3>
            @if($order->hasEtimsInvoice())
                <p class="text-gray-600 mb-1">KRA PIN: {{ $order->etims_kra_pin }}</p>
                @if($order->etims_invoice_number)
                    <p class="text-gray-600 mb-3">Invoice No: {{ $order->etims_invoice_number }}</p>
                @endif
                <a href="{{ route('user.orders.etims', $order->id) }}" class="inline-flex items-center bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-download mr-2"></i>Download eTIMS Invoice
                </a>
            @elseif($order->etims_requested)
                <p class="text-gray-600">Requested for KRA PIN {{ $order->etims_kra_pin }}. We'll email it to you and it will appear here once ready.</p>
            @else
                <p class="text-gray-500">No eTIMS invoice was requested for this order.</p>
            @endif
        </div>
    </div>
</div>
@endsection
