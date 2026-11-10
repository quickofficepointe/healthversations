@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4">
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        @if($state === 'success')
            <i class="fas fa-check-circle text-6xl text-green-500"></i>
            <h1 class="text-2xl font-bold text-gray-800 mt-6">Payment Successful</h1>
            <p class="text-gray-600 mt-2">Thank you for your order! We'll contact you about delivery.</p>
        @elseif($state === 'processing')
            <i class="fas fa-hourglass-half text-6xl text-yellow-500"></i>
            <h1 class="text-2xl font-bold text-gray-800 mt-6">Confirming Your Payment</h1>
            <p class="text-gray-600 mt-2">We're waiting for M-Pesa to confirm your payment. This page will refresh shortly.</p>
            <meta http-equiv="refresh" content="10">
        @else
            <i class="fas fa-times-circle text-6xl text-red-500"></i>
            <h1 class="text-2xl font-bold text-gray-800 mt-6">Payment Not Completed</h1>
            <p class="text-gray-600 mt-2">Your M-Pesa payment did not go through. No money was taken. Please try again.</p>
        @endif

        @if($order)
            <div class="mt-8 bg-gray-50 rounded-lg p-6 text-left grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Order Number</p>
                    <p class="font-semibold text-gray-800">{{ $order->order_id ?? $order->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Amount</p>
                    <p class="font-semibold text-gray-800">KES {{ number_format($kcbPayment->amount ?? $order->amount, 2) }}</p>
                </div>
                @if($state === 'success' && $kcbPayment?->mpesa_receipt_number)
                    <div>
                        <p class="text-sm text-gray-500">M-Pesa Receipt</p>
                        <p class="font-semibold text-gray-800">{{ $kcbPayment->mpesa_receipt_number }}</p>
                    </div>
                @endif
                <div>
                    <p class="text-sm text-gray-500">Payment Method</p>
                    <p class="font-semibold text-gray-800">M-Pesa</p>
                </div>
            </div>
        @endif

        <div class="mt-8 flex flex-col sm:flex-row justify-center gap-3">
            @if($state === 'failed')
                <a href="{{ route('cart.index') }}" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Try Again</a>
            @elseif(auth()->check())
                <a href="{{ route('user.orders') }}" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">View My Orders</a>
            @endif
            <a href="{{ route('home') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">Back to Home</a>
        </div>
    </div>
</div>
@endsection
