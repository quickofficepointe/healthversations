@extends('layouts.app')

@section('title', 'Terms and Conditions - Health Versations Wellness Programs')
@section('meta_description', 'Read our comprehensive terms and conditions for Health Versations wellness packages, coaching programs, and services. Understand our policies and your rights.')
@section('meta_keywords', 'terms and conditions, wellness program terms, health coaching agreement, service terms, privacy policy, Health Versations')
@section('meta_author', 'Health Versations Legal Team')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('terms.versation'))

@section('og_title', 'Terms and Conditions - Health Versations Wellness Programs')
@section('og_description', 'Review our terms and conditions for health coaching programs, wellness packages, and services. Clear, transparent policies for your peace of mind.')
@section('og_image', asset('Assets/images/terms-og.jpg'))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', 'Health Versations Terms and Conditions')
@section('og_type', 'website')

@section('twitter_title', 'Terms and Conditions | Health Versations')
@section('twitter_description', 'Read our terms for wellness programs and coaching services.')
@section('twitter_image', asset('Assets/images/terms-og.jpg'))
@section('twitter_card', 'summary_large_image')

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Terms and Conditions",
  "description": "Terms and conditions for Health Versations wellness programs and services",
  "url": "{{ route('terms.versation') }}",
  "publisher": {
    "@type": "Organization",
    "name": "Health Versations",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('Assets/images/logo.png') }}"
    }
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
      "name": "Terms and Conditions",
      "item": "{{ route('terms.versation') }}"
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
                <i class="fas fa-file-contract mr-2"></i>
                <span class="text-sm font-semibold">Legal Information</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                Terms and <span class="text-yellow-300">Conditions</span>
            </h1>
            <div class="w-24 h-1 bg-yellow-300 mx-auto my-4 rounded-full"></div>
            <p class="text-lg md:text-xl opacity-90 max-w-2xl mx-auto">
                Please read these terms carefully before engaging with our wellness programs and services.
            </p>
            <div class="mt-6 text-sm opacity-75">
                Last updated: {{ now()->format('F d, Y') }}
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
            <li class="text-gray-600 font-medium" aria-current="page">Terms and Conditions</li>
        </ol>
    </div>
</nav>

<!-- Terms Content Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Introduction -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-[#93C754]/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-info-circle text-[#93C754] text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Introduction</h2>
                </div>
                <div class="prose prose-sm max-w-none text-gray-600">
                    <p>Welcome to Health Versations. By accessing or using our wellness programs, coaching services, and products, you agree to be bound by these Terms and Conditions. Please read them carefully.</p>
                    <p class="mt-3">These terms apply to all users of our website, coaching programs, wellness packages, and any other services we provide.</p>
                </div>
            </div>

            <!-- Terms List -->
            <div class="space-y-6">
                @forelse($termsandconditions as $index => $terms)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="border-l-4 border-[#93C754]">
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-[#93C754]/20 rounded-full flex items-center justify-center">
                                        <span class="font-bold text-[#0A4040]">{{ sprintf('%02d', $index + 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-800 mb-3">
                                        {{ $terms->terms }}
                                    </h3>
                                    @if($terms->description)
                                        <div class="prose prose-sm max-w-none text-gray-600">
                                            <p>{{ $terms->description }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-contract text-gray-400 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Terms Loading</h3>
                    <p class="text-gray-500">Please check back later for our complete terms and conditions.</p>
                </div>
                @endforelse
            </div>

            <!-- Additional Legal Sections -->
            <div class="grid md:grid-cols-2 gap-6 mt-8">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-shield-alt text-blue-600"></i>
                        </div>
                        <h3 class="font-bold text-gray-800">Privacy Policy</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Your privacy is important to us. We collect and use your information only as described in our Privacy Policy.</p>
                    <a href="{{ route('privacypolicy.versation') }}" class="text-[#93C754] text-sm font-medium hover:underline">Read Privacy Policy →</a>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-green-600"></i>
                        </div>
                        <h3 class="font-bold text-gray-800">Contact Us</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Have questions about our terms? Reach out to our legal team or customer support.</p>
                    <a href="{{ route('contact.health') }}" class="text-[#93C754] text-sm font-medium hover:underline">Contact Support →</a>
                </div>
            </div>

            <!-- Acceptance Banner -->
            <div class="mt-8 bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] rounded-2xl p-6 text-center text-white">
                <i class="fas fa-check-circle text-3xl mb-3 inline-block"></i>
                <p class="text-sm opacity-90 max-w-2xl mx-auto">
                    By continuing to use our services, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Have Questions About Our Terms?</h2>
            <p class="text-gray-600 mb-8">
                Our team is here to clarify any questions you may have about our policies and terms of service.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact.health') }}"
                   class="inline-flex items-center justify-center bg-[#93C754] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#7eae47] transition-all transform hover:scale-105">
                    <i class="fas fa-envelope mr-2"></i>
                    Contact Support
                </a>
                <a href="{{ route('faq.versation') }}"
                   class="inline-flex items-center justify-center border-2 border-gray-300 text-gray-600 px-8 py-3 rounded-xl font-bold hover:border-[#93C754] hover:text-[#93C754] transition-all">
                    <i class="fas fa-question-circle mr-2"></i>
                    Visit FAQ
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Trust Indicators -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <i class="fas fa-lock text-[#93C754] text-2xl mb-2 block"></i>
                <p class="text-xs text-gray-500">Secure & Confidential</p>
            </div>
            <div>
                <i class="fas fa-gavel text-[#93C754] text-2xl mb-2 block"></i>
                <p class="text-xs text-gray-500">Legally Compliant</p>
            </div>
            <div>
                <i class="fas fa-handshake text-[#93C754] text-2xl mb-2 block"></i>
                <p class="text-xs text-gray-500">Fair & Transparent</p>
            </div>
            <div>
                <i class="fas fa-clock text-[#93C754] text-2xl mb-2 block"></i>
                <p class="text-xs text-gray-500">Updated Regularly</p>
            </div>
        </div>
    </div>
</section>

<script>
// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;

        const target = document.querySelector(targetId);
        if (target) {
            e.preventDefault();
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>

<style>
.prose {
    line-height: 1.6;
}

.prose p {
    margin-bottom: 1em;
}

.prose p:last-child {
    margin-bottom: 0;
}
</style>
@endsection
