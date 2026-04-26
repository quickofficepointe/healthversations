<!DOCTYPE html>
<html lang="en" itemscope itemtype="https://schema.org/WebPage">
<head>
    <!-- Primary Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Dynamic Title with Site Name -->
    <title>@yield('title', 'Health Versations | Premium Wellness Products & Personalized Health Coaching')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Discover premium wellness products and personalized coaching for holistic well-being. Natural supplements, expert coaching, and wellness resources.')">
    <meta name="keywords" content="@yield('meta_keywords', 'wellness products, health coaching, holistic health, natural supplements, Health Versations, wellness journey, healthy living')">
    <meta name="author" content="@yield('meta_author', 'Health Versations')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <meta name="googlebot" content="index, follow">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <!-- Alternate Languages (if multilingual) -->
    @yield('alternate_languages')

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('Assets/images/favicon.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('Assets/images/logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('Assets/images/logo.png') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Health Versations">
    <meta property="og:title" content="@yield('og_title', 'Health Versations | Premium Wellness Products & Personalized Health Coaching')">
    <meta property="og:description" content="@yield('og_description', 'Discover premium wellness products and personalized coaching for holistic well-being.')">
    <meta property="og:image" content="@yield('og_image', asset('Assets/images/health-versations-social.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Health Versations - Wellness Products and Coaching">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="en_US">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@healthversations">
    <meta name="twitter:creator" content="@healthversations">
    <meta name="twitter:title" content="@yield('twitter_title', 'Health Versations | Premium Wellness Products & Personalized Health Coaching')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Discover premium wellness products and personalized coaching for holistic well-being.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('Assets/images/health-versations-social.jpg'))">
    <meta name="twitter:image:alt" content="Health Versations Wellness Products">

    <!-- Preload Critical Resources -->
    <link rel="preload" href="https://cdn.tailwindcss.com" as="script">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" as="style">
    <link rel="preload" href="{{ asset('Assets/images/logo.png') }}" as="image">

    <!-- DNS Prefetch for External Resources -->
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Stylesheets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tangerine:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Assets/css/styles.css') }}">

    <!-- Swiper JS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom Styles -->
    <style>
        /* Accessibility Skip Link */
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
            background: #15803d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        /* Loading Spinner */
        .loader {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #93C754;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Focus Styles for Accessibility */
        *:focus-visible {
            outline: 2px solid #93C754;
            outline-offset: 2px;
        }

        /* Animations */
        .animate-bounce {
            animation: bounce 0.5s ease;
        }
        .animate-pulse {
            animation: pulse 1s ease;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>

    <!-- JSON-LD: Organization Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "MedicalOrganization",
      "name": "Health Versations",
      "alternateName": "Health Versations Wellness",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('Assets/images/logo.png') }}",
      "image": "{{ asset('Assets/images/health-versations-social.jpg') }}",
      "description": "Premium wellness products and personalized health coaching for holistic well-being.",
      "email": "info@healthversation.com",
      "telephone": "+254717813291",
      "address": {
        "@type": "PostalAddress",
        "addressCountry": "KE"
      },
      "sameAs": [
        "https://www.facebook.com/healthversations",
        "https://twitter.com/healthversations",
        "https://www.instagram.com/health_versations",
        "https://www.linkedin.com/company/healthversations",
        "https://www.tiktok.com/@healthversations"
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+254717813291",
        "contactType": "Customer Service",
        "availableLanguage": ["English"]
      },
      "potentialAction": {
        "@type": "SearchAction",
        "target": "{{ url('/search') }}?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>

    <!-- Dynamic Breadcrumb Schema (to be overridden by child pages) -->
    @hasSection('breadcrumb_schema')
        @yield('breadcrumb_schema')
    @else
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
            }
          ]
        }
        </script>
    @endif

    <!-- Page-specific structured data -->
    @stack('json-ld')

    @stack('styles')
</head>

<body class="bg-gray-100 text-gray-800 font-poppins antialiased" data-cart-url="{{ route('cart.add') }}">

    <!-- Skip to Content Link for Accessibility -->
    <a href="#main-content" class="skip-to-content" aria-label="Skip to main content">
        Skip to main content
    </a>

    <!-- Loading Overlay (optional) -->
    <div id="loading-overlay" class="fixed inset-0 bg-white z-50 hidden items-center justify-center">
        <div class="loader"></div>
    </div>

    <!-- Flash Messages Data Attributes -->
    @if(session('success'))
        <div id="successMessage" data-message="{{ session('success') }}" class="hidden"></div>
    @endif
    @if(session('error'))
        <div id="errorMessage" data-message="{{ session('error') }}" class="hidden"></div>
    @endif

    <!-- Header Section -->
    <header class="bg-white shadow-md sticky top-0 z-40">
        <nav class="container mx-auto flex items-center justify-between py-4 px-6 md:px-12" aria-label="Main Navigation">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="focus:outline-none focus:ring-2 focus:ring-primary-600 rounded-lg" aria-label="Health Versations Home">
                    <img src="{{ asset('Assets/images/logo.png') }}" alt="Health Versations - Premium Wellness Products" class="h-20 w-auto" width="80" height="80" loading="eager">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <ul class="hidden md:flex space-x-6 font-medium" role="menubar">
                <li role="none"><a href="{{ url('/') }}" class="hover:text-primary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-600 rounded px-2 py-1" role="menuitem">Home</a></li>
                <li role="none"><a href="{{ route('all.products') }}" class="hover:text-primary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-600 rounded px-2 py-1" role="menuitem">Products</a></li>
                <li role="none"><a href="{{ route('ebooks.show') }}" class="hover:text-primary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-600 rounded px-2 py-1" role="menuitem">Ebooks</a></li>
                <li role="none"><a href="{{ route('contact.health') }}" class="hover:text-primary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-600 rounded px-2 py-1" role="menuitem">Talk to Us</a></li>
                <li role="none"><a href="{{ route('about.health') }}" class="hover:text-primary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-600 rounded px-2 py-1" role="menuitem">About Us</a></li>
                <li role="none"><a href="{{ route('frontend.blogs.index') }}" class="hover:text-primary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-600 rounded px-2 py-1" role="menuitem">Articles</a></li>
                <li role="none"><a href="{{ route('orders.track') }}" class="hover:text-primary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-600 rounded px-2 py-1" role="menuitem">Track Order</a></li>
            </ul>

            <!-- CTA Button -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('custompackages.create') }}" class="bg-[#93C754] text-white px-6 py-2 text-sm font-semibold uppercase rounded-lg hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600">
                    Create Package
                </a>

                <!-- Mobile Menu Button -->
                <button id="menu-btn" class="block md:hidden text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-600 rounded-lg p-2"
                        aria-label="Menu" aria-expanded="false" aria-controls="mobile-menu">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg" role="menu" aria-label="Mobile Navigation">
            <ul class="space-y-4 p-6">
                <li><a href="{{ url('/') }}" class="block text-gray-800 hover:text-primary-600 transition-colors py-2">Home</a></li>
                <li><a href="{{ route('all.products') }}" class="block text-gray-800 hover:text-primary-600 transition-colors py-2">Products</a></li>
                <li><a href="{{ route('ebooks.show') }}" class="block text-gray-800 hover:text-primary-600 transition-colors py-2">Ebooks</a></li>
                <li><a href="{{ route('contact.health') }}" class="block text-gray-800 hover:text-primary-600 transition-colors py-2">Talk to Us</a></li>
                <li><a href="{{ route('frontend.blogs.index') }}" class="block text-gray-800 hover:text-primary-600 transition-colors py-2">Articles</a></li>
                <li><a href="{{ route('about.health') }}" class="block text-gray-800 hover:text-primary-600 transition-colors py-2">About Us</a></li>
                <li><a href="{{ route('orders.track') }}" class="block text-gray-800 hover:text-primary-600 transition-colors py-2">Track Order</a></li>
            </ul>
        </div>
    </header>

    <!-- Promotional Banner -->
    <div class="bg-[#93C754] text-black text-center py-2 text-sm font-medium" role="banner" aria-label="Promotional Banner">
        <span class="hidden md:inline text-white">✨ Premium Quality | 100% Natural | Tried and Tested | Expertly Created ✨</span>
        <marquee class="md:hidden text-white" aria-label="Scrolling promotions">
            Premium Quality | 100% Natural | Tried and Tested | Expertly Created
        </marquee>
    </div>

    <!-- Main Content -->
    <main id="main-content" class="min-h-screen" role="main" tabindex="-1">
        <!-- Child pages will inject their H1 here -->
        @yield('content')
    </main>

    <!-- Floating Cart Button -->
    <a href="{{ route('cart.index') }}" id="cart-button" class="fixed bottom-4 right-4 bg-[#93C754] text-white p-4 rounded-full shadow-lg hover:bg-opacity-80 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-600 z-40 group" aria-label="Shopping Cart">
        <img src="{{ asset('Assets/images/shopping-cart.svg') }}" alt="Shopping Cart Icon" class="w-6 h-6 group-hover:scale-110 transition-transform" width="24" height="24">
        <span id="cart-counter" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold">
            {{ array_sum(array_column(session('cart', []), 'quantity')) }}
        </span>
    </a>

    <!-- Footer Section -->
    <footer class="bg-teal-800 text-white mt-auto" role="contentinfo">
        <div class="container mx-auto px-6 md:px-12 py-8">
            <div class="flex flex-col md:flex-row items-start justify-between gap-8">
                <!-- Logo and Call to Action -->
                <div class="flex flex-col items-start gap-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('Assets/images/white logo.png') }}" alt="Health Versations Logo" class="h-16 w-auto" width="64" height="64" loading="lazy">
                        <span class="text-2xl font-semibold text-green-300">HEALTH VERSATIONS</span>
                    </div>
                    <a href="{{ route('custompackages.create') }}" class="bg-green-500 hover:bg-green-600 text-teal-800 px-6 py-2 font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400">
                        Create a Custom Package for me
                    </a>
                </div>

                <!-- Quick Links -->
                <div class="flex flex-col gap-2">
                    <h2 class="text-lg font-semibold text-green-300">Quick Links</h2>
                    <ul class="space-y-1">
                        <li><a href="{{ url('/') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-green-400 rounded">Home</a></li>
                    
                        <li><a href="{{ route('videos.show') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-green-400 rounded">Videos</a></li>
                        <li><a href="{{ route('frontend.blogs.index') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-green-400 rounded">Blogs</a></li>
                        <li><a href="{{ route('orders.track') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-green-400 rounded">Track Order</a></li>
                    </ul>
                </div>

                <!-- Support and Information -->
                <div class="flex flex-col gap-2">
                    <h2 class="text-lg font-semibold text-green-300">Support</h2>
                    <ul class="space-y-1">
                        <li><a href="{{ route('contact.health') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-green-400 rounded">Talk to Us</a></li>
                        <li><a href="{{ route('about.health') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-green-400 rounded">About Us</a></li>
                        <li><a href="{{ route('faq.versation') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-green-400 rounded">FAQs</a></li>
                        <li><button id="rateUsButton" class="hover:underline focus:outline-none focus:ring-2 focus:ring-green-400 rounded">Rate Us</button></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div class="flex flex-col gap-2">
                    <h2 class="text-lg font-semibold text-green-300">Legal</h2>
                    <ul class="space-y-1">
                        <li><a href="{{ route('returns.refunds') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-green-400 rounded">Return and Refund</a></li>
                        <li><a href="{{ route('terms.versation') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-green-400 rounded">Terms & Conditions</a></li>
                        <li><a href="{{ route('privacypolicy.versation') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-green-400 rounded">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact Information -->
                <div class="flex flex-col gap-2">
                    <h2 class="text-lg font-semibold text-green-300">Contact Us</h2>
                    <ul class="space-y-1 text-sm">
                        <li>TELEPHONE: <span class="font-semibold text-[#93C754]">+254717813291</span></li>
                        <li>EMAIL: <span class="font-semibold text-[#93C754]">info@healthversation.com</span></li>
                    </ul>
                    <div class="flex gap-4 mt-2" aria-label="Social Media Links">
                        <a href="https://www.facebook.com/share/1D5etZeuVs/" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity focus:outline-none focus:ring-2 focus:ring-green-400 rounded" aria-label="Facebook">
                            <img src="{{ asset('Assets/images/facebook.svg') }}" alt="Facebook" class="h-6 w-6" width="24" height="24" loading="lazy">
                        </a>
                        <a href="https://wa.me/254717813291" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity focus:outline-none focus:ring-2 focus:ring-green-400 rounded" aria-label="WhatsApp">
                            <img src="{{ asset('Assets/images/whatsapp.svg') }}" alt="WhatsApp" class="h-6 w-6" width="24" height="24" loading="lazy">
                        </a>
                        <a href="https://www.instagram.com/health_versations" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity focus:outline-none focus:ring-2 focus:ring-green-400 rounded" aria-label="Instagram">
                            <img src="{{ asset('Assets/images/instagram.svg') }}" alt="Instagram" class="h-6 w-6" width="24" height="24" loading="lazy">
                        </a>
                        <a href="https://www.linkedin.com/in/beatrice-kariuki-bb03b2a1/" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity focus:outline-none focus:ring-2 focus:ring-green-400 rounded" aria-label="LinkedIn">
                            <img src="{{ asset('Assets/images/linkedIn.svg') }}" alt="LinkedIn" class="h-6 w-6" width="24" height="24" loading="lazy">
                        </a>
                        <a href="https://www.tiktok.com/@healthversations" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition-opacity focus:outline-none focus:ring-2 focus:ring-green-400 rounded" aria-label="TikTok">
                            <img src="{{ asset('Assets/images/tiktok.svg') }}" alt="TikTok" class="h-6 w-6" width="24" height="24" loading="lazy">
                        </a>
                    </div>
                </div>
            </div>

            <hr class="border-white/20 my-6">

            <!-- Copyright Section -->
            <div class="text-center text-sm">
                <p>&copy; <span id="current-year">{{ date('Y') }}</span> HEALTH VERSATIONS. All rights reserved.</p>
                <p class="mt-1">
                    Developed and designed by
                    <a href="https://quickofficepointe.co.ke" target="_blank" rel="noopener noreferrer" class="text-[#93C754] hover:underline">
                        Quick Office Pointe
                    </a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Modals (hidden by default) -->
    @include('components.modals')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('Assets/js/main.js') }}" defer></script>
    <script src="{{ asset('Assets/js/modal.js') }}" defer></script>

    <script>
        (function() {
            // Mobile Menu Toggle
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function() {
                    const expanded = mobileMenu.classList.contains('hidden');
                    mobileMenu.classList.toggle('hidden');
                    menuBtn.setAttribute('aria-expanded', !expanded);
                });
            }

            // Flash Messages with SweetAlert
            const successMsg = document.getElementById('successMessage');
            const errorMsg = document.getElementById('errorMessage');

            if (successMsg && successMsg.dataset.message) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: successMsg.dataset.message,
                    confirmButtonColor: '#15803d',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }

            if (errorMsg && errorMsg.dataset.message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMsg.dataset.message,
                    confirmButtonColor: '#dc2626',
                    timer: 4000
                });
            }

            // Current Year for Footer
            const yearSpan = document.getElementById('current-year');
            if (yearSpan) {
                yearSpan.textContent = new Date().getFullYear();
            }

            // Cart Counter Animation
            const cartCounter = document.getElementById('cart-counter');
            if (cartCounter && parseInt(cartCounter.textContent) > 0) {
                cartCounter.classList.add('animate-bounce');
                setTimeout(() => cartCounter.classList.remove('animate-bounce'), 500);
            }
        })();
    </script>

    @stack('scripts')
</body>
</html>
