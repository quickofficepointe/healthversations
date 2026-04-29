@extends('layouts.app')

@section('title', 'Your Shopping Cart | Health Versations')
@section('meta_description', 'Review the items in your shopping cart and proceed to checkout for premium wellness products from Health Versations.')
@section('meta_keywords', 'shopping cart, health products, checkout, Health Versations, natural supplements, wellness products')
@section('meta_author', 'Health Versations')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('cart.index'))

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Your Shopping Cart</h1>

    @if(count($cartItems) > 0)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Desktop Table Headers -->
        <div class="hidden md:grid grid-cols-12 bg-gray-100 p-4 font-semibold border-b">
            <div class="col-span-6">Product</div>
            <div class="col-span-2 text-center">Price</div>
            <div class="col-span-2 text-center">Quantity</div>
            <div class="col-span-2 text-center">Total</div>
        </div>

        @foreach($cartItems as $cartKey => $item)
        <div class="border-b cart-item" data-id="{{ $cartKey }}" data-unit-price="{{ $item['price_kes'] }}">
            <!-- Mobile Layout -->
            <div class="md:hidden p-4">
                <div class="flex items-start mb-4">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded mr-4">
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-800">{{ $item['name'] }}</h3>
                        @if(isset($item['variant_name']) && $item['variant_name'])
                            <p class="text-sm text-gray-500">{{ $item['variant_name'] }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <div class="text-gray-600 unit-price-display">
                        Ksh {{ number_format($item['price_kes'], 2) }}
                    </div>

                    <div class="flex items-center">
                        <button class="decrease-quantity bg-gray-200 hover:bg-gray-300 w-8 h-8 flex items-center justify-center rounded-l">
                            <span class="text-lg">-</span>
                        </button>
                        <input type="number" value="{{ $item['quantity'] }}" min="1" max="99"
                               class="quantity-input w-12 text-center border-t border-b border-gray-300 py-1 h-8">
                        <button class="increase-quantity bg-gray-200 hover:bg-gray-300 w-8 h-8 flex items-center justify-center rounded-r">
                            <span class="text-lg">+</span>
                        </button>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <div class="font-medium item-total">
                        Ksh {{ number_format($item['price_kes'] * $item['quantity'], 2) }}
                    </div>
                    <button class="remove-item text-red-500 text-sm hover:text-red-700" data-id="{{ $cartKey }}">
                        Remove
                    </button>
                </div>
            </div>

            <!-- Desktop Layout -->
            <div class="hidden md:grid grid-cols-12 p-4 items-center">
                <div class="col-span-6 flex items-center">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded mr-4">
                    <div>
                        <h3 class="font-medium text-gray-800">{{ $item['name'] }}</h3>
                        @if(isset($item['variant_name']) && $item['variant_name'])
                            <p class="text-sm text-gray-500">{{ $item['variant_name'] }}</p>
                        @endif
                        <button class="remove-item text-red-500 text-sm hover:text-red-700 mt-1" data-id="{{ $cartKey }}">
                            Remove
                        </button>
                    </div>
                </div>

                <div class="col-span-2 text-center text-gray-600 unit-price-display">
                    Ksh {{ number_format($item['price_kes'], 2) }}
                </div>

                <div class="col-span-2 text-center">
                    <div class="flex justify-center items-center">
                        <button class="decrease-quantity bg-gray-200 hover:bg-gray-300 w-8 h-8 flex items-center justify-center rounded-l">
                            <span class="text-lg">-</span>
                        </button>
                        <input type="number" value="{{ $item['quantity'] }}" min="1" max="99"
                               class="quantity-input w-12 text-center border-t border-b border-gray-300 py-1 h-8">
                        <button class="increase-quantity bg-gray-200 hover:bg-gray-300 w-8 h-8 flex items-center justify-center rounded-r">
                            <span class="text-lg">+</span>
                        </button>
                    </div>
                </div>

                <div class="col-span-2 text-center font-medium item-total">
                    Ksh {{ number_format($item['price_kes'] * $item['quantity'], 2) }}
                </div>
            </div>
        </div>
        @endforeach

        <!-- Cart Summary -->
        <div class="p-4 flex flex-col sm:flex-row justify-between items-center bg-gray-50 space-y-4 sm:space-y-0">
            <div class="text-xl font-semibold">
                Subtotal: <span class="text-green-600 cart-subtotal">Ksh {{ number_format($totalKES, 2) }}</span>
            </div>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('all.products') }}" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100 text-center">
                    Continue Shopping
                </a>
                <button id="proceedToCheckoutBtn" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-center">
                    Proceed to Checkout
                </button>
            </div>
        </div>
    </div>

    <!-- Checkout Form (Initially Hidden) -->
    <div id="checkoutFormSection" class="bg-white rounded-lg shadow-md p-6 mt-8 hidden">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Checkout</h2>

        <form id="checkoutForm" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 font-medium">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500" required>
                </div>
                <div>
                    <label class="block mb-2 font-medium">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" name="last_name" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500" required>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Phone Number <span class="text-red-500">*</span></label>
                <input type="tel" name="phone" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500" required placeholder="2547XXXXXXXX">
                <p class="text-xs text-gray-500 mt-1">Enter your phone number in format 2547XXXXXXXX</p>
            </div>

            <!-- Payment Method Selection -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Payment Method</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="payment-method-card cursor-pointer">
                        <input type="radio" name="payment_method" value="kcb" class="sr-only peer" checked>
                        <div class="p-4 border-2 border-gray-200 rounded-lg hover:border-[#0A4040] peer-checked:border-[#0A4040] peer-checked:bg-[#0A4040]/10 transition-all">
                            <div class="flex items-center">
                                <i class="fas fa-mobile-alt text-[#0A4040] text-xl mr-3"></i>
                                <div>
                                    <h4 class="font-medium text-[#0A4040]">M-Pesa</h4>
                                    <p class="text-sm text-gray-600">Pay with your M-Pesa account</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="payment-method-card cursor-pointer">
                        <input type="radio" name="payment_method" value="iveri" class="sr-only peer">
                        <div class="p-4 border-2 border-gray-200 rounded-lg hover:border-[#93C754] peer-checked:border-[#93C754] peer-checked:bg-[#93C754]/10 transition-all">
                            <div class="flex items-center">
                                <i class="fas fa-credit-card text-[#93C754] text-xl mr-3"></i>
                                <div>
                                    <h4 class="font-medium text-[#0A4040]">Credit/Debit Card</h4>
                                    <p class="text-sm text-gray-600">Pay with Visa, Mastercard, or Amex</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Delivery Method Selection -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Delivery Method</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border rounded-lg p-4 cursor-pointer delivery-option" data-method="pickup" data-cost="0" data-zone="B">
                        <div class="flex items-center">
                            <input type="radio" name="delivery_method" value="pickup" class="mr-2 delivery-method-radio" checked>
                            <label class="font-medium cursor-pointer">Pickup (FREE)</label>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">TOM MBOYA STREET, STAR MALL, 1st Floor, Shop A17</p>
                    </div>

                    <div class="border rounded-lg p-4 cursor-pointer delivery-option" data-method="delivery" data-cost="" data-zone="">
                        <div class="flex items-center">
                            <input type="radio" name="delivery_method" value="delivery" class="mr-2 delivery-method-radio">
                            <label class="font-medium cursor-pointer">Home Delivery</label>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Select your delivery zone below</p>
                    </div>
                </div>
            </div>

            <!-- Delivery Zone Selection -->
            <div id="deliveryZoneSection" class="mb-6 hidden">
                <h3 class="text-lg font-semibold mb-4">Select Delivery Zone</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach([
                        'A' => ['name' => 'Zone A: CBD Delivery', 'rate' => 150, 'areas' => 'Around Nairobi CBD'],
                        'J' => ['name' => 'Zone J', 'rate' => 350, 'areas' => 'Roasters, Mountain Mall, Garden City, TRM, Lumumba Drive, USIU, Ngumba etc.'],
                        'D' => ['name' => 'Zone D', 'rate' => 400, 'areas' => 'Kangemi, Loresho, Mountain View, Spring Valley, Lower Kabete etc.'],
                        'F' => ['name' => 'Zone F', 'rate' => 400, 'areas' => 'Junction Mall, Lavington, Kibra, Dagoretti Corner, Kawangware, Wanyee etc.'],
                        'K' => ['name' => 'Zone K', 'rate' => 400, 'areas' => 'Outside Nairobi via courier – 2NK, Nakonns, Chania, Northrift, Genesis, Easy Coach etc.'],
                        'N' => ['name' => 'Zone N', 'rate' => 400, 'areas' => 'Donholm, Uhuru Estate, Buruburu, Fedha, Tassia, Savanah, Pipeline, Mtindwa, Lucky Summer'],
                        'G' => ['name' => 'Zone G', 'rate' => 450, 'areas' => 'Ruaka, Runda, Nyari, Gigiri, UNEP, Muchatha, Thindigua, Muthaiga North, Fourways, Ridgeways, Komarock, Tassia etc.'],
                        'M' => ['name' => 'Zone M', 'rate' => 450, 'areas' => 'Mirema, Kahawa Sukari, Zimmerman, Githurai, Kahawa West, Kahawa Wendani, Clayworks etc.'],
                        'H' => ['name' => 'Zone H', 'rate' => 600, 'areas' => 'Gateway Mall, Syokimau, Kinoo, Kenyatta Road, Ruiru Bypass'],
                        'O' => ['name' => 'Zone O', 'rate' => 650, 'areas' => 'Utawala, Karen, Ruiru Town'],
                        'P' => ['name' => 'Zone P', 'rate' => 800, 'areas' => 'Rongai, Kikuyu, Kiambu Town, Tatu City'],
                        'R' => ['name' => 'Zone R', 'rate' => 900, 'areas' => 'Athi River'],
                        'Q' => ['name' => 'Zone Q', 'rate' => 1350, 'areas' => 'Thika Town, Kamulu, Kitengela']
                    ] as $zone => $details)
                    <div class="border rounded-lg p-4 cursor-pointer zone-option" data-zone="{{ $zone }}" data-cost="{{ $details['rate'] }}">
                        <div class="flex items-center">
                            <input type="radio" name="delivery_zone" value="{{ $zone }}" class="mr-2 zone-radio">
                            <label class="font-medium cursor-pointer">{{ $details['name'] }}</label>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $details['areas'] }}</p>
                        <p class="text-sm font-semibold mt-2">Rate: Ksh {{ number_format($details['rate'], 2) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Information Container -->
            <div id="shippingInfoContainer"></div>

            <!-- Order Summary -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <div class="flex justify-between mb-2">
                    <span>Subtotal:</span>
                    <span class="text-gray-600 cart-subtotal">Ksh {{ number_format($totalKES, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Delivery:</span>
                    <span class="text-gray-600" id="deliveryCostDisplay">Ksh 0.00</span>
                </div>
                <div class="flex justify-between text-lg font-bold">
                    <span>Total:</span>
                    <span class="text-green-600 cart-total">Ksh {{ number_format($totalKES, 2) }}</span>
                </div>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition">
                Pay Now
            </button>
        </form>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <h2 class="text-xl font-medium text-gray-700 mt-4">Your cart is empty</h2>
        <p class="text-gray-500 mt-2">Looks like you haven't added any items to your cart yet.</p>
        <a href="/" class="mt-6 inline-block px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Start Shopping
        </a>
    </div>
    @endif
</div>

<!-- Hidden payment form for iVeri -->
<form id="iveriPaymentForm" method="POST" action="{{ config('services.iveri.url', 'https://portal.host.iveri.com/Lite/Authorise.aspx') }}" class="hidden">
    @csrf
    <input type="hidden" name="Lite_Version" value="4.0">
    <input type="hidden" name="Lite_Merchant_ApplicationId" value="{{ config('services.iveri.app_id', '3a7f44fd-4bb4-432c-b483-32e5a19e100d') }}">
    <input type="hidden" name="Lite_Order_Amount" id="iveriAmount">
    <input type="hidden" name="Ecom_ConsumerOrderID" id="iveriOrderId">
    <input type="hidden" name="Lite_Website_Successful_Url" value="{{ route('payment.success') }}">
    <input type="hidden" name="Lite_Website_Fail_Url" value="{{ route('payment.fail') }}">
    <input type="hidden" name="Lite_Website_TryLater_Url" value="{{ route('payment.retry') }}">
    <input type="hidden" name="Lite_Website_Error_Url" value="{{ route('payment.error') }}">
    <input type="hidden" name="Lite_ConsumerOrderID_PreFix" value="ORD">
    <input type="hidden" name="Ecom_Payment_Card_Protocols" value="iVeri">
    <input type="hidden" name="Ecom_TransactionComplete" value="false">
    <input type="hidden" name="Lite_Currency_AlphaCode" value="KES">
    <input type="hidden" name="Lite_Transaction_Token" id="iveriToken">
    <input type="hidden" name="Ecom_BillTo_Online_Email" id="iveriEmail">
    <input type="hidden" name="Ecom_BillTo_Postal_Name_First" id="iveriFirstName">
    <input type="hidden" name="Ecom_BillTo_Postal_Name_Last" id="iveriLastName">
    <input type="hidden" name="delivery_cost" id="iveriDeliveryCost">
    <input type="hidden" name="delivery_zone" id="iveriDeliveryZone">
    <input type="hidden" name="order_id" id="iveriOrderIdField">
</form>

<!-- Payment Status Modal -->
<div id="payment-status-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 p-4 overflow-auto">
    <div class="flex items-center justify-center min-h-full">
        <div class="bg-white max-w-md mx-auto rounded-lg p-6 relative text-center">
            <button id="close-payment-modal-top" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div id="payment-status-content" class="mt-4"></div>
            <button id="close-payment-modal-bottom" class="mt-6 px-6 py-2 bg-[#93C754] text-white rounded hover:bg-[#7eae47] transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const proceedBtn = document.getElementById('proceedToCheckoutBtn');
    if (proceedBtn) {
        proceedBtn.addEventListener('click', function() {
            const checkoutForm = document.getElementById('checkoutFormSection');
            if (checkoutForm) {
                checkoutForm.classList.remove('hidden');
                window.scrollTo({ top: checkoutForm.offsetTop - 20, behavior: 'smooth' });
            }
        });
    }

    let cartSubtotal = {{ $totalKES }};

    // Delivery method selection
    const deliveryOptions = document.querySelectorAll('.delivery-option');
    const deliveryZoneSection = document.getElementById('deliveryZoneSection');
    const shippingInfoContainer = document.getElementById('shippingInfoContainer');
    const deliveryCostDisplay = document.getElementById('deliveryCostDisplay');
    const cartTotalDisplay = document.querySelector('.cart-total');

    const shippingFieldsHTML = `
        <div id="shippingInfoSection">
            <h3 class="text-lg font-semibold mb-4">Shipping Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 font-medium">County <span class="text-red-500">*</span></label>
                    <select name="county" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500 shipping-field" required>
                        <option value="">Select County</option>
                        @foreach(['Baringo', 'Bomet', 'Bungoma', 'Busia', 'Elgeyo-Marakwet', 'Embu', 'Garissa', 'Homa Bay', 'Isiolo', 'Kajiado', 'Kakamega', 'Kericho', 'Kiambu', 'Kilifi', 'Kirinyaga', 'Kisii', 'Kisumu', 'Kitui', 'Kwale', 'Laikipia', 'Lamu', 'Machakos', 'Makueni', 'Mandera', 'Marsabit', 'Meru', 'Migori', 'Mombasa', 'Murang\'a', 'Nairobi', 'Nakuru', 'Nandi', 'Narok', 'Nyamira', 'Nyandarua', 'Nyeri', 'Samburu', 'Siaya', 'Taita-Taveta', 'Tana River', 'Tharaka-Nithi', 'Trans Nzoia', 'Turkana', 'Uasin Gishu', 'Vihiga', 'Wajir', 'West Pokot'] as $county)
                            <option value="{{ $county }}">{{ $county }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2 font-medium">Subcounty <span class="text-red-500">*</span></label>
                    <input type="text" name="subcounty" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500 shipping-field" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-medium">Location/Neighborhood <span class="text-red-500">*</span></label>
                <input type="text" name="location" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500 shipping-field" required>
            </div>
            <div class="mb-6">
                <label class="block mb-2 font-medium">Detailed Address <span class="text-red-500">*</span></label>
                <textarea name="address" rows="2" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500 shipping-field" required></textarea>
            </div>
        </div>
    `;

    function updateTotalDisplay() {
        const deliveryCostText = deliveryCostDisplay.textContent;
        let deliveryCost = 0;
        if (deliveryCostText) {
            deliveryCost = parseFloat(deliveryCostText.replace('Ksh ', '').replace(/,/g, '')) || 0;
        }
        const finalTotal = cartSubtotal + deliveryCost;
        cartTotalDisplay.textContent = 'Ksh ' + finalTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        const subtotalElements = document.querySelectorAll('.cart-subtotal');
        subtotalElements.forEach(el => {
            el.textContent = 'Ksh ' + cartSubtotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        });
    }

    function updateDeliveryCost(cost, zone) {
        deliveryCostDisplay.textContent = 'Ksh ' + cost.toFixed(2);
        updateTotalDisplay();
    }

    function showShippingInfo() {
        shippingInfoContainer.innerHTML = shippingFieldsHTML;
    }

    function removeShippingInfo() {
        shippingInfoContainer.innerHTML = '';
    }

    // Initialize with pickup selected
    updateDeliveryCost(0, 'B');
    removeShippingInfo();
    deliveryZoneSection.classList.add('hidden');

    deliveryOptions.forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.querySelector('.delivery-method-radio');
            radio.checked = true;
            const method = this.getAttribute('data-method');
            const cost = this.getAttribute('data-cost');
            const zone = this.getAttribute('data-zone');

            if (method === 'delivery') {
                deliveryZoneSection.classList.remove('hidden');
                showShippingInfo();
                const firstZone = document.querySelector('.zone-option');
                if (firstZone && !document.querySelector('input[name="delivery_zone"]:checked')) {
                    const zoneRadio = firstZone.querySelector('.zone-radio');
                    zoneRadio.checked = true;
                    updateDeliveryCost(parseFloat(firstZone.getAttribute('data-cost')), firstZone.getAttribute('data-zone'));
                }
            } else {
                deliveryZoneSection.classList.add('hidden');
                removeShippingInfo();
                updateDeliveryCost(parseFloat(cost), zone);
            }
        });
    });

    document.querySelectorAll('.zone-option').forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.querySelector('.zone-radio');
            radio.checked = true;
            const cost = parseFloat(this.getAttribute('data-cost'));
            const zone = this.getAttribute('data-zone');
            updateDeliveryCost(cost, zone);
        });
    });

    // Cart quantity update function
    async function updateCartQuantity(cartItem, newQuantity) {
        const cartKey = cartItem.getAttribute('data-id');

        try {
            const response = await fetch(`/cart/update/${cartKey}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: newQuantity })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                const unitPrice = parseFloat(cartItem.getAttribute('data-unit-price'));
                const itemTotal = unitPrice * newQuantity;

                const itemTotalElements = cartItem.querySelectorAll('.item-total');
                itemTotalElements.forEach(el => {
                    el.textContent = 'Ksh ' + itemTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                });

                const quantityInputs = cartItem.querySelectorAll('.quantity-input');
                quantityInputs.forEach(input => {
                    input.value = newQuantity;
                });

                if (data.cart_total !== undefined) {
                    cartSubtotal = data.cart_total;
                    updateTotalDisplay();
                }

                const cartCounter = document.getElementById('cart-counter');
                if (cartCounter && data.cart_count !== undefined) {
                    cartCounter.textContent = data.cart_count;
                }

                return true;
            } else {
                throw new Error(data.message || 'Failed to update cart');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to update cart. Please try again.');
            return false;
        }
    }

    // Quantity control event listeners
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', async function() {
            const cartItem = this.closest('.cart-item');
            let newQuantity = parseInt(this.value);
            if (isNaN(newQuantity) || newQuantity < 1) newQuantity = 1;
            await updateCartQuantity(cartItem, newQuantity);
        });
    });

    document.querySelectorAll('.increase-quantity').forEach(button => {
        button.addEventListener('click', async function() {
            const cartItem = this.closest('.cart-item');
            const input = cartItem.querySelector('.quantity-input');
            const newQuantity = parseInt(input.value) + 1;
            await updateCartQuantity(cartItem, newQuantity);
        });
    });

    document.querySelectorAll('.decrease-quantity').forEach(button => {
        button.addEventListener('click', async function() {
            const cartItem = this.closest('.cart-item');
            const input = cartItem.querySelector('.quantity-input');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                const newQuantity = currentValue - 1;
                await updateCartQuantity(cartItem, newQuantity);
            }
        });
    });

    // Remove item from cart
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', async function() {
            const itemId = this.getAttribute('data-id');
            if (!itemId) return;

            try {
                const response = await fetch(`/cart/remove/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    const itemElement = document.querySelector(`.cart-item[data-id="${itemId}"]`);
                    if (itemElement) itemElement.remove();

                    if (document.querySelectorAll('.cart-item').length === 0) {
                        location.reload();
                    } else {
                        const data = await response.json();
                        if (data.cart_total !== undefined) {
                            cartSubtotal = data.cart_total;
                            updateTotalDisplay();
                        }
                        const cartCounter = document.getElementById('cart-counter');
                        if (cartCounter && data.cart_count !== undefined) {
                            cartCounter.textContent = data.cart_count;
                        }
                    }
                } else {
                    throw new Error('Failed to remove item');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to remove item from cart. Please try again.');
            }
        });
    });

    // Payment status modal functions
    function showPaymentStatusModal(content) {
        const modal = document.getElementById('payment-status-modal');
        document.getElementById('payment-status-content').innerHTML = content;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function hidePaymentStatusModal() {
        const modal = document.getElementById('payment-status-modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        if (window.paymentStatusInterval) {
            clearInterval(window.paymentStatusInterval);
            window.paymentStatusInterval = null;
        }
    }

    document.getElementById('close-payment-modal-top')?.addEventListener('click', hidePaymentStatusModal);
    document.getElementById('close-payment-modal-bottom')?.addEventListener('click', hidePaymentStatusModal);
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') hidePaymentStatusModal();
    });
    document.addEventListener('click', function(e) {
        if (e.target.id === 'payment-status-modal') hidePaymentStatusModal();
    });

    // KCB Payment
    async function initiateKcbPayment(paymentData) {
        try {
            const response = await fetch('{{ route("kcb.payment.initiate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(paymentData)
            });
            const data = await response.json();
            if (data.success) {
                return { success: true, checkout_request_id: data.checkout_request_id, customer_message: data.customer_message, order_id: data.order_id };
            } else {
                throw new Error(data.message || 'Payment initiation failed');
            }
        } catch (error) {
            console.error('KCB Payment Error:', error);
            throw error;
        }
    }

    async function checkKcbPaymentStatus(checkoutRequestId) {
        try {
            const response = await fetch('{{ route("kcb.payment.status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ checkout_request_id: checkoutRequestId })
            });
            const data = await response.json();

            if (data.success && data.status === 'completed') {
                showPaymentStatusModal(`
                    <div class="text-green-600">
                        <i class="fas fa-check-circle text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Payment Successful!</h3>
                        <p class="text-gray-600">Your order has been placed successfully.</p>
                        <p class="text-sm text-gray-500 mt-2">Order #: ${window.currentOrderId || data.order_id}</p>
                        <p class="text-sm text-gray-500">Receipt: ${data.mpesa_receipt_number || 'N/A'}</p>
                    </div>
                `);
                if (window.paymentStatusInterval) clearInterval(window.paymentStatusInterval);
                setTimeout(() => { window.location.href = '{{ route("kcb.payment.success") }}?order_id=' + (window.currentOrderId || data.order_id); }, 3000);
            } else if (data.success && data.status === 'failed') {
                showPaymentStatusModal(`
                    <div class="text-red-600">
                        <i class="fas fa-times-circle text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Payment Failed</h3>
                        <p class="text-gray-600">${data.result_description || 'Please try again.'}</p>
                        <p class="text-sm text-gray-500 mt-4">You can close this window and try again from the checkout page.</p>
                    </div>
                `);
                if (window.paymentStatusInterval) clearInterval(window.paymentStatusInterval);
            }
        } catch (error) {
            console.error('Error checking payment status:', error);
        }
    }

    // Form submission
    const checkoutForm = document.getElementById('checkoutForm');
    const iveriForm = document.getElementById('iveriPaymentForm');

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked').value;
            const submitButton = checkoutForm.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;

            const phone = document.querySelector('input[name="phone"]').value;
            if (!phone.startsWith('254') || phone.length !== 12) {
                alert('Please enter a valid phone number in format 2547XXXXXXXX');
                return;
            }

            submitButton.innerHTML = '<span class="spinner"></span> Processing...';
            submitButton.disabled = true;

            try {
                const formData = new FormData();
                formData.append('first_name', document.querySelector('input[name="first_name"]').value);
                formData.append('last_name', document.querySelector('input[name="last_name"]').value);
                formData.append('email', document.querySelector('input[name="email"]').value);
                formData.append('phone', phone);
                formData.append('delivery_method', deliveryMethod);
                formData.append('delivery_zone', document.querySelector('input[name="delivery_zone"]:checked')?.value || 'B');
                formData.append('payment_method', paymentMethod);

                if (deliveryMethod === 'delivery') {
                    formData.append('county', document.querySelector('select[name="county"]')?.value || '');
                    formData.append('subcounty', document.querySelector('input[name="subcounty"]')?.value || '');
                    formData.append('location', document.querySelector('input[name="location"]')?.value || '');
                    formData.append('address', document.querySelector('textarea[name="address"]')?.value || '');
                } else {
                    formData.append('county', '');
                    formData.append('subcounty', '');
                    formData.append('location', '');
                    formData.append('address', '');
                }

                const orderResponse = await fetch("{{ route('cart.order.process') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: formData
                });

                const orderData = await orderResponse.json();

                if (orderData.success && orderData.order_id) {
                    window.currentOrderId = orderData.order_id;

                    if (paymentMethod === 'iveri') {
                        document.getElementById('iveriOrderIdField').value = orderData.order_id;
                        document.getElementById('iveriAmount').value = orderData.amount * 100;
                        document.getElementById('iveriOrderId').value = orderData.order_id;
                        document.getElementById('iveriToken').value = orderData.token;
                        document.getElementById('iveriEmail').value = orderData.email;
                        document.getElementById('iveriFirstName').value = orderData.first_name;
                        document.getElementById('iveriLastName').value = orderData.last_name;
                        document.getElementById('iveriDeliveryCost').value = orderData.delivery_cost;
                        document.getElementById('iveriDeliveryZone').value = orderData.delivery_zone;
                        iveriForm.submit();
                    } else if (paymentMethod === 'kcb') {
                        const kcbPaymentData = {
                            payment_type: 'product',
                            phone_number: phone,
                            amount: orderData.amount,
                            currency: 'KES',
                            customer_name: orderData.first_name + ' ' + orderData.last_name,
                            email: orderData.email,
                            existing_order_id: orderData.order_id,
                            reference_data: {
                                delivery_method: orderData.delivery_method,
                                delivery_zone: orderData.delivery_zone,
                                delivery_cost: orderData.delivery_cost
                            }
                        };

                        const kcbResult = await initiateKcbPayment(kcbPaymentData);
                        if (kcbResult.success) {
                            showPaymentStatusModal(`
                                <div class="text-blue-600">
                                    <i class="fas fa-spinner fa-spin text-4xl mb-4"></i>
                                    <h3 class="text-xl font-semibold mb-2">Payment Initiated</h3>
                                    <p class="text-gray-600">${kcbResult.customer_message || 'Check your phone for M-Pesa prompt...'}</p>
                                    <p class="text-sm text-gray-500 mt-2">Order #: ${orderData.order_id}</p>
                                </div>
                            `);
                            window.checkoutRequestId = kcbResult.checkout_request_id;
                            window.paymentStatusInterval = setInterval(() => checkKcbPaymentStatus(kcbResult.checkout_request_id), 3000);
                            setTimeout(() => { if (window.paymentStatusInterval) clearInterval(window.paymentStatusInterval); }, 300000);
                        } else {
                            alert('Failed to initiate M-Pesa payment: ' + kcbResult.message);
                            submitButton.innerHTML = originalText;
                            submitButton.disabled = false;
                        }
                    }
                } else {
                    if (orderData.errors) {
                        let errorMessage = 'Please fix the following errors:\n';
                        for (const [field, errors] of Object.entries(orderData.errors)) {
                            errorMessage += `- ${errors.join(', ')}\n`;
                        }
                        alert(errorMessage);
                    } else {
                        alert(orderData.message || 'Error processing order. Please try again.');
                    }
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }
        });
    }
});
</script>

<style>
.payment-method-card input:checked + div {
    border-color: inherit;
    background-color: inherit;
}
.payment-method-card div {
    transition: all 0.2s ease;
}
.payment-method-card:hover div {
    transform: translateY(-2px);
}
.spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #93C754;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 1s linear infinite;
    display: inline-block;
    margin-right: 8px;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.quantity-input {
    -moz-appearance: textfield;
}
.quantity-input::-webkit-inner-spin-button,
.quantity-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
@endsection
