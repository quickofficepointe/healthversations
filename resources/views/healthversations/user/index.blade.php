{{-- resources/views/healthversations/user/dashboard.blade.php --}}
@extends('healthversations.user.layout.userlayout')

@section('title', 'Dashboard - Health Versation')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl p-6 text-white">
        <h2 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h2>
        <p class="text-primary-100">Here's what's happening with your account today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalOrders ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                </div>
            </div>
            <a href="{{ route('user.orders') }}" class="text-primary-600 text-sm mt-4 inline-block hover:underline">
                View Details →
            </a>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Consultations</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalConsultations ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                </div>
            </div>
            <a href="{{ route('user.consultations') }}" class="text-primary-600 text-sm mt-4 inline-block hover:underline">
                View Details →
            </a>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Ebooks Purchased</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalEbooks ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-book-open text-purple-600 text-xl"></i>
                </div>
            </div>
            <a href="{{ route('user.ebooks') }}" class="text-primary-600 text-sm mt-4 inline-block hover:underline">
                View Details →
            </a>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Reviews Written</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalReviews ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
            </div>
            <a href="{{ route('user.reviews') }}" class="text-primary-600 text-sm mt-4 inline-block hover:underline">
                View Details →
            </a>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
            <a href="{{ route('user.orders') }}" class="text-primary-600 text-sm hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentOrders ?? [] as $order)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">${{ number_format($order->total_amount ?? $order->total, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="status-badge status-{{ strtolower($order->status ?? 'pending') }}">
                                {{ ucfirst($order->status ?? 'Pending') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('user.orders.show', $order->id) }}" class="text-primary-600 hover:text-primary-700 text-sm">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-shopping-bag text-4xl mb-2 block"></i>
                            No orders yet.
                            <a href="{{ route('all.products') }}" class="text-primary-600 block mt-2">Start Shopping →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Ebooks -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Recent Ebook Purchases</h3>
            <a href="{{ route('user.ebooks') }}" class="text-primary-600 text-sm hover:underline">View All</a>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recentEbooks ?? [] as $ebook)
            <div class="p-6 hover:bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-medium text-gray-800">{{ $ebook->ebook->title ?? 'Ebook' }}</h4>
                        <p class="text-sm text-gray-500">Purchased: {{ $ebook->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <span class="status-badge status-{{ $ebook->payment_status === 'completed' ? 'completed' : 'pending' }}">
                            {{ ucfirst($ebook->payment_status ?? 'Pending') }}
                        </span>
                        @if($ebook->payment_status === 'completed')
                        <a href="{{ route('user.ebooks.download', $ebook->id) }}" class="text-primary-600 hover:text-primary-700">
                            <i class="fas fa-download"></i> Download
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-book-open text-4xl mb-2 block"></i>
                No ebook purchases yet.
                <a href="{{ route('ebooks.show') }}" class="text-primary-600 block mt-2">Browse Ebooks →</a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
