@extends('healthversations.user.layout.userlayout')

@section('title', 'My Meal Plan - Health Versation')
@section('page-title', 'My Meal Plan')

@section('content')
@if(!$activePlan)
    <div class="bg-white rounded-xl shadow-sm p-10 text-center">
        <i class="fas fa-apple-alt text-5xl text-primary-600 mb-4 block"></i>
        <h2 class="text-xl font-semibold text-gray-800 mb-2">No active meal plan</h2>
        <p class="text-gray-500 mb-4">Once your nutritionist sets up a plan for you, it will appear here.</p>
        <a href="{{ route('consultations.create') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white px-5 py-2 rounded-lg">Book a Consultation</a>
    </div>

    @if($completedPlans->isNotEmpty())
        <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
            <h3 class="font-semibold text-gray-800 mb-3">Completed plans</h3>
            @foreach($completedPlans as $plan)
                <p class="text-sm text-gray-600 py-1">{{ $plan->title }} · {{ $plan->total_weeks }} weeks · finished {{ $plan->updated_at->format('M d, Y') }}</p>
            @endforeach
        </div>
    @endif
@else
@php
    $currentWeek = $activePlan->weeklyPlans->firstWhere('week_number', $activePlan->current_week);
    $t = $todayTracking;
@endphp
<div class="space-y-6">
    <!-- Plan header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl p-6 text-white">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold">{{ $activePlan->title }}</h2>
                @if($activePlan->goal)<p class="text-primary-100"><i class="fas fa-bullseye mr-1"></i>{{ $activePlan->goal }}</p>@endif
                <p class="text-primary-100 mt-1">Week {{ $activePlan->current_week }} of {{ $activePlan->total_weeks }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('user.meal-plan.current-week') }}" class="bg-white text-primary-700 px-4 py-2 rounded-lg text-sm font-medium">This Week's Plan</a>
                <a href="{{ route('user.meal-plan.weekly-summary') }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-sm font-medium">Weekly Summary</a>
            </div>
        </div>
        <div class="h-2 bg-white/20 rounded-full mt-4">
            <div class="h-2 bg-white rounded-full" style="width: {{ $activePlan->progressPercent() }}%"></div>
        </div>
    </div>

    @if($currentWeek && $currentWeek->goals)
        <div class="bg-white rounded-xl shadow-sm p-4 text-sm"><strong>This week's goals:</strong> {{ $currentWeek->goals }}</div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Daily tracker -->
        <form id="trackingForm" class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Today's Check-in</h3>
                <span class="text-sm">Score: <strong id="dailyScore">{{ optional($t)->daily_score ?? 0 }}</strong>/100</span>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Water (litres)</label>
                    <input type="number" step="0.1" min="0" max="20" name="water_intake_liters" value="{{ optional($t)->water_intake_liters }}" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Sleep (hours)</label>
                    <input type="number" step="0.5" min="0" max="24" name="sleep_hours" value="{{ optional($t)->sleep_hours }}" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Steps</label>
                    <input type="number" min="0" name="steps_count" value="{{ optional($t)->steps_count }}" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Cardio (minutes)</label>
                    <input type="number" min="0" name="cardio_minutes" value="{{ optional($t)->cardio_minutes }}" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 text-sm">
                @foreach(['walked_today' => 'Went for a walk', 'exercised_today' => 'Exercised', 'did_cardio' => 'Did cardio', 'lifted_weights' => 'Lifted weights', 'ate_breakfast' => 'Ate breakfast', 'ate_lunch' => 'Ate lunch', 'ate_dinner' => 'Ate dinner'] as $field => $label)
                    <label class="flex items-center"><input type="checkbox" name="{{ $field }}" value="1" class="mr-2" @checked(optional($t)->$field)>{{ $label }}</label>
                @endforeach
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Mood (1–5)</label>
                    <input type="number" min="1" max="5" name="mood_rating" value="{{ optional($t)->mood_rating }}" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Energy (1–5)</label>
                    <input type="number" min="1" max="5" name="energy_rating" value="{{ optional($t)->energy_rating }}" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Notes</label>
                <textarea name="exercise_notes" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="How did today go?">{{ optional($t)->exercise_notes }}</textarea>
            </div>
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg">Save Check-in</button>
        </form>

        <!-- Meal log -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Log a Meal</h3>
            <form id="mealForm" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Meal</label>
                    <select name="meal_type" class="w-full border rounded-lg px-3 py-2 text-sm">
                        @foreach(\App\Models\UserDailyMealLog::MEAL_TYPES as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">What did you eat?</label>
                    <textarea name="food_items" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="e.g. 2 boiled eggs, avocado, green tea"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Photo (optional)</label>
                    <input type="file" name="photo" accept="image/*" class="text-sm">
                </div>
                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg">Save Meal</button>
            </form>

            <h4 class="font-medium text-gray-700 mt-6 mb-2">Logged today</h4>
            <div class="space-y-2 text-sm">
                @forelse($todayMeals as $type => $log)
                    <div class="flex justify-between bg-gray-50 rounded p-2">
                        <span><strong>{{ ucfirst($type) }}:</strong> {{ $log->food_items ?: '—' }}</span>
                        @if($log->photo_path)<a href="{{ asset('storage/' . $log->photo_path) }}" target="_blank" class="text-primary-600"><i class="fas fa-image"></i></a>@endif
                    </div>
                @empty
                    <p class="text-gray-500">Nothing logged yet today.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
(function () {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    async function post(url, body) {
        const res = await fetch(url, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }, body });
        const data = await res.json().catch(() => ({}));
        if (!res.ok || data.success === false) {
            const msg = data.errors ? Object.values(data.errors).flat().join('\n') : (data.message || 'Something went wrong.');
            throw new Error(msg);
        }
        return data;
    }

    function toast(icon, text) {
        if (window.Swal) Swal.fire({ icon, text, toast: true, position: 'top-end', timer: 2500, showConfirmButton: false });
        else alert(text);
    }

    const trackingForm = document.getElementById('trackingForm');
    if (trackingForm) {
        trackingForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            try {
                const data = await post('{{ route('user.meal-plan.save-tracking') }}', new FormData(trackingForm));
                document.getElementById('dailyScore').textContent = data.daily_score;
                toast('success', data.message);
            } catch (err) { toast('error', err.message); }
        });
    }

    const mealForm = document.getElementById('mealForm');
    if (mealForm) {
        mealForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            try {
                const data = await post('{{ route('user.meal-plan.save-meal-log') }}', new FormData(mealForm));
                toast('success', data.message);
                setTimeout(() => window.location.reload(), 800);
            } catch (err) { toast('error', err.message); }
        });
    }
})();
</script>
@endpush
