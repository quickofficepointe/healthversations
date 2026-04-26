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
      "position": 2",
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
        <p class="text-sm mt-1 opacity-90">Use code automatically applied at checkout | Offer ends soon</p>
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
            <div class="flex gap-2 mt-4 overflow-x-auto scrollbar-hide pb-2">
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
                                // Calculate discounted prices for variant
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
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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

    <!-- Rest of the content remains same (tabbed content, modals, scripts) -->
    <!-- ... keep your existing tabbed content, modals, and scripts ... -->
</div>
@endsection
