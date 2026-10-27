{{-- Product quick view, rendered by ProductController@quickView and injected into #quickViewContent --}}
@php
    $hasVariants = $product->variants_count > 0;
    $inStockVariants = $product->variants->where('stock', '>', 0);
    $defaultVariant = $hasVariants ? ($inStockVariants->sortBy('price_kes')->first() ?? $product->variants->sortBy('price_kes')->first()) : null;
    $stock = $hasVariants ? (int) optional($defaultVariant)->stock : (int) $product->stock;
    $gallery = collect([$product->cover_image])
        ->merge($product->images->pluck('image_path'))
        ->filter()
        ->unique()
        ->values();
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Images -->
    <div>
        <div class="relative rounded-xl overflow-hidden bg-gray-50">
            <img id="quickViewMainImage" src="{{ asset($gallery->first()) }}" alt="{{ $product->product_name }}" class="w-full h-80 object-cover">
            <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">-{{ $defaultDiscount }}% OFF</span>
        </div>
        @if($gallery->count() > 1)
            <div class="flex gap-2 mt-3 overflow-x-auto">
                @foreach($gallery as $image)
                    <button type="button" class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 {{ $loop->first ? 'border-[#52823C]' : 'border-transparent' }} hover:border-[#52823C]"
                            onclick="document.getElementById('quickViewMainImage').src=this.querySelector('img').src; this.parentNode.querySelectorAll('button').forEach(b=>b.classList.replace('border-[#52823C]','border-transparent')); this.classList.replace('border-transparent','border-[#52823C]');">
                        <img src="{{ asset($image) }}" alt="" class="w-full h-full object-cover">
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Details -->
    <div class="flex flex-col">
        <span class="self-start text-xs font-semibold text-[#93C754] bg-green-50 px-2 py-1 rounded-full mb-2">
            {{ optional($product->category)->category_name ?? 'Premium Quality' }}
        </span>
        <h2 class="text-2xl font-bold text-[#0A4040] mb-3">{{ $product->product_name }}</h2>

        <div class="mb-4">
            <div class="flex items-center flex-wrap gap-2">
                <span class="text-gray-400 line-through" id="quickViewOriginalPrice">KES {{ number_format($originalPriceKES, 2) }}</span>
                <span class="text-[#52823C] text-3xl font-bold" id="quickViewPrice">KES {{ number_format($currentPriceKES, 2) }}</span>
            </div>
            <div class="flex items-center gap-2 text-sm mt-1">
                <span class="text-gray-400 line-through">${{ number_format($originalPriceUSD, 2) }}</span>
                <span class="text-[#52823C] font-bold">${{ number_format($currentPriceUSD, 2) }}</span>
                <span class="bg-green-50 text-green-700 text-xs font-medium px-2 py-0.5 rounded-full" id="quickViewSavings">Save KES {{ number_format($savingsKES, 2) }}</span>
            </div>
            @if($hasVariants)
                <p class="text-xs text-gray-500 mt-1">Price shown is for the selected option.</p>
            @endif
        </div>

        @if($product->description)
            <div class="text-gray-600 text-sm leading-relaxed mb-4 max-h-40 overflow-y-auto">
                {!! \Illuminate\Support\Str::limit(strip_tags($product->description, '<p><br><strong><em><ul><ol><li>'), 600) !!}
            </div>
        @endif

        @if($hasVariants)
            <div class="mb-4">
                <label for="quickViewVariant" class="block text-sm font-medium text-gray-700 mb-1">Choose an option</label>
                <select id="quickViewVariant" class="quick-variant w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#93C754]">
                    @foreach($product->variants->sortBy('price_kes') as $variant)
                        <option value="{{ $variant->id }}"
                                data-price="{{ $variant->price_kes }}"
                                data-original="{{ round($variant->price_kes / (1 - $defaultDiscount / 100), 2) }}"
                                data-stock="{{ (int) $variant->stock }}"
                                @selected(optional($defaultVariant)->id === $variant->id)
                                @disabled($variant->stock < 1)>
                            {{ $variant->display_name ?: $variant->name }} — KES {{ number_format($variant->price_kes, 2) }}{{ $variant->stock < 1 ? ' (out of stock)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <p class="text-sm mb-4" id="quickViewStock">
            @if($stock > 0)
                <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>In stock{{ $stock <= 10 ? " — only {$stock} left" : '' }}</span>
            @else
                <span class="text-red-500"><i class="fas fa-times-circle mr-1"></i>Out of stock</span>
            @endif
        </p>

        <div class="flex items-center gap-3 mb-4">
            <div class="flex items-center border border-gray-300 rounded-lg">
                <button type="button" class="quick-qty-decrease px-3 py-2 text-gray-600 hover:bg-gray-100" aria-label="Decrease quantity">−</button>
                <input type="number" class="quick-quantity w-14 text-center border-0 focus:ring-0" value="1" min="1" max="{{ max($stock, 1) }}" aria-label="Quantity">
                <button type="button" class="quick-qty-increase px-3 py-2 text-gray-600 hover:bg-gray-100" aria-label="Increase quantity">+</button>
            </div>
            <button type="button" class="quick-add-to-cart flex-1 bg-[#52823C] hover:bg-[#0A4040] text-white font-semibold px-6 py-3 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    data-product-id="{{ $product->id }}" @disabled($stock < 1)>
                <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
            </button>
        </div>

        <a href="{{ route('product.show', $product->slug) }}" class="text-[#52823C] hover:text-[#0A4040] text-sm font-medium mt-auto">
            View full details <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>
