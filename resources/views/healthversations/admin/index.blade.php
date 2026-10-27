@extends('healthversations.admin.layout.adminlayout')

@section('content')
@php
    $cards = [
        ['label' => 'Product Orders', 'value' => number_format($orderCount), 'sub' => $pendingOrders . ' pending', 'icon' => 'shopping-cart', 'color' => 'purple', 'route' => route('admin.cart-orders.index')],
        ['label' => 'Paid Revenue', 'value' => 'KES ' . number_format($revenue), 'sub' => 'Confirmed & completed orders', 'icon' => 'coins', 'color' => 'green', 'route' => route('admin.cart-orders.index', ['status' => 'completed'])],
        ['label' => 'eTIMS Awaiting Upload', 'value' => $etimsPending, 'sub' => 'Invoices to generate', 'icon' => 'file-invoice', 'color' => 'orange', 'route' => route('admin.cart-orders.index', ['etims' => 'pending'])],
        ['label' => 'Consultations', 'value' => number_format($consultationCount), 'sub' => $pendingConsultations . ' pending', 'icon' => 'calendar-check', 'color' => 'teal', 'route' => route('admin.const-orders.index')],
        ['label' => 'Ebook Orders', 'value' => number_format($ebookOrderCount), 'sub' => 'All time', 'icon' => 'book-open', 'color' => 'indigo', 'route' => route('admin.ebook-orders.index')],
        ['label' => 'Messages', 'value' => number_format($contactCount), 'sub' => $newContacts . ' new this month', 'icon' => 'envelope', 'color' => 'blue', 'route' => route('all.messages')],
        ['label' => 'Products', 'value' => number_format($productCount), 'sub' => $inStockCount . ' in stock', 'icon' => 'box-open', 'color' => 'pink', 'route' => route('products.index')],
        ['label' => 'Reviews', 'value' => number_format($reviewCount), 'sub' => 'Avg ' . number_format($avgRating, 1) . '/5 · ' . $pendingReviews . ' to approve', 'icon' => 'star', 'color' => 'yellow', 'route' => route('admin.reviews.index')],
    ];
    $statusColors = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'confirmed' => 'bg-blue-100 text-blue-800',
        'processing' => 'bg-indigo-100 text-indigo-800',
        'completed' => 'bg-green-100 text-green-800',
        'failed' => 'bg-red-100 text-red-800',
        'cancelled' => 'bg-gray-200 text-gray-700',
    ];
@endphp
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
        <div class="text-sm text-gray-500">Last updated: {{ now()->format('M d, Y h:i A') }}</div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        @foreach($cards as $card)
            <a href="{{ $card['route'] }}" class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-{{ $card['color'] }}-500 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 font-medium">{{ $card['label'] }}</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $card['value'] }}</h3>
                    </div>
                    <div class="bg-{{ $card['color'] }}-100 p-3 rounded-full">
                        <i class="fas fa-{{ $card['icon'] }} text-{{ $card['color'] }}-500 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-4">{{ $card['sub'] }}</p>
            </a>
        @endforeach
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Orders &amp; Paid Revenue (6 months)</h3>
            <div class="h-64"><canvas id="ordersChart"></canvas></div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">New Subscribers (6 months)</h3>
            <div class="h-64"><canvas id="subscribersChart"></canvas></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Recent Product Orders</h3>
                <a href="{{ route('admin.cart-orders.index') }}" class="text-primary-600 text-sm hover:underline">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="px-4 py-2">
                                    {{ $order->order_id }}
                                    @if($order->etims_requested)
                                        <span class="ml-1 px-1.5 py-0.5 text-[10px] font-semibold rounded bg-orange-100 text-orange-800">eTIMS</span>
                                    @endif
                                    <div class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-4 py-2">{{ $order->customer_name }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">KES {{ number_format($order->amount, 2) }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst($order->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                    <div class="flex items-start">
                        <div class="bg-{{ $activity['color'] }}-100 p-2 rounded-full mr-4">
                            <i class="fas fa-{{ $activity['icon'] }} text-{{ $activity['color'] }}-500"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ $activity['title'] }}</p>
                            <p class="text-xs text-gray-500">{{ $activity['description'] }} · {{ $activity['at']->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No recent activity.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = @json($chartLabels);

    new Chart(document.getElementById('ordersChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [
                { label: 'Orders', data: @json($ordersByMonth), backgroundColor: '#8b5cf6', yAxisID: 'y', order: 2 },
                // Lower order draws on top, so the revenue line stays visible over the bars
                { label: 'Paid revenue (KES)', data: @json($revenueByMonth), type: 'line', borderColor: '#10b981', backgroundColor: '#10b981', tension: 0.3, yAxisID: 'y1', order: 1 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 }, position: 'left' },
                y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } }
            }
        }
    });

    new Chart(document.getElementById('subscribersChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Subscribers',
                data: @json($subscribersByMonth),
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderColor: '#3b82f6',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
            plugins: { legend: { display: false } }
        }
    });
});
</script>
@endsection
