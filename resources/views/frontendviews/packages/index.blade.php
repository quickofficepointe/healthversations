@extends('layouts.app')

@section('title', 'Premium Health & Wellness Packages | Health Versations')
@section('meta_description', 'Discover our expertly curated premium wellness packages designed for sustainable weight loss, gut health restoration, and metabolic wellness. Start your transformation today.')
@section('meta_keywords', 'premium health packages, wellness plans, nutrition coaching, weight loss programs, gut health restoration, metabolic health, personalized wellness')
@section('meta_author', 'Health Versations Team')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('premiumpackages'))

@section('og_title', 'Premium Health & Wellness Packages | Health Versations')
@section('og_description', 'Explore our top-tier wellness packages designed to help you achieve optimal health naturally. Expert-curated plans for sustainable results.')
@section('og_image', asset('Assets/images/premium-packages-og.jpg'))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', 'Health Versations Premium Wellness Packages')
@section('og_type', 'website')

@section('twitter_title', 'Premium Wellness Packages | Health Versations')
@section('twitter_description', 'Discover our expert-curated health packages for sustainable weight loss and wellness.')
@section('twitter_image', asset('Assets/images/premium-packages-og.jpg'))
@section('twitter_card', 'summary_large_image')

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Premium Health Packages",
  "description": "Expertly curated wellness packages for optimal health",
  "url": "{{ route('premiumpackages') }}",
  "numberOfItems": {{ $termsandconditions->count() }},
  "itemListElement": [
    @foreach($termsandconditions as $index => $terms)
    {
      "@type": "ListItem",
      "position": {{ $index + 1 }},
      "item": {
        "@type": "Product",
        "name": "{{ addslashes(Str::limit($terms->terms, 50)) }}",
        "description": "Premium wellness package for health transformation",
        "offers": {
          "@type": "Offer",
          "priceCurrency": "KES",
          "availability": "https://schema.org/InStock"
        }
      }
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endpush

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
      "name": "Premium Packages",
      "item": "{{ route('premiumpackages') }}"
    }
  ]
}
</script>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                <i class="fas fa-crown mr-2 text-yellow-300"></i>
                <span class="text-sm font-semibold">Premium Collection</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                <span class="text-yellow-300" style="font-family: 'Tangerine', cursive; font-size: 1.2em;">Premium</span>
                <span class="block text-3xl md:text-4xl mt-2">Health Packages for You</span>
            </h1>
            <div class="w-24 h-1 bg-yellow-300 mx-auto my-6 rounded-full"></div>
            <p class="text-lg md:text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                Expertly curated wellness solutions designed to transform your health naturally and sustainably.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('custompackages.create') }}"
                   class="inline-flex items-center bg-yellow-500 text-[#0A4040] px-6 py-3 rounded-xl font-bold hover:bg-yellow-400 transition-all transform hover:scale-105">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Get Started
                </a>
                <a href="{{ route('contact.health') }}"
                   class="inline-flex items-center border-2 border-white text-white px-6 py-3 rounded-xl font-bold hover:bg-white hover:text-[#0A4040] transition-all">
                    <i class="fas fa-headset mr-2"></i>
                    Talk to Coach
                </a>
            </div>
        </div>
    </div>

    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="fill-gray-50 w-full h-12">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"></path>
        </svg>
    </div>
</section>

<!-- Breadcrumb Navigation -->
<nav class="bg-gray-50 py-4 border-b" aria-label="Breadcrumb">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <ol class="flex flex-wrap items-center space-x-2 text-sm">
            <li><a href="{{ url('/') }}" class="text-green-700 hover:text-green-800 transition-colors">Home</a></li>
            <li><span class="text-gray-400">›</span></li>
            <li class="text-gray-600 font-medium" aria-current="page">Premium Packages</li>
        </ol>
    </div>
</section>

<!-- Packages Grid Section -->
<section id="premium-packages" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-block bg-[#93C754]/10 rounded-full px-4 py-1 mb-4">
                <span class="text-[#0A4040] text-sm font-semibold">Choose Your Path</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Find Your Perfect Wellness Journey
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-[#93C754] to-[#0A4040] mx-auto mb-6 rounded-full"></div>
            <p class="text-lg text-gray-600">
                Each package is carefully designed to address specific health goals and provide sustainable results.
            </p>
        </div>

        @if($termsandconditions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($termsandconditions as $index => $terms)
                @php
                    $bgColor = $terms->bg_color ?? '#0A4040';
                    $textColor = $terms->text_color ?? 'white';
                    $features = [
                        'Personalized nutrition plan',
                        'Weekly coaching sessions',
                        'Progress tracking',
                        'Recipe library access',
                        '24/7 support'
                    ];
                    $packageFeatures = array_slice($features, 0, rand(3, 5));
                @endphp
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <!-- Package Header -->
                    <div class="p-6 text-center" style="background-color: {{ $bgColor }}">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
                            @if($index == 0)
                                <i class="fas fa-crown text-2xl text-yellow-300"></i>
                            @elseif($index == 1)
                                <i class="fas fa-heartbeat text-2xl"></i>
                            @else
                                <i class="fas fa-leaf text-2xl"></i>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold mb-2" style="color: {{ $textColor }}">
                            {{ Str::limit($terms->terms, 50) }}
                        </h3>
                        <div class="w-12 h-0.5 bg-white/50 mx-auto my-3"></div>
                        <p class="text-sm opacity-90" style="color: {{ $textColor }}">
                            {{ $index == 0 ? 'Most Popular' : ($index == 1 ? 'Best Value' : 'Comprehensive Care') }}
                        </p>
                    </div>

                    <!-- Package Content -->
                    <div class="p-6">
                        <!-- Price -->
                        <div class="text-center mb-6">
                            <span class="text-3xl font-bold text-[#0A4040]">Call for Price</span>
                            <p class="text-sm text-gray-500 mt-1">Customized to your needs</p>
                        </div>

                        <!-- Features List -->
                        <ul class="space-y-3 mb-8">
                            @foreach($packageFeatures as $feature)
                            <li class="flex items-center text-gray-600 text-sm">
                                <i class="fas fa-check-circle text-[#93C754] mr-3 flex-shrink-0"></i>
                                <span>{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>

                        <!-- CTA Button -->
                        <a href="{{ route('custompackages.create') }}"
                           class="block text-center bg-[#93C754] text-white py-3 rounded-xl font-semibold hover:bg-[#7eae47] transition-all group-hover:shadow-lg">
                            Get This Package
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-box-open text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Packages Available</h3>
                <p class="text-gray-500">Check back soon for our premium wellness packages.</p>
                <a href="{{ route('contact.health') }}" class="inline-block mt-4 text-[#93C754] hover:text-[#7eae47] font-medium">
                    Contact us for custom packages →
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-block bg-[#93C754]/10 rounded-full px-4 py-1 mb-4">
                <span class="text-[#0A4040] text-sm font-semibold">Why Choose Us</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                What Makes Our Packages Premium
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-[#93C754] to-[#0A4040] mx-auto mb-6 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center group">
                <div class="w-16 h-16 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-[#93C754] group-hover:scale-110 transition-all">
                    <i class="fas fa-user-md text-2xl text-[#0A4040] group-hover:text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Expert Coaching</h3>
                <p class="text-gray-500 text-sm">Guidance from certified wellness professionals</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-[#93C754] group-hover:scale-110 transition-all">
                    <i class="fas fa-chart-line text-2xl text-[#0A4040] group-hover:text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Trackable Results</h3>
                <p class="text-gray-500 text-sm">Regular progress assessments and measurements</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-[#93C754] group-hover:scale-110 transition-all">
                    <i class="fas fa-clock text-2xl text-[#0A4040] group-hover:text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Flexible Scheduling</h3>
                <p class="text-gray-500 text-sm">Sessions at times that work for you</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-[#93C754] group-hover:scale-110 transition-all">
                    <i class="fas fa-heartbeat text-2xl text-[#0A4040] group-hover:text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2">Holistic Approach</h3>
                <p class="text-gray-500 text-sm">Mind-body wellness integration</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-block bg-[#93C754]/10 rounded-full px-4 py-1 mb-4">
                <span class="text-[#0A4040] text-sm font-semibold">Client Success</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                What Our Clients Say
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-[#93C754] to-[#0A4040] mx-auto mb-6 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <div class="flex text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-4">"The premium package transformed my health completely. Lost 15kg and regained my energy!"</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-[#93C754]/20 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user text-[#0A4040]"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Sarah M.</h4>
                        <p class="text-xs text-gray-500">Weight Loss Success</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <div class="flex text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-4">"Finally healed my gut issues after years of struggling. The personalized approach made all the difference."</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-[#93C754]/20 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user text-[#0A4040]"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">James K.</h4>
                        <p class="text-xs text-gray-500">Gut Health</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
                <div class="flex text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-4">"The coaching and support I received was exceptional. Highly recommend their premium packages!"</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-[#93C754]/20 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user text-[#0A4040]"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Mary W.</h4>
                        <p class="text-xs text-gray-500">Overall Wellness</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Transform Your Health?</h2>
            <p class="text-lg mb-8 opacity-90">
                Let's create a personalized wellness package that addresses your unique health goals.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('custompackages.create') }}"
                   class="inline-flex items-center justify-center bg-yellow-500 text-[#0A4040] px-8 py-3 rounded-xl font-bold hover:bg-yellow-400 transition-all transform hover:scale-105">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Create Custom Package
                </a>
                <a href="{{ route('contact.health') }}"
                   class="inline-flex items-center justify-center border-2 border-white text-white px-8 py-3 rounded-xl font-bold hover:bg-white hover:text-[#0A4040] transition-all">
                    <i class="fas fa-comments mr-2"></i>
                    Free Consultation
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Custom animations */
.group:hover .fa-arrow-right {
    transform: translateX(4px);
}

/* Card hover effects */
.group {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Smooth icon transitions */
.fa-arrow-right {
    transition: transform 0.2s ease;
}
</style>
@endpush
