@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4">
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <h1 class="text-2xl font-bold text-gray-800 mt-6">Payment Error</h1>
        <p class="text-gray-600 mt-2">We encountered an issue processing your payment.</p>

        <div class="mt-8 bg-gray-50 rounded-lg p-6 text-left">
            <h2 class="text-lg font-medium mb-4">Error Details</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Reference:</p>
                    <p class="font-medium">{{ $transaction_id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Error Message:</p>
                    <p class="font-medium">{{ $error }}</p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <p class="text-gray-600">Please contact our support team with the reference above:</p>
            <a href="mailto:{{ $support_email }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Contact Support
            </a>
        </div>
    </div>
</div>
@endsection
