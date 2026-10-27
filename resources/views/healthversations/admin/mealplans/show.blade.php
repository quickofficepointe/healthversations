@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <a href="{{ route('admin.meal-plans.index') }}" class="text-primary-600 text-sm hover:underline">← All meal plans</a>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded my-4">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mt-2 mb-6">
        <div class="flex flex-col lg:flex-row lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">{{ $plan->title }}</h1>
                <p class="text-gray-600">{{ optional($plan->user)->name }} · {{ optional($plan->user)->email }}</p>
                @if($plan->goal)<p class="text-sm text-gray-500 mt-1"><i class="fas fa-bullseye mr-1"></i>{{ $plan->goal }}</p>@endif
                <p class="text-sm text-gray-500 mt-1">Week {{ $plan->current_week }} of {{ $plan->total_weeks }} · {{ $plan->progressPercent() }}% complete</p>
            </div>
            <div class="flex flex-wrap items-start gap-2">
                <form method="POST" action="{{ route('admin.meal-plans.update-status', $plan) }}" class="flex gap-2">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="border rounded-lg px-3 py-2 text-sm">
                        @foreach(\App\Models\UserMealPlan::STATUSES as $status)
                            <option value="{{ $status }}" @selected($plan->status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('admin.meal-plans.edit', $plan) }}" class="border px-3 py-2 rounded-lg text-sm hover:bg-gray-50"><i class="fas fa-edit mr-1"></i>Edit</a>
                <a href="{{ route('admin.meal-plans.tracking', $plan) }}" class="border px-3 py-2 rounded-lg text-sm hover:bg-gray-50"><i class="fas fa-chart-line mr-1"></i>Tracking</a>
                <a href="{{ route('admin.meal-plans.assessments', $plan) }}" class="border px-3 py-2 rounded-lg text-sm hover:bg-gray-50"><i class="fas fa-clipboard-check mr-1"></i>Assessments</a>
                <form method="POST" action="{{ route('admin.meal-plans.destroy', $plan) }}" onsubmit="return confirm('Delete this meal plan and all its tracking data?')">
                    @csrf
                    @method('DELETE')
                    <button class="border border-red-300 text-red-600 px-3 py-2 rounded-lg text-sm hover:bg-red-50"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
        @if($plan->admin_notes)
            <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded p-3 text-sm text-gray-700"><strong>Notes:</strong> {{ $plan->admin_notes }}</div>
        @endif
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Weeks -->
        <div class="xl:col-span-2 space-y-4">
            @foreach($plan->weeklyPlans as $week)
                @php $assessment = $plan->assessments->firstWhere('week_number', $week->week_number); @endphp
                <details class="bg-white rounded-lg shadow" @if($week->week_number == $plan->current_week) open @endif>
                    <summary class="px-6 py-4 cursor-pointer flex flex-wrap items-center gap-3">
                        <span class="font-semibold text-gray-800">Week {{ $week->week_number }}{{ $week->title ? ': ' . $week->title : '' }}</span>
                        @if($week->is_completed)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                        @elseif($week->week_number == $plan->current_week)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800">Current</span>
                        @endif
                        @unless($week->hasContent())
                            <span class="px-2 py-0.5 text-xs rounded-full bg-orange-100 text-orange-800">No content yet</span>
                        @endunless
                        @if($assessment)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-purple-100 text-purple-800">Assessment submitted</span>
                        @endif
                    </summary>
                    <form method="POST" action="{{ route('admin.meal-plans.upload-week', [$plan, $week->week_number]) }}" enctype="multipart/form-data" class="px-6 pb-6 space-y-4 border-t pt-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Week title</label>
                                <input type="text" name="title" value="{{ $week->title }}" maxlength="255" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="e.g. Detox & Hydration">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Goals for the week</label>
                                <input type="text" name="goals" value="{{ $week->goals }}" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="e.g. 2.5L water daily, 8k steps">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Meal plan &amp; instructions</label>
                            <textarea name="content" rows="8" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="Breakfast, lunch, dinner, snacks, shopping list…">{{ $week->content }}</textarea>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center gap-3">
                            <input type="file" name="attachment" accept=".pdf,.jpg,.jpeg,.png" class="text-sm">
                            @if($week->attachment_path)
                                <a href="{{ asset('storage/' . $week->attachment_path) }}" target="_blank" class="text-primary-600 text-sm hover:underline"><i class="fas fa-paperclip mr-1"></i>Current attachment</a>
                                <label class="text-sm text-gray-600"><input type="checkbox" name="remove_attachment" value="1" class="mr-1">Remove</label>
                            @endif
                        </div>
                        <div class="flex flex-wrap justify-end gap-2">
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm">Save Week {{ $week->week_number }}</button>
                        </div>
                    </form>
                    @unless($week->is_completed)
                        <form method="POST" action="{{ route('admin.meal-plans.complete-week', [$plan, $week->week_number]) }}" class="px-6 pb-6 -mt-4 flex justify-end" onsubmit="return confirm('Mark week {{ $week->week_number }} as completed?')">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm"><i class="fas fa-check mr-1"></i>Mark Week Complete</button>
                        </form>
                    @endunless
                </details>
            @endforeach
        </div>

        <!-- Last 7 days -->
        <div class="bg-white rounded-lg shadow p-6 self-start">
            <h2 class="font-semibold text-gray-800 mb-4">Last 7 days</h2>
            @forelse($recentTracking as $day)
                <div class="flex justify-between items-center py-2 border-b last:border-0 text-sm">
                    <span>{{ $day->tracking_date->format('D, M d') }}</span>
                    <span class="font-semibold {{ $day->daily_score >= 70 ? 'text-green-600' : ($day->daily_score >= 40 ? 'text-yellow-600' : 'text-red-600') }}">{{ $day->daily_score }}/100</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">The client hasn't logged any days yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
