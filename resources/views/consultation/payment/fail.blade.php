@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-lg p-6 rounded-lg text-center">
    <div class="text-red-500 text-6xl mb-4">✗</div>
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Payment Failed</h2>
    <p class="text-gray-600 mb-6">Your payment was not successful. Please try again.</p>

    @if($consultation)
    <div class="mb-6">
        <a href="{{ route('consultations.create') }}" class="bg-[#93C754] hover:bg-[#7eae47] text-white px-6 py-2 rounded-md mr-2">
            Try Again
        </a>
        <a href="{{ route('home') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md">
            Return to Home
        </a>
    </div>
    @endif
</div>
@endsection
