@extends('layouts.app')

@section('title', $product->product_name . ' | Premium Wellness Product | Health Versations')
@section('meta_description', $product->meta_description ?: 'Discover ' . $product->product_name . ' - a premium wellness product offering ' . $product->short_description)
@section('meta_keywords', $product->tags ?: 'wellness product, health supplement, ' . $product->product_name . ', natural remedy')
@section('canonical_url', route('product.show', ['slug' => $product->slug]))

@section('og_title', $product->product_name . ' | Health Versations')
@section('og_description', $product->short_description ?: 'Premium quality ' . $product->product_name . ' for your wellness needs')
@section('og_image', asset($product->cover_image))
@section('og_image_width', '1200')
@section('og_image_height', '630')
@section('og_image_alt', $product->product_name)

@section('twitter_title', $product->product_name . ' | Health Versations')
@section('twitter_description', $product->short_description ?: 'Check out our premium ' . $product->product_name)
@section('twitter_image', asset($product->cover_image))

@push('structured-data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ $product->product_name }}",
    "description": "{{ $product->meta_description ?: $product->short_description }}",
    "brand": {
        "@type": "Brand",
        "name": "Health Versations"
    },
    @if($product->reviews->count() > 0)
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{{ number_format($product->reviews->avg('rating'), 1) }}",
        "reviewCount": "{{ $product->reviews->count() }}"
    },
    @endif
    "offers": {
        "@type": "Offer",
        "url": "{{ route('product.show', ['slug' => $product->slug]) }}",
        "priceCurrency": "KES",
        "price": "{{ $product->has_variations ? $product->variants->min('price_kes') : $product->price_kes }}",
        "availability": "https://schema.org/{{ ($product->has_variations ? $product->variants->sum('stock') : $product->stock) > 0 ? 'InStock' : 'OutOfStock' }}",
        "itemCondition": "https://schema.org/NewCondition"
    },
    "image": "{{ asset($product->cover_image) }}"
}
</script>
@endpush

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4 sm:px-6">
    <div class="flex flex-col md:flex-row items-start gap-8">
        <!-- Product Images Section -->
        <div class="w-full md:w-2/5">
            <!-- Main Image -->
            <div class="border rounded-lg shadow-md overflow-hidden">
                <img id="mainImage" src="{{ asset($product->cover_image) }}"
                     alt="{{ $product->product_name }}"
                     class="w-full h-auto object-cover transition duration-300 ease-in-out cursor-pointer hover:opacity-90"
                     onclick="openImageModal('{{ asset($product->cover_image) }}', {{ json_encode($product->images->pluck('image_path')) }})">
            </div>

            <!-- Additional Images -->
           @if($product->images && $product->images->count())
    <div class="flex gap-2 mt-4 overflow-x-auto scrollbar-hide pb-2">
        @foreach($product->images as $index => $image)
            @php
                // Handle both full URLs and relative paths
                $imagePath = $image->image_path;

                // If path doesn't start with 'http' or '/storage', prepend '/storage/'
                if (!Str::startsWith($imagePath, ['http://', 'https://', '/storage/'])) {
                    $imagePath = '/storage/' . ltrim($imagePath, '/');
                }

                // Generate full URLs for the modal
                $allImages = $product->images->map(function($img) {
                    $path = $img->image_path;
                    if (!Str::startsWith($path, ['http://', 'https://', '/storage/'])) {
                        $path = '/storage/' . ltrim($path, '/');
                    }
                    return asset($path);
                });
            @endphp

            <img src="{{ asset($imagePath) }}"
                 alt="{{ $product->product_name }} - Image {{ $index + 1 }}"
                 class="w-20 h-20 object-cover cursor-pointer border rounded-lg shadow-sm hover:opacity-75 transition duration-300 ease-in-out"
                 onclick="openImageModal('{{ asset($imagePath) }}', {{ $allImages->toJson() }}, {{ $index }})">
        @endforeach
    </div>
@endif
        </div>

        <!-- Product Details Section -->
        <div class="w-full md:w-3/5 space-y-6">
            <!-- Product Name -->
            <h1 class="text-3xl font-bold text-[#0A4040]">{{ $product->product_name }}</h1>

            <!-- Tags -->
            @if($product->tags)
            <div class="flex items-center">
                <span class="text-sm font-semibold text-[#93C754] mr-2">Tags:</span>
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $product->tags) as $tag)
                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">{{ trim($tag) }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Variant Selection -->
            @if($product->has_variations && $product->variants->count())
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-[#0A4040]">Available Options</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($product->variants as $variant)
                            <div class="variant-option border rounded-lg p-4 hover:border-[#93C754] transition-colors duration-300 cursor-pointer
                                {{ $loop->first ? 'border-[#93C754] bg-green-50' : 'border-gray-200' }}"
                                data-variant-id="{{ $variant->id }}"
                                data-price-kes="{{ $variant->price_kes }}"
                                data-price-usd="{{ $variant->price_usd }}"
                                data-stock="{{ $variant->stock }}"
                                data-display-name="{{ $variant->display_name }}"
                                role="button"
                                aria-pressed="{{ $loop->first ? 'true' : 'false' }}"
                                tabindex="0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $variant->display_name }}</h4>
                                        <div class="mt-2">
                                            <span class="text-gray-600">KES: </span>
                                            <span class="font-bold text-[#93C754]">{{ number_format($variant->price_kes, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">USD: </span>
                                            <span class="font-bold text-[#93C754]">${{ number_format($variant->price_usd, 2) }}</span>
                                        </div>
                                    </div>
                                    @if($variant->stock > 0)
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">In Stock</span>
                                    @else
                                        <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" id="selectedVariant" name="variant_id" value="{{ $product->variants->first()->id }}">
                </div>
            @else
                <!-- Simple Product Pricing -->
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b">
                        <span class="text-gray-600">KES Price:</span>
                        <span class="font-bold text-[#93C754]">{{ number_format($product->price_kes, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b">
                        <span class="text-gray-600">USD Price:</span>
                        <span class="font-bold text-[#93C754]">${{ number_format($product->price_usd, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Availability:</span>
                        @if($product->stock > 0)
                            <span class="font-bold text-green-600">In Stock</span>
                        @else
                            <span class="font-bold text-red-600">Out of Stock</span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quantity Selector -->
            <div class="flex items-center gap-4 mt-6">
                <span class="text-gray-700 font-medium">Quantity:</span>
                <div class="flex items-center space-x-2">
                    <button class="decrease px-3 py-1 border rounded-lg text-lg font-semibold hover:bg-gray-100 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#93C754]">-</button>
                    <input type="number" class="quantity w-12 text-center border rounded-lg py-1" value="1" min="1" :max="maxStock">
                    <button class="increase px-3 py-1 border rounded-lg text-lg font-semibold hover:bg-gray-100 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#93C754]">+</button>
                </div>
                @if($product->has_variations)
                    @php $maxStock = $product->variants->max('stock'); @endphp
                @else
                    @php $maxStock = $product->stock; @endphp
                @endif
                <span class="text-sm text-gray-500 ml-2">Max: <span class="max-stock-display">{{ $maxStock }}</span></span>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mt-8">
                <button class="add-to-cart flex items-center justify-center bg-[#93C754] text-white px-6 py-3 text-sm font-semibold uppercase rounded-lg shadow-md hover:bg-opacity-90 transition duration-300 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ ($product->has_variations && $product->variants->count() ? $product->variants->first()->stock : $product->stock) <= 0 ? 'disabled' : '' }}>
                    <span class="add-to-cart-text">Add to Cart</span>
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
                <a href="{{ route('cart.index') }}" class="view-cart flex items-center justify-center bg-[#0A4040] text-white px-6 py-3 text-sm font-semibold uppercase rounded-lg shadow-md hover:bg-opacity-90 transition duration-300 ease-in-out">
                    View Cart
                </a>
            </div>

            <!-- Review Stars -->
            <div class="flex items-center mt-6 pt-6 border-t">
                @php
                    $averageRating = $product->reviews->avg('rating') ?? 0;
                    $reviewCount = $product->reviews->count();
                @endphp
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $averageRating)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @elseif($i - 0.5 <= $averageRating)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <defs>
                                    <linearGradient id="half-star" x1="0" x2="100%" y1="0" y2="0">
                                        <stop offset="50%" stop-color="currentColor"></stop>
                                        <stop offset="50%" stop-color="#D1D5DB"></stop>
                                    </linearGradient>
                                </defs>
                                <path fill="url(#half-star)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endif
                    @endfor
                </div>
                <span class="ml-2 text-gray-600 text-sm">{{ number_format($averageRating, 1) }} ({{ $reviewCount }} reviews)</span>
                <button class="open-review-modal ml-4 text-sm text-[#0A4040] font-semibold hover:underline focus:outline-none">
                    Write a review
                </button>
            </div>
        </div>
    </div>

    <!-- Tabbed Content Section -->
    <div class="mt-12 border-t pt-8">
        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button data-tab="description" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-[#0A4040] text-[#0A4040]">
                    Description
                </button>
                <button data-tab="specifications" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Specifications
                </button>
                <button data-tab="reviews" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Reviews ({{ $reviewCount }})
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="py-6">
            <!-- Description Tab -->
            <div id="description-content" class="tab-content">
                <div class="prose max-w-none">
                    {!! $product->description !!}
                </div>
            </div>

            <!-- Specifications Tab -->
            <div id="specifications-content" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-[#0A4040] mb-4">Product Details</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">{{ $product->category->category_name ?? 'N/A' }}</span>
                            </div>
                            @if($product->measurement_unit)
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Measurement:</span>
                                <span class="font-medium" id="variant-measurement">{{ $product->measurement_unit }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Stock Status:</span>
                                <span class="font-medium" id="variant-stock-status">
                                    @if($product->has_variations && $product->variants->count())
                                        {{ $product->variants->first()->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                    @else
                                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Variant-specific details -->
                    <div>
                        <h3 class="text-lg font-semibold text-[#0A4040] mb-4">Selected Variant</h3>
                        <div class="space-y-3" id="variant-details">
                            @if($product->has_variations && $product->variants->count())
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Variant:</span>
                                <span class="font-medium">{{ $product->variants->first()->display_name }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">KES Price:</span>
                                <span class="font-medium">{{ number_format($product->variants->first()->price_kes, 2) }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">USD Price:</span>
                                <span class="font-medium">${{ number_format($product->variants->first()->price_usd, 2) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div id="reviews-content" class="tab-content hidden">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-[#0A4040]">Customer Reviews</h3>
                    <button class="open-review-modal bg-[#0A4040] text-white px-4 py-2 text-sm font-semibold uppercase rounded-lg shadow-md hover:bg-opacity-90 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#93C754]">
                        Write a Review
                    </button>
                </div>

                @if($product->reviews->count() > 0)
                    <div class="space-y-6">
                        @foreach($product->reviews as $review)
                            <div class="border-b pb-6">
                                <div class="flex items-center mb-2">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600">{{ $review->created_at->format('M d, Y') }}</span>
                                </div>
                                <h4 class="font-semibold text-gray-800">{{ $review->name }}</h4>
                                <p class="mt-1 text-gray-700">{{ $review->review }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">No reviews yet. Be the first to review this product!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex justify-center items-center hidden z-50 px-4">
    <div class="bg-white p-4 rounded-lg shadow-lg max-w-4xl w-full relative">
        <!-- Close Button -->
        <button class="close-image-modal absolute top-4 right-4 text-gray-700 text-2xl hover:text-gray-900 focus:outline-none">
            &times;
        </button>
        <!-- Previous Button -->
        <button class="prev-image absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-700 text-2xl hover:text-gray-900 focus:outline-none">
            &#10094;
        </button>
        <!-- Next Button -->
        <button class="next-image absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-700 text-2xl hover:text-gray-900 focus:outline-none">
            &#10095;
        </button>
        <!-- Enlarged Image -->
        <img id="enlargedImage" src="" alt="Enlarged Product Image" class="w-full h-auto max-h-[80vh] object-contain rounded-lg">
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-75 flex justify-center items-center hidden z-50 px-4">
    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg max-w-md w-full relative">
        <!-- Close Button -->
        <button class="close-review-modal absolute top-4 right-4 text-gray-700 text-2xl hover:text-gray-900 focus:outline-none">
            &times;
        </button>

        <h2 class="text-2xl font-bold text-[#0A4040] mb-6">Write a Review</h2>

        <form action="{{ route('reviews.store', ['productId' => $product->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                <input type="text" id="name" name="name" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition duration-300">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition duration-300">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="star-rating focus:outline-none" data-rating="{{ $i }}" aria-label="Rate {{ $i }} star">
                            <svg class="w-8 h-8 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </button>
                    @endfor
                    <input type="hidden" id="star" name="star" value="5">
                </div>
            </div>

            <div class="mb-6">
                <label for="review" class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
                <textarea id="review" name="review" rows="4" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition duration-300"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" class="close-review-modal px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#93C754]">
                    Cancel
                </button>
                <button type="submit" class="bg-[#0A4040] text-white px-6 py-2 rounded-md shadow-md hover:bg-opacity-90 transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#93C754]">
                    Submit Review
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // =============================================
    // Utility Functions
    // =============================================
    function getElement(selector, parent = document) {
        return parent.querySelector(selector);
    }

    function getElements(selector, parent = document) {
        return parent.querySelectorAll(selector);
    }

    // =============================================
    // Image Modal
    // =============================================
    const imageModal = {
        currentIndex: 0,
        images: [],
        modal: getElement('#imageModal'),
        enlargedImage: getElement('#enlargedImage'),

        init: function() {
            if (!this.modal || !this.enlargedImage) return;

            getElements('[onclick^="openImageModal"]').forEach(img => {
                img.addEventListener('click', (e) => {
                    e.preventDefault();
                    const src = img.getAttribute('src');
                    const images = JSON.parse(img.getAttribute('data-images') || '[]');
                    this.open(src, images);
                });
            });

            const closeBtn = getElement('.close-image-modal', this.modal);
            const prevBtn = getElement('.prev-image', this.modal);
            const nextBtn = getElement('.next-image', this.modal);

            if (closeBtn) closeBtn.addEventListener('click', () => this.close());
            if (prevBtn) prevBtn.addEventListener('click', () => this.prev());
            if (nextBtn) nextBtn.addEventListener('click', () => this.next());

            this.modal.addEventListener('click', (e) => {
                if (e.target === this.modal) this.close();
            });

            document.addEventListener('keydown', (e) => {
                if (!this.modal.classList.contains('hidden')) {
                    if (e.key === 'Escape') this.close();
                    if (e.key === 'ArrowLeft') this.prev();
                    if (e.key === 'ArrowRight') this.next();
                }
            });
        },

        open: function(src, images = [], index = 0) {
            this.images = images.map(img => img.startsWith('http') ? img : `${window.location.origin}/storage/${img}`);
            this.currentIndex = index;
            this.enlargedImage.src = this.images[this.currentIndex] || src;
            this.modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        },

        close: function() {
            this.modal.classList.add('hidden');
            document.body.style.overflow = '';
        },

        prev: function() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
            this.enlargedImage.src = this.images[this.currentIndex];
        },

        next: function() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
            this.enlargedImage.src = this.images[this.currentIndex];
        }
    };

    // =============================================
    // Tab System
    // =============================================
    const tabSystem = {
        init: function() {
            const tabButtons = getElements('.tab-button');
            if (tabButtons.length === 0) return;

            tabButtons.forEach(button => {
                button.addEventListener('click', () => this.switchTab(button));
            });
        },

        switchTab: function(button) {
            const tabName = button.getAttribute('data-tab');
            const tabContent = getElement(`#${tabName}-content`);

            if (!tabContent) return;

            // Update active tab button
            getElements('.tab-button').forEach(btn => {
                if (btn) {
                    btn.classList.remove('border-[#0A4040]', 'text-[#0A4040]');
                    btn.classList.add('border-transparent', 'text-gray-500');
                }
            });

            button.classList.add('border-[#0A4040]', 'text-[#0A4040]');
            button.classList.remove('border-transparent', 'text-gray-500');

            // Show selected tab content
            getElements('.tab-content').forEach(content => {
                if (content) content.classList.add('hidden');
            });

            tabContent.classList.remove('hidden');
        }
    };

    // =============================================
    // Product Variants
    // =============================================
    const productVariants = {
        init: function() {
            const variantOptions = getElements('.variant-option');
            if (variantOptions.length === 0) return;

            variantOptions.forEach(option => {
                if (option) {
                    option.addEventListener('click', () => this.selectVariant(option));
                    option.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            this.selectVariant(option);
                        }
                    });
                }
            });

            // Initialize with first variant if exists
            if (variantOptions.length > 0 && variantOptions[0]) {
                this.selectVariant(variantOptions[0]);
            }
        },

        selectVariant: function(option) {
            if (!option) return;

            // Clear previous selections
            getElements('.variant-option').forEach(opt => {
                if (opt) {
                    opt.classList.remove('border-[#93C754]', 'bg-green-50');
                    opt.setAttribute('aria-pressed', 'false');
                }
            });

            // Set new selection
            option.classList.add('border-[#93C754]', 'bg-green-50');
            option.setAttribute('aria-pressed', 'true');

            // Get variant data
            const variantId = option.getAttribute('data-variant-id');
            const stock = parseInt(option.getAttribute('data-stock')) || 0;
            const priceKES = parseFloat(option.getAttribute('data-price-kes')) || 0;
            const priceUSD = parseFloat(option.getAttribute('data-price-usd')) || 0;
            const displayName = option.getAttribute('data-display-name') || '';
            const quantityInput = getElement('.quantity');
            const currentQuantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;

            // Update hidden input
            const variantInput = getElement('#selectedVariant');
            if (variantInput) variantInput.value = variantId;

            // Update max stock display
            const maxStockDisplay = getElement('.max-stock-display');
            if (maxStockDisplay) maxStockDisplay.textContent = stock;

            // Update variant details in specifications tab
            this.updateVariantDetails({
                id: variantId,
                stock: stock,
                price_kes: priceKES,
                price_usd: priceUSD,
                display_name: displayName
            });

            // Update button states
            this.updateButtonStates(stock, currentQuantity);

            // Update order button URL
            orderHandler.updateOrderButton();
        },

        updateVariantDetails: function(variant) {
            const variantDetailsContainer = getElement('#variant-details');
            if (variantDetailsContainer) {
                variantDetailsContainer.innerHTML = `
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Variant:</span>
                        <span class="font-medium">${variant.display_name}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">KES Price:</span>
                        <span class="font-medium">${variant.price_kes.toFixed(2)}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">USD Price:</span>
                        <span class="font-medium">$${variant.price_usd.toFixed(2)}</span>
                    </div>
                `;
            }

            // Update stock status
            const stockStatusElement = getElement('#variant-stock-status');
            if (stockStatusElement) {
                stockStatusElement.textContent = variant.stock > 0 ? 'In Stock' : 'Out of Stock';
            }
        },

        updateButtonStates: function(stock, quantity) {
            const addToCartBtn = getElement('.add-to-cart');
            const viewCartBtn = getElement('.view-cart');
            const quantityInput = getElement('.quantity');

            if (!addToCartBtn || !viewCartBtn || !quantityInput) return;

            if (stock <= 0) {
                addToCartBtn.disabled = true;
                quantityInput.value = '0';
            } else {
                addToCartBtn.disabled = false;
                if (quantity > stock) {
                    quantityInput.value = stock;
                }
            }
        }
    };

    // =============================================
    // Quantity Controls
    // =============================================
    const quantityControls = {
        init: function() {
            const increaseBtns = getElements('.increase');
            const decreaseBtns = getElements('.decrease');
            const quantityInput = getElement('.quantity');

            increaseBtns.forEach(btn => {
                if (btn) btn.addEventListener('click', (e) => this.adjustQuantity(e, 1));
            });

            decreaseBtns.forEach(btn => {
                if (btn) btn.addEventListener('click', (e) => this.adjustQuantity(e, -1));
            });

            if (quantityInput) {
                quantityInput.addEventListener('change', (e) => this.validateQuantity(e));
                quantityInput.addEventListener('blur', (e) => this.validateQuantity(e));
            }
        },

        adjustQuantity: function(e, change) {
            e.preventDefault();
            const quantityInput = getElement('.quantity');
            if (!quantityInput) return;

            let quantity = parseInt(quantityInput.value) || 1;
            let maxStock = this.getMaxStock();

            quantity += change;

            // Validate min/max
            if (quantity < 1) quantity = 1;
            if (maxStock > 0 && quantity > maxStock) {
                quantity = maxStock;
                this.showStockWarning(maxStock);
            }

            quantityInput.value = quantity;
            orderHandler.updateOrderButton();
        },

        validateQuantity: function(e) {
            const quantityInput = e.target;
            let quantity = parseInt(quantityInput.value) || 1;
            const maxStock = this.getMaxStock();

            // Validate min/max
            if (quantity < 1) quantity = 1;
            if (maxStock > 0 && quantity > maxStock) {
                quantity = maxStock;
                this.showStockWarning(maxStock);
            }

            quantityInput.value = quantity;
            orderHandler.updateOrderButton();
        },

        getMaxStock: function() {
            if ({{ $product->has_variations ? 'true' : 'false' }}) {
                const selectedVariant = getElement('.variant-option.border-[#93C754]');
                return selectedVariant ? parseInt(selectedVariant.getAttribute('data-stock')) || 0 : 0;
            }
            return {{ $product->stock ?? 0 }};
        },

        showStockWarning: function(maxStock) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Maximum stock reached',
                    text: `Only ${maxStock} available`,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                console.warn(`Only ${maxStock} available`);
            }
        }
    };

    // =============================================
    // Order Handling
    // =============================================
    const orderHandler = {
        init: function() {
            const orderNowBtn = getElement('#orderNowButton');
            if (orderNowBtn) {
                orderNowBtn.addEventListener('click', (e) => {
                    // Let the anchor tag handle the navigation by default
                    // We'll just ensure the URL is up to date
                    this.updateOrderButton();
                });
            }

            // Initialize the button state
            this.updateOrderButton();
        },

        updateOrderButton: function() {
            const orderNowBtn = getElement('#orderNowButton');
            if (!orderNowBtn) return;

            const quantity = parseInt(getElement('.quantity')?.value) || 1;
            let priceKES, priceUSD, variantId = null, variantName = '';

            // Handle both products with and without variants
            if ({{ $product->has_variations ? 'true' : 'false' }}) {
                const selectedOption = getElement('.variant-option.border-[#93C754]');
                if (selectedOption) {
                    priceKES = parseFloat(selectedOption.getAttribute('data-price-kes')) || 0;
                    priceUSD = parseFloat(selectedOption.getAttribute('data-price-usd')) || 0;
                    variantId = selectedOption.getAttribute('data-variant-id');
                    variantName = selectedOption.getAttribute('data-display-name') || '';

                    // Check stock availability
                    const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
                    orderNowBtn.disabled = (stock <= 0);
                } else {
                    // No variant selected - disable button
                    orderNowBtn.disabled = true;
                    orderNowBtn.href = '#';
                    return;
                }
            } else {
                // Simple product without variants
                priceKES = {{ $product->price_kes ?? 0 }};
                priceUSD = {{ $product->price_usd ?? 0 }};
                orderNowBtn.disabled = ({{ $product->stock ?? 0 }} <= 0);
            }

            // Calculate totals
            const totalKES = (quantity * priceKES).toFixed(2);
            const totalUSD = (quantity * priceUSD).toFixed(2);

            // Build order URL
            let url = `{{ route('order.page', ['slug' => $product->slug]) }}?quantity=${quantity}`;

            // Add variant info if exists
            if (variantId) {
                url += `&variant_id=${variantId}`;
                url += `&variant_name=${encodeURIComponent(variantName)}`;
                url += `&price_kes=${priceKES.toFixed(2)}`;
                url += `&price_usd=${priceUSD.toFixed(2)}`;
            }

            // Add price info
            url += `&total_kes=${totalKES}`;
            url += `&total_usd=${totalUSD}`;

            // Update button
            orderNowBtn.href = url;

            // Add animation for visual feedback
            orderNowBtn.classList.add('animate-pulse');
            setTimeout(() => {
                orderNowBtn.classList.remove('animate-pulse');
            }, 300);
        }
    };

    // =============================================
    // Add to Cart Functionality
    // =============================================
    const cartHandler = {
        init: function() {
            const addToCartBtn = getElement('.add-to-cart');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', (e) => this.addToCart(e));
            }
        },

        addToCart: async function(e) {
            e.preventDefault();
            const addToCartBtn = e.target.closest('.add-to-cart');
            if (!addToCartBtn) return;

            addToCartBtn.disabled = true;
            const spinner = addToCartBtn.querySelector('svg');
            const text = addToCartBtn.querySelector('.add-to-cart-text');

            if (spinner) spinner.classList.remove('hidden');
            if (text) text.textContent = 'Adding...';

            try {
                const quantity = parseInt(getElement('.quantity')?.value) || 1;
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                if (quantity <= 0) throw new Error('Invalid quantity');

                const payload = {
                    product_id: {{ $product->id }},
                    quantity: quantity
                };

                // Add variant if this product has variants
                if ({{ $product->has_variations ? 'true' : 'false' }}) {
                    const variantId = getElement('#selectedVariant')?.value;
                    if (!variantId) throw new Error('Please select a variant');
                    payload.variant_id = variantId;
                }

                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Failed to add to cart');
                }

                const counter = getElement('#cart-counter');
                if (counter) counter.textContent = data.cart_count;

                this.showSuccess('Product added to cart!');
            } catch (error) {
                this.showError(error.message);
            } finally {
                addToCartBtn.disabled = false;
                if (spinner) spinner.classList.add('hidden');
                if (text) text.textContent = 'Add to Cart';
            }
        },

        showSuccess: function(message) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                alert(message);
            }
        },

        showError: function(message) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                alert(message);
            }
        }
    };

    // =============================================
    // Review System
    // =============================================
    const reviewSystem = {
        init: function() {
            const openButtons = getElements('.open-review-modal');
            const closeButtons = getElements('.close-review-modal');
            const starRatings = getElements('.star-rating');

            openButtons.forEach(btn => {
                if (btn) btn.addEventListener('click', () => this.openModal());
            });

            closeButtons.forEach(btn => {
                if (btn) btn.addEventListener('click', () => this.closeModal());
            });

            starRatings.forEach(star => {
                if (star) {
                    star.addEventListener('click', () => {
                        this.setRating(parseInt(star.getAttribute('data-rating')));
                    });
                }
            });

            this.setRating(5);
        },

        openModal: function() {
            const modal = getElement('#reviewModal');
            if (modal) modal.classList.remove('hidden');
        },

        closeModal: function() {
            const modal = getElement('#reviewModal');
            if (modal) modal.classList.add('hidden');
        },

        setRating: function(rating) {
            const starInput = getElement('#star');
            if (starInput) starInput.value = rating;

            getElements('.star-rating svg').forEach((star, index) => {
                if (star) {
                    star.classList.toggle('text-yellow-400', index < rating);
                    star.classList.toggle('text-gray-300', index >= rating);
                }
            });
        }
    };

    // =============================================
    // Initialize Everything
    // =============================================
    imageModal.init();
    tabSystem.init();
    reviewSystem.init();
    quantityControls.init();
    orderHandler.init();
    cartHandler.init();

    // Only initialize variant-related code if variants exist
    if (getElements('.variant-option').length > 0) {
        productVariants.init();
    }
});
</script>

<style>
    /* Hide scrollbar for additional images */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }

    /* Smooth transition for tabs */
    .tab-content {
        transition: opacity 0.3s ease-in-out;
    }

    /* Animation for variant selection */
    .variant-option {
        transition: all 0.3s ease;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .product-details-container {
            flex-direction: column;
        }
        .product-images, .product-info {
            width: 100% !important;
        }
    }

    /* Quantity input styling */
    .quantity {
        -moz-appearance: textfield;
    }
    .quantity::-webkit-outer-spin-button,
    .quantity::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

@endsection
