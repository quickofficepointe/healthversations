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
  <!-- Cart items table - Mobile Responsive -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Desktop Table Headers (Hidden on mobile) -->
    <div class="hidden md:grid grid-cols-12 bg-gray-100 p-4 font-semibold border-b">
        <div class="col-span-6">Product</div>
        <div class="col-span-2 text-center">Price</div>
        <div class="col-span-2 text-center">Quantity</div>
        <div class="col-span-2 text-center">Total</div>
    </div>

    @foreach($cartItems as $cartKey => $item)
    <div class="border-b cart-item" data-id="{{ $cartKey }}">
        <!-- Mobile Layout -->
        <div class="md:hidden p-4">
            <!-- Product Info -->
            <div class="flex items-start mb-4">
                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded mr-4">
                <div class="flex-1">
                    <h3 class="font-medium text-gray-800">{{ $item['name'] }}</h3>
                    @if($item['variant_name'])
                        <p class="text-sm text-gray-500">{{ $item['variant_name'] }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Price and Quantity Row -->
            <div class="flex justify-between items-center mb-3">
                <div class="text-gray-600 price">
                    Ksh {{ number_format($item['price_kes'], 2) }}
                </div>
                
                <!-- Quantity Controls -->
                <div class="flex items-center">
                    <button class="decrease-quantity bg-gray-200 hover:bg-gray-300 w-8 h-8 flex items-center justify-center rounded-l">
                        <span class="text-lg">-</span>
                    </button>
                    <input type="number" value="{{ $item['quantity'] }}" min="1"
                           class="quantity-input w-12 text-center border-t border-b border-gray-300 py-1 h-8">
                    <button class="increase-quantity bg-gray-200 hover:bg-gray-300 w-8 h-8 flex items-center justify-center rounded-r">
                        <span class="text-lg">+</span>
                    </button>
                </div>
            </div>
            
            <!-- Total and Remove Row -->
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
                    @if($item['variant_name'])
                        <p class="text-sm text-gray-500">{{ $item['variant_name'] }}</p>
                    @endif
                    <button class="remove-item text-red-500 text-sm hover:text-red-700" data-id="{{ $cartKey }}">
                        Remove
                    </button>
                </div>
            </div>

            <div class="col-span-2 text-center text-gray-600 price">
                Ksh {{ number_format($item['price_kes'], 2) }}
            </div>

            <div class="col-span-2 text-center">
                <div class="flex justify-center items-center">
                    <button class="decrease-quantity bg-gray-200 hover:bg-gray-300 w-8 h-8 flex items-center justify-center rounded-l">
                        <span class="text-lg">-</span>
                    </button>
                    <input type="number" value="{{ $item['quantity'] }}" min="1"
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
            Subtotal: <span class="text-green-600 cart-subtotal">Ksh {{ number_format($total, 2) }}</span>
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

        <!-- Checkout Form -->
        <form id="checkoutForm" class="space-y-6">
            @csrf

            <!-- Customer Information -->
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
                    <!-- M-Pesa Payment (First) -->
                    <label class="payment-method-card">
                        <input type="radio" name="payment_method" value="kcb" class="sr-only peer" checked>
                        <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#0A4040] peer-checked:border-[#0A4040] peer-checked:bg-[#0A4040]/10">
                            <div class="flex items-center">
                                <i class="fas fa-mobile-alt text-[#0A4040] text-xl mr-3"></i>
                                <div>
                                    <h4 class="font-medium text-[#0A4040]">M-Pesa</h4>
                                    <p class="text-sm text-gray-600">Pay with your M-Pesa account</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <!-- Card Payment (Second) -->
                    <label class="payment-method-card">
                        <input type="radio" name="payment_method" value="iveri" class="sr-only peer">
                        <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#93C754] peer-checked:border-[#93C754] peer-checked:bg-[#93C754]/10">
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
                    <!-- Pickup Option -->
                    <div class="border rounded-lg p-4 cursor-pointer delivery-option" data-method="pickup" data-cost="0" data-zone="B">
                        <div class="flex items-center">
                            <input type="radio" name="delivery_method" value="pickup" class="mr-2 delivery-method-radio" checked>
                            <label class="font-medium">Pickup (FREE)</label>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">TOM MBOYA STREET, STAR MALL, 1st Floor, Shop A17</p>
                    </div>

                    <!-- Delivery Option -->
                    <div class="border rounded-lg p-4 cursor-pointer delivery-option" data-method="delivery" data-cost="" data-zone="">
                        <div class="flex items-center">
                            <input type="radio" name="delivery_method" value="delivery" class="mr-2 delivery-method-radio">
                            <label class="font-medium">Home Delivery</label>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Select your delivery zone below</p>
                    </div>
                </div>
            </div>

            <!-- Delivery Zone Selection (Initially Hidden) -->
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
                            <label class="font-medium">{{ $details['name'] }}</label>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $details['areas'] }}</p>
                        <p class="text-sm font-semibold mt-2">Rate: Ksh {{ number_format($details['rate'], 2) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Information Container -->
            <div id="shippingInfoContainer">
                <!-- Shipping fields will be dynamically inserted here when delivery is selected -->
            </div>

            <!-- Order Summary -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <div class="flex justify-between mb-2">
                    <span>Subtotal:</span>
                    <span class="text-gray-600 cart-subtotal">Ksh {{ number_format($total, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Delivery:</span>
                    <span class="text-gray-600" id="deliveryCostDisplay">Ksh 0.00</span>
                </div>
                <div class="flex justify-between text-lg font-bold">
                    <span>Total:</span>
                    <span class="text-green-600 cart-total">Ksh {{ number_format($total, 2) }}</span>
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
<!-- Payment Status Modal -->
<div id="payment-status-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 p-4 overflow-auto">
    <div class="flex items-center justify-center min-h-full">
        <div class="bg-white max-w-md mx-auto rounded-lg p-6 relative text-center">
            <!-- Close button at top right - FIXED -->
            <button id="close-payment-modal-top" 
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div id="payment-status-content" class="mt-4">
                <!-- Content will be populated by JavaScript -->
            </div>
            <!-- Close button at bottom - FIXED -->
            <button id="close-payment-modal-bottom"
                    class="mt-6 px-6 py-2 bg-[#93C754] text-white rounded hover:bg-[#7eae47] transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show checkout form when proceed button is clicked
    const proceedBtn = document.getElementById('proceedToCheckoutBtn');
    if (proceedBtn) {
        proceedBtn.addEventListener('click', function() {
            const checkoutForm = document.getElementById('checkoutFormSection');
            if (checkoutForm) {
                checkoutForm.classList.remove('hidden');
                window.scrollTo({
                    top: checkoutForm.offsetTop - 20,
                    behavior: 'smooth'
                });
            }
        });
    }

    // Delivery method selection
    const deliveryOptions = document.querySelectorAll('.delivery-option');
    const deliveryZoneSection = document.getElementById('deliveryZoneSection');
    const shippingInfoContainer = document.getElementById('shippingInfoContainer');
    const zoneOptions = document.querySelectorAll('.zone-option');
    const deliveryCostDisplay = document.getElementById('deliveryCostDisplay');
    const cartTotal = document.querySelector('.cart-total');
    const cartSubtotal = parseFloat({{ $total }});

    // Shipping fields HTML template
    const shippingFieldsHTML = `
        <div id="shippingInfoSection">
            <h3 class="text-lg font-semibold mb-4">Shipping Information</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 font-medium">County <span class="text-red-500">*</span></label>
                    <select name="county" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500 shipping-field" required>
                        <option value="">Select County</option>
                        @foreach([
                            'Baringo', 'Bomet', 'Bungoma', 'Busia', 'Elgeyo-Marakwet',
                            'Embu', 'Garissa', 'Homa Bay', 'Isiolo', 'Kajiado',
                            'Kakamega', 'Kericho', 'Kiambu', 'Kilifi', 'Kirinyaga',
                            'Kisii', 'Kisumu', 'Kitui', 'Kwale', 'Laikipia',
                            'Lamu', 'Machakos', 'Makueni', 'Mandera', 'Marsabit',
                            'Meru', 'Migori', 'Mombasa', 'Murang\'a', 'Nairobi',
                            'Nakuru', 'Nandi', 'Narok', 'Nyamira', 'Nyandarua',
                            'Nyeri', 'Samburu', 'Siaya', 'Taita-Taveta', 'Tana River',
                            'Tharaka-Nithi', 'Trans Nzoia', 'Turkana', 'Uasin Gishu',
                            'Vihiga', 'Wajir', 'West Pokot'
                        ] as $county)
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

    // Initialize with pickup selected
    updateDeliveryCost(0, 'B');
    removeShippingInfo();

    deliveryOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Update radio button selection
            const radio = this.querySelector('.delivery-method-radio');
            radio.checked = true;

            const method = this.getAttribute('data-method');
            const cost = this.getAttribute('data-cost');
            const zone = this.getAttribute('data-zone');

            // Show/hide sections based on delivery method
            if (method === 'delivery') {
                deliveryZoneSection.classList.remove('hidden');
                showShippingInfo();
                // Auto-select first zone if none selected
                if (!document.querySelector('input[name="delivery_zone"]:checked')) {
                    const firstZone = document.querySelector('.zone-option');
                    if (firstZone) {
                        const zoneRadio = firstZone.querySelector('.zone-radio');
                        zoneRadio.checked = true;
                        updateDeliveryCost(
                            parseFloat(firstZone.getAttribute('data-cost')),
                            firstZone.getAttribute('data-zone')
                        );
                    }
                }
            } else {
                deliveryZoneSection.classList.add('hidden');
                removeShippingInfo();
                updateDeliveryCost(parseFloat(cost), zone);
            }
        });
    });

    // Zone selection
    zoneOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Update radio button selection
            const radio = this.querySelector('.zone-radio');
            radio.checked = true;

            // Update delivery cost
            const cost = parseFloat(this.getAttribute('data-cost'));
            const zone = this.getAttribute('data-zone');
            updateDeliveryCost(cost, zone);
        });
    });

    function updateDeliveryCost(cost, zone) {
        // Update display
        deliveryCostDisplay.textContent = 'Ksh ' + cost.toFixed(2);

        // Update order total
        const total = cartSubtotal + cost;
        cartTotal.textContent = 'Ksh ' + total.toFixed(2);
    }

    function showShippingInfo() {
        // Insert shipping fields into the container
        shippingInfoContainer.innerHTML = shippingFieldsHTML;
    }

    function removeShippingInfo() {
        // Completely remove shipping fields from the DOM
        shippingInfoContainer.innerHTML = '';
    }

    // Cart quantity controls
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', updateCart);
    });

    document.querySelectorAll('.increase-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            if (input) {
                input.value = parseInt(input.value) + 1;
                updateCart.call(input);
            }
        });
    });

    document.querySelectorAll('.decrease-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            if (input && parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateCart.call(input);
            }
        });
    });

    // Remove item from cart
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            if (itemId) {
                removeFromCart(itemId);
            }
        });
    });

    // Payment status modal functions
    function showPaymentStatusModal(content) {
        document.getElementById('payment-status-content').innerHTML = content;
        document.getElementById('payment-status-modal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function hidePaymentStatusModal() {
        document.getElementById('payment-status-modal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        if (window.paymentStatusInterval) {
            clearInterval(window.paymentStatusInterval);
            window.paymentStatusInterval = null;
        }
    }

    // Unified KCB payment function - UPDATED
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
                return {
                    success: true,
                    checkout_request_id: data.checkout_request_id,
                    customer_message: data.customer_message,
                    order_id: data.order_id // This should be the same as existing_order_id
                };
            } else {
                throw new Error(data.message || 'Payment initiation failed');
            }
        } catch (error) {
            console.error('KCB Payment Error:', error);
            throw error;
        }
    }

    // Check KCB payment status - UPDATED
    async function checkKcbPaymentStatus(checkoutRequestId) {
        try {
            const response = await fetch('{{ route("kcb.payment.status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    checkout_request_id: checkoutRequestId
                })
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
                        <p class="text-sm text-gray-500">You will receive an order confirmation email shortly.</p>
                    </div>
                `);
                
                if (window.paymentStatusInterval) {
                    clearInterval(window.paymentStatusInterval);
                    window.paymentStatusInterval = null;
                }

                // Redirect to success page after 3 seconds
               // Redirect to KCB success page after 3 seconds
setTimeout(() => {
    window.location.href = '{{ route("kcb.payment.success") }}?order_id=' + (window.currentOrderId || data.order_id);
}, 3000);
                
            } else if (data.success && data.status === 'failed') {
                showPaymentStatusModal(`
                    <div class="text-red-600">
                        <i class="fas fa-times-circle text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Payment Failed</h3>
                        <p class="text-gray-600">${data.result_description || 'Please try again.'}</p>
                        <button onclick="hidePaymentStatusModal()"
                                class="mt-4 px-6 py-2 bg-[#93C754] text-white rounded hover:bg-[#7eae47] transition">
                            Try Again
                        </button>
                    </div>
                `);
                
                if (window.paymentStatusInterval) {
                    clearInterval(window.paymentStatusInterval);
                    window.paymentStatusInterval = null;
                }
                
            } else if (!data.success) {
                // Payment still pending
                console.log('Payment status:', data.status);
            }
        } catch (error) {
            console.error('Error checking payment status:', error);
        }
    }

    // Handle form submission - COMPLETELY REWRITTEN
    const checkoutForm = document.getElementById('checkoutForm');
    const iveriForm = document.getElementById('iveriPaymentForm');

    checkoutForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked').value;
        const submitButton = checkoutForm.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;

        // Validate phone number
        const phone = document.querySelector('input[name="phone"]').value;
        if (!phone.startsWith('254') || phone.length !== 12) {
            alert('Please enter a valid phone number in format 2547XXXXXXXX');
            return;
        }

        // Show loading state
        submitButton.innerHTML = '<span class="spinner"></span> Processing...';
        submitButton.disabled = true;

        try {
            // Prepare order data using FormData
            const formData = new FormData();

            // Add basic customer info
            formData.append('first_name', document.querySelector('input[name="first_name"]').value);
            formData.append('last_name', document.querySelector('input[name="last_name"]').value);
            formData.append('email', document.querySelector('input[name="email"]').value);
            formData.append('phone', phone);
            formData.append('delivery_method', deliveryMethod);
            formData.append('delivery_zone', document.querySelector('input[name="delivery_zone"]:checked')?.value || 'B');
            formData.append('payment_method', paymentMethod);

            // Only add shipping info if delivery method is delivery AND fields exist
            if (deliveryMethod === 'delivery') {
                const county = document.querySelector('select[name="county"]');
                const subcounty = document.querySelector('input[name="subcounty"]');
                const location = document.querySelector('input[name="location"]');
                const address = document.querySelector('textarea[name="address"]');

                if (county && subcounty && location && address) {
                    formData.append('county', county.value);
                    formData.append('subcounty', subcounty.value);
                    formData.append('location', location.value);
                    formData.append('address', address.value);
                }
            } else {
                // For pickup, send empty strings
                formData.append('county', '');
                formData.append('subcounty', '');
                formData.append('location', '');
                formData.append('address', '');
            }

            // Submit the order via AJAX first - THIS CREATES THE ORD- ORDER
            const orderResponse = await fetch("{{ route('cart.order.process') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const orderData = await orderResponse.json();

            if (orderData.success && orderData.order_id) {
                // STORE THE ORDER ID FOR LATER USE
                window.currentOrderId = orderData.order_id;
                
                if (paymentMethod === 'iveri') {
                    // Set iVeri form values
                    document.getElementById('iveriOrderIdField').value = orderData.order_id;
                    document.getElementById('iveriAmount').value = orderData.amount * 100;
                    document.getElementById('iveriOrderId').value = orderData.order_id;
                    document.getElementById('iveriToken').value = orderData.token;
                    document.getElementById('iveriEmail').value = orderData.email;
                    document.getElementById('iveriFirstName').value = orderData.first_name;
                    document.getElementById('iveriLastName').value = orderData.last_name;
                    document.getElementById('iveriDeliveryCost').value = orderData.delivery_cost;
                    document.getElementById('iveriDeliveryZone').value = orderData.delivery_zone;

                    // Submit iVeri form
                    iveriForm.submit();
                    
                } else if (paymentMethod === 'kcb') {
                    // IMPORTANT: Use the existing order_id when initiating payment
                    // This prevents creating a duplicate CART- order
                    const kcbPaymentData = {
                        payment_type: 'product',
                        phone_number: phone,
                        amount: orderData.amount,
                        currency: 'KES',
                        customer_name: orderData.first_name + ' ' + orderData.last_name,
                        email: orderData.email,
                        existing_order_id: orderData.order_id, // PASS THE EXISTING ORDER ID
                        reference_data: {
                            // Pass minimal data since we're using existing order
                            delivery_method: orderData.delivery_method,
                            delivery_zone: orderData.delivery_zone,
                            delivery_cost: orderData.delivery_cost,
                            county: deliveryMethod === 'delivery' ? document.querySelector('select[name="county"]')?.value : '',
                            subcounty: deliveryMethod === 'delivery' ? document.querySelector('input[name="subcounty"]')?.value : '',
                            location: deliveryMethod === 'delivery' ? document.querySelector('input[name="location"]')?.value : '',
                            address: deliveryMethod === 'delivery' ? document.querySelector('textarea[name="address"]')?.value : ''
                        }
                    };

                    console.log('Initiating KCB payment with existing order:', orderData.order_id);

                    const kcbResult = await initiateKcbPayment(kcbPaymentData);

                    if (kcbResult.success) {
                        // Show payment status modal
                        showPaymentStatusModal(`
                            <div class="text-blue-600">
                                <i class="fas fa-spinner fa-spin text-4xl mb-4"></i>
                                <h3 class="text-xl font-semibold mb-2">Payment Initiated</h3>
                                <p class="text-gray-600">${kcbResult.customer_message || 'Check your phone for M-Pesa prompt...'}</p>
                                <p class="text-sm text-gray-500 mt-2">Order #: ${orderData.order_id}</p>
                                <p class="text-xs text-gray-500 mt-2">Checking payment status automatically</p>
                            </div>
                        `);

                        // Store checkout request ID
                        window.checkoutRequestId = kcbResult.checkout_request_id;

                        // Start polling for payment status
                        window.paymentStatusInterval = setInterval(() => {
                            checkKcbPaymentStatus(kcbResult.checkout_request_id);
                        }, 3000);
                        
                        // Auto-stop polling after 5 minutes (300 seconds)
                        setTimeout(() => {
                            if (window.paymentStatusInterval) {
                                clearInterval(window.paymentStatusInterval);
                                window.paymentStatusInterval = null;
                                console.log('Stopped polling after 5 minutes');
                            }
                        }, 300000);
                        
                    } else {
                        alert('Failed to initiate M-Pesa payment: ' + kcbResult.message);
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                    }
                }
            } else {
                // Handle validation errors
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

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hidePaymentStatusModal();
        }
    });

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.id === 'payment-status-modal') {
            hidePaymentStatusModal();
        }
    });
});

async function updateCart() {
    const cartItem = this.closest('.cart-item');
    if (!cartItem) return;

    const cartKey = cartItem.getAttribute('data-id');
    const quantity = this.value;

    try {
        const response = await fetch(`/cart/update/${cartKey}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                quantity: quantity
            })
        });

        const data = await response.json();

        if (response.ok) {
            // Update item total
            const priceElement = cartItem.querySelector('.price');
            const itemTotalElement = cartItem.querySelector('.item-total');

            if (priceElement && itemTotalElement) {
                const price = parseFloat(priceElement.textContent.replace('Ksh ', '').replace(/,/g, ''));
                const total = price * quantity;
                itemTotalElement.textContent = 'Ksh ' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }

            // Update cart total
            updateCartTotal();
        } else {
            throw new Error(data.message || 'Failed to update cart');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to update cart. Please try again.');
    }
}

function updateCartTotal() {
    let newTotal = 0;
    document.querySelectorAll('.item-total').forEach(el => {
        newTotal += parseFloat(el.textContent.replace('Ksh ', '').replace(/,/g, ''));
    });

    // Update displayed subtotal
    document.querySelector('.cart-subtotal').textContent = 'Ksh ' + newTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

    // Update the global subtotal variable
    window.cartSubtotal = newTotal;

    // Recalculate the total with delivery cost
    const deliveryCost = parseFloat(document.getElementById('deliveryCostDisplay').textContent.replace('Ksh ', '').replace(/,/g, '') || 0);
    document.querySelector('.cart-total').textContent = 'Ksh ' + (newTotal + deliveryCost).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

async function removeFromCart(itemId) {
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
            // Remove item row from DOM
            const itemElement = document.querySelector(`.cart-item[data-id="${itemId}"]`);
            if (itemElement) {
                itemElement.remove();
            }

            // Update cart total
            updateCartTotal();

            // If cart is empty, reload the page to show empty cart message
            if (document.querySelectorAll('.cart-item').length === 0) {
                location.reload();
            }
        } else {
            throw new Error('Failed to remove item from cart');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to remove item from cart. Please try again.');
    }
}
</script>

<style>
.payment-method-card input:checked + div {
    border-color: inherit;
    background-color: inherit;
    box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}
.payment-method-card div {
    transition: all 0.2s ease;
}
.payment-method-card:hover div {
    transform: translateY(-1px);
}

.delivery-option input:checked + label {
    font-weight: bold;
}
.zone-option input:checked + label {
    font-weight: bold;
}

/* Loading spinner */
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
</style>
@endsection