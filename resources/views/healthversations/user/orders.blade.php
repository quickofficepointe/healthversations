@extends('healthversations.user.layout.userlayout')

@section('title', 'My Orders - Health Versation')
@section('page-title', 'My Orders')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">eTIMS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $order->order_id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">KES {{ number_format($order->amount, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="status-badge status-{{ strtolower($order->status ?? 'pending') }}">{{ ucfirst($order->status ?? 'Pending') }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($order->hasEtimsInvoice())
                                <a href="{{ route('user.orders.etims', $order->id) }}" class="text-primary-600 hover:underline"><i class="fas fa-download mr-1"></i>Invoice</a>
                            @elseif($order->etims_requested)
                                <span class="text-gray-500">Being prepared</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('user.orders.show', $order->id) }}" class="text-primary-600 hover:text-primary-700 text-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <i class="fas fa-shopping-bag text-4xl mb-2 block"></i>
                            No orders yet.
                            <a href="{{ route('all.products') }}" class="text-primary-600 block mt-2">Start Shopping →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t">{{ $orders->links() }}</div>
</div>
@endsection
