@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4">
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        <h1 class="text-2xl font-bold text-gray-800 mt-6">Please Try Again</h1>
        <p class="text-gray-600 mt-2">{{ $message }}</p>

        <div class="mt-8 bg-gray-50 rounded-lg p-6 text-left">
            <h2 class="text-lg font-medium mb-4">Transaction Reference</h2>
            <p class="font-medium">{{ $transaction_id }}</p>
            <p class="mt-2 text-gray-600">Please try again after {{ $retry_time }}</p>
        </div>

        <div class="mt-8">
            <p class="text-gray-600">If the problem persists, please contact our support team:</p>
            <a href="mailto:{{ $support_email }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Contact Support
            </a>
        </div>
    </div>
</div>
@endsection
