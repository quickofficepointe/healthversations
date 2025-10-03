@extends('layouts.app')

@section('title', 'Track Your Order | Health Versations')
@section('meta_description', 'Track your order status easily with Health Versations. Get real-time updates on your product delivery and ensure a smooth wellness journey.')
@section('meta_keywords', 'track order, delivery tracking, product status, Health Versations, order lookup')
@section('meta_author', 'Health Versations')
@section('meta_robots', 'index, follow')
@section('canonical_url', request()->url())

@section('og_title', 'Track Your Order | Health Versations')
@section('og_description', 'Use your tracking number to check the delivery status of your Health Versations order.')
@section('og_image', asset('Assets/images/health-versations-social.jpg'))

@section('twitter_title', 'Track Your Order | Health Versations')
@section('twitter_description', 'Use your tracking number to check the delivery status of your Health Versations order.')
@section('twitter_image', asset('Assets/images/health-versations-social.jpg'))

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "{{ url('/') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Track Your Order",
      "item": "{{ url()->current() }}"
    }
  ]
}
</script>
@endpush

@section('content')

<div class="container">
    <h1 class="mb-4"><b>Track Your Order</b></h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm p-4">

    <!-- Centered Section -->
    <section class="flex items-center justify-center py-6 bg-gray-100">
        <div class="max-w-3xl w-full bg-white shadow-md rounded-lg flex flex-col md:flex-row overflow-hidden mx-4 md:mx-0">
            <!-- Image Section -->
            <div class="md:w-1/2">
                <img src="{{asset ('Assets/images/rider.webp') }}" alt="Delivery Person" class="w-full h-full object-cover">
            </div>

            <!-- Form Section -->
            <div class="md:w-1/2 flex flex-col items-center justify-center p-6 text-center" >
                <h2 class="text-black text-lg font-semibold">Hello, welcome back</h2>
                <p class="text-black text-sm">Enter your tracking number here</p>
                <!-- <p class="text-[#93C754] text-xs">(this was sent on your email)</p> --> <!--FIXME:THIS WILL BE FOR SUCCESS/ CORRECT TRACK NUMBER-->
                <!-- <p class="text-red-600 text-xs">(PLEASE ENTER A VALID TRACKING NUMBER)</p> --> <!--FIXME:THIS WILL BE FOR inCORRECT TRACK NUMBER-->
                <input type="text"  placeholder="Tracking number"
                    class="w-full border border-gray-300 p-2 mt-4 focus:outline-none focus:ring-2 focus:ring-green-500">

                <button class="w-full bg-[#0A4040] text-[#93C754] px-6 py-2 mt-4 hover:bg-green-800 transition" id="trackingInput">
                    Check my product
                </button>
            </div>
        </div>





    <div id="orderDetails">
        @if(request()->has('tracking_id'))
            @if(isset($order))
                <div class="card mt-4 shadow-sm p-4">
                    <h4 class="mb-3">Order Details</h4>
                    <p><strong>Product:</strong> {{ $order->product_name }}</p>
                    <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Status:</strong>
                        @if($order->status == 'not_delivered')
                            <span class="badge bg-warning">In Progress</span>
                        @elseif($order->status == 'processed')
                            <span class="badge bg-info">Processed</span>
                        @elseif($order->status == 'delivered')
                            <span class="badge bg-success">Delivered</span>
                        @else
                            <span class="badge bg-secondary">Unknown</span>
                        @endif
                    </p>
                </div>
            @else
                <div class="alert alert-danger mt-3">Order not found. Please check your tracking ID.</div>
            @endif
        @endif
    </div>
</div>

<script>
    function clearPreviousResults() {
        document.getElementById('orderDetails').innerHTML = '';
    }
</script>
 <!-- JavaScript to Focus on Input -->
 <script>
    window.onload = function () {
        document.getElementById("trackingInput").focus();
    };
</script>
@endsection
