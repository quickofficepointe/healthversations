@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>

    @if(count($cartItems) > 0)
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Order Summary -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
            @foreach($cartItems as $item)
            <div class="flex justify-between mb-2">
                <span>{{ $item['name'] }} @if($item['variant_name'])({{ $item['variant_name'] }})@endif × {{ $item['quantity'] }}</span>
                <span>Ksh {{ number_format($item['price_kes'] * $item['quantity'], 2) }}</span>
            </div>
            @endforeach

            <div class="border-t my-2"></div>

            <div class="flex justify-between mb-2">
                <span>Subtotal:</span>
                <span>Ksh {{ number_format($subtotalKES, 2) }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span>Delivery Fee:</span>
                <span>Ksh {{ number_format($deliveryFeeKES, 2) }}</span>
            </div>
            <div class="flex justify-between font-bold text-lg">
                <span>Total:</span>
                <span class="text-green-600">Ksh {{ number_format($totalKES, 2) }}</span>
            </div>
        </div>

        <!-- Payment Form -->
        <form id="paymentForm" method="post" action="https://portal.host.iveri.com/Lite/Authorise.aspx">
            @csrf

            <!-- Hidden Payment Fields -->
            <input type="hidden" name="Lite_Order_Amount" value="{{ $totalCents }}">
            <input type="hidden" name="Lite_Currency_AlphaCode" value="KES">
            <input type="hidden" name="ORDER_TYPE" value="delivery">
            <input type="hidden" name="Lite_Merchant_ApplicationId" value="3a7f44fd-4bb4-432c-b483-32e5a19e100d">
            <input type="hidden" name="Ecom_ConsumerOrderID" value="ORD-{{ time() }}">

            <!-- Product Line Items -->
            @foreach($cartItems as $index => $item)
                <input type="hidden"
                       name="Lite_Order_LineItems_Product_{{ $index + 1 }}"
                       value="{{ $item['name'] }} @if($item['variant_name'])({{ $item['variant_name'] }})@endif">
                <input type="hidden"
                       name="Lite_Order_LineItems_Quantity_{{ $index + 1 }}"
                       value="{{ $item['quantity'] }}">
                <input type="hidden"
                       name="Lite_Order_LineItems_Amount_{{ $index + 1 }}"
                       value="{{ $item['price_kes'] * $item['quantity'] * 100 }}">
            @endforeach

            <!-- Delivery Line Item -->
            <input type="hidden"
                   name="Lite_Order_LineItems_Product_{{ count($cartItems) + 1 }}"
                   value="Delivery Fee">
            <input type="hidden"
                   name="Lite_Order_LineItems_Quantity_{{ count($cartItems) + 1 }}"
                   value="1">
            <input type="hidden"
                   name="Lite_Order_LineItems_Amount_{{ count($cartItems) + 1 }}"
                   value="{{ $deliveryFeeCents }}">

            <!-- Customer Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Customer Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-2">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="Ecom_BillTo_Postal_Name_First" class="w-full border px-4 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block mb-2">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="Ecom_BillTo_Postal_Name_Last" class="w-full border px-4 py-2 rounded" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="Ecom_BillTo_Online_Email" class="w-full border px-4 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-2">Phone Number <span class="text-red-500">*</span></label>
                    <input type="tel" name="Ecom_BillTo_Telecom_Phone_Number" class="w-full border px-4 py-2 rounded" required>
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Delivery Information</h2>
                <div class="mb-4">
                    <label class="block mb-2">County <span class="text-red-500">*</span></label>
                    <select name="Ecom_ShipTo_Postal_StateProv" class="w-full border px-4 py-2 rounded" required>
                        <option value="">Select County</option>
                        <option value="Nairobi">Nairobi</option>
                        <option value="Mombasa">Mombasa</option>
                        <!-- Add more counties as needed -->
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-2">Detailed Address <span class="text-red-500">*</span></label>
                    <textarea name="Ecom_ShipTo_Postal_Street_Line1" class="w-full border px-4 py-2 rounded" rows="3" required></textarea>
                </div>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded hover:bg-green-700">
                Complete Payment
            </button>
        </form>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <p class="text-gray-600 mb-4">Your cart is empty</p>
        <a href="{{ route('products.index') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
            Continue Shopping
        </a>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            // Validate amounts
            const orderTotal = parseInt(document.querySelector('[name="Lite_Order_Amount"]').value);
            let lineItemsTotal = 0;

            document.querySelectorAll('[name^="Lite_Order_LineItems_Amount_"]').forEach(input => {
                lineItemsTotal += parseInt(input.value);
            });

            if (orderTotal !== lineItemsTotal) {
                e.preventDefault();
                alert('Error: Payment amounts do not match. Please try again.');
                console.error('Amount mismatch:', {
                    orderTotal: orderTotal,
                    lineItemsTotal: lineItemsTotal
                });
            }
        });
    }
});
</script>
@endsection
