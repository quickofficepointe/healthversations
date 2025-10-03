@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-lg p-6 rounded-lg text-center">
    <div class="text-yellow-500 text-6xl mb-4">⚠️</div>
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Payment Error</h2>
    <p class="text-gray-600 mb-6">An error occurred during the payment process. Please contact support if the issue persists.</p>

    <a href="/" class="bg-[#93C754] hover:bg-[#7eae47] text-white px-6 py-2 rounded-md">
        Return to Home
    </a>
</div>
@endsection
