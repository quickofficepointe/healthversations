@extends('healthversations.admin.layout.adminlayout')

@section('content')
@php
    $statusColors = [
        'active' => 'bg-green-100 text-green-800',
        'paused' => 'bg-yellow-100 text-yellow-800',
        'completed' => 'bg-blue-100 text-blue-800',
        'cancelled' => 'bg-gray-200 text-gray-700',
    ];
@endphp
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Meal Plans</h1>
        <a href="{{ route('admin.meal-plans.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm">
            <i class="fas fa-plus mr-1"></i> New Meal Plan
        </a>
    </div>

    <form method="GET" class="bg-white rounded-lg shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Plan title, client name or email" class="border rounded-lg px-3 py-2 text-sm">
        <select name="status" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">All statuses</option>
            @foreach(\App\Models\UserMealPlan::STATUSES as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <div class="flex gap-2">
            <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
            <a href="{{ route('admin.meal-plans.index') }}" class="px-4 py-2 rounded-lg text-sm border text-gray-600">Reset</a>
        </div>
    </form>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Plan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progress</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($plans as $plan)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">{{ optional($plan->user)->name ?? 'Deleted user' }}</div>
                                <div class="text-xs text-gray-500">{{ optional($plan->user)->email }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900">{{ $plan->title }}</div>
                                <div class="text-xs text-gray-500">{{ $plan->total_weeks }} weeks · started {{ optional($plan->start_date)->format('M d, Y') ?? '—' }}</div>
                            </td>
                            <td class="px-4 py-3 w-48">
                                <div class="text-xs text-gray-600 mb-1">Week {{ $plan->current_week }} of {{ $plan->total_weeks }}</div>
                                <div class="h-2 bg-gray-100 rounded-full">
                                    <div class="h-2 bg-primary-600 rounded-full" style="width: {{ $plan->progressPercent() }}%"></div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$plan->status] ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst($plan->status) }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.meal-plans.show', $plan) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-1 rounded text-xs">Manage</a>
                                    <a href="{{ route('admin.meal-plans.tracking', $plan) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs">Tracking</a>
                                    <a href="{{ route('admin.meal-plans.assessments', $plan) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs">Assessments</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-gray-500">No meal plans yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t">{{ $plans->links() }}</div>
    </div>
</div>
@endsection
