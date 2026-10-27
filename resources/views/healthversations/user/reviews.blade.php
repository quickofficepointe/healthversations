@extends('healthversations.user.layout.userlayout')

@section('title', 'My Reviews - Health Versation')
@section('page-title', 'My Reviews')

@section('content')
<div class="bg-white rounded-xl shadow-sm divide-y divide-gray-200">
    @forelse($reviews as $review)
        <div class="p-6">
            <div class="flex flex-col sm:flex-row sm:justify-between gap-2">
                <div>
                    <h4 class="font-medium text-gray-800">{{ optional($review->reviewable)->name ?? optional($review->reviewable)->title ?? 'Product' }}</h4>
                    <div class="text-yellow-400 text-sm">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $review->star ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                    </div>
                </div>
                <div class="text-sm text-gray-500 sm:text-right">
                    {{ $review->created_at->format('M d, Y') }}
                    <span class="status-badge {{ $review->approved ? 'status-completed' : 'status-pending' }} ml-2">{{ $review->approved ? 'Published' : 'Awaiting approval' }}</span>
                </div>
            </div>
            <p class="text-gray-700 text-sm mt-3">{{ $review->review }}</p>
        </div>
    @empty
        <div class="p-10 text-center text-gray-500">
            <i class="fas fa-star text-4xl mb-2 block"></i>
            You haven't written any reviews yet.
        </div>
    @endforelse
</div>
@if(method_exists($reviews, 'links'))
    <div class="mt-4">{{ $reviews->links() }}</div>
@endif
@endsection
