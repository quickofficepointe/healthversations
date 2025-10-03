@extends('layouts.app')

@section('title', 'Our Products | Health Versations')
@section('meta_description', 'Explore a curated range of wellness products from Health Versations, crafted to support your holistic well-being. Natural, effective, and designed for you.')
@section('meta_keywords', 'wellness products, health supplements, holistic wellness, Health Versations, natural health products')
@section('meta_author', 'Health Versations')
@section('meta_robots', 'index, follow')
@section('canonical_url', request()->url())

@section('og_title', 'Our Products | Health Versations')
@section('og_description', 'Explore our premium wellness products for a healthier life. Backed by science, trusted by wellness experts.')
@section('og_image', asset('Assets/images/health-versations-social.jpg'))

@section('twitter_title', 'Our Products | Health Versations')
@section('twitter_description', 'Discover premium wellness products tailored for your health journey.')
@section('twitter_image', asset('Assets/images/health-versations-social.jpg'))

@section('content')
<div class="bg-gradient-to-b from-white to-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-[#0A4040] text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Products</h1>
            <p class="text-xl max-w-2xl mx-auto">Discover our complete range of health and wellness products</p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-8 bg-white rounded-t-3xl"></div>
    </div>

    <div class="container mx-auto px-4 py-8 my-10">
        <!-- Category Filter -->


        <div class="w-24 h-1 bg-[#0A4040] mx-auto mb-6"></div>
        <h2 class="text-3xl font-bold text-center mb-8 text-[#0A4040]">Healthy Living is our middle name</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
            <!-- Product Card -->
            <div class="bg-white shadow-md p-4 border border-black mx-4">
                <!-- Product Image -->
                <img src="{{ asset($product->cover_image) }}"
                     alt="{{ $product->product_name }}"
                     class="w-full mb-4 product-image">

                <!-- Product Info -->
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-medium text-[#0A4040] product-name">{{ $product->product_name }}</h3>
                    <div class="space-y-2 mb-4">
                        @if($product->variants_count == 0)
                            <div class="flex justify-between">
                                <span class="text-gray-700">KES Price:</span>
                                <span class="font-bold text-[#93C754]">{{ number_format($product->price_kes, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">USD Price:</span>
                                <span class="font-bold text-[#93C754]">${{ number_format($product->price_usd, 2) }}</span>
                            </div>
                        @else
                            <div class="flex justify-between">
                                <span class="text-gray-700">From KES:</span>
                                <span class="font-bold text-[#93C754]">{{ number_format($product->variants->min('price_kes'), 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">From USD:</span>
                                <span class="font-bold text-[#93C754]">${{ number_format($product->variants->min('price_usd'), 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Tags -->
                <p class="text-[#93C754] mb-4">
                    {{ $product->category->category_name ?? 'Premium quality' }}
                </p>

                <!-- Description -->
                <p class="text-gray-600 text-sm mb-4 product-description">
                    {{ Str::limit($product->description, 100) }}
                </p>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('product.show', $product->slug) }}"
                       class="order-now bg-[#52823C] hover:bg-[#93C754] text-white font-bold py-2 px-4">
                        View Details
                    </a>

                    <div class="flex items-center space-x-2">
                        <button class="decrease bg-gray-200 hover:bg-gray-300 text-black font-bold py-1 px-3 rounded">
                            <img src="{{ asset('Assets/images/minus.svg') }}" alt="Minus" class="h-4 w-4">
                        </button>
                        <span class="quantity text-lg font-medium">1</span>
                        <button class="increase bg-gray-200 hover:bg-gray-300 text-black font-bold py-1 px-3 rounded">
                            <img src="{{ asset('Assets/images/plus.svg') }}" alt="Plus" class="h-4 w-4">
                        </button>
                    </div>

                    <button class="add-to-cart" data-product-id="{{ $product->id }}">
                        <img src="{{ asset('Assets/images/shopping-cart.svg') }}"
                             alt="Shopping Cart"
                             class="h-6 w-6 cart-icon transition-all duration-300">
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-10">
                <p class="text-gray-500 text-lg">No products available at the moment.</p>
                <a href="{{ route('home') }}" class="text-[#52823C] hover:underline mt-2 inline-block">
                    Return to homepage
                </a>
            </div>
            @endforelse
        </div>

        <!-- Products CTA Section -->
        <div class="mt-16 bg-[#0A4040] rounded-lg p-8 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">Looking for something specific?</h3>
            <p class="text-gray-200 mb-6">We can create custom products tailored to your unique health needs</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('custompackages.create') }}" class="bg-[#93C754] hover:bg-[#7eae47] text-[#0A4040] font-bold px-6 py-3 rounded-lg transition-colors">
                    Request Custom Product
                </a>
                <a href="" class="bg-white hover:bg-gray-100 text-[#0A4040] font-bold px-6 py-3 rounded-lg transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="mt-8 px-4">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
