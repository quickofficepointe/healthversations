@extends('healthversations.user.layout.userlayout')

@section('title', 'Weekly Summary - Health Versation')
@section('page-title', 'Weekly Summary')

@section('content')
@if(isset($hasActivePlan) && !$hasActivePlan)
    <div class="bg-white rounded-xl shadow-sm p-10 text-center text-gray-500">
        <i class="fas fa-chart-line text-4xl mb-2 block"></i>
        You don't have an active meal plan yet.
    </div>
@else
@php
    $days = $dailyTracking->count();
    $avg = fn ($field) => $days ? round($dailyTracking->avg($field), 1) : 0;
@endphp
<div class="space-y-6">
    <a href="{{ route('user.meal-plan.dashboard') }}" class="text-primary-600 text-sm hover:underline">← Back to my meal plan</a>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([
            ['Days logged', $days . '/7', 'calendar-check'],
            ['Avg score', $avg('daily_score') . '/100', 'star'],
            ['Avg water', $avg('water_intake_liters') . ' L', 'tint'],
            ['Avg sleep', $avg('sleep_hours') . ' h', 'bed'],
        ] as [$label, $value, $icon])
            <div class="bg-white rounded-xl shadow-sm p-5">
                <p class="text-gray-500 text-sm"><i class="fas fa-{{ $icon }} mr-1"></i>{{ $label }}</p>
                <p class="text-2xl font-bold text-gray-800">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Water &amp; Sleep</h3>
            <div class="h-64"><canvas id="waterSleepChart"></canvas></div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Steps</h3>
            <div class="h-64"><canvas id="stepsChart"></canvas></div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-2">Week {{ $activePlan->current_week }} assessment</h3>
        @if($weeklyAssessment)
            <p class="text-sm text-gray-600">Submitted{{ $weeklyAssessment->weight_kg ? ' · Weight: ' . $weeklyAssessment->weight_kg . ' kg' : '' }}</p>
            @if($weeklyAssessment->admin_feedback)
                <p class="text-sm mt-2"><strong>Coach feedback:</strong> {{ $weeklyAssessment->admin_feedback }}</p>
            @endif
        @else
            <p class="text-sm text-gray-500">Not submitted yet. <a href="{{ route('user.meal-plan.current-week') }}" class="text-primary-600 hover:underline">Submit it here →</a></p>
        @endif
    </div>
</div>
@endif
@endsection

@if(!isset($hasActivePlan) || $hasActivePlan)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const data = @json($chartData);
    const num = v => (v === null || v === undefined) ? null : Number(v);
    const labels = data.map(d => d.date);
    const opts = { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } };

    new Chart(document.getElementById('waterSleepChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [
                { label: 'Water (L)', data: data.map(d => num(d.water)), backgroundColor: '#3b82f6' },
                { label: 'Sleep (h)', data: data.map(d => num(d.sleep)), backgroundColor: '#8b5cf6' }
            ]
        },
        options: opts
    });

    new Chart(document.getElementById('stepsChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [{ label: 'Steps', data: data.map(d => num(d.steps)), borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', fill: true, tension: 0.3 }]
        },
        options: { ...opts, plugins: { legend: { display: false } } }
    });
});
</script>
@endpush
@endif
