@extends('layouts.app')

@section('title', 'Privacy Policy - Health Versations')
@section('meta_description', 'Read our comprehensive privacy policy to understand how Health Versations collects, uses, and protects your personal information. Your privacy and data security matter to us.')
@section('meta_keywords', 'privacy policy, data protection, personal information, privacy practices, GDPR compliance, Health Versations')
@section('meta_author', 'Health Versations Legal Team')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('privacypolicy.versation'))

@section('og_title', 'Privacy Policy - Health Versations')
@section('og_description', 'Learn how we protect your personal information and respect your privacy rights.')
@section('og_image', asset('Assets/images/privacy-og.jpg'))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', 'Health Versations Privacy Policy')
@section('og_type', 'website')

@section('twitter_title', 'Privacy Policy | Health Versations')
@section('twitter_description', 'Your privacy and data security are our priority. Read our privacy policy.')
@section('twitter_image', asset('Assets/images/privacy-og.jpg'))
@section('twitter_card', 'summary_large_image')

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Privacy Policy",
  "description": "Privacy policy for Health Versations wellness programs and services",
  "url": "{{ route('privacypolicy.versation') }}",
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
      "name": "Privacy Policy",
      "item": "{{ route('privacypolicy.versation') }}"
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
                <i class="fas fa-shield-alt mr-2"></i>
                <span class="text-sm font-semibold">Your Privacy Matters</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                Privacy <span class="text-yellow-300">Policy</span>
            </h1>
            <div class="w-24 h-1 bg-yellow-300 mx-auto my-4 rounded-full"></div>
            <p class="text-lg md:text-xl opacity-90 max-w-2xl mx-auto">
                How we collect, use, and protect your personal information
            </p>
            <div class="mt-6 text-sm opacity-75">
                Last updated: {{ now()->format('F d, Y') }}
            </div>
        </div>
    </div>

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
            <li class="text-gray-600 font-medium" aria-current="page">Privacy Policy</li>
        </ol>
    </div>
</nav>

<!-- Main Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Introduction -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-[#93C754]/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-info-circle text-[#93C754] text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Information We Collect</h2>
                </div>
                <div class="prose prose-sm max-w-none text-gray-600">
                    <p>At Health Versations, we collect information to provide better services to our clients. We collect:</p>
                    <ul class="mt-3 space-y-2">
                        <li><strong>Personal Information:</strong> Name, email address, phone number, and physical address</li>
                        <li><strong>Health Information:</strong> Wellness goals, health concerns, and consultation notes</li>
                        <li><strong>Payment Information:</strong> Transaction details for purchases</li>
                        <li><strong>Usage Data:</strong> How you interact with our website and services</li>
                    </ul>
                </div>
            </div>

            <!-- Privacy Policies List -->
            @if($privacypolicy->count() > 0)
                <div class="space-y-6">
                    @foreach($privacypolicy as $index => $policy)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="border-l-4 border-[#93C754]">
                            <div class="p-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-[#93C754]/20 rounded-full flex items-center justify-center">
                                            <i class="fas fa-lock text-[#0A4040]"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-gray-800 mb-3">
                                            {{ $policy->privacy }}
                                        </h3>
                                        @if($policy->description)
                                            <div class="prose prose-sm max-w-none text-gray-600">
                                                <p>{{ $policy->description }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-gray-400 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Privacy Policy Loading</h3>
                    <p class="text-gray-500">Please check back later for our complete privacy policy.</p>
                </div>
            @endif

            <!-- Your Rights Section -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mt-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-shield text-blue-600 text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Your Privacy Rights</h2>
                </div>
                <div class="space-y-4 text-gray-600">
                    <p>You have the right to:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Access your personal information we hold</li>
                        <li>Request correction of inaccurate information</li>
                        <li>Request deletion of your information</li>
                        <li>Opt-out of marketing communications</li>
                        <li>Data portability</li>
                    </ul>
                    <p class="mt-4">To exercise these rights, please contact our Data Protection Officer at <a href="mailto:privacy@healthversation.com" class="text-[#93C754] hover:underline">privacy@healthversation.com</a></p>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] rounded-2xl p-8 mt-8 text-center text-white">
                <i class="fas fa-envelope text-3xl mb-3 inline-block"></i>
                <h3 class="text-xl font-bold mb-2">Questions About Privacy?</h3>
                <p class="text-sm opacity-90 mb-4">Contact our privacy team for any concerns about your data</p>
                <a href="{{ route('contact.health') }}" class="inline-flex items-center bg-white text-[#0A4040] px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Contact Privacy Team
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
