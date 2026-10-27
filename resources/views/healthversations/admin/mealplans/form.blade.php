@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-3xl">
    <a href="{{ $plan->exists ? route('admin.meal-plans.show', $plan) : route('admin.meal-plans.index') }}" class="text-primary-600 text-sm hover:underline">← Back</a>
    <h1 class="text-2xl font-semibold text-gray-800 mt-2 mb-6">{{ $plan->exists ? 'Edit Meal Plan' : 'New Meal Plan' }}</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ $plan->exists ? route('admin.meal-plans.update', $plan) : route('admin.meal-plans.store') }}" class="bg-white rounded-lg shadow p-6 space-y-5">
        @csrf
        @if($plan->exists) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium mb-1">Client <span class="text-red-500">*</span></label>
            <select name="user_id" required class="w-full border rounded-lg px-3 py-2 text-sm">
                <option value="">Select a client…</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id', $plan->user_id) == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Plan title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $plan->title) }}" required maxlength="255" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="e.g. 8-Week Weight Loss Plan">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Goal</label>
                <input type="text" name="goal" value="{{ old('goal', $plan->goal) }}" maxlength="255" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="e.g. Lose 5kg, manage blood sugar">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('description', $plan->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Total weeks <span class="text-red-500">*</span></label>
                <input type="number" name="total_weeks" min="1" max="52" value="{{ old('total_weeks', $plan->total_weeks) }}" required class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
            @if($plan->exists)
                <div>
                    <label class="block text-sm font-medium mb-1">Current week</label>
                    <input type="number" name="current_week" min="1" max="52" value="{{ old('current_week', $plan->current_week) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
            @endif
            <div>
                <label class="block text-sm font-medium mb-1">Start date</label>
                <input type="date" name="start_date" value="{{ old('start_date', optional($plan->start_date)->toDateString()) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">End date</label>
                <input type="date" name="end_date" value="{{ old('end_date', optional($plan->end_date)->toDateString()) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border rounded-lg px-3 py-2 text-sm">
                    @foreach(\App\Models\UserMealPlan::STATUSES as $status)
                        <option value="{{ $status }}" @selected(old('status', $plan->status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Private notes (admin only)</label>
            <textarea name="admin_notes" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('admin_notes', $plan->admin_notes) }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg text-sm">{{ $plan->exists ? 'Save Changes' : 'Create Plan' }}</button>
        </div>
    </form>
</div>
@endsection
