@extends('healthversations.user.layout.userlayout')

@section('title', 'My Coaching - Health Versation')
@section('page-title', 'My Coaching')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Package</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrolled</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($enrollments as $enrollment)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $enrollment->package->package_name ?? 'Coaching Package' }}
                            @if($enrollment->package && $enrollment->package->duration)
                                <span class="block text-xs text-gray-500">{{ $enrollment->package->duration }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->order_id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">KES {{ number_format($enrollment->amount, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="status-badge status-{{ strtolower($enrollment->status ?? 'pending') }}">{{ ucfirst($enrollment->status ?? 'Pending') }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            <i class="fas fa-user-graduate text-4xl mb-2 block"></i>
                            You haven't enrolled in a coaching package yet.
                            <a href="{{ url('/') }}#coaching" class="text-primary-600 block mt-2">See Coaching Packages →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($enrollments, 'links'))
        <div class="px-6 py-4 border-t">{{ $enrollments->links() }}</div>
    @endif
</div>
@endsection
