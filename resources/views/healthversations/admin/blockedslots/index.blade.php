@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Blocked Consultation Slots</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <form action="{{ route('admin.blocked-slots.store') }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4">
            @csrf
            <h2 class="font-semibold text-gray-700">Block a time</h2>
            <div>
                <label class="block text-sm font-medium mb-1">Date</label>
                <input type="date" name="blocked_date" value="{{ old('blocked_date') }}" min="{{ now()->toDateString() }}" required class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
            <label class="flex items-center text-sm">
                <input type="checkbox" name="full_day" value="1" id="fullDay" class="mr-2" @checked(old('full_day'))> Block the whole day
            </label>
            <div id="timeFields" class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium mb-1">From</label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">To</label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Reason (optional)</label>
                <input type="text" name="reason" value="{{ old('reason') }}" maxlength="255" class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm">Block Slot</button>
        </form>

        <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($blockedSlots as $slot)
                        <tr>
                            <td class="px-4 py-3">{{ $slot->blocked_date->format('D, M d, Y') }}</td>
                            <td class="px-4 py-3">{{ $slot->isFullDay() ? 'Whole day' : substr($slot->start_time, 0, 5) . ' – ' . substr($slot->end_time, 0, 5) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $slot->reason ?: '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <form action="{{ route('admin.blocked-slots.destroy', $slot->id) }}" method="POST" onsubmit="return confirm('Unblock this slot?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs"><i class="fas fa-trash mr-1"></i>Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-10 text-center text-gray-500">No upcoming blocked slots.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-4 py-3 border-t">{{ $blockedSlots->links() }}</div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const fullDay = document.getElementById('fullDay');
    const toggleTimes = () => document.getElementById('timeFields').classList.toggle('hidden', fullDay.checked);
    fullDay.addEventListener('change', toggleTimes);
    toggleTimes();
</script>
@endsection
