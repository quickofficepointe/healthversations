@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-lg p-6 rounded-lg text-center">
    <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    <h2 class="text-2xl font-bold text-[#0A4040] mb-2">Payment Successful!</h2>
    <p class="text-gray-600 mb-4">Thank you for your order. Your payment has been processed successfully.</p>
    <p class="text-gray-600 mb-6">Order Reference: <span class="font-semibold">{{ $reference }}</span></p>
    <a href="{{ route('orders.index') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded font-bold">
        View Your Orders
    </a>
</div>
@endsection
