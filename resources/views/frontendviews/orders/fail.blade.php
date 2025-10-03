@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4">
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <h1 class="text-2xl font-bold text-gray-800 mt-6">Payment Failed</h1>
        <p class="text-gray-600 mt-2">{{ $error }}</p>

        <div class="mt-8 bg-gray-50 rounded-lg p-6 text-left">
            <h2 class="text-lg font-medium mb-4">Transaction Details</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Transaction ID:</p>
                    <p class="font-medium">{{ $transaction_id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Status Code:</p>
                    <p class="font-medium">{{ $status_code }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Reason:</p>
                    <p class="font-medium">{{ $error }}</p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            @if($can_retry)
                <a href="{{ route('cart.checkout') }}" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Try Again
                </a>
            @endif
            <p class="mt-4 text-gray-600">Need help? Contact us at <a href="mailto:{{ $support_email }}" class="text-blue-600">{{ $support_email }}</a></p>
        </div>
    </div>
</div>
@endsection
