@extends('healthversations.user.layout.userlayout')

@section('title', 'My Ebooks - Health Versation')
@section('page-title', 'My Ebooks')

@section('content')
<div class="bg-white rounded-xl shadow-sm divide-y divide-gray-200">
    @forelse($ebooks as $order)
        <div class="p-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <div class="flex items-center gap-4">
                @if($order->ebook && $order->ebook->cover_image)
                    <img src="{{ asset('storage/' . $order->ebook->cover_image) }}" alt="" class="w-12 h-16 object-cover rounded">
                @endif
                <div>
                    <h4 class="font-medium text-gray-800">{{ $order->ebook->title ?? 'Ebook' }}</h4>
                    <p class="text-sm text-gray-500">Order {{ $order->order_id }} · {{ $order->created_at->format('M d, Y') }} · KES {{ number_format($order->amount, 2) }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="status-badge status-{{ strtolower($order->status ?? 'pending') }}">{{ ucfirst($order->status ?? 'Pending') }}</span>
                @if($order->status === 'completed')
                    <a href="{{ route('user.ebooks.download', $order->id) }}" class="text-primary-600 hover:text-primary-700 text-sm">
                        <i class="fas fa-download"></i> Download
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="p-10 text-center text-gray-500">
            <i class="fas fa-book-open text-4xl mb-2 block"></i>
            No ebook purchases yet.
            <a href="{{ route('ebooks.show') }}" class="text-primary-600 block mt-2">Browse Ebooks →</a>
        </div>
    @endforelse
</div>
@if(method_exists($ebooks, 'links'))
    <div class="mt-4">{{ $ebooks->links() }}</div>
@endif
@endsection
