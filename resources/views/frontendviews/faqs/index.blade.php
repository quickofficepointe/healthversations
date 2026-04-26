@extends('layouts.app')

@section('title', 'Frequently Asked Questions - Health & Wellness FAQs | Health Versations')
@section('meta_description', 'Find answers to common questions about Health Versations - personalized health packages, wellness coaching, nutrition plans, and holistic health solutions.')
@section('meta_keywords', 'FAQ, health questions, wellness tips, Health Versations, health packages, nutrition coaching, gut health, weight loss FAQs')
@section('meta_author', 'Health Versations Team')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('faq.versation'))

@section('og_title', 'Health & Wellness FAQs - Got Questions? We Have Answers')
@section('og_description', 'Frequently Asked Questions about Health Versations - Find answers to common questions about our personalized health packages, coaching programs, and wellness tips.')
@section('og_image', asset('Assets/images/faq-banner.jpg'))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', 'Health Versations FAQ - Frequently Asked Questions')
@section('og_type', 'website')

@section('twitter_title', 'Health & Wellness FAQs | Health Versations')
@section('twitter_description', 'Find answers to common health questions about our programs, products, and services.')
@section('twitter_image', asset('Assets/images/faq-banner.jpg'))
@section('twitter_card', 'summary_large_image')

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "name": "Health Versations Frequently Asked Questions",
  "description": "Answers to common questions about personalized health packages, wellness coaching, and nutrition plans.",
  "url": "{{ route('faq.versation') }}",
  "mainEntity": [
    @foreach($faqs as $index => $faq)
    {
      "@type": "Question",
      "name": "{{ addslashes(strip_tags($faq->question)) }}",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "{{ addslashes(strip_tags($faq->answer)) }}"
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
      "name": "FAQs",
      "item": "{{ route('faq.versation') }}"
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
                <i class="fas fa-question-circle mr-2"></i>
                <span class="text-sm font-semibold">Got Questions?</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                Frequently Asked <span class="text-yellow-300">Questions</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90 max-w-2xl mx-auto">
                Find answers to common questions about our health programs, products, and services.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl px-6 py-3">
                    <div class="text-2xl font-bold">{{ $faqs->count() }}+</div>
                    <div class="text-sm">Expert Answers</div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl px-6 py-3">
                    <div class="text-2xl font-bold">24/7</div>
                    <div class="text-sm">Support Available</div>
                </div>
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
            <li class="text-gray-600 font-medium" aria-current="page">FAQs</li>
        </ol>
    </div>
</nav>

<!-- Search Section -->
<section class="py-8 bg-white border-b">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text"
                       id="faqSearch"
                       placeholder="Search for answers..."
                       class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition">
            </div>
            <div class="flex justify-center gap-3 mt-4">
                <button class="category-filter active px-4 py-2 rounded-full text-sm font-medium bg-[#93C754]/20 text-[#0A4040] hover:bg-[#93C754]/30 transition"
                        data-category="all">All Questions</button>
                @php
                    $categories = $faqs->pluck('category')->unique()->filter();
                @endphp
                @foreach($categories as $category)
                    @if($category)
                    <button class="category-filter px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-[#93C754]/20 hover:text-[#0A4040] transition"
                            data-category="{{ Str::slug($category) }}">
                        {{ $category }}
                    </button>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Main FAQs Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-block bg-[#93C754]/10 rounded-full px-4 py-1 mb-4">
                <span class="text-[#0A4040] text-sm font-semibold">Knowledge Base</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Everything You Need to Know
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-[#93C754] to-[#0A4040] mx-auto mb-6 rounded-full"></div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Can't find what you're looking for? Contact our support team for personalized assistance.
            </p>
        </div>

        @if($faqs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="faqGrid">
                @foreach($faqs as $faq)
                    <div class="faq-item bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 group"
                         data-category="{{ Str::slug($faq->category ?? 'general') }}"
                         data-question="{{ strtolower(strip_tags($faq->question)) }}"
                         data-answer="{{ strtolower(strip_tags($faq->answer)) }}">
                        <div class="p-6 cursor-pointer" onclick="toggleFaq(this)">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-8 h-8 bg-[#93C754]/20 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-question text-[#93C754] text-sm"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-[#93C754] transition-colors">
                                            {{ $faq->question }}
                                        </h3>
                                    </div>
                                    <div class="faq-answer hidden mt-3 pl-11">
                                        <div class="prose prose-sm max-w-none text-gray-600">
                                            <p>{{ $faq->answer }}</p>
                                        </div>
                                        @if($faq->category)
                                            <span class="inline-block mt-3 text-xs text-gray-400">
                                                <i class="fas fa-tag mr-1"></i>{{ $faq->category }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300 faq-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No Results Message -->
            <div id="noResults" class="hidden text-center py-12">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-gray-400 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No matching questions found</h3>
                    <p class="text-gray-500">Try adjusting your search or browse all categories.</p>
                    <button onclick="resetSearch()" class="mt-4 text-[#93C754] hover:text-[#7eae47] font-medium">
                        Clear search →
                    </button>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-question-circle text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No FAQs Available</h3>
                <p class="text-gray-500">Check back soon for answers to common questions.</p>
                <a href="{{ route('contact.health') }}" class="inline-block mt-4 text-[#93C754] hover:text-[#7eae47] font-medium">
                    Contact Support →
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Still Have Questions Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <div class="w-20 h-20 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-headset text-[#93C754] text-3xl"></i>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Still Have Questions?</h2>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                Our team is here to help you with any additional questions about our programs, products, or services.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact.health') }}"
                   class="inline-flex items-center justify-center bg-[#93C754] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#7eae47] transition-all transform hover:scale-105 shadow-lg">
                    <i class="fas fa-envelope mr-2"></i>
                    Contact Support
                </a>
                <a href="https://wa.me/254717813291"
                   target="_blank"
                   class="inline-flex items-center justify-center border-2 border-[#93C754] text-[#93C754] px-8 py-3 rounded-xl font-bold hover:bg-[#93C754] hover:text-white transition-all">
                    <i class="fab fa-whatsapp mr-2"></i>
                    WhatsApp Us
                </a>
            </div>
            <p class="text-sm text-gray-500 mt-6">
                Typical response time: Within 24 hours
            </p>
        </div>
    </div>
</section>

<script>
// FAQ Toggle Function
function toggleFaq(element) {
    const faqItem = element.closest('.faq-item');
    const answerDiv = faqItem.querySelector('.faq-answer');
    const icon = faqItem.querySelector('.faq-icon');

    // Close other open FAQs
    document.querySelectorAll('.faq-item').forEach(item => {
        if (item !== faqItem) {
            const otherAnswer = item.querySelector('.faq-answer');
            const otherIcon = item.querySelector('.faq-icon');
            if (otherAnswer && !otherAnswer.classList.contains('hidden')) {
                otherAnswer.classList.add('hidden');
                otherIcon.style.transform = 'rotate(0deg)';
            }
        }
    });

    // Toggle current FAQ
    if (answerDiv.classList.contains('hidden')) {
        answerDiv.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        answerDiv.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Search and Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('faqSearch');
    const categoryButtons = document.querySelectorAll('.category-filter');
    const faqItems = document.querySelectorAll('.faq-item');
    const noResults = document.getElementById('noResults');

    let activeCategory = 'all';
    let searchTerm = '';

    function filterFaqs() {
        let visibleCount = 0;

        faqItems.forEach(item => {
            const itemCategory = item.dataset.category;
            const itemQuestion = item.dataset.question || '';
            const itemAnswer = item.dataset.answer || '';

            const matchesCategory = activeCategory === 'all' || itemCategory === activeCategory;
            const matchesSearch = searchTerm === '' ||
                itemQuestion.includes(searchTerm) ||
                itemAnswer.includes(searchTerm);

            if (matchesCategory && matchesSearch) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0 && noResults) {
            noResults.classList.remove('hidden');
        } else if (noResults) {
            noResults.classList.add('hidden');
        }

        // Update FAQ grid layout
        const faqGrid = document.getElementById('faqGrid');
        if (faqGrid && visibleCount > 0) {
            faqGrid.classList.remove('hidden');
        } else if (faqGrid) {
            faqGrid.classList.add('hidden');
        }
    }

    // Search input handler
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            searchTerm = e.target.value.toLowerCase().trim();
            filterFaqs();
        });
    }

    // Category filter handler
    categoryButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button styles
            categoryButtons.forEach(b => {
                b.classList.remove('active', 'bg-[#93C754]/20', 'text-[#0A4040]');
                b.classList.add('bg-gray-100', 'text-gray-600');
            });
            this.classList.add('active', 'bg-[#93C754]/20', 'text-[#0A4040]');
            this.classList.remove('bg-gray-100', 'text-gray-600');

            activeCategory = this.dataset.category;
            filterFaqs();
        });
    });
});

// Reset search function
function resetSearch() {
    const searchInput = document.getElementById('faqSearch');
    if (searchInput) {
        searchInput.value = '';
        // Trigger input event
        const event = new Event('input', { bubbles: true });
        searchInput.dispatchEvent(event);
    }
}

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

// Close FAQs when clicking outside (optional)
document.addEventListener('click', function(e) {
    if (!e.target.closest('.faq-item')) {
        document.querySelectorAll('.faq-answer').forEach(answer => {
            if (!answer.classList.contains('hidden')) {
                answer.classList.add('hidden');
                const icon = answer.closest('.faq-item')?.querySelector('.faq-icon');
                if (icon) icon.style.transform = 'rotate(0deg)';
            }
        });
    }
});
</script>

<style>
.faq-item {
    transition: all 0.3s ease;
}

.faq-answer {
    transition: all 0.3s ease;
}

.category-filter.active {
    background-color: rgba(147, 199, 84, 0.2);
    color: #0A4040;
}

/* Prose styles for FAQ answers */
.prose {
    line-height: 1.6;
}

.prose p {
    margin-bottom: 0.75em;
}

.prose p:last-child {
    margin-bottom: 0;
}
</style>
@endsection
