@extends('layouts.app')

@section('title', 'About Us - Our Health Journey | Healthversations')
@section('meta_description', 'Learn how Healthversations was founded through a personal health journey of healing from ulcers, weight struggles, and metabolic diseases naturally. Discover our mission to help others achieve wellness.')
@section('meta_keywords', 'health, wellness, nutrition, weight loss, gut health, metabolic diseases, natural healing, fermented foods, Healthversations story')
@section('meta_author', 'Beatrice - Founder, Healthversations')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('about.health'))

@section('og_title', 'About Healthversations - Our Journey to Natural Wellness')
@section('og_description', 'From personal struggle to healing: The story behind Healthversations. Learn how we help people lose weight, reverse gut issues, and live medication-free.')
@section('og_image', asset('Assets/images/IMG_2851.JPG'))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', 'Beatrice - Founder of Healthversations on her wellness journey')

@section('twitter_title', 'About Healthversations - Natural Wellness Journey')
@section('twitter_description', 'Discover the story behind Healthversations - helping people achieve optimal health through nutrition and lifestyle changes.')
@section('twitter_image', asset('Assets/images/IMG_2851.JPG'))

@section('content')
<div class="container mx-auto px-4 py-10">

    <!-- JSON-LD: Organization & About Page Schema -->
    @push('json-ld')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "AboutPage",
      "name": "About Healthversations",
      "description": "Healthversations was born out of a personal journey of pain, struggle, and eventual triumph. We help people lose weight sustainably, reverse gut issues, and live medication-free.",
      "url": "{{ route('about.health') }}",
      "mainEntity": {
        "@type": "Organization",
        "name": "Healthversations",
        "founder": {
          "@type": "Person",
          "name": "Beatrice",
          "jobTitle": "Founder & Wellness Coach",
          "description": "Health advocate who overcame weight struggles, ulcers, and metabolic diseases through natural healing."
        },
        "mission": "Help people lose weight sustainably, reverse gut issues and metabolic diseases naturally, empower individuals to live medication-free through proper nutrition.",
        "foundingDate": "2020",
        "address": {
          "@type": "PostalAddress",
          "addressCountry": "KE"
        }
      }
    }
    </script>
    @endpush

    <!-- JSON-LD: Breadcrumb Schema -->
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
          "name": "About Us",
          "item": "{{ route('about.health') }}"
        }
      ]
    }
    </script>
    @endpush

    <div class="grid md:grid-cols-2 gap-12 items-start">
        <!-- Founder Image Carousel with Enhanced SEO -->
        <div class="relative w-full max-w-md mx-auto">
            <div class="relative overflow-hidden rounded-2xl shadow-xl">
                <div class="carousel w-full h-[32rem] relative">
                    <!-- Image 1 -->
                    <div class="carousel-item absolute inset-0 opacity-100 transition-opacity duration-1000 ease-in-out">
                        <img src="{{ asset('Assets/images/IMG_2851.JPG') }}"
                             alt="Beatrice - Founder of Healthversations sharing her wellness journey"
                             class="w-full h-full object-cover rounded-2xl"
                             loading="eager"
                             width="600"
                             height="800"
                             decoding="async">
                    </div>
                    <!-- Image 2 -->
                    <div class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                        <img src="{{ asset('Assets/images/IMG_2856.JPG') }}"
                             alt="Healthversations founder Beatrice - Before and after health transformation"
                             class="w-full h-full object-cover rounded-2xl"
                             loading="lazy"
                             width="600"
                             height="800"
                             decoding="async">
                    </div>
                    <!-- Image 3 -->
                    <div class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                        <img src="{{ asset('Assets/images/IMG_2875.JPG') }}"
                             alt="The journey to creating Healthversations - Natural healing and wellness"
                             class="w-full h-full object-cover rounded-2xl"
                             loading="lazy"
                             width="600"
                             height="800"
                             decoding="async">
                    </div>
                </div>

                <!-- Image Navigation Dots -->
                <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-10">
                    <button class="carousel-dot w-3 h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition" data-index="0" aria-label="View image 1"></button>
                    <button class="carousel-dot w-3 h-3 rounded-full bg-white opacity-30 hover:opacity-100 transition" data-index="1" aria-label="View image 2"></button>
                    <button class="carousel-dot w-3 h-3 rounded-full bg-white opacity-30 hover:opacity-100 transition" data-index="2" aria-label="View image 3"></button>
                </div>
            </div>
        </div>

        <!-- About Content -->
        <div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Our Story</h1>

            <div class="prose prose-lg max-w-none text-gray-700">
                <p class="leading-relaxed mb-6">
                    <strong>Healthversations</strong> was born out of a personal journey of pain, struggle, and eventual triumph.
                    Growing up overweight, life became even harder in the corporate world. A Western diet, ulcers, and weight struggles
                    led to a wake-up call, pushing me to take control of my health. It took months to heal naturally, and from that journey,
                    <strong>Healthversations was born</strong>.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Our Mission</h2>
                <ul class="list-disc pl-5 space-y-2 mb-8">
                    <li>Help people <strong>lose weight sustainably</strong>—without shortcuts.</li>
                    <li>Reverse <strong>gut issues and metabolic diseases</strong> naturally.</li>
                    <li>Empower individuals to <strong>live medication-free</strong> through proper nutrition.</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">What We Stand For</h2>
                <p class="leading-relaxed mb-6">
                    We don't believe in quick fixes or trendy diets. Instead, we guide you through
                    <strong>science-backed nutrition, fermented foods, and lifestyle changes</strong> to help you thrive.
                </p>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-xl font-bold text-gray-900">Beatrice</p>
                    <p class="text-gray-600">Founder, Healthversations</p>
                    <p class="text-sm text-gray-500 mt-2">Certified Wellness Coach | Nutrition Advocate</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="mt-20">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Core Values</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-seedling text-2xl text-[#93C754]"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Natural Healing</h3>
                <p class="text-gray-600">We believe in the power of nature to heal and restore balance to the body.</p>
            </div>
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-2xl text-[#93C754]"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Sustainable Wellness</h3>
                <p class="text-gray-600">No quick fixes—just lasting results through healthy lifestyle changes.</p>
            </div>
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-2xl text-[#93C754]"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Community Support</h3>
                <p class="text-gray-600">We're here to guide and support you every step of the way.</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="mt-16 bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] rounded-2xl p-10 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Ready to Start Your Wellness Journey?</h2>
        <p class="text-gray-200 mb-8 text-lg">Let us help you achieve your health goals naturally</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('custompackages.create') }}" class="bg-[#93C754] hover:bg-[#7eae47] text-[#0A4040] font-bold px-8 py-3 rounded-xl transition-all transform hover:scale-105 inline-flex items-center gap-2">
                <i class="fas fa-calendar-check"></i> Request Custom Package
            </a>
            <a href="{{ route('contact.health') }}" class="bg-white hover:bg-gray-100 text-[#0A4040] font-bold px-8 py-3 rounded-xl transition-all transform hover:scale-105 inline-flex items-center gap-2">
                <i class="fas fa-envelope"></i> Contact Us
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Carousel Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const items = document.querySelectorAll(".carousel-item");
        const dots = document.querySelectorAll(".carousel-dot");
        let currentIndex = 0;
        let interval;

        function showSlide(index) {
            items.forEach((item, i) => {
                item.style.opacity = i === index ? "1" : "0";
            });
            dots.forEach((dot, i) => {
                dot.style.opacity = i === index ? "1" : "0.3";
            });
            currentIndex = index;
        }

        function nextSlide() {
            const next = (currentIndex + 1) % items.length;
            showSlide(next);
        }

        function startCarousel() {
            interval = setInterval(nextSlide, 5000);
        }

        function stopCarousel() {
            clearInterval(interval);
        }

        // Add click handlers to dots
        dots.forEach((dot, index) => {
            dot.addEventListener("click", () => {
                stopCarousel();
                showSlide(index);
                startCarousel();
            });
        });

        // Pause on hover
        const carousel = document.querySelector(".carousel");
        if (carousel) {
            carousel.addEventListener("mouseenter", stopCarousel);
            carousel.addEventListener("mouseleave", startCarousel);
        }

        // Start the carousel
        startCarousel();
    });
</script>

<!-- Schema FAQ for Common Questions -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What makes Healthversations different from other wellness brands?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Healthversations was born from a personal healing journey. We don't believe in quick fixes - we focus on sustainable, natural wellness through science-backed nutrition and lifestyle changes."
      }
    },
    {
      "@type": "Question",
      "name": "Can natural nutrition really reverse gut issues?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes! Through proper nutrition, fermented foods, and lifestyle changes, many people have successfully reversed gut issues and metabolic diseases naturally."
      }
    },
    {
      "@type": "Question",
      "name": "Do you offer personalized wellness plans?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, we create custom products and wellness packages tailored to your unique health needs and goals."
      }
    }
  ]
}
</script>
@endsection
