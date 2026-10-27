@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <a href="{{ route('admin.meal-plans.show', $plan) }}" class="text-primary-600 text-sm hover:underline">← {{ $plan->title }}</a>
    <h1 class="text-2xl font-semibold text-gray-800 mt-2 mb-6">Weekly Assessments — {{ optional($plan->user)->name }}</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <div class="space-y-6">
        @forelse($plan->assessments as $assessment)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-semibold text-gray-800">Week {{ $assessment->week_number }}</h2>
                    <span class="text-xs text-gray-500">Submitted {{ $assessment->updated_at->format('M d, Y') }}</span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-sm mb-4">
                    @foreach(['weight_kg' => 'Weight (kg)', 'body_fat_percentage' => 'Body fat %', 'chest_cm' => 'Chest (cm)', 'waist_cm' => 'Waist (cm)', 'hips_cm' => 'Hips (cm)'] as $field => $label)
                        <div class="bg-gray-50 rounded p-3">
                            <div class="text-xs text-gray-500">{{ $label }}</div>
                            <div class="font-semibold">{{ $assessment->$field ?? '—' }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm mb-4">
                    <div><div class="font-medium text-gray-700">What went well</div><p class="text-gray-600">{{ $assessment->what_went_well ?: '—' }}</p></div>
                    <div><div class="font-medium text-gray-700">Challenges</div><p class="text-gray-600">{{ $assessment->challenges_faced ?: '—' }}</p></div>
                    <div><div class="font-medium text-gray-700">Next week's goals</div><p class="text-gray-600">{{ $assessment->next_week_goals ?: '—' }}</p></div>
                </div>

                @if($assessment->front_photo || $assessment->side_photo || $assessment->back_photo)
                    <div class="flex gap-3 mb-4">
                        @foreach(['front_photo' => 'Front', 'side_photo' => 'Side', 'back_photo' => 'Back'] as $field => $label)
                            @if($assessment->$field)
                                <a href="{{ asset('storage/' . $assessment->$field) }}" target="_blank" class="text-center">
                                    <img src="{{ asset('storage/' . $assessment->$field) }}" alt="{{ $label }}" class="w-24 h-32 object-cover rounded border">
                                    <span class="text-xs text-gray-500">{{ $label }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.meal-plans.add-feedback', [$plan, $assessment->week_number]) }}" class="border-t pt-4">
                    @csrf
                    <label class="block text-sm font-medium mb-1">
                        Your feedback
                        @if($assessment->feedback_at)<span class="text-xs text-gray-500 font-normal">(sent {{ $assessment->feedback_at->format('M d, Y H:i') }})</span>@endif
                    </label>
                    <textarea name="admin_feedback" rows="3" required class="w-full border rounded-lg px-3 py-2 text-sm">{{ $assessment->admin_feedback }}</textarea>
                    <div class="flex justify-end mt-2">
                        <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm">{{ $assessment->admin_feedback ? 'Update' : 'Send' }} Feedback</button>
                    </div>
                </form>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-10 text-center text-gray-500">No weekly assessments submitted yet.</div>
        @endforelse
    </div>
</div>
@endsection
