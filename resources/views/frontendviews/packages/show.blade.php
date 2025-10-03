@extends('layouts.app')

@section('title', '{{ $package->package_name }} - Premium Health Package')
@section('meta_description', '{{ Str::limit($package->package_description, 160) }}')
@section('meta_keywords', '{{ $package->package_tags ? str_replace(",", ", ", $package->package_tags) : "health package, wellness, fitness, nutrition" }}')
@section('canonical_url', url()->current())

@section('og_title', '{{ $package->package_name }} - Premium Health Package')
@section('og_description', '{{ Str::limit($package->package_description, 160) }}')
@section('og_image', '{{ asset("storage/" . $package->package_image) }}')
@section('og_url', url()->current())

@section('twitter_title', '{{ $package->package_name }} - Premium Health Package')
@section('twitter_description', '{{ Str::limit($package->package_description, 160) }}')
@section('twitter_image', '{{ asset("storage/" . $package->package_image) }}')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col items-center">
        <!-- Package Image -->
        <img src="{{ asset('storage/' . $package->package_image) }}"
             alt="{{ $package->package_name }}"
             class="w-full max-w-md rounded-lg shadow-md mb-6">

        <!-- Package Name -->
        <h1 class="text-3xl font-bold text-[#0A4040] mb-4">
            {{ $package->package_name }}
        </h1>

        <!-- Package Description -->
        <p class="text-lg text-gray-700 text-center mb-6">
            {{ $package->package_description }}
        </p>

        <!-- Package Tags (if available) -->
        @if ($package->package_tags)
            <div class="mb-6">
                <span class="font-semibold text-gray-600">Tags:</span>
                <span class="text-gray-800">{{ $package->package_tags }}</span>
            </div>
        @endif

        <!-- Package Category -->
        <div class="mb-6">
            <span class="font-semibold text-gray-600">Category:</span>
            <span class="text-gray-800">{{ $package->category->name }}</span>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4">
            <a href="{{ route('packages.index') }}" {{-- Replace with actual route --}}
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">
                Back to Packages
            </a>
            <a href="#start-now"
               class="bg-[#0A4040] hover:bg-[#93C754] text-white font-bold py-2 px-4 rounded">
                Start Package Now
            </a>
        </div>
    </div>
</div>

<!-- Structured Data (JSON-LD) for SEO -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ $package->package_name }}",
    "image": "{{ asset('storage/' . $package->package_image) }}",
    "description": "{{ $package->package_description }}",
    "brand": {
        "@type": "Brand",
        "name": "Healthversations"
    },
    "category": "{{ $package->category->name }}",
    "keywords": "{{ $package->package_tags }}",
    "url": "{{ url()->current() }}"
}
</script>

@endsection
