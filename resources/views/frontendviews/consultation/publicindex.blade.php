@extends('layouts.app')


@section('title', 'Client Success Stories & Testimonials - Health Versations')
@section('meta_description', 'Read inspiring success stories and testimonials from our clients. See real results with before/after photos and measurable transformations.')
@section('meta_keywords', 'client testimonials, success stories, before after photos, weight loss results, fitness transformations, health coaching reviews')
@section('meta_author', 'Health Versations')

@section('og_title', 'Client Success Stories & Testimonials - Health Versations')
@section('og_description', 'Discover real client transformations with before/after photos. Read inspiring success stories from our health coaching programs.')
@section('og_image', asset('Assets/images/testimonials-og.jpg'))

@section('twitter_title', 'Client Success Stories & Testimonials - Health Versations')
@section('twitter_description', 'Real client transformations with before/after photos. Inspiring success stories from health coaching programs.')

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Client Testimonials",
  "description": "Real success stories and transformations from Health Versations clients",
  "url": "{{ request()->url() }}",
  "numberOfItems": "{{ $testimonials->count() }}",
  "itemListElement": [
    @foreach($testimonials as $index => $testimonial)
    {
      "@type": "ListItem",
      "position": {{ $index + 1 }},
      "item": {
        "@type": "Review",
        "name": "{{ $testimonial->client_name }}'s Transformation",
        "reviewBody": "{{ Str::limit(strip_tags($testimonial->testimonial_text), 200) }}",
        "author": {
          "@type": "Person",
          "name": "{{ $testimonial->client_name }}"
        },
        "reviewRating": {
          "@type": "Rating",
          "ratingValue": "{{ $testimonial->rating }}",
          "bestRating": "5"
        },
        "itemReviewed": {
          "@type": "Service",
          "name": "{{ $testimonial->program_type }} Program"
        }
      }
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endpush

@section('content')
<!-- Breadcrumb Navigation -->
<nav class="bg-green-50 py-4">
    <div class="container mx-auto px-4">
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="/" class="text-green-600 hover:text-green-700">Home</a></li>
            <li><span class="text-gray-400">›</span></li>
            <li class="text-green-800 font-medium">Success Stories</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-green-600 to-teal-700 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Real Stories, Real Results</h1>
        <p class="text-xl md:text-2xl mb-8 opacity-90">Discover inspiring transformations from our amazing clients</p>
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                <span class="text-2xl font-bold">{{ $testimonials->count() }}+</span>
                <p class="text-sm">Success Stories</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                <span class="text-2xl font-bold">{{ round($testimonials->avg('rating'), 1) }}</span>
                <p class="text-sm">Average Rating</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                <span class="text-2xl font-bold">{{ $testimonials->sum('weight_loss_kg') }}+</span>
                <p class="text-sm">KG Lost</p>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="bg-white py-8 border-b">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <h2 class="text-2xl font-bold text-gray-800">Featured Transformations</h2>

            <div class="flex flex-wrap gap-4">
                <select id="programFilter" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">All Programs</option>
                    @foreach($programTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>

                <select id="ratingFilter" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">All Ratings</option>
                    <option value="5">5 Stars</option>
                    <option value="4">4+ Stars</option>
                    <option value="3">3+ Stars</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Grid -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($testimonials->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="testimonialsGrid">
                @foreach($testimonials as $testimonial)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 testimonial-card"
                         data-program="{{ $testimonial->program_type }}"
                         data-rating="{{ $testimonial->rating }}">
                        <!-- Before/After Images -->
                        <div class="relative h-64 overflow-hidden">
                            <div class="absolute inset-0 flex">
                                <div class="w-1/2 relative">
                                    <img src="{{ Storage::url($testimonial->before_image) }}"
                                         alt="{{ $testimonial->client_name }} before transformation - {{ $testimonial->program_type }}"
                                         class="w-full h-full object-cover">
                                    <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-center py-1 text-sm">
                                        Before
                                    </div>
                                </div>
                                <div class="w-1/2 relative">
                                    <img src="{{ Storage::url($testimonial->after_image) }}"
                                         alt="{{ $testimonial->client_name }} after transformation - {{ $testimonial->program_type }}"
                                         class="w-full h-full object-cover">
                                    <div class="absolute bottom-0 left-0 right-0 bg-green-600/80 text-white text-center py-1 text-sm">
                                        After
                                    </div>
                                </div>
                            </div>

                            <!-- Featured Badge -->
                            @if($testimonial->featured)
                                <div class="absolute top-4 left-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-star mr-1"></i> Featured
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Client Info -->
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800">{{ $testimonial->client_name }}</h3>
                                    @if($testimonial->client_location)
                                        <p class="text-gray-600 text-sm">{{ $testimonial->client_location }}</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <div class="flex text-yellow-400 mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $testimonial->rating ? '' : '-o' }} text-sm"></i>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $testimonial->program_duration_weeks }} weeks</span>
                                </div>
                            </div>

                            <!-- Program & Results -->
                            <div class="mb-4">
                                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium mb-2">
                                    {{ $testimonial->program_type }}
                                </span>

                                @if($testimonial->weight_loss_kg || $testimonial->inches_lost)
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @if($testimonial->weight_loss_kg)
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-medium">
                                                -{{ $testimonial->weight_loss_kg }}kg
                                            </span>
                                        @endif
                                        @if($testimonial->inches_lost)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                                -{{ $testimonial->inches_lost }} inches
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Testimonial Excerpt -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($testimonial->testimonial_text), 120) }}
                            </p>

                            <!-- Key Achievements -->
                            @if($testimonial->key_achievements)
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-800 text-sm mb-2">Key Achievements:</h4>
                                    <p class="text-gray-600 text-sm line-clamp-2">
                                        {{ Str::limit($testimonial->key_achievements, 80) }}
                                    </p>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <a href="{{ route('testimonials.show', $testimonial->slug) }}"
                                   class="text-green-600 hover:text-green-700 font-medium text-sm flex items-center">
                                    Read Full Story
                                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                </a>

                                @if($testimonial->social_media_handle)
                                    <span class="text-gray-500 text-xs">
                                        <i class="fab fa-instagram mr-1"></i>
                                        {{ $testimonial->social_media_handle }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State for Filtering -->
            <div id="noResults" class="hidden text-center py-12">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No testimonials found</h3>
                    <p class="text-gray-500">Try adjusting your filters to see more results.</p>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-star text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No testimonials yet</h3>
                    <p class="text-gray-500">Check back soon to see our amazing client transformations!</p>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="bg-green-600 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start Your Transformation?</h2>
        <p class="text-xl mb-8 opacity-90">Join hundreds of satisfied clients who have achieved their health goals</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('custompackages.create') }}"
               class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Create Your Custom Package
            </a>
            <a href="{{ route('contact.health') }}"
               class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition-colors">
                Talk to Our Coach
            </a>
        </div>
    </div>
</section>

<!-- Trust Indicators -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-green-600 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Verified Results</h3>
                <p class="text-gray-600 text-sm">All transformations are verified with before/after documentation</p>
            </div>
            <div>
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-check text-green-600 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Real Clients</h3>
                <p class="text-gray-600 text-sm">Genuine stories from real people who achieved amazing results</p>
            </div>
            <div>
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-medal text-green-600 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Proven Methods</h3>
                <p class="text-gray-600 text-sm">Results achieved through scientifically-backed coaching methods</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const programFilter = document.getElementById('programFilter');
    const ratingFilter = document.getElementById('ratingFilter');
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    const noResults = document.getElementById('noResults');

    function filterTestimonials() {
        const programValue = programFilter.value;
        const ratingValue = ratingFilter.value;
        let visibleCount = 0;

        testimonialCards.forEach(card => {
            const programMatch = !programValue || card.dataset.program === programValue;
            const ratingMatch = !ratingValue || parseInt(card.dataset.rating) >= parseInt(ratingValue);

            if (programMatch && ratingMatch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }

    programFilter.addEventListener('change', filterTestimonials);
    ratingFilter.addEventListener('change', filterTestimonials);
});
</script>
@endpush
