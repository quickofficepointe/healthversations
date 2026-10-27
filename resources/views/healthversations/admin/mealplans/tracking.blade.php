@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <a href="{{ route('admin.meal-plans.show', $plan) }}" class="text-primary-600 text-sm hover:underline">← {{ $plan->title }}</a>
    <h1 class="text-2xl font-semibold text-gray-800 mt-2 mb-6">Daily Tracking — {{ optional($plan->user)->name }}</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Water</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sleep</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Movement</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Meals</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mood / Energy</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($tracking as $day)
                        @php $logs = $mealLogs->get($day->tracking_date->toDateString(), collect()); @endphp
                        <tr class="align-top">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $day->tracking_date->format('D, M d') }}</td>
                            <td class="px-4 py-3 font-semibold {{ $day->daily_score >= 70 ? 'text-green-600' : ($day->daily_score >= 40 ? 'text-yellow-600' : 'text-red-600') }}">{{ $day->daily_score }}</td>
                            <td class="px-4 py-3">{{ $day->water_intake_liters ? $day->water_intake_liters . ' L' : '' }}{{ $day->water_intake_glasses ? ' (' . $day->water_intake_glasses . ' glasses)' : '' }}</td>
                            <td class="px-4 py-3">{{ $day->sleep_hours ? $day->sleep_hours . ' h' : '—' }}</td>
                            <td class="px-4 py-3">
                                @if($day->steps_count)<div>{{ number_format($day->steps_count) }} steps</div>@endif
                                @if($day->did_cardio)<div>Cardio {{ $day->cardio_minutes ? $day->cardio_minutes . ' min' : '' }}</div>@endif
                                @if($day->lifted_weights)<div>Weights {{ $day->weightlifting_minutes ? $day->weightlifting_minutes . ' min' : '' }}</div>@endif
                                @if($day->exercise_notes)<div class="text-xs text-gray-500">{{ $day->exercise_notes }}</div>@endif
                            </td>
                            <td class="px-4 py-3">
                                @foreach(['breakfast', 'lunch', 'dinner', 'snack'] as $meal)
                                    @php $log = $logs->firstWhere('meal_type', $meal); @endphp
                                    @if($log || ($meal !== 'snack' && $day->{'ate_' . $meal}))
                                        <div class="mb-1">
                                            <span class="font-medium">{{ ucfirst($meal) }}:</span>
                                            {{ optional($log)->food_items ?? 'eaten' }}
                                            @if($log && $log->photo_path)
                                                <a href="{{ asset('storage/' . $log->photo_path) }}" target="_blank" class="text-primary-600 ml-1"><i class="fas fa-image"></i></a>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                                @if($day->meal_notes)<div class="text-xs text-gray-500">{{ $day->meal_notes }}</div>@endif
                            </td>
                            <td class="px-4 py-3">{{ $day->mood_rating ?? '—' }} / {{ $day->energy_rating ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-10 text-center text-gray-500">No tracking logged yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t">{{ $tracking->links() }}</div>
    </div>
</div>
@endsection
