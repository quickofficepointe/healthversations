@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Dashboard Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
        <div class="text-sm text-gray-500">Last updated: {{ now()->format('M d, Y h:i A') }}</div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        <!-- Subscribers -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 font-medium">Subscribers</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $subscribers->count() }}</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="h-2 bg-gray-100 rounded-full">
                    <div class="h-2 bg-blue-500 rounded-full" style="width: {{ min(($subscribers->count()/1000)*100, 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $subscribers->count() }} total subscribers</p>
            </div>
        </div>

        <!-- Messages {{ route('all.messages') }} -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 font-medium">Messages</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $contacts->count() }}</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-envelope text-green-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="h-2 bg-gray-100 rounded-full">
                    <div class="h-2 bg-green-500 rounded-full" style="width: {{ min(($contacts->count()/500)*100, 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $contacts->where('created_at', '>=', now()->subMonth())->count() }} new this month</p>
            </div>
        </div>

        <!-- Orders -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 font-medium">Orders</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $orders->count() }}</h3>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-shopping-cart text-purple-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="h-2 bg-gray-100 rounded-full">
                    <div class="h-2 bg-purple-500 rounded-full" style="width: {{ min(($orders->count()/500)*100, 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">${{ number_format($orders->sum('total'), 2) }} total revenue</p>
            </div>
        </div>

        <!-- Blogs -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 font-medium">Blog Posts</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $blogs->count() }}</h3>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-blog text-yellow-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="h-2 bg-gray-100 rounded-full">
                    <div class="h-2 bg-yellow-500 rounded-full" style="width: {{ min(($blogs->count()/100)*100, 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $blogs->where('published', true)->count() }} published</p>
            </div>
        </div>

        <!-- Custom Packages -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 font-medium">Custom Packages</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $customPackages->count() }}</h3>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-boxes text-red-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="h-2 bg-gray-100 rounded-full">
                    <div class="h-2 bg-red-500 rounded-full" style="width: {{ min(($customPackages->count()/50)*100, 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $customPackages->where('is_active', true)->count() }} active</p>
            </div>
        </div>

        <!-- Products -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 font-medium">Products</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $products->count() }}</h3>
                </div>
                <div class="bg-indigo-100 p-3 rounded-full">
                    <i class="fas fa-box-open text-indigo-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="h-2 bg-gray-100 rounded-full">
                    <div class="h-2 bg-indigo-500 rounded-full" style="width: {{ min(($products->count()/200)*100, 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $products->where('in_stock', '>', 0)->count() }} in stock</p>
            </div>
        </div>

        <!-- Reviews -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-pink-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 font-medium">Reviews</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $reviews->count() }}</h3>
                </div>
                <div class="bg-pink-100 p-3 rounded-full">
                    <i class="fas fa-star text-pink-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="h-2 bg-gray-100 rounded-full">
                    <div class="h-2 bg-pink-500 rounded-full" style="width: {{ ($reviews->avg('rating')/5)*100 }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Avg rating: {{ number_format($reviews->avg('rating'), 1) }}/5</p>
            </div>
        </div>
    </div>
<!-- Updated Charts Section with Chart.js -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Monthly Orders Chart -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Orders</h3>
        <div class="h-64">
            <canvas id="ordersChart"></canvas>
        </div>
    </div>

    <!-- Subscriber Growth Chart -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Subscriber Growth</h3>
        <div class="h-64">
            <canvas id="subscribersChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
    <div class="space-y-4">
        @foreach($recentActivities as $activity)
        <div class="flex items-start">
            <div class="bg-{{ $activity['color'] }}-100 p-2 rounded-full mr-4">
                <i class="fas fa-{{ $activity['icon'] }} text-{{ $activity['color'] }}-500"></i>
            </div>
            <div>
                <p class="text-sm font-medium">{{ $activity['title'] }}</p>
                <p class="text-xs text-gray-500">{{ $activity['description'] }} - {{ $activity['time'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
// Orders Chart
const ordersCtx = document.getElementById('ordersChart');
new Chart(ordersCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($ordersByMonth->pluck('month')) !!},
        datasets: [{
            label: 'Orders',
            data: {!! json_encode($ordersByMonth->pluck('count')) !!},
            backgroundColor: '#8b5cf6',
            borderColor: '#7c3aed',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Subscribers Chart
const subsCtx = document.getElementById('subscribersChart');
new Chart(subsCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($subscribersByMonth->pluck('month')) !!},
        datasets: [{
            label: 'Subscribers',
            data: {!! json_encode($subscribersByMonth->pluck('count')) !!},
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            borderColor: '#10b981',
            borderWidth: 2,
            tension: 0.1,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
});
</script>
@endsection
