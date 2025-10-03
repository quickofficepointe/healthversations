@extends('layouts.app')

@section('title', 'About Us - Healthversations')
@section('meta_description', 'Learn how Healthversations was founded through a personal health journey and our mission to help others achieve wellness naturally.')
@section('meta_keywords', 'health, wellness, nutrition, weight loss, gut health, metabolic diseases')

@section('content')

<div class="container mx-auto px-4 py-10">
    <div class="grid md:grid-cols-2 gap-8 items-center">

        <!-- Founder Image Carousel -->
        <div class="relative w-full max-w-md mx-auto">
            <div class="relative overflow-hidden rounded-lg shadow-lg">
                <div class="carousel w-full h-[30rem] relative"> <!-- Increased height -->
                    <div class="carousel-item absolute inset-0 opacity-100 transition-opacity duration-1000 ease-in-out">
                        <img src="{{ asset('Assets/images/IMG_2851.JPG') }}" alt="Beatrice - Founder of Healthversations" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                        <img src="{{ asset('Assets/images/IMG_2856.JPG') }}" alt="Healthversations Founder" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                        <img src="{{ asset('Assets/images/IMG_2875.JPG') }}" alt="Journey to Healthversations" class="w-full h-full object-cover rounded-lg">
                    </div>
                </div>
            </div>
        </div>

        <!-- About Content -->
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Story</h1>
            <p class="text-gray-700 leading-relaxed mb-6">
                Healthversations was born out of a personal journey of pain, struggle, and eventual triumph.
                Growing up overweight, life became even harder in the corporate world. A Western diet, ulcers, and weight struggles
                led to a wake-up call, pushing me to take control of my health. It took months to heal naturally, and from that journey,
                Healthversations was born.
            </p>

            <h2 class="text-2xl font-semibold text-gray-900 mt-6">Our Mission</h2>
            <ul class="list-disc pl-5 text-gray-700 mb-6">
                <li>Help people lose weight sustainably—without shortcuts.</li>
                <li>Reverse gut issues and metabolic diseases naturally.</li>
                <li>Empower individuals to live medication-free through proper nutrition.</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-900 mt-6">What We Stand For</h2>
            <p class="text-gray-700 leading-relaxed mb-6">
                We don’t believe in quick fixes or trendy diets. Instead, we guide you through science-backed nutrition, fermented foods,
                and lifestyle changes to help you thrive.
            </p>

            <p class="mt-6 text-gray-900 font-bold">Beatrice</p>
            <p class="text-gray-700">Founder, Healthversations</p>
        </div>
          <!-- Products CTA Section -->
        <div class="mt-16 bg-[#0A4040] rounded-lg p-8 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">Looking for something specific?</h3>
            <p class="text-gray-200 mb-6">We can create custom products tailored to your unique health needs</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('custompackages.create') }}" class="bg-[#93C754] hover:bg-[#7eae47] text-[#0A4040] font-bold px-6 py-3 rounded-lg transition-colors">
                    Request Custom Product
                </a>
                <a href="" class="bg-white hover:bg-gray-100 text-[#0A4040] font-bold px-6 py-3 rounded-lg transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Tailwind Carousel Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let items = document.querySelectorAll(".carousel-item");
        let index = 0;
        setInterval(() => {
            items.forEach((item, i) => {
                item.style.opacity = i === index ? "1" : "0";
            });
            index = (index + 1) % items.length;
        }, 3000);
    });
</script>

@endsection
