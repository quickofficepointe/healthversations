@extends('healthversations.user.layout.userlayout')

@section('title', 'My Consultations - Health Versation')
@section('page-title', 'My Consultations')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date &amp; Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">eTIMS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($consultations as $consultation)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $consultation->type_label ?? ucfirst(str_replace('_', ' ', $consultation->type)) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('M d, Y') }}
                            at {{ substr($consultation->consultation_time, 0, 5) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $consultation->display_amount ?? 'KES ' . number_format($consultation->fee, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="status-badge status-{{ in_array($consultation->payment_status, ['paid', 'completed']) ? 'completed' : (in_array($consultation->payment_status, ['failed', 'cancelled']) ? 'cancelled' : 'pending') }}">
                                {{ ucfirst($consultation->payment_status ?? 'unpaid') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="status-badge status-{{ strtolower($consultation->status ?? 'pending') }}">{{ ucfirst($consultation->status ?? 'Pending') }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($consultation->hasEtimsInvoice())
                                <a href="{{ route('user.consultations.etims', $consultation->id) }}" class="text-primary-600 hover:underline"><i class="fas fa-download mr-1"></i>Invoice</a>
                            @elseif($consultation->etims_requested)
                                <span class="text-gray-500">Being prepared</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <i class="fas fa-calendar-check text-4xl mb-2 block"></i>
                            No consultations booked yet.
                            <a href="{{ route('consultations.create') }}" class="text-primary-600 block mt-2">Book a Consultation →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t">{{ $consultations->links() }}</div>
</div>
@endsection
