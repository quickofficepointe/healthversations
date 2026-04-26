@extends('layouts.app')

@section('title', $package->package_name . ' - Premium Health & Wellness Package | Health Versations')
@section('meta_description', Str::limit(strip_tags($package->package_description), 160))
@section('meta_keywords', $package->package_tags ? str_replace(",", ", ", $package->package_tags) . ', health package, wellness program, fitness plan, nutrition coaching' : 'health package, wellness, fitness, nutrition, holistic health')
@section('meta_author', 'Health Versations Team')
@section('meta_robots', 'index, follow')
@section('canonical_url', url()->current())

@section('og_title', $package->package_name . ' - Premium Health Package')
@section('og_description', Str::limit(strip_tags($package->package_description), 155))
@section('og_image', asset('storage/' . $package->package_image))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', $package->package_name . ' - Health Versations Wellness Package')
@section('og_type', 'product')
@section('og:product:price:amount', $package->price ?? 'Call for pricing')
@section('og:product:price:currency', 'KES')

@section('twitter_title', $package->package_name . ' - Premium Health Package')
@section('twitter_description', Str::limit(strip_tags($package->package_description), 200))
@section('twitter_image', asset('storage/' . $package->package_image))
@section('twitter_card', 'summary_large_image')

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "{{ addslashes($package->package_name) }}",
  "description": "{{ addslashes(strip_tags($package->package_description)) }}",
  "image": "{{ asset('storage/' . $package->package_image) }}",
  "brand": {
    "@type": "Brand",
    "name": "Health Versations"
  },
  "category": "{{ addslashes($package->category->name ?? 'Wellness') }}",
  "keywords": "{{ addslashes($package->package_tags) }}",
  "url": "{{ url()->current() }}",
  "offers": {
    "@type": "Offer",
    "priceCurrency": "KES",
    "availability": "https://schema.org/InStock",
    "url": "{{ url()->current() }}"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ $package->rating ?? 4.8 }}",
    "reviewCount": "{{ $package->review_count ?? 0 }}"
  }
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
      "name": "Packages",
      "item": "{{ route('packages.all') }}"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "{{ addslashes($package->package_name) }}",
      "item": "{{ url()->current() }}"
    }
  ]
}
</script>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] text-white py-16 overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                <i class="fas fa-box mr-2"></i>
                <span class="text-sm font-semibold">Premium Package</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                {{ $package->package_name }}
            </h1>
            <div class="w-24 h-1 bg-yellow-300 mx-auto my-4 rounded-full"></div>
            <p class="text-lg md:text-xl opacity-90 max-w-2xl mx-auto">
                {{ Str::limit(strip_tags($package->package_description), 150) }}
            </p>
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
            <li><a href="{{ route('packages.all') }}" class="text-green-700 hover:text-green-800 transition-colors">Health Packages</a></li>
            <li><span class="text-gray-400">›</span></li>
            <li class="text-gray-600 font-medium" aria-current="page">{{ Str::limit($package->package_name, 40) }}</li>
        </ol>
    </div>
</section>

<!-- Package Details Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <!-- Main Package Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-0">
                    <!-- Package Image -->
                    <div class="relative h-80 md:h-auto overflow-hidden bg-gradient-to-br from-[#0A4040] to-[#1a6b6b]">
                        <img src="{{ asset('storage/' . $package->package_image) }}"
                             alt="{{ $package->package_name }} - Premium Health Package"
                             class="w-full h-full object-cover"
                             width="500"
                             height="500"
                             loading="eager">

                        <!-- Badges -->
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            @if($package->is_featured ?? false)
                                <span class="bg-yellow-500 text-[#0A4040] text-xs font-bold px-3 py-1 rounded-full">
                                    <i class="fas fa-star mr-1"></i> Featured
                                </span>
                            @endif
                            @if($package->is_bestseller ?? false)
                                <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                    <i class="fas fa-fire mr-1"></i> Bestseller
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Package Info -->
                    <div class="p-8">
                        <!-- Category -->
                        <div class="mb-4">
                            <span class="inline-flex items-center bg-[#93C754]/20 text-[#0A4040] text-sm font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-tag mr-1 text-xs"></i>
                                {{ $package->category->name ?? 'Wellness Package' }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">{{ $package->package_name }}</h2>

                        <!-- Rating -->
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= ($package->rating ?? 5) ? '' : '-o' }} text-sm"></i>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">({{ $package->review_count ?? 0 }} reviews)</span>
                        </div>

                        <!-- Price -->
                        <div class="mb-6">
                            @if(isset($package->price) && $package->price)
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-bold text-[#0A4040]">KES {{ number_format($package->price, 2) }}</span>
                                    @if(isset($package->original_price) && $package->original_price > $package->price)
                                        <span class="text-gray-400 line-through">KES {{ number_format($package->original_price, 2) }}</span>
                                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">Save {{ round((($package->original_price - $package->price) / $package->original_price) * 100) }}%</span>
                                    @endif
                                </div>
                            @else
                                <div class="text-2xl font-bold text-[#0A4040]">Call for Pricing</div>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">Customized to your individual needs</p>
                        </div>

                        <!-- Description -->
                        <div class="prose prose-sm max-w-none text-gray-600 mb-6">
                            {!! nl2br(e($package->package_description)) !!}
                        </div>

                        <!-- Tags -->
                        @if($package->package_tags)
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach(explode(',', $package->package_tags) as $tag)
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                        {{ trim($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3">
                            <a href="#start-now"
                               class="flex-1 text-center bg-[#93C754] text-white py-3 rounded-xl font-bold hover:bg-[#7eae47] transition-all transform hover:scale-105 shadow-md">
                                <i class="fas fa-calendar-check mr-2"></i>
                                Start Package Now
                            </a>
                            <a href="{{ route('custompackages.create') }}"
                               class="flex-1 text-center border-2 border-[#93C754] text-[#93C754] py-3 rounded-xl font-bold hover:bg-[#93C754] hover:text-white transition-all">
                                <i class="fas fa-customize mr-2"></i>
                                Customize Package
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Package Features Section -->
@if($package->features && $package->features->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <div class="inline-block bg-[#93C754]/10 rounded-full px-4 py-1 mb-4">
                    <span class="text-[#0A4040] text-sm font-semibold">What's Included</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Package Features
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-[#93C754] to-[#0A4040] mx-auto mb-6 rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                @foreach($package->features as $feature)
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                    <div class="w-8 h-8 bg-[#93C754]/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check text-[#93C754] text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $feature->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $feature->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Package Benefits Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <div class="inline-block bg-[#93C754]/10 rounded-full px-4 py-1 mb-4">
                    <span class="text-[#0A4040] text-sm font-semibold">Why Choose This Package</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Key Benefits
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-[#93C754] to-[#0A4040] mx-auto mb-6 rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-[#93C754] group-hover:scale-110 transition-all">
                        <i class="fas fa-user-md text-2xl text-[#0A4040] group-hover:text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Expert Guidance</h3>
                    <p class="text-gray-500 text-sm">Personalized coaching from certified wellness experts</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-[#93C754] group-hover:scale-110 transition-all">
                        <i class="fas fa-chart-line text-2xl text-[#0A4040] group-hover:text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Trackable Progress</h3>
                    <p class="text-gray-500 text-sm">Regular assessments and measurable results</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-[#93C754] group-hover:scale-110 transition-all">
                        <i class="fas fa-headset text-2xl text-[#0A4040] group-hover:text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">24/7 Support</h3>
                    <p class="text-gray-500 text-sm">Ongoing support throughout your journey</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section for This Package -->
@if($package->faqs && $package->faqs->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12">
                <div class="inline-block bg-[#93C754]/10 rounded-full px-4 py-1 mb-4">
                    <span class="text-[#0A4040] text-sm font-semibold">Common Questions</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Frequently Asked Questions
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-[#93C754] to-[#0A4040] mx-auto mb-6 rounded-full"></div>
            </div>

            <div class="space-y-4">
                @foreach($package->faqs as $faq)
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="faq-question w-full text-left p-4 font-semibold text-gray-800 bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center" onclick="toggleFaq(this)">
                        <span>{{ $faq->question }}</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden p-4 text-gray-600 border-t border-gray-200">
                        <p>{{ $faq->answer }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] text-white" id="start-now">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-3xl mx-auto">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Begin Your Transformation?</h2>
            <p class="text-lg mb-8 opacity-90">
                Take the first step toward better health with our {{ $package->package_name }} package.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('custompackages.create') }}"
                   class="inline-flex items-center justify-center bg-yellow-500 text-[#0A4040] px-8 py-3 rounded-xl font-bold hover:bg-yellow-400 transition-all transform hover:scale-105">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Enroll Now
                </a>
                <a href="{{ route('contact.health') }}"
                   class="inline-flex items-center justify-center border-2 border-white text-white px-8 py-3 rounded-xl font-bold hover:bg-white hover:text-[#0A4040] transition-all">
                    <i class="fas fa-comments mr-2"></i>
                    Talk to Coach
                </a>
            </div>
        </div>
    </div>
</section>

<script>
// FAQ Toggle Function
function toggleFaq(button) {
    const answer = button.nextElementSibling;
    const icon = button.querySelector('.fa-chevron-down');

    if (answer.classList.contains('hidden')) {
        answer.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        answer.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>

<style>
.faq-answer {
    transition: all 0.3s ease;
}

.group:hover .fa-arrow-right {
    transform: translateX(4px);
}

.fa-chevron-down {
    transition: transform 0.3s ease;
}
</style>
@endsection
