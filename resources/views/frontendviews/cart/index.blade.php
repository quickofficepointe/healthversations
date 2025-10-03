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
        <!-- Cart items table -->
        <div class="grid grid-cols-12 bg-gray-100 p-4 font-semibold border-b">
            <div class="col-span-5 md:col-span-6">Product</div>
            <div class="col-span-2 text-center">Price</div>
            <div class="col-span-3 text-center">Quantity</div>
            <div class="col-span-2 text-center">Total</div>
        </div>

        @foreach($cartItems as $cartKey => $item)
        <div class="grid grid-cols-12 p-4 items-center border-b cart-item" data-id="{{ $cartKey }}">
            <div class="col-span-5 md:col-span-6 flex items-center">
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

            <div class="col-span-3 text-center">
                <div class="flex justify-center items-center">
                    <button class="decrease-quantity bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded-l">-</button>
                    <input type="number" value="{{ $item['quantity'] }}" min="1"
                           class="quantity-input w-16 text-center border-t border-b border-gray-300 py-1">
                    <button class="increase-quantity bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded-r">+</button>
                </div>
            </div>

            <div class="col-span-2 text-center font-medium item-total">
                Ksh {{ number_format($item['price_kes'] * $item['quantity'], 2) }}
            </div>
        </div>
        @endforeach

        <div class="p-4 flex justify-between items-center bg-gray-50">
            <div class="text-xl font-semibold">
                Subtotal: <span class="text-green-600 cart-subtotal">Ksh {{ number_format($total, 2) }}</span>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">
                    Continue Shopping
                </a>
                <button id="proceedToCheckoutBtn" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Proceed to Checkout
                </button>
            </div>
        </div>
    </div>

    <!-- Checkout Form (Initially Hidden) -->
    <div id="checkoutFormSection" class="bg-white rounded-lg shadow-md p-6 mt-8 hidden">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Checkout</h2>

        <!-- Checkout Form -->
        <form id="checkoutForm" method="POST" class="space-y-6">
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
                <input type="tel" name="phone" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500" required>
            </div>

            <!-- Delivery Method Selection -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Delivery Method</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Pickup Option -->
                    <div class="border rounded-lg p-4 cursor-pointer delivery-option" data-zone="B" data-cost="0">
                        <div class="flex items-center">
                            <input type="radio" name="delivery_method" value="pickup" class="mr-2 delivery-method-radio">
                            <label class="font-medium">Pickup (FREE)</label>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">OM MBOYA STREET, STAR MALL, 1st Floor, Shop A17</p>
                    </div>

                    <!-- Delivery Option -->
                    <div class="border rounded-lg p-4 cursor-pointer delivery-option" data-zone="" data-cost="">
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

            <!-- Shipping Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 font-medium">County <span class="text-red-500">*</span></label>
                    <select name="county" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500" required>
                        <option value="">Select County</option>
                        @foreach(['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret', 'Kiambu', 'Machakos'] as $county)
                            <option value="{{ $county }}">{{ $county }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2 font-medium">Subcounty <span class="text-red-500">*</span></label>
                    <input type="text" name="subcounty" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Location/Neighborhood <span class="text-red-500">*</span></label>
                <input type="text" name="location" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500" required>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-medium">Detailed Address <span class="text-red-500">*</span></label>
                <textarea name="address" rows="2" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500" required></textarea>
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

            <button type="submit" class="w-full bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition">Pay Now</button>
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
    const zoneOptions = document.querySelectorAll('.zone-option');
    const deliveryCostDisplay = document.getElementById('deliveryCostDisplay');
    const cartTotal = document.querySelector('.cart-total');
    const cartSubtotal = parseFloat({{ $total }});

    deliveryOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Update radio button selection
            const radio = this.querySelector('.delivery-method-radio');
            radio.checked = true;

            // Show/hide delivery zone section
            if (radio.value === 'delivery') {
                deliveryZoneSection.classList.remove('hidden');
            } else {
                deliveryZoneSection.classList.add('hidden');
                // Reset delivery cost for pickup
                updateDeliveryCost(0, 'B');
            }

            // If it's a delivery option with predefined cost
            const cost = this.getAttribute('data-cost');
            const zone = this.getAttribute('data-zone');
            if (cost && zone) {
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

    // Handle form submission
    const checkoutForm = document.getElementById('checkoutForm');
    const iveriForm = document.getElementById('iveriPaymentForm');

    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Show loading state
        const submitButton = checkoutForm.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'Processing...';
        submitButton.disabled = true;

        // Submit the checkout form via AJAX first
        fetch("{{ route('cart.order.process') }}", {
            method: 'POST',
            body: new FormData(checkoutForm),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.order_id) {
                // Set iVeri form values
                document.getElementById('iveriOrderIdField').value = data.order_id;
                document.getElementById('iveriAmount').value = data.amount * 100;
                document.getElementById('iveriOrderId').value = data.order_id;
                document.getElementById('iveriToken').value = data.token;
                document.getElementById('iveriEmail').value = data.email;
                document.getElementById('iveriFirstName').value = data.first_name;
                document.getElementById('iveriLastName').value = data.last_name;
                document.getElementById('iveriDeliveryCost').value = data.delivery_cost;
                document.getElementById('iveriDeliveryZone').value = data.delivery_zone;

                // Submit iVeri form
                iveriForm.submit();
            } else {
                alert('Error processing order. Please try again.');
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        });
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
@endsection
