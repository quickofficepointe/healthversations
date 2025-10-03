@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4">
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <h1 class="text-2xl font-bold text-gray-800 mt-6">Payment Successful</h1>
        <p class="text-gray-600 mt-2">Thank you for your order!</p>

        <div class="mt-8 bg-gray-50 rounded-lg p-6 text-left">
            <h2 class="text-lg font-medium mb-4">Order Details</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Order Reference:</p>
                    <p class="font-medium">{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Transaction ID:</p>
                    <p class="font-medium">{{ $transaction_id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Amount Paid:</p>
                    <p class="font-medium">Ksh {{ number_format($amount, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Payment Method:</p>
                    <p class="font-medium">Credit/Debit Card</p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <p class="text-gray-600">We've sent a confirmation email to your registered address.</p>
            <a href="{{ route('orders.show', $order->id) }}" class="mt-4 inline-block px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                View Order Details
            </a>
        </div>
    </div>
</div>
@endsection
