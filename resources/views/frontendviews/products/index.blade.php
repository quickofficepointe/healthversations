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
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', 'Health Versations Products')

@section('twitter_title', 'Our Products | Health Versations')
@section('twitter_description', 'Discover premium wellness products tailored for your health journey.')
@section('twitter_image', asset('Assets/images/health-versations-social.jpg'))
@section('twitter_card', 'summary_large_image')

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Health Versations Products",
  "description": "Premium wellness products for holistic health",
  "url": "{{ route('all.products') }}",
  "numberOfItems": {{ $products->count() }},
  "itemListElement": [
    @foreach($products as $index => $product)
    {
      "@type": "ListItem",
      "position": {{ $index + 1 }},
      "item": {
        "@type": "Product",
        "name": "{{ addslashes($product->product_name) }}",
        "image": "{{ asset($product->cover_image) }}",
        "description": "{{ addslashes(Str::limit(strip_tags($product->description), 150)) }}",
        "offers": {
          "@type": "Offer",
          "priceCurrency": "KES",
          "price": "{{ $product->price_kes }}",
          "availability": "https://schema.org/InStock"
        }
      }
    }@if(!$loop->last),@endif
    @endforeach
  ]
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
    }
  ]
}
</script>
@endpush

@section('content')
<style>
    .product-card {
        transition: all 0.3s ease;
        border-radius: 16px;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .discount-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, #FF6B6B, #EE5A24);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        z-index: 10;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
        margin-right: 8px;
    }

    .current-price {
        color: #52823C;
        font-weight: bold;
        font-size: 20px;
    }

    .save-badge {
        background: #EE5A24;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: bold;
        margin-left: 8px;
    }

    .product-image {
        transition: transform 0.5s ease;
        height: 250px;
        object-fit: cover;
        width: 100%;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .image-container {
        overflow: hidden;
        position: relative;
    }

    .add-to-cart-btn {
        transition: all 0.3s ease;
        background: #52823C;
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
    }

    .add-to-cart-btn:hover {
        background: #3d632e;
        transform: scale(1.05);
    }

    .rating-stars {
        display: inline-flex;
        gap: 2px;
    }

    .star-filled {
        color: #FFB800;
    }

    .star-empty {
        color: #E0E0E0;
    }

    /* Quick View Modal Styles */
    .quick-qty-btn {
        transition: all 0.2s ease;
    }

    .quick-qty-btn:hover {
        background-color: #e5e7eb;
    }

    .quick-quantity {
        -moz-appearance: textfield;
    }

    .quick-quantity::-webkit-inner-spin-button,
    .quick-quantity::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<div class="bg-gradient-to-b from-white to-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <div class="inline-block bg-white/20 backdrop-blur-sm rounded-full px-4 py-1 mb-4">
                <span class="text-sm font-semibold">Limited Time Offer</span>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in">Our Products</h1>
            <p class="text-xl max-w-2xl mx-auto opacity-90">Discover our complete range of health and wellness products</p>
            <div class="flex flex-wrap justify-center gap-3 mt-6">
                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm">20% OFF SITEWIDE</span>
                <span class="bg-yellow-500 text-[#0A4040] px-3 py-1 rounded-full text-sm font-semibold">FREE SHIPPING OVER KES 10,000</span>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12 my-10">

        <div class="w-24 h-1 bg-gradient-to-r from-[#0A4040] to-[#93C754] mx-auto mb-6 rounded-full"></div>
        <h2 class="text-3xl font-bold text-center mb-12 text-[#0A4040]">Premium Quality Products for Your Wellness Journey</h2>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($products as $product)
            @php
                $defaultDiscount = 20;
                $currentPriceKES = $product->variants_count == 0 ? $product->price_kes : $product->variants->min('price_kes');
                $currentPriceUSD = $product->variants_count == 0 ? $product->price_usd : $product->variants->min('price_usd');
                $originalPriceKES = $currentPriceKES / (1 - $defaultDiscount / 100);
                $originalPriceUSD = $currentPriceUSD / (1 - $defaultDiscount / 100);
                $savingsKES = $originalPriceKES - $currentPriceKES;
            @endphp

            <!-- Product Card -->
            <div class="product-card bg-white rounded-2xl shadow-lg hover:shadow-2xl group">
                <div class="image-container relative">
                    <img src="{{ asset($product->cover_image) }}"
                         alt="{{ $product->product_name }}"
                         class="product-image w-full h-64 object-cover"
                         width="300"
                         height="250"
                         loading="lazy">

                    <div class="discount-badge">
                        -{{ $defaultDiscount }}% OFF
                    </div>

                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <button onclick="quickView({{ $product->id }})" class="bg-white text-[#0A4040] px-4 py-2 rounded-full font-semibold hover:bg-[#0A4040] hover:text-white transition-all">
                            Quick View
                        </button>
                    </div>
                </div>

                <div class="p-5">
                    <div class="mb-3">
                        <span class="text-xs font-semibold text-[#93C754] bg-green-50 px-2 py-1 rounded-full">
                            {{ $product->category->category_name ?? 'Premium Quality' }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-[#0A4040] mb-2 line-clamp-2 hover:text-[#52823C] transition-colors">
                        {{ $product->product_name }}
                    </h3>

                    <div class="flex items-center gap-2 mb-3">
                        <div class="rating-stars">
                            @php $rating = $product->avg_rating ?? 4.5; @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($rating))
                                    <i class="fas fa-star star-filled text-xs"></i>
                                @else
                                    <i class="far fa-star star-empty text-xs"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500">({{ $product->reviews_count ?? 0 }} reviews)</span>
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center flex-wrap gap-2 mb-1">
                            <span class="original-price text-gray-400">
                                KES {{ number_format($originalPriceKES, 2) }}
                            </span>
                            <span class="current-price text-[#52823C] text-2xl font-bold">
                                KES {{ number_format($currentPriceKES, 2) }}
                            </span>
                            <span class="save-badge">
                                Save KES {{ number_format($savingsKES, 2) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="original-price text-gray-400 text-sm">
                                ${{ number_format($originalPriceUSD, 2) }}
                            </span>
                            <span class="current-price text-[#52823C] font-bold">
                                ${{ number_format($currentPriceUSD, 2) }}
                            </span>
                        </div>
                        <div class="mt-2">
                            <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-0.5 rounded-full">
                                <i class="fas fa-tag mr-1"></i>
                                You save {{ $defaultDiscount }}% today!
                            </span>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {!! Str::limit(strip_tags($product->description), 80) !!}
                    </p>

                    <div class="flex items-center justify-between gap-3">
                        <a href="{{ route('product.show', $product->slug) }}"
                           class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-[#0A4040] font-semibold py-2 px-3 rounded-lg transition-all text-sm">
                            View Details
                        </a>

                        <button class="add-to-cart-btn flex-1"
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->product_name }}">
                            <i class="fas fa-shopping-cart"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">No products available at the moment.</p>
                <a href="{{ route('home') }}" class="text-[#52823C] hover:underline mt-4 inline-block">
                    Return to homepage
                </a>
            </div>
            @endforelse
        </div>

        <!-- Products CTA Section -->
        <div class="mt-20 bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] rounded-2xl p-10 text-center">
            <h3 class="text-3xl font-bold text-white mb-4">Looking for something specific?</h3>
            <p class="text-gray-200 mb-8 text-lg">We can create custom products tailored to your unique health needs</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('custompackages.create') }}" class="bg-[#93C754] hover:bg-[#7eae47] text-[#0A4040] font-bold px-8 py-3 rounded-lg transition-all transform hover:scale-105">
                    <i class="fas fa-customize mr-2"></i> Request Custom Product
                </a>
                <a href="{{ route('contact.health') }}" class="bg-white hover:bg-gray-100 text-[#0A4040] font-bold px-8 py-3 rounded-lg transition-all transform hover:scale-105">
                    <i class="fas fa-headset mr-2"></i> Contact Us
                </a>
            </div>
        </div>

        <!-- Features Section -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-truck text-2xl text-[#52823C]"></i>
                </div>
                <h4 class="font-semibold text-gray-800">Free Shipping</h4>
                <p class="text-sm text-gray-500">On orders over KES 10,000</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-shield-alt text-2xl text-[#52823C]"></i>
                </div>
                <h4 class="font-semibold text-gray-800">Secure Payment</h4>
                <p class="text-sm text-gray-500">100% secure transactions</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-undo-alt text-2xl text-[#52823C]"></i>
                </div>
                <h4 class="font-semibold text-gray-800">Easy Returns</h4>
                <p class="text-sm text-gray-500">30-day return policy</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-headset text-2xl text-[#52823C]"></i>
                </div>
                <h4 class="font-semibold text-gray-800">24/7 Support</h4>
                <p class="text-sm text-gray-500">Dedicated customer service</p>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="mt-8 px-4 pb-12">
        {{ $products->links() }}
    </div>
    @endif
</div>

<!-- Quick View Modal -->
<div id="quickViewModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b p-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-[#0A4040]">Quick View</h3>
            <button onclick="closeQuickView()" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div id="quickViewContent" class="p-6">
            <!-- Content loaded via AJAX -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to Cart functionality for products listing page
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const productId = this.dataset.productId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            this.disabled = true;

            try {
                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                });

                const data = await response.json();

                if (data.success) {
                    const cartCounter = document.getElementById('cart-counter');
                    if (cartCounter) {
                        cartCounter.textContent = data.cart_count;
                        cartCounter.classList.add('animate-bounce');
                        setTimeout(() => cartCounter.classList.remove('animate-bounce'), 500);
                    }

                    this.innerHTML = '<i class="fas fa-check"></i> Added!';
                    this.style.background = '#10B981';

                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart!',
                        text: 'Product has been added to your cart.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.background = '#52823C';
                        this.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            } catch (error) {
                console.error('Error:', error);
                this.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Error';
                this.style.background = '#EF4444';

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.message || 'Something went wrong. Please try again.',
                    confirmButtonText: 'OK'
                });

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.background = '#52823C';
                    this.disabled = false;
                }, 2000);
            }
        });
    });
});

// Global functions for quick view
function quickView(productId) {
    const modal = document.getElementById('quickViewModal');
    const content = document.getElementById('quickViewContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    content.innerHTML = '<div class="text-center py-8"><i class="fas fa-spinner fa-spin text-3xl text-[#52823C]"></i><p class="mt-2">Loading...</p></div>';

    fetch(`/product/${productId}/quick-view`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        content.innerHTML = data.html;
        // Initialize quick view functionality after content is loaded
        initQuickViewFunctions();
    })
    .catch(error => {
        console.error('Error:', error);
        content.innerHTML = '<div class="text-center py-8 text-red-500">Error loading product details. Please try again.</div>';
    });
}

function closeQuickView() {
    const modal = document.getElementById('quickViewModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function initQuickViewFunctions() {
    const modal = document.getElementById('quickViewModal');
    if (!modal) return;

    // Quantity controls for quick view
    const decreaseBtn = modal.querySelector('.quick-qty-decrease');
    const increaseBtn = modal.querySelector('.quick-qty-increase');
    const quantityInput = modal.querySelector('.quick-quantity');

    if (decreaseBtn && increaseBtn && quantityInput) {
        const maxStock = parseInt(quantityInput.getAttribute('max')) || 999;

        // Remove existing listeners by cloning
        const newDecreaseBtn = decreaseBtn.cloneNode(true);
        const newIncreaseBtn = increaseBtn.cloneNode(true);
        decreaseBtn.parentNode.replaceChild(newDecreaseBtn, decreaseBtn);
        increaseBtn.parentNode.replaceChild(newIncreaseBtn, increaseBtn);

        newDecreaseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            let currentVal = parseInt(quantityInput.value);
            if (currentVal > 1) {
                quantityInput.value = currentVal - 1;
            }
        });

        newIncreaseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            let currentVal = parseInt(quantityInput.value);
            if (currentVal < maxStock) {
                quantityInput.value = currentVal + 1;
            } else {
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

    // Add to cart button in quick view
    const addToCartBtn = modal.querySelector('.quick-add-to-cart');
    if (addToCartBtn) {
        const newAddToCartBtn = addToCartBtn.cloneNode(true);
        addToCartBtn.parentNode.replaceChild(newAddToCartBtn, addToCartBtn);

        newAddToCartBtn.addEventListener('click', async function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            const quantityInput = modal.querySelector('.quick-quantity');
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            this.disabled = true;

            try {
                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });

                const data = await response.json();

                if (data.success) {
                    const cartCounter = document.getElementById('cart-counter');
                    if (cartCounter) {
                        cartCounter.textContent = data.cart_count;
                        cartCounter.classList.add('animate-bounce');
                        setTimeout(() => cartCounter.classList.remove('animate-bounce'), 500);
                    }

                    this.innerHTML = '<i class="fas fa-check"></i> Added!';
                    this.style.background = '#10B981';

                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart!',
                        text: 'Product has been added to your cart.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(() => {
                        closeQuickView();
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            } catch (error) {
                console.error('Error:', error);
                this.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Error';
                this.style.background = '#EF4444';

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.message || 'Something went wrong. Please try again.',
                    confirmButtonText: 'OK'
                });

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.background = '#52823C';
                    this.disabled = false;
                }, 2000);
            }
        });
    }
}
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in 0.6s ease-out; }
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
