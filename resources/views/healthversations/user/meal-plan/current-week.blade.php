@extends('healthversations.user.layout.userlayout')

@section('title', 'This Week - Health Versation')
@section('page-title', 'Week ' . $activePlan->current_week . ' Meal Plan')

@section('content')
<div class="space-y-6">
    <a href="{{ route('user.meal-plan.dashboard') }}" class="text-primary-600 text-sm hover:underline">← Back to my meal plan</a>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-800">
            Week {{ $activePlan->current_week }}{{ optional($currentWeekPlan)->title ? ': ' . $currentWeekPlan->title : '' }}
        </h2>
        @if(optional($currentWeekPlan)->goals)
            <p class="text-sm text-gray-600 mt-1"><i class="fas fa-bullseye mr-1"></i>{{ $currentWeekPlan->goals }}</p>
        @endif

        @if($currentWeekPlan && $currentWeekPlan->hasContent())
            @if($currentWeekPlan->content)
                <div class="mt-4 text-gray-700 whitespace-pre-line leading-relaxed">{{ $currentWeekPlan->content }}</div>
            @endif
            @if($currentWeekPlan->attachment_path)
                <a href="{{ asset('storage/' . $currentWeekPlan->attachment_path) }}" target="_blank" class="inline-flex items-center mt-4 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm">
                    <i class="fas fa-file-download mr-2"></i>Download this week's plan
                </a>
            @endif
        @else
            <p class="mt-4 text-gray-500">Your nutritionist is still preparing this week's plan. You'll get an email when it's ready.</p>
        @endif
    </div>

    <!-- Weekly assessment -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-1">End-of-week Assessment</h3>
        <p class="text-sm text-gray-500 mb-4">
            {{ $weeklyAssessment ? 'You submitted this week\'s assessment. You can update it below.' : 'Record your measurements and reflections at the end of the week.' }}
        </p>

        @if(optional($weeklyAssessment)->admin_feedback)
            <div class="bg-green-50 border border-green-200 rounded p-4 mb-4 text-sm">
                <strong class="text-green-800">Feedback from your coach:</strong>
                <p class="text-gray-700 mt-1 whitespace-pre-line">{{ $weeklyAssessment->admin_feedback }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('user.meal-plan.submit-assessment') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach(['weight_kg' => 'Weight (kg)', 'body_fat_percentage' => 'Body fat %', 'chest_cm' => 'Chest (cm)', 'waist_cm' => 'Waist (cm)', 'hips_cm' => 'Hips (cm)'] as $field => $label)
                    <div>
                        <label class="block text-sm font-medium mb-1">{{ $label }}</label>
                        <input type="number" step="0.1" name="{{ $field }}" value="{{ old($field, optional($weeklyAssessment)->$field) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
                    </div>
                @endforeach
            </div>
            @foreach(['what_went_well' => 'What went well this week?', 'challenges_faced' => 'What challenges did you face?', 'next_week_goals' => 'Goals for next week'] as $field => $label)
                <div>
                    <label class="block text-sm font-medium mb-1">{{ $label }}</label>
                    <textarea name="{{ $field }}" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old($field, optional($weeklyAssessment)->$field) }}</textarea>
                </div>
            @endforeach
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach(['front_photo' => 'Front photo', 'side_photo' => 'Side photo', 'back_photo' => 'Back photo'] as $field => $label)
                    <div>
                        <label class="block text-sm font-medium mb-1">{{ $label }} (optional)</label>
                        <input type="file" name="{{ $field }}" accept="image/*" class="text-sm">
                        @if(optional($weeklyAssessment)->$field)
                            <a href="{{ asset('storage/' . $weeklyAssessment->$field) }}" target="_blank" class="text-xs text-primary-600 block mt-1">View current</a>
                        @endif
                    </div>
                @endforeach
            </div>
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">{{ $weeklyAssessment ? 'Update' : 'Submit' }} Assessment</button>
        </form>
    </div>
</div>
@endsection
