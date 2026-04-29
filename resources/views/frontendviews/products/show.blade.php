@extends('layouts.app')

@section('title', $product->product_name . ' - 20% OFF | Premium Wellness Product | Health Versations')
@section('meta_description', $product->meta_description ?: 'Get ' . $product->product_name . ' at 20% OFF! Premium wellness product for your health journey. Limited time offer.')
@section('meta_keywords', $product->tags ?: 'wellness product, health supplement, ' . $product->product_name . ', natural remedy, 20% off')
@section('canonical_url', route('product.show', ['slug' => $product->slug]))

@section('og_title', $product->product_name . ' - 20% OFF | Health Versations')
@section('og_description', $product->short_description ?: 'Premium quality ' . $product->product_name . ' at 20% off. Limited time offer!')
@section('og_image', asset($product->cover_image))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', $product->product_name)

@section('twitter_title', $product->product_name . ' - 20% OFF | Health Versations')
@section('twitter_description', 'Get our premium ' . $product->product_name . ' at 20% off today!')
@section('twitter_image', asset($product->cover_image))
@section('twitter_card', 'summary_large_image')

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "{{ addslashes($product->product_name) }}",
  "description": "{{ addslashes($product->meta_description ?: $product->short_description) }}",
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
    "itemCondition": "https://schema.org/NewCondition",
    "priceValidUntil": "{{ now()->addDays(30)->format('Y-m-d') }}"
  },
  "image": "{{ asset($product->cover_image) }}"
}
</script>
@endpush

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "{{ url('/') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Products",
      "item": "{{ route('all.products') }}"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "{{ addslashes($product->product_name) }}",
      "item": "{{ route('product.show', ['slug' => $product->slug]) }}"
    }
  ]
}
</script>
@endpush

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4 sm:px-6">
    <!-- Discount Alert Banner -->
    <div class="bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-xl p-4 mb-8 text-center">
        <div class="flex items-center justify-center gap-3 flex-wrap">
            <i class="fas fa-tag text-2xl"></i>
            <span class="font-bold text-lg">🔥 LIMITED TIME OFFER: 20% OFF ALL PRODUCTS! 🔥</span>
            <i class="fas fa-fire text-2xl"></i>
        </div>
        <p class="text-sm mt-1 opacity-90">Discount automatically applied at checkout | Offer ends soon</p>
    </div>

    <div class="flex flex-col md:flex-row items-start gap-8">
        <!-- Product Images Section -->
        <div class="w-full md:w-2/5">
            <!-- Main Image with Discount Badge -->
            <div class="border rounded-lg shadow-md overflow-hidden relative">
                <div class="absolute top-4 right-4 z-10 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                    -20% OFF
                </div>
                <img id="mainImage" src="{{ asset($product->cover_image) }}"
                     alt="{{ $product->product_name }}"
                     class="w-full h-auto object-cover transition duration-300 ease-in-out cursor-pointer hover:opacity-90"
                     onclick="openImageModal('{{ asset($product->cover_image) }}', {{ json_encode($product->images->pluck('image_path')) }})">
            </div>

            <!-- Additional Images -->
            @if($product->images && $product->images->count())
            <div class="flex gap-2 mt-4 overflow-x-auto pb-2">
                @foreach($product->images as $index => $image)
                    @php
                        $imagePath = $image->image_path;
                        if (!Str::startsWith($imagePath, ['http://', 'https://', '/storage/'])) {
                            $imagePath = '/storage/' . ltrim($imagePath, '/');
                        }
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
                            @php
                                $defaultDiscount = 20;
                                $originalVariantPriceKES = $variant->price_kes;
                                $currentVariantPriceKES = $originalVariantPriceKES;
                                $strikedVariantPriceKES = $currentVariantPriceKES / (1 - $defaultDiscount / 100);
                                $originalVariantPriceUSD = $variant->price_usd;
                                $currentVariantPriceUSD = $originalVariantPriceUSD;
                                $strikedVariantPriceUSD = $currentVariantPriceUSD / (1 - $defaultDiscount / 100);
                            @endphp
                            <div class="variant-option border rounded-lg p-4 hover:border-[#93C754] transition-colors duration-300 cursor-pointer
                                {{ $loop->first ? 'border-[#93C754] bg-green-50' : 'border-gray-200' }}"
                                data-variant-id="{{ $variant->id }}"
                                data-price-kes="{{ $currentVariantPriceKES }}"
                                data-price-usd="{{ $currentVariantPriceUSD }}"
                                data-stock="{{ $variant->stock }}"
                                data-display-name="{{ $variant->display_name }}"
                                role="button"
                                aria-pressed="{{ $loop->first ? 'true' : 'false' }}"
                                tabindex="0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $variant->display_name }}</h4>
                                        <div class="mt-2">
                                            <span class="text-gray-400 line-through text-sm">KES {{ number_format($strikedVariantPriceKES, 2) }}</span>
                                            <span class="font-bold text-[#93C754] ml-2 text-lg">KES {{ number_format($currentVariantPriceKES, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-400 line-through text-xs">${{ number_format($strikedVariantPriceUSD, 2) }}</span>
                                            <span class="font-bold text-[#93C754] ml-2">${{ number_format($currentVariantPriceUSD, 2) }}</span>
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
                <!-- Simple Product Pricing with Discount -->
                @php
                    $defaultDiscount = 20;
                    $currentPriceKES = $product->price_kes;
                    $strikedPriceKES = $currentPriceKES / (1 - $defaultDiscount / 100);
                    $currentPriceUSD = $product->price_usd;
                    $strikedPriceUSD = $currentPriceUSD / (1 - $defaultDiscount / 100);
                    $savingsKES = $strikedPriceKES - $currentPriceKES;
                @endphp
                <div class="bg-gradient-to-r from-yellow-50 to-green-50 rounded-xl p-5">
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">Original Price:</span>
                            <span class="text-gray-400 line-through text-lg">KES {{ number_format($strikedPriceKES, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-t border-gray-200">
                            <span class="text-gray-600 font-semibold">Sale Price:</span>
                            <span class="font-bold text-[#93C754] text-2xl">KES {{ number_format($currentPriceKES, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-t border-gray-200">
                            <span class="text-gray-600">USD Price:</span>
                            <div class="text-right">
                                <span class="text-gray-400 line-through text-sm mr-2">${{ number_format($strikedPriceUSD, 2) }}</span>
                                <span class="font-bold text-[#93C754]">${{ number_format($currentPriceUSD, 2) }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center py-2 border-t border-gray-200">
                            <span class="text-gray-600">You Save:</span>
                            <span class="text-red-500 font-bold">KES {{ number_format($savingsKES, 2) }} (20% OFF!)</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">Availability:</span>
                            @if($product->stock > 0)
                                <span class="font-bold text-green-600 flex items-center gap-1"><i class="fas fa-check-circle"></i> In Stock</span>
                            @else
                                <span class="font-bold text-red-600 flex items-center gap-1"><i class="fas fa-times-circle"></i> Out of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quantity Selector -->
            <div class="flex items-center gap-4 mt-6">
                <span class="text-gray-700 font-medium">Quantity:</span>
                <div class="flex items-center space-x-2">
                    <button class="decrease px-3 py-1 border rounded-lg text-lg font-semibold hover:bg-gray-100 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#93C754]">-</button>
                    <input type="number" class="quantity w-12 text-center border rounded-lg py-1" value="1" min="1" max="{{ $product->has_variations ? $product->variants->max('stock') : $product->stock }}">
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
                    <svg class="animate-spin ml-2 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
                <a href="{{ route('cart.index') }}" class="view-cart flex items-center justify-center bg-[#0A4040] text-white px-6 py-3 text-sm font-semibold uppercase rounded-lg shadow-md hover:bg-opacity-90 transition duration-300 ease-in-out">
                    View Cart
                </a>
            </div>

            <!-- Savings Callout -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-center">
                <p class="text-red-600 font-semibold">
                    <i class="fas fa-gift mr-2"></i>
                    You're saving 20% on this purchase today! 🎉
                </p>
            </div>

            <!-- Review Stars -->
            <div class="flex items-center mt-6 pt-6 border-t">
                @php
                    $averageRating = $product->reviews->avg('star') ?? 0;
                    $reviewCount = $product->reviews->count();
                @endphp
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($averageRating))
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endif
                    @endfor
                </div>
                <span class="ml-2 text-gray-600 text-sm">{{ number_format($averageRating, 1) }} ({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</span>
                <button class="open-review-modal ml-4 text-sm text-[#0A4040] font-semibold hover:underline focus:outline-none">
                    Write a review
                </button>
            </div>
        </div>
    </div>

    <!-- Product Description Tabs -->
    <div class="mt-12">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8">
                <button class="tab-btn py-4 px-1 border-b-2 font-medium text-sm transition-colors" data-tab="description">
                    Description
                </button>
                <button class="tab-btn py-4 px-1 border-b-2 font-medium text-sm transition-colors" data-tab="reviews">
                    Reviews ({{ $reviewCount }})
                </button>
            </nav>
        </div>

        <!-- Description Tab -->
        <div id="description-tab" class="tab-content py-6">
            <div class="prose max-w-none">
                {!! $product->description !!}
            </div>
        </div>

        <!-- Reviews Tab -->
        <div id="reviews-tab" class="tab-content py-6 hidden">
            <div class="space-y-6">
                @if($product->reviews->where('approved', true)->count() > 0)
                    @foreach($product->reviews->where('approved', true) as $review)
                        <div class="border-b border-gray-200 pb-4">
                            <div class="flex items-center mb-2">
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->star)
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 font-medium text-gray-800">{{ $review->name }}</span>
                                <span class="ml-auto text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <p class="text-gray-600">{{ $review->review }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 text-center py-8">No reviews yet. Be the first to review this product!</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b p-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-[#0A4040]">Write a Review</h3>
            <button onclick="closeReviewModal()" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div class="p-6">
            <form id="reviewForm" action="{{ route('reviews.store', $product->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Your Name *</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#93C754] focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Your Email *</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#93C754] focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Rating *</label>
                    <div class="flex space-x-2" id="reviewRatingStars">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="text-3xl text-gray-300 hover:text-yellow-400 transition-colors rating-star-btn" data-rating="{{ $i }}">
                                ★
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="star" id="reviewStarValue" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Your Review *</label>
                    <textarea name="review" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#93C754] focus:border-transparent" placeholder="Share your experience with this product..." required></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeReviewModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium transition-colors">Cancel</button>
                    <button type="submit" class="bg-[#93C754] hover:bg-[#7eae47] text-white px-6 py-2 rounded-lg font-medium transition-colors">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Modal (if needed) -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center p-4">
    <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 transition-colors">&times;</button>
    <img id="modalImage" src="" alt="Product Image" class="max-w-full max-h-full object-contain">
</div>

<style>
    .tab-btn {
        border-color: transparent;
        color: #6B7280;
    }
    .tab-btn.active {
        border-color: #93C754;
        color: #0A4040;
    }
    .rating-star-btn {
        transition: all 0.2s ease;
    }
    .rating-star-btn:hover,
    .rating-star-btn.active {
        color: #FFB800;
        transform: scale(1.1);
    }
    #reviewModal {
        backdrop-filter: blur(4px);
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = {
        description: document.getElementById('description-tab'),
        reviews: document.getElementById('reviews-tab')
    };

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');

            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            Object.values(tabContents).forEach(content => {
                if (content) content.classList.add('hidden');
            });

            if (tabContents[tabId]) {
                tabContents[tabId].classList.remove('hidden');
            }
        });
    });

    // Set default active tab
    if (tabBtns.length > 0) {
        tabBtns[0].classList.add('active');
    }

    // Product Quantity Controls
    const decreaseBtn = document.querySelector('.decrease');
    const increaseBtn = document.querySelector('.increase');
    const quantityInput = document.querySelector('.quantity');
    const maxStockSpan = document.querySelector('.max-stock-display');
    let maxStock = parseInt(maxStockSpan ? maxStockSpan.textContent : 999);

    if (decreaseBtn && increaseBtn && quantityInput) {
        decreaseBtn.addEventListener('click', function() {
            let currentVal = parseInt(quantityInput.value);
            if (currentVal > 1) {
                quantityInput.value = currentVal - 1;
            }
        });

        increaseBtn.addEventListener('click', function() {
            let currentVal = parseInt(quantityInput.value);
            if (currentVal < maxStock) {
                quantityInput.value = currentVal + 1;
            }
        });

        quantityInput.addEventListener('change', function() {
            let val = parseInt(this.value);
            if (isNaN(val) || val < 1) {
                this.value = 1;
            } else if (val > maxStock) {
                this.value = maxStock;
                Swal.fire({
                    icon: 'warning',
                    title: 'Maximum quantity reached',
                    text: `Only ${maxStock} items available in stock.`,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    }

    // Variant Selection
    const variantOptions = document.querySelectorAll('.variant-option');
    const selectedVariantInput = document.getElementById('selectedVariant');

    if (variantOptions.length && selectedVariantInput) {
        variantOptions.forEach(option => {
            option.addEventListener('click', function() {
                variantOptions.forEach(opt => {
                    opt.classList.remove('border-[#93C754]', 'bg-green-50');
                    opt.classList.add('border-gray-200');
                    opt.setAttribute('aria-pressed', 'false');
                });
                this.classList.remove('border-gray-200');
                this.classList.add('border-[#93C754]', 'bg-green-50');
                this.setAttribute('aria-pressed', 'true');

                const variantId = this.getAttribute('data-variant-id');
                selectedVariantInput.value = variantId;

                const stock = parseInt(this.getAttribute('data-stock'));
                maxStock = stock;
                if (maxStockSpan) maxStockSpan.textContent = stock;

                if (parseInt(quantityInput.value) > maxStock) {
                    quantityInput.value = maxStock;
                }
            });
        });
    }

    // Add to Cart Functionality
    const addToCartBtn = document.querySelector('.add-to-cart');

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', async function() {
            const productId = {{ $product->id }};
            const quantity = parseInt(document.querySelector('.quantity').value);
            const variantId = document.getElementById('selectedVariant') ? document.getElementById('selectedVariant').value : null;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            const requestBody = {
                product_id: productId,
                quantity: quantity
            };

            if (variantId) {
                requestBody.variant_id = variantId;
            }

            const originalText = this.innerHTML;
            this.innerHTML = '<span class="add-to-cart-text">Adding...</span><svg class="animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            this.disabled = true;

            try {
                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(requestBody)
                });

                const data = await response.json();

                if (data.success) {
                    const cartCounter = document.getElementById('cart-counter');
                    if (cartCounter) {
                        cartCounter.textContent = data.cart_count;
                        cartCounter.classList.add('animate-bounce');
                        setTimeout(() => cartCounter.classList.remove('animate-bounce'), 500);
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart!',
                        text: 'Product has been added to your cart successfully.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    this.innerHTML = originalText;
                    this.disabled = false;
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.message || 'Something went wrong. Please try again.',
                    confirmButtonText: 'OK'
                });
                this.innerHTML = originalText;
                this.disabled = false;
            }
        });
    }

    // ==================== REVIEW MODAL FUNCTIONALITY ====================

    const openReviewBtn = document.querySelector('.open-review-modal');
    const reviewModal = document.getElementById('reviewModal');

    if (openReviewBtn && reviewModal) {
        openReviewBtn.addEventListener('click', function() {
            reviewModal.classList.remove('hidden');
            reviewModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    }

    window.closeReviewModal = function() {
        if (reviewModal) {
            reviewModal.classList.add('hidden');
            reviewModal.classList.remove('flex');
            document.body.style.overflow = '';
            const reviewForm = document.getElementById('reviewForm');
            if (reviewForm) {
                reviewForm.reset();
            }
            document.querySelectorAll('.rating-star-btn').forEach(btn => {
                btn.classList.remove('active', 'text-yellow-400');
                btn.classList.add('text-gray-300');
            });
            document.getElementById('reviewStarValue').value = '';
        }
    };

    if (reviewModal) {
        reviewModal.addEventListener('click', function(e) {
            if (e.target === reviewModal) {
                closeReviewModal();
            }
        });
    }

    // Rating stars functionality
    const ratingStars = document.querySelectorAll('.rating-star-btn');
    const starValueInput = document.getElementById('reviewStarValue');

    if (ratingStars.length && starValueInput) {
        ratingStars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                starValueInput.value = rating;

                ratingStars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('active', 'text-yellow-400');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.classList.remove('active', 'text-yellow-400');
                        s.classList.add('text-gray-300');
                    }
                });
            });

            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingStars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.classList.add('text-gray-300');
                        s.classList.remove('text-yellow-400');
                    }
                });
            });

            star.addEventListener('mouseleave', function() {
                const currentRating = parseInt(starValueInput.value) || 0;
                ratingStars.forEach((s, index) => {
                    if (index < currentRating) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.classList.remove('text-yellow-400');
                        s.classList.add('text-gray-300');
                    }
                });
            });
        });
    }

    // Handle review form submission
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            const rating = document.getElementById('reviewStarValue').value;
            if (!rating) {
                Swal.fire({
                    icon: 'error',
                    title: 'Rating Required',
                    text: 'Please select a star rating for your review.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Submitting...';
            submitBtn.disabled = true;

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Review Submitted!',
                        text: 'Thank you for your feedback. Your review will appear after approval.',
                        confirmButtonText: 'OK'
                    });
                    closeReviewModal();
                } else {
                    throw new Error(data.message || 'Failed to submit review');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Submission Failed',
                    text: error.message || 'Something went wrong. Please try again.',
                    confirmButtonText: 'OK'
                });
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
});

// Image Modal Functions
function openImageModal(imageUrl, allImages, index) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    if (modal && modalImg) {
        modalImg.src = imageUrl;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
}

// Close image modal with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
        closeReviewModal();
    }
});
</script>
@endsection
