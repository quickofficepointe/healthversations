@extends('layouts.app')

@section('title', 'Returns & Refund Policy - Health Versations')
@section('meta_description', 'Read our clear and fair returns and refund policy for Health Versations products and services. 7-day return policy, money-back guarantee, and customer satisfaction commitment.')
@section('meta_keywords', 'returns policy, refund policy, money-back guarantee, product returns, refund terms, Health Versations')
@section('meta_author', 'Health Versations Customer Service')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('returns.refunds'))

@section('og_title', 'Returns & Refund Policy - Health Versations')
@section('og_description', 'Clear and transparent returns and refund policy for your peace of mind.')
@section('og_image', asset('Assets/images/returns-og.jpg'))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', 'Health Versations Returns and Refund Policy')
@section('og_type', 'website')

@section('twitter_title', 'Returns & Refund Policy | Health Versations')
@section('twitter_description', 'Our commitment to your satisfaction - clear returns and refund policy.')
@section('twitter_image', asset('Assets/images/returns-og.jpg'))
@section('twitter_card', 'summary_large_image')

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Returns and Refund Policy",
  "description": "Returns and refund policy for Health Versations products and services",
  "url": "{{ route('returns.refunds') }}",
  "publisher": {
    "@type": "Organization",
    "name": "Health Versations"
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
      "name": "Returns & Refund Policy",
      "item": "{{ route('returns.refunds') }}"
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
                <i class="fas fa-exchange-alt mr-2"></i>
                <span class="text-sm font-semibold">Customer Protection</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                Returns & <span class="text-yellow-300">Refund Policy</span>
            </h1>
            <div class="w-24 h-1 bg-yellow-300 mx-auto my-4 rounded-full"></div>
            <p class="text-lg md:text-xl opacity-90 max-w-2xl mx-auto">
                Our commitment to your satisfaction and peace of mind
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
            <li class="text-gray-600 font-medium" aria-current="page">Returns & Refund Policy</li>
        </ol>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Returns Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="border-l-4 border-[#93C754]">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-[#93C754]/20 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-undo-alt text-[#93C754] text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Returns Policy</h2>
                        </div>
                        <div class="prose prose-sm max-w-none text-gray-600 space-y-4">
                            <p>At <strong>Health Versations</strong>, we strive to ensure every customer is completely satisfied with their purchase. If you are not entirely happy with your order, we offer a simple and fair return policy.</p>

                            <div class="bg-green-50 rounded-xl p-5 my-6">
                                <div class="flex items-center gap-3 mb-3">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                    <span class="font-semibold text-green-800">Key Return Policy Points</span>
                                </div>
                                <ul class="space-y-2 text-sm">
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-green-600 text-xs mt-1"></i> <span>Returns are accepted within <strong>7 days</strong> from the date of delivery</span></li>
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-green-600 text-xs mt-1"></i> <span>Item must be unused, unopened, and in the original packaging</span></li>
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-green-600 text-xs mt-1"></i> <span>Perishable goods (food, supplements, beverages) are not eligible for returns unless damaged or defective</span></li>
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-green-600 text-xs mt-1"></i> <span>Proof of purchase or receipt required</span></li>
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-green-600 text-xs mt-1"></i> <span>All returns must be approved by our support team before being sent back</span></li>
                                </ul>
                            </div>

                            <p>To initiate a return, please contact us at
                                <a href="mailto:support@healthversation.com" class="text-[#93C754] hover:underline">support@healthversation.com</a>
                                or call our hotline at <strong>+254 717 813 291</strong>. Our team will guide you through the return process.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Refunds Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="border-l-4 border-[#93C754]">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-[#93C754]/20 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-money-bill-wave text-[#93C754] text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Refund Policy</h2>
                        </div>
                        <div class="prose prose-sm max-w-none text-gray-600 space-y-4">
                            <p>Once we receive your returned item, we will inspect it and notify you of the status of your refund.</p>

                            <div class="bg-blue-50 rounded-xl p-5 my-6">
                                <div class="flex items-center gap-3 mb-3">
                                    <i class="fas fa-clock text-blue-600"></i>
                                    <span class="font-semibold text-blue-800">Refund Processing Timeline</span>
                                </div>
                                <ul class="space-y-2 text-sm">
                                    <li class="flex items-start gap-2"><i class="fas fa-hourglass-half text-blue-600 text-xs mt-1"></i> <span>Approved refunds processed within <strong>7–14 business days</strong></span></li>
                                    <li class="flex items-start gap-2"><i class="fas fa-truck text-blue-600 text-xs mt-1"></i> <span>Shipping costs are non-refundable unless due to our error</span></li>
                                    <li class="flex items-start gap-2"><i class="fas fa-envelope text-blue-600 text-xs mt-1"></i> <span>Late or missing refunds should be reported within 5 business days</span></li>
                                </ul>
                            </div>

                            <p>If you experience any delay or issue with your refund, please reach out to our support team for assistance.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Non-Returnable Items -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="border-l-4 border-red-400">
                    <div class="p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Non-Returnable Items</h2>
                        </div>
                        <div class="prose prose-sm max-w-none text-gray-600">
                            <p>The following items cannot be returned unless defective or damaged:</p>
                            <ul class="list-disc pl-6 mt-3 space-y-1">
                                <li>Perishable goods (food items, supplements)</li>
                                <li>Digital products and ebooks after download</li>
                                <li>Personalized or custom packages</li>
                                <li>Items with broken or damaged seals</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Note -->
            <div class="bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] rounded-2xl p-8 text-center text-white">
                <i class="fas fa-heart text-3xl mb-3 inline-block"></i>
                <h3 class="text-xl font-bold mb-2">We Value Your Satisfaction</h3>
                <p class="text-sm opacity-90 max-w-2xl mx-auto">
                    Thank you for choosing <strong>Health Versations</strong>. Your satisfaction and well-being are our top priorities. If you have any questions about our return policy, please don't hesitate to contact us.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center mt-6">
                    <a href="{{ route('contact.health') }}" class="inline-flex items-center justify-center bg-white text-[#0A4040] px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                        <i class="fas fa-headset mr-2"></i>
                        Contact Support
                    </a>
                    <a href="{{ route('all.products') }}" class="inline-flex items-center justify-center border-2 border-white text-white px-6 py-2 rounded-lg font-semibold hover:bg-white hover:text-[#0A4040] transition">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
