<!DOCTYPE html>
<html lang="en" itemscope itemtype="https://schema.org/WebPage">
<head>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-2NZ5XWXLL0"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-2NZ5XWXLL0');
  </script>

  <!-- Primary Meta Tags -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Health Versation | Premium Wellness Products & Personalized Health Coaching</title>
  <meta name="description" content="Health Versation offers premium wellness products, personalized health coaching, and expert advice to help you achieve holistic well-being. Start your health journey with us. Get 20% OFF on all products!">
  <meta name="keywords" content="Health Versation, wellness products, health coaching, holistic health, nutrition, natural supplements, fitness plans, personalized wellness, 20% off, discount">
  <meta name="author" content="Health Versation">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <meta name="revisit-after" content="7 days">
  <meta name="rating" content="general">

  <!-- Canonical URL -->
  <link rel="canonical" href="https://www.healthversation.com">
  <link rel="sitemap" type="application/xml" title="Sitemap" href="https://www.healthversation.com/sitemap.xml">

  <!-- Open Graph / Facebook Meta Tags -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://www.healthversation.com">
  <meta property="og:title" content="Health Versation | Premium Wellness Products & Personalized Health Coaching">
  <meta property="og:description" content="Health Versation offers premium wellness products, personalized health coaching, and expert advice to help you achieve holistic well-being. 20% OFF sitewide!">
  <meta property="og:image" content="https://www.healthversation.com/Assets/images/health-versation-social.jpg">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:site_name" content="Health Versation">

  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="https://www.healthversation.com">
  <meta name="twitter:title" content="Health Versation | Premium Wellness Products & Personalized Health Coaching">
  <meta name="twitter:description" content="Health Versation offers premium wellness products, personalized health coaching, and expert advice. 20% OFF sitewide!">
  <meta name="twitter:image" content="https://www.healthversation.com/Assets/images/health-versation-social.jpg">
  <meta name="twitter:site" content="@HealthVersation">
  <meta name="twitter:creator" content="@HealthVersation">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="/Assets/images/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/Assets/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/Assets/images/favicon/favicon-16x16.png">
  <link rel="manifest" href="/Assets/images/logo.png">
  <link rel="mask-icon" href="/Assets/images/favicon/safari-pinned-tab.svg" color="#93c754">
  <meta name="msapplication-TileColor" content="#93c754">
  <meta name="theme-color" content="#ffffff">

  <!-- Stylesheets -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Tangerine:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('Assets/css/styles.css') }}">

  <!-- Swiper JS CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- JSON-LD Schema for SEO -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "MedicalOrganization",
    "name": "Health Versation",
    "alternateName": "Health Versations",
    "url": "https://www.healthversation.com",
    "logo": "https://www.healthversation.com/Assets/images/logo.png",
    "image": "https://www.healthversation.com/Assets/images/health-versation-social.jpg",
    "description": "Premium wellness products and personalized health coaching for holistic well-being. Get 20% OFF on all products!",
    "email": "info@healthversation.com",
    "telephone": "+254717813291",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Nairobi",
      "addressCountry": "KE"
    },
    "sameAs": [
      "https://www.facebook.com/healthversations",
      "https://www.instagram.com/health_versations",
      "https://twitter.com/healthversations"
    ],
    "potentialAction": {
      "@type": "SearchAction",
      "target": "https://www.healthversation.com/search?q={search_term_string}",
      "query-input": "required name=search_term_string"
    }
  }
  </script>

  <style>
    .line-clamp-3 {
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .line-clamp-4 {
      display: -webkit-box;
      -webkit-line-clamp: 4;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .testimonial-content, .blog-content {
      min-height: 120px;
    }

    .swiper-slide {
      height: auto;
    }

    .animate-bounce {
      animation: bounce 0.5s;
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }

    /* Discount Styles */
    .original-price {
      text-decoration: line-through;
      color: #9ca3af;
      font-size: 0.875rem;
    }

    .discount-badge {
      background: linear-gradient(135deg, #FF6B6B, #EE5A24);
      color: white;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: bold;
    }

    /* Skip to content link */
    .skip-to-content {
      position: absolute;
      left: -9999px;
      top: auto;
      width: 1px;
      height: 1px;
      overflow: hidden;
      z-index: 9999;
    }
    .skip-to-content:focus {
      left: 50%;
      transform: translateX(-50%);
      width: auto;
      height: auto;
      padding: 12px 24px;
      background: #93C754;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
    }

    /* Product card hover */
    .product-card {
      transition: all 0.3s ease;
    }
    .product-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
  </style>
</head>

<body class="bg-gray-100 text-gray-800 font-poppins" data-cart-url="{{ route('cart.add') }}">

  <!-- Skip to Content Link -->
  <a href="#main-content" class="skip-to-content">Skip to main content</a>

  @if(session('success'))
    <div id="successMessage" data-message="{{ session('success') }}"></div>
  @endif

  @if(session('error'))
    <div id="errorMessage" data-message="{{ session('error') }}"></div>
  @endif

  <!-- Header -->
  <header class="bg-white shadow-md sticky top-0 z-40">
    <nav class="container mx-auto flex items-center justify-between py-4 px-6 md:px-12">
      <!-- Logo -->
      <div>
        <a href="/">
          <img src="{{asset ('Assets/images/logo.png') }}" alt="Health Versations Logo" class="h-20 w-auto" loading="eager">
        </a>
      </div>

      <!-- Navbar Links -->
      <ul class="hidden md:flex space-x-6 font-medium">
        <li><a href="/" class="hover:text-green-600 transition-colors">Home</a></li>
        <li><a href="{{ route('all.products') }}" class="hover:text-green-600 transition-colors">Products</a></li>
        <li><a href="{{route ('ebooks.show') }}" class="hover:text-green-600 transition-colors">Ebooks</a></li>
        <li><a href="{{ route('contact.health') }}" class="hover:text-green-600 transition-colors">Talk to Us</a></li>
        <li><a href="{{ route('about.health') }}" class="hover:text-green-600 transition-colors">About Us</a></li>
        <li><a href="{{ route('frontend.blogs.index') }}" class="hover:text-green-600 transition-colors">Articles</a></li>
        <li><a href="{{route ('orders.track') }}" class="hover:text-green-600 transition-colors">Track order</a></li>
      </ul>

      <!-- CTA Button -->
      <div>
        <a href="{{ route('custompackages.create') }}" class="bg-[#93C754] text-white px-6 py-2 text-sm font-semibold uppercase rounded-lg hover:bg-green-700 transition-colors">
          Create package
        </a>
      </div>

      <!-- Mobile Menu Button -->
      <button id="menu-btn" class="block md:hidden text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#93C754] rounded-lg p-2" aria-label="Menu">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </button>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg">
      <ul class="space-y-4 p-6">
        <li><a href="/" class="block text-gray-800 hover:text-green-600">Home</a></li>
        <li><a href="{{ route('all.products') }}" class="block text-gray-800 hover:text-green-600">Products</a></li>
        <li><a href="{{route ('ebooks.show') }}" class="block text-gray-800 hover:text-green-600">Ebooks</a></li>
        <li><a href="{{ route('contact.health') }}" class="block text-gray-800 hover:text-green-600">Talk to Us</a></li>
        <li><a href="{{ route('frontend.blogs.index') }}" class="block text-gray-800 hover:text-green-600">Articles</a></li>
        <li><a href="{{route ('about.health') }}" class="block text-gray-800 hover:text-green-600">About Us</a></li>
        <li><a href="{{route ('orders.track') }}" class="block text-gray-800 hover:text-green-600">Track order</a></li>
      </ul>
    </div>
  </header>

  <!-- Promotional Banner with Discount -->
  <div class="bg-gradient-to-r from-red-500 to-orange-500 text-white text-center py-3 text-sm font-medium">
    <div class="container mx-auto px-4">
      <span class="hidden md:inline">🔥 LIMITED TIME OFFER: 20% OFF ALL PRODUCTS! 🔥</span>
      <marquee class="md:hidden">🔥 LIMITED TIME OFFER: 20% OFF ALL PRODUCTS! 🔥 Premium Quality | 100% Natural | Tried and Tested</marquee>
    </div>
  </div>

  <main id="main-content">
    <!-- Hero Banner with H1 -->
    <section class="relative overflow-hidden">
      <div class="banner-container flex transition-transform duration-1000 ease-in-out">
        @foreach($banners as $banner)
          <div class="w-full flex-shrink-0 relative" style="aspect-ratio: 3000 / 948;">
            <img src="{{ asset('storage/' . $banner->image) }}"
                 alt="{{ $banner->title }}"
                 class="w-full h-full object-contain md:object-cover"
                 loading="eager">
          </div>
        @endforeach
      </div>

      <!-- Hero Text Overlay -->
      <div class="absolute inset-0 flex items-center justify-center text-center text-white z-10 bg-black/30">
        <div class="px-4">
          <div class="inline-block bg-[#93C754]/90 text-white px-4 py-1 rounded-full text-sm font-semibold mb-4">
            🎉 20% OFF SITEWIDE 🎉
          </div>

          <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('all.products') }}" class="bg-[#93C754] hover:bg-[#7eae47] text-white px-6 py-3 rounded-lg font-bold transition-all transform hover:scale-105">
              Shop Now
            </a>
            <a href="{{ route('consultations.create') }}" class="bg-white hover:bg-gray-100 text-[#0A4040] px-6 py-3 rounded-lg font-bold transition-all transform hover:scale-105">
              Book Consultation
            </a>
          </div>
        </div>
      </div>

      <!-- Banner Navigation -->
      <button class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-50 p-2 rounded-full hover:bg-opacity-75 transition z-20">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-50 p-2 rounded-full hover:bg-opacity-75 transition z-20">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>

      <!-- Banner Dots -->
      <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2 banner-dots z-20"></div>
    </section>

    <!-- Consultation CTA -->
    <section class="py-12 bg-gradient-to-b from-white to-gray-50">
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center p-8 rounded-xl shadow-sm border border-gray-200 bg-white">
          <div class="bg-red-100 text-red-600 inline-block px-4 py-1 rounded-full text-sm font-semibold mb-4">
            🎯 Limited Time Offer
          </div>
          <h2 class="text-2xl md:text-3xl font-bold text-[#0A4040] mb-4">
            Not sure which program is right for you?
          </h2>
          <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
            Schedule a free consultation with our health experts to find the perfect solution for your needs. <span class="font-bold text-red-500">Plus get 20% OFF your first purchase!</span>
          </p>
          <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('consultations.create') }}"
               class="inline-flex items-center justify-center bg-[#0A4040] hover:bg-[#072b2b] text-white px-8 py-4 rounded-lg font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
              Book Your Free Consultation
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Wellness Services -->
    <section class="py-16 bg-gradient-to-r from-[#F8F9FA] to-[#E8F5E9]">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <div class="w-24 h-1 bg-[#0A4040] mx-auto mb-6 rounded-full"></div>
          <h2 class="text-3xl font-bold text-[#0A4040]">Your Wellness is Our Core Concern</h2>
          <p class="text-lg text-gray-600 mt-2 max-w-2xl mx-auto">We provide personalized solutions to help you achieve optimal health</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          @php
            $services = [
              ['icon' => 'fas fa-heartbeat', 'title' => 'Holistic Approach', 'text' => 'We address all aspects of your health - physical, mental, and emotional - to create comprehensive wellness solutions.'],
              ['icon' => 'fas fa-user-md', 'title' => 'Expert Guidance', 'text' => 'Our team of health professionals provides evidence-based recommendations tailored to your unique needs.'],
              ['icon' => 'fas fa-seedling', 'title' => 'Natural Solutions', 'text' => 'We prioritize natural, sustainable approaches to health that work in harmony with your body\'s systems.']
            ];
          @endphp

          @foreach ($services as $service)
            <div class="bg-white p-8 rounded-2xl shadow-lg transform transition-transform duration-500 hover:scale-105">
              <div class="text-[#93C754] text-5xl mb-4">
                <i class="{{ $service['icon'] }}"></i>
              </div>
              <h3 class="text-xl font-bold text-[#0A4040] mb-3">{{ $service['title'] }}</h3>
              <p class="text-gray-600">{{ $service['text'] }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Real Transformations Section -->
    <section id="real-transformations" class="bg-[#F8F9FA] py-16">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <div class="w-24 h-1 bg-[#0A4040] mx-auto mb-6 rounded-full"></div>
          <h2 class="text-3xl font-bold text-[#0A4040]">Real Transformations</h2>
          <p class="text-lg text-gray-600 mt-2 max-w-2xl mx-auto">See the amazing results our clients have achieved through our programs</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          @forelse($consultTestimonials->take(3) as $testimonial)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
              <div class="relative h-64 bg-gray-100">
                <div class="flex h-full">
                  <div class="w-1/2 relative">
                    <img src="{{ Storage::url($testimonial->before_image) }}"
                         alt="{{ $testimonial->client_name }} before transformation"
                         class="w-full h-full object-cover"
                         loading="lazy">
                    <div class="absolute bottom-0 left-0 right-0 bg-black/70 text-white text-center py-2 text-sm font-medium">
                      Before
                    </div>
                  </div>
                  <div class="w-1/2 relative">
                    <img src="{{ Storage::url($testimonial->after_image) }}"
                         alt="{{ $testimonial->client_name }} after transformation"
                         class="w-full h-full object-cover"
                         loading="lazy">
                    <div class="absolute bottom-0 left-0 right-0 bg-green-600/80 text-white text-center py-2 text-sm font-medium">
                      After
                    </div>
                  </div>
                </div>
              </div>

              <div class="p-6">
                <div class="flex items-center mb-4">
                  <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                    @if($testimonial->before_image)
                      <img src="{{ Storage::url($testimonial->before_image) }}"
                           alt="{{ $testimonial->client_name }}"
                           class="w-full h-full object-cover"
                           loading="lazy">
                    @else
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                      </svg>
                    @endif
                  </div>
                  <div class="ml-3">
                    <h3 class="text-lg font-bold text-[#0A4040]">{{ $testimonial->client_name }}</h3>
                    <p class="text-sm text-gray-500">{{ $testimonial->program_type ?? 'Health Program' }}</p>
                  </div>
                </div>

                <div class="mb-4">
                  <div class="flex flex-wrap gap-2">
                    @if($testimonial->weight_loss_kg)
                      <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                        -{{ $testimonial->weight_loss_kg }}kg
                      </span>
                    @endif
                    @if($testimonial->inches_lost)
                      <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        -{{ $testimonial->inches_lost }} inches
                      </span>
                    @endif
                    @if($testimonial->program_duration_weeks)
                      <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                        {{ $testimonial->program_duration_weeks }} weeks
                      </span>
                    @endif
                  </div>
                </div>

                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                  "{{ Str::limit(strip_tags($testimonial->testimonial_text), 120) }}"
                </p>

                <a href="{{ route('testimonials.show', $testimonial->slug) }}"
                   class="inline-flex items-center text-[#93C754] hover:text-[#7eae47] font-medium text-sm">
                  View Full Transformation
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </a>
              </div>
            </div>
          @empty
            <div class="text-center col-span-3 py-12">
              <p class="text-gray-500">Transformation stories coming soon!</p>
            </div>
          @endforelse
        </div>

        <div class="mt-16 bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] rounded-2xl p-8 text-center">
          <h3 class="text-2xl font-bold text-white mb-3">Ready for Your Transformation?</h3>
          <p class="text-gray-300 mb-6">Join thousands of satisfied clients who have transformed their health with our programs</p>
          <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('consultations.create') }}"
               class="bg-[#93C754] hover:bg-[#7eae47] text-[#0A4040] font-bold px-6 py-3 rounded-lg transition-colors">
              Start Your Journey
            </a>
            <a href="{{ route('testimonials.index') }}"
               class="bg-white hover:bg-gray-100 text-[#0A4040] font-bold px-6 py-3 rounded-lg transition-colors">
              View All Success Stories
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Products Section with 20% Discount -->
    <section class="py-16 bg-white">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <div class="inline-block bg-red-100 text-red-600 px-4 py-1 rounded-full text-sm font-semibold mb-4">
            🔥 Limited Time Offer 🔥
          </div>
          <div class="w-24 h-1 bg-[#0A4040] mx-auto mb-6 rounded-full"></div>
          <h2 class="text-3xl font-bold text-[#0A4040]">Featured Products</h2>
          <p class="text-lg text-gray-600 mt-2">Premium wellness products for your health journey - <span class="text-red-500 font-bold">20% OFF</span></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          @foreach($products->take(4) as $product)
            @php
              $defaultDiscount = 20;
              $currentPriceKES = $product->has_variations ? $product->variants->min('price_kes') : $product->price_kes;
              $currentPriceUSD = $product->has_variations ? $product->variants->min('price_usd') : $product->price_usd;
              $originalPriceKES = $currentPriceKES / (1 - $defaultDiscount / 100);
              $originalPriceUSD = $currentPriceUSD / (1 - $defaultDiscount / 100);
              $savingsKES = $originalPriceKES - $currentPriceKES;
            @endphp
            <div class="product-card bg-white rounded-2xl shadow-md overflow-hidden flex flex-col transform transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
              <div class="relative bg-white rounded-t-2xl flex items-center justify-center p-4 h-60">
                <div class="absolute top-2 right-2 discount-badge z-10">
                  -{{ $defaultDiscount }}% OFF
                </div>
                <img src="{{ asset($product->cover_image) }}"
                     alt="{{ $product->product_name }}"
                     class="max-w-full max-h-full object-contain"
                     loading="lazy">
              </div>

              <div class="p-5 flex-grow flex flex-col">
                <h3 class="text-lg font-semibold text-[#0A4040] mb-3">{{ $product->product_name }}</h3>

                <!-- Price with Discount -->
                <div class="mb-4">
                  <div class="flex items-baseline gap-2">
                    <span class="text-gray-400 original-price">KES {{ number_format($originalPriceKES, 2) }}</span>
                    <span class="text-2xl font-bold text-[#93C754]">KES {{ number_format($currentPriceKES, 2) }}</span>
                  </div>
                  <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-gray-400 original-price text-xs">${{ number_format($originalPriceUSD, 2) }}</span>
                    <span class="font-semibold text-[#93C754]">${{ number_format($currentPriceUSD, 2) }}</span>
                  </div>
                  <div class="mt-2 text-xs text-green-600 font-medium">
                    <i class="fas fa-tag mr-1"></i> You save KES {{ number_format($savingsKES, 2) }}
                  </div>
                </div>

                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                  {!! Str::limit($product->description, 80) !!}
                </p>

                <div class="flex items-center justify-between mt-auto">
                  <a href="{{ route('product.show', $product->slug) }}"
                     class="bg-[#52823C] hover:bg-[#93C754] text-white font-bold py-2 px-4 rounded-md text-sm transition-colors">
                    View Details
                  </a>

                  <div class="flex items-center space-x-2">
                    <button class="decrease bg-gray-200 hover:bg-gray-300 text-black font-bold py-1 px-3 rounded transition-colors">-</button>
                    <span class="quantity text-lg font-medium">1</span>
                    <button class="increase bg-gray-200 hover:bg-gray-300 text-black font-bold py-1 px-3 rounded transition-colors">+</button>
                  </div>

                  <button class="add-to-cart transition-transform hover:scale-110" data-product-id="{{ $product->id }}">
                    <img src="{{ asset('Assets/images/shopping-cart.svg') }}" alt="Add to Cart" class="h-6 w-6">
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="text-center mt-12">
          <a href="{{ route('all.products') }}"
             class="inline-block bg-[#93C754] hover:bg-[#7eae47] text-white px-8 py-3 rounded-lg font-bold text-lg transition-colors transform hover:scale-105">
            View All Products <span class="ml-2">→</span>
          </a>
        </div>
      </div>
    </section>

    <!-- Rest of the sections remain the same... -->
    <!-- Testimonials Section -->
<!-- Testimonials Section -->
<section class="py-16 bg-gray-50 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <div class="w-24 h-1 bg-[#0A4040] mx-auto mb-6 rounded-full"></div>
            <h2 class="text-3xl font-bold text-[#0A4040]">What Our Clients Say</h2>
            <p class="text-lg text-gray-600 mt-2">Real stories from people who transformed their health with us</p>
        </div>

        <div class="swiper testimonials-swiper">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 h-full flex flex-col">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                                    @if($testimonial->image)
                                        <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->full_name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <h3 class="font-semibold text-gray-800">{{ $testimonial->full_name }}</h3>
                                    <p class="text-xs text-gray-500">Satisfied Client</p>
                                </div>
                            </div>

                            <div class="testimonial-content flex-grow">
                                @php
                                    $content = strip_tags($testimonial->message);
                                    $words = str_word_count($content, 1);
                                    $limitedWords = array_slice($words, 0, 30);
                                    $limitedText = implode(' ', $limitedWords);
                                    $isLongText = count($words) > 30;
                                    if ($isLongText) {
                                        $limitedText .= '...';
                                    }
                                @endphp

                                <div class="relative">
                                    <p class="text-gray-700 italic testimonial-text">
                                        "{{ $limitedText }}"
                                    </p>

                                    @if($isLongText)
                                        <p class="text-gray-700 italic testimonial-full hidden mt-2">
                                            "{{ $content }}"
                                        </p>
                                    @endif

                                    @if($isLongText)
                                        <button onclick="toggleReadMore(this)" class="read-more-btn text-[#93C754] font-medium hover:underline mt-2 text-sm transition-colors z-10 relative">
                                            Read More
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination mt-6 relative z-0"></div>
        </div>

        <div class="text-center mt-12">
            <button id="rateUsButton" class="inline-block bg-[#93C754] hover:bg-[#7eae47] text-white px-8 py-3 rounded-lg font-bold text-lg transition-colors">
                Share Your Experience
            </button>
        </div>
    </div>
</div>
<!-- Rate Us Modal -->
<div id="rateUsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
        <!-- Modal Header -->
        <div class="bg-[#0A4040] text-white p-6 rounded-t-2xl">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold">Share Your Experience</h3>
                <button id="closeModal" class="text-white hover:text-gray-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <p class="text-green-200 mt-2">We'd love to hear about your journey with us!</p>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <form id="testimonialForm" action="{{ route('testimonials.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Your Name *</label>
                    <input type="text" name="full_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#93C754] focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Your Email *</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#93C754] focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Your Rating *</label>
                    <div class="flex space-x-2" id="ratingStars">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 rating-star" data-rating="{{ $i }}">
                                ★
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="selectedRating" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Your Experience *</label>
                    <textarea name="message" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#93C754] focus:border-transparent" placeholder="Share your health journey and results..." required></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelModal" class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium transition-colors">Cancel</button>
                    <button type="submit" class="bg-[#93C754] hover:bg-[#7eae47] text-white px-6 py-2 rounded-lg font-medium transition-colors">Share Experience</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Blog Section -->
<!-- Blog Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <div class="w-24 h-1 bg-[#0A4040] mx-auto mb-6 rounded-full"></div>
            <h2 class="text-3xl font-bold text-[#0A4040]">Latest Articles</h2>
            <p class="text-lg text-gray-600 mt-2">Expert insights and health tips from our wellness team</p>
        </div>

        @if($blogs->count() > 0)
            <div class="swiper blog-swiper">
                <div class="swiper-wrapper">
                    @foreach($blogs as $blog)
                        <div class="swiper-slide">
                            <div class="bg-white rounded-lg shadow-md overflow-hidden h-full flex flex-col transform transition-all duration-300 hover:shadow-xl">
                                <!-- Blog Image -->
                                <div class="h-48 overflow-hidden">
                                    @if($blog->cover_image)
                                        <img src="{{ asset($blog->cover_image) }}"
                                             alt="{{ $blog->blog_title }}"
                                             class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Blog Content -->
                                <div class="p-6 flex-grow flex flex-col">
                                    <!-- Category -->
                                    @if($blog->category)
                                        <span class="inline-block bg-[#93C754] text-white text-xs font-semibold px-3 py-1 rounded-full mb-3 self-start">
                                            {{ $blog->category->name ?? 'Uncategorized' }}
                                        </span>
                                    @endif

                                    <!-- Title -->
                                    <h3 class="text-xl font-bold text-[#0A4040] mb-3 line-clamp-2">
                                        {{ $blog->blog_title }}
                                    </h3>

                                    <!-- Description -->
                                    <div class="blog-content flex-grow">
                                        @php
                                            $content = strip_tags($blog->blog_description);
                                            $words = str_word_count($content, 1);
                                            $limitedWords = array_slice($words, 0, 20);
                                            $limitedText = implode(' ', $limitedWords);
                                            $isLongText = count($words) > 20;
                                            if ($isLongText) {
                                                $limitedText .= '...';
                                            }
                                        @endphp

                                        <p class="text-gray-600 text-sm blog-text">
                                            {{ $limitedText }}
                                        </p>

                                        @if($isLongText)
                                            <p class="text-gray-600 text-sm blog-full hidden mt-2">
                                                {{ $content }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Read More Button -->
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <a href="{{ route('frontend.blogs.show', $blog->slug) }}"
                                           class="inline-flex items-center text-[#0A4040] hover:text-[#93C754] font-medium text-sm transition-colors">
                                            Read Full Article
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Swiper Pagination -->
                <div class="swiper-pagination mt-8 relative z-0"></div>

                <!-- Swiper Navigation -->
                <div class="swiper-button-next text-[#0A4040]"></div>
                <div class="swiper-button-prev text-[#0A4040]"></div>
            </div>

            <!-- View All Blogs Button -->
            <div class="text-center mt-12">
                <a href="{{ route('frontend.blogs.index') }}"
                   class="inline-block bg-[#93C754] hover:bg-[#7eae47] text-white px-8 py-3 rounded-lg font-bold text-lg transition-colors">
                    View All Articles
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Articles Yet</h3>
                <p class="text-gray-500">Check back soon for the latest health and wellness articles.</p>
            </div>
        @endif
    </div>
</section>
<!-- Contact Section -->
<section class="bg-gradient-to-b from-gray-50 to-white py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="w-24 h-1 bg-[#0A4040] mx-auto mb-6 rounded-full"></div>
            <h2 class="text-3xl font-bold text-[#0A4040]">Get In Touch</h2>
            <p class="text-lg text-gray-600 mt-2 max-w-2xl mx-auto">We're here to help you on your wellness journey. Reach out to us with any questions.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch">
            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <h3 class="text-2xl font-bold text-[#0A4040] mb-6 text-center">Send Us a Message</h3>
                <form class="space-y-5" method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-semibold text-[#0A4040] mb-2">Full Name *</label>
                        <input type="text" id="name" name="name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition"
                               placeholder="Enter your full name">
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-semibold text-[#0A4040] mb-2">Phone Number</label>
                        <input type="tel" id="phone_number" name="phone_number"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition"
                               placeholder="Enter your phone number">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-[#0A4040] mb-2">Email Address *</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition"
                               placeholder="Enter your email address">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-[#0A4040] mb-2">Message *</label>
                        <textarea id="message" name="message" rows="5" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition"
                                  placeholder="Tell us about your health goals or questions..."></textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] text-white font-bold py-4 rounded-xl hover:from-[#1a6b6b] hover:to-[#0A4040] transition-all duration-300 transform hover:scale-[1.02] shadow-md">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information & Map -->
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-[#0A4040] to-[#093535] rounded-2xl shadow-xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-6 text-center text-[#93C754]">Contact Information</h3>
                    <div class="space-y-5">
                        <div class="flex items-start">
                            <div class="bg-[#93C754] p-3 rounded-xl mr-4">
                                <i class="fas fa-envelope text-[#0A4040] text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-[#93C754]">Email</p>
                                <a href="mailto:info@healthversation.com" class="text-white hover:text-[#93C754] transition">
                                    info@healthversation.com
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-[#93C754] p-3 rounded-xl mr-4">
                                <i class="fas fa-phone text-[#0A4040] text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-[#93C754]">Phone</p>
                                <a href="tel:+254717813291" class="text-white hover:text-[#93C754] transition">
                                    +254 717 813 291
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="bg-[#93C754] p-3 rounded-xl mr-4">
                                <i class="fas fa-map-marker-alt text-[#0A4040] text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-[#93C754]">Location</p>
                                <p class="text-white">Nairobi CBD, Kenya</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-[#93C754]/30">
                            <p class="font-semibold text-[#93C754] mb-4 text-center">Follow Us</p>
                            <div class="flex justify-center space-x-5">
                                <a href="https://www.facebook.com/share/1D5etZeuVs/" target="_blank" rel="noopener noreferrer"
                                   class="bg-white/10 hover:bg-[#93C754] p-3 rounded-full transition-all duration-300 transform hover:scale-110">
                                    <i class="fab fa-facebook-f text-white text-lg"></i>
                                </a>
                                <a href="https://wa.me/254717813291"
                                   class="bg-white/10 hover:bg-[#93C754] p-3 rounded-full transition-all duration-300 transform hover:scale-110">
                                    <i class="fab fa-whatsapp text-white text-lg"></i>
                                </a>
                                <a href="https://www.instagram.com/health_versations" target="_blank" rel="noopener noreferrer"
                                   class="bg-white/10 hover:bg-[#93C754] p-3 rounded-full transition-all duration-300 transform hover:scale-110">
                                    <i class="fab fa-instagram text-white text-lg"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                    <div class="bg-[#0A4040] p-4 text-center">
                        <h3 class="text-white font-bold text-lg">Visit Us</h3>
                        <p class="text-[#93C754] text-sm">Find us in Nairobi CBD</p>
                    </div>
                    <div class="h-80">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.808722050356!2d36.82114697469622!3d-1.2923591356496865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f10d5c66309d1%3A0x6f0c2b5c9c5a33f0!2sNairobi%20CBD%2C%20Kenya!5e0!3m2!1sen!2sus!4v1690000000000!5m2!1sen!2sus"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Testimonials Section, Blog Section, Contact Section, Footer -->

  </main>

  <!-- Footer -->
  <footer class="bg-teal-800 text-white">
    <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row items-start justify-between gap-8 py-8">
      <div class="flex flex-col items-start gap-4">
        <div class="flex items-center gap-2">
          <img src="{{asset ('Assets/images/white logo.png') }}" alt="Health Versations Logo" class="h-16" loading="lazy">
          <span class="text-2xl font-semibold text-green-300">HEALTH VERSATIONS</span>
        </div>
        <a href="{{ route('custompackages.create') }}">
          <button class="bg-green-500 hover:bg-green-600 text-teal-800 px-6 py-2 font-medium rounded-lg transition-colors">
            Create a Custom Package for me
          </button>
        </a>
      </div>

      <div class="flex flex-col gap-2">
        <h3 class="text-lg font-semibold text-green-300">Quick Links</h3>
        <a href="/" class="hover:underline">Home</a>
        <a href="{{ route('all.products') }}" class="hover:underline">Products</a>
        <a href="{{ route('frontend.blogs.index') }}" class="hover:underline">Blogs</a>
        <a href="{{route ('orders.track') }}" class="hover:underline">Track Order</a>
      </div>

      <div class="flex flex-col gap-2">
        <h3 class="text-lg font-semibold text-green-300">Support</h3>
        <a href="{{ route('contact.health') }}" class="hover:underline">Talk to Us</a>
        <a href="{{ route('about.health') }}" class="hover:underline">About Us</a>
        <a href="{{ route('faq.versation') }}" class="hover:underline">FAQs</a>
        <a href="#" class="hover:underline rate-us-footer">Rate Us</a>
      </div>

      <div class="flex flex-col gap-2">
        <h3 class="text-lg font-semibold text-green-300">Legal</h3>
        <a href="{{ route('returns.refunds') }}" class="hover:underline">Return and Refund</a>
        <a href="{{ route('terms.versation') }}" class="hover:underline">Terms & Conditions</a>
        <a href="{{ route('privacypolicy.versation') }}" class="hover:underline">Privacy Policy</a>
      </div>

      <div class="flex flex-col gap-2">
        <h3 class="text-lg font-semibold text-green-300">Contact Us</h3>
        <p>TELEPHONE: <span class="text-sm font-semibold text-[#93C754]">+254717813291</span></p>
        <p>EMAIL: <span class="text-sm font-semibold text-[#93C754]">info@healthversation.com</span></p>
        <div class="flex gap-4 mt-2">
          <a href="https://www.facebook.com/share/1D5etZeuVs/" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition"><img src="{{asset ('Assets/images/facebook.svg') }}" alt="Facebook" class="h-6"></a>
          <a href="https://wa.me/254717813291" class="hover:opacity-80 transition"><img src="{{asset ('Assets/images/whatsapp.svg') }}" alt="WhatsApp" class="h-6"></a>
          <a href="https://www.instagram.com/health_versations" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition"><img src="{{asset ('Assets/images/instagram.svg') }}" alt="Instagram" class="h-6"></a>
        </div>
      </div>
    </div>

    <div class="bg-[#0A4040] text-center py-4 text-white">
      <p>&copy; <span id="current-year"></span> HEALTH VERSATIONS. All rights reserved.</p>
      <p style="color: #93C754;">
        Developed and designed by <a href="https://quickofficepointe.co.ke" target="_blank" rel="noopener noreferrer" style="color: #93C754; text-decoration: underline;">
          Quick Office Pointe
        </a>.
      </p>
    </div>
  </footer>

  <!-- Floating Cart -->
  <a href="{{ route('cart.index') }}" id="cart-button" class="fixed bottom-4 right-4 bg-[#93C754] text-white p-4 rounded-full shadow-lg hover:bg-opacity-80 transition flex items-center justify-center z-40">
    <img src="{{ asset('Assets/images/shopping-cart.svg') }}" alt="Cart Icon" class="w-6 h-6">
    <span id="cart-counter" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center">
      {{ array_sum(array_column(session('cart', []), 'quantity')) }}
    </span>
  </a>

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile Menu
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Banner Carousel
        const bannerContainer = document.querySelector('.banner-container');
        const bannerSlides = document.querySelectorAll('.banner-container > div');
        const bannerDotsContainer = document.querySelector('.banner-dots');
        let currentBannerIndex = 0;

        if (bannerContainer && bannerSlides.length > 0) {
            bannerSlides.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.className = `w-3 h-3 rounded-full ${index === 0 ? 'bg-white' : 'bg-white/50'}`;
                dot.addEventListener('click', () => goToBannerSlide(index));
                bannerDotsContainer.appendChild(dot);
            });

            const bannerDots = document.querySelectorAll('.banner-dots button');

            function goToBannerSlide(index) {
                currentBannerIndex = index;
                const offset = -currentBannerIndex * 100;
                bannerContainer.style.transform = `translateX(${offset}%)`;
                bannerDots.forEach((dot, i) => {
                    dot.className = `w-3 h-3 rounded-full ${i === currentBannerIndex ? 'bg-white' : 'bg-white/50'}`;
                });
            }

            let bannerInterval = setInterval(() => {
                currentBannerIndex = (currentBannerIndex + 1) % bannerSlides.length;
                goToBannerSlide(currentBannerIndex);
            }, 5000);

            const prevBtn = document.querySelector('.banner-prev');
            const nextBtn = document.querySelector('.banner-next');

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    clearInterval(bannerInterval);
                    currentBannerIndex = (currentBannerIndex - 1 + bannerSlides.length) % bannerSlides.length;
                    goToBannerSlide(currentBannerIndex);
                    bannerInterval = setInterval(() => {
                        currentBannerIndex = (currentBannerIndex + 1) % bannerSlides.length;
                        goToBannerSlide(currentBannerIndex);
                    }, 5000);
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    clearInterval(bannerInterval);
                    currentBannerIndex = (currentBannerIndex + 1) % bannerSlides.length;
                    goToBannerSlide(currentBannerIndex);
                    bannerInterval = setInterval(() => {
                        currentBannerIndex = (currentBannerIndex + 1) % bannerSlides.length;
                        goToBannerSlide(currentBannerIndex);
                    }, 5000);
                });
            }
        }
// Testimonial Read More Toggle
function toggleTestimonial(button) {
    const parent = button.parentElement;
    const shortText = parent.querySelector('.testimonial-short');
    const fullText = parent.querySelector('.testimonial-full');

    if (fullText.classList.contains('hidden')) {
        shortText.classList.add('hidden');
        fullText.classList.remove('hidden');
        button.textContent = 'Read Less';
    } else {
        shortText.classList.remove('hidden');
        fullText.classList.add('hidden');
        button.textContent = 'Read More';
    }
}
// Read More Functionality for Testimonials
function toggleReadMore(button) {
    const parent = button.closest('.testimonial-content');
    const shortText = parent.querySelector('.testimonial-text');
    const fullText = parent.querySelector('.testimonial-full');

    if (fullText.classList.contains('hidden')) {
        shortText.classList.add('hidden');
        fullText.classList.remove('hidden');
        button.textContent = 'Read Less';
    } else {
        shortText.classList.remove('hidden');
        fullText.classList.add('hidden');
        button.textContent = 'Read More';
    }
}

// Initialize Swipers
const testimonialsSwiper = new Swiper('.testimonials-swiper', {
    slidesPerView: 1,
    spaceBetween: 30,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
    }
});

const blogSwiper = new Swiper('.blog-swiper', {
    slidesPerView: 1,
    spaceBetween: 30,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        640: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
    },
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
});
// Rate Us Modal Functionality
function initializeRateUsModal() {
    const modal = document.getElementById('rateUsModal');
    const openButton = document.getElementById('rateUsButton');
    const closeButton = document.getElementById('closeModal');
    const cancelButton = document.getElementById('cancelModal');
    const modalContent = modal?.querySelector('.bg-white');
    const ratingStars = document.querySelectorAll('.rating-star');
    const selectedRating = document.getElementById('selectedRating');

    if (openButton) {
        openButton.addEventListener('click', function() {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    }

    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    if (closeButton) closeButton.addEventListener('click', closeModal);
    if (cancelButton) cancelButton.addEventListener('click', closeModal);

    modal?.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });

    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            selectedRating.value = rating;
            ratingStars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });
}
        // Product Quantity Controls
        document.querySelectorAll('.increase').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const quantityElement = this.parentElement.querySelector('.quantity');
                quantityElement.textContent = parseInt(quantityElement.textContent) + 1;
            });
        });

        document.querySelectorAll('.decrease').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const quantityElement = this.parentElement.querySelector('.quantity');
                const current = parseInt(quantityElement.textContent);
                if (current > 1) quantityElement.textContent = current - 1;
            });
        });

        // Add to Cart
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                const productId = this.getAttribute('data-product-id');
                const productCard = this.closest('.bg-white');
                const quantity = parseInt(productCard.querySelector('.quantity').textContent);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                const cartUrl = document.body.getAttribute('data-cart-url');

                const cartIcon = this.querySelector('img');
                if (cartIcon) cartIcon.classList.add('animate-bounce');

                try {
                    const response = await fetch(cartUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        const counter = document.getElementById('cart-counter');
                        if (counter) counter.textContent = data.cart_count;

                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Cart!',
                            text: 'Product added successfully',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        throw new Error(data.message || 'Failed to add to cart');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.message,
                        confirmButtonText: 'OK'
                    });
                } finally {
                    if (cartIcon) cartIcon.classList.remove('animate-bounce');
                }
            });
        });

        // Set current year in footer
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Flash messages
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');

        if (successMessage && successMessage.dataset.message) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: successMessage.dataset.message,
                confirmButtonText: 'OK'
            });
        }

        if (errorMessage && errorMessage.dataset.message) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: errorMessage.dataset.message,
                confirmButtonText: 'OK'
            });
        }
    });
  </script>
</body>
</html>
