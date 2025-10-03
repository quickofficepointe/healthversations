@extends('layouts.app')

@section('content')
<!-- Main Products Section -->
<div class="container mx-auto px-4 py-8 my-10">
    <div class="w-24 h-1 bg-[#0A4040] mx-auto mb-6"></div>
    <h2 class="text-3xl font-bold text-center mb-8 text-[#0A4040]">Privacy Policies</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($privacypolicy as $policy)

        <!-- Dynamic Product Card -->
            <div >
                <h3 class="text-xl font-bold mb-2"
                style="color: {{ $terms->text_color ?? 'green' }};">
                {{ Str::limit($policy->privacy, 50) }}
            </h3>
        @empty
            <div class="text-center col-span-3">
                <p class="text-gray-500">No policy available at the moment.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

