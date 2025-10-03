@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-lg p-6 rounded-lg text-center">
    <div class="text-green-500 text-6xl mb-4">✓</div>
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Payment Successful!</h2>
    <p class="text-gray-600 mb-6">Your consultation has been booked successfully.</p>

    <div class="bg-gray-100 p-4 rounded-lg mb-6 text-left">
        <h3 class="font-semibold mb-2">Consultation Details:</h3>
        <p><strong>Reference:</strong> {{ $consultation->order_reference }}</p>
        <p><strong>Date & Time:</strong> {{ $consultation->consultation_date }} at {{ $consultation->consultation_time }}</p>
        <p><strong>Type:</strong> {{ App\Models\Consultation::getTypes()[$consultation->type] }}</p>
    </div>

    <a href="{{ route('home') }}" class="bg-[#93C754] hover:bg-[#7eae47] text-white px-6 py-2 rounded-md">
        Return to Home
    </a>
</div>
@endsection
