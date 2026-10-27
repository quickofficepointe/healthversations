@extends('layouts.app')

@section('title', $consultTestimonial->client_name . "'s " . $consultTestimonial->program_type . " Transformation | Health Versations")
@section('meta_description', Str::limit(strip_tags($consultTestimonial->testimonial_text), 155))
@section('meta_keywords', $consultTestimonial->client_name . ', ' . $consultTestimonial->program_type . ', transformation, success story, before after, ' . $consultTestimonial->client_location)
@section('meta_author', 'Health Versations')

@section('og_title', $consultTestimonial->client_name . "'s Amazing " . $consultTestimonial->program_type . " Transformation")
@section('og_description', Str::limit(strip_tags($consultTestimonial->testimonial_text), 155))
@section('og_image', Storage::url($consultTestimonial->after_image))

@section('twitter_title', $consultTestimonial->client_name . "'s " . $consultTestimonial->program_type . " Transformation")
@section('twitter_description', Str::limit(strip_tags($consultTestimonial->testimonial_text), 155))

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Review",
  "name": "{{ $consultTestimonial->client_name }}'s {{ $consultTestimonial->program_type }} Transformation",
  "reviewBody": "{{ strip_tags($consultTestimonial->testimonial_text) }}",
  "author": {
    "@type": "Person",
    "name": "{{ $consultTestimonial->client_name }}"
  },
  "datePublished": "{{ $consultTestimonial->created_at->format('Y-m-d') }}",
  "reviewRating": {
    "@type": "Rating",
    "ratingValue": "{{ $consultTestimonial->rating }}",
    "bestRating": "5"
  },
  "itemReviewed": {
    "@type": "Service",
    "name": "{{ $consultTestimonial->program_type }} Program",
    "description": "Health and wellness coaching program by Health Versations"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Health Versations"
  }
}
</script>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-green-600 via-teal-600 to-blue-600 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                <div class="flex text-yellow-400 mr-2">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star{{ $i <= $consultTestimonial->rating ? '' : '-o' }} text-sm"></i>
                    @endfor
                </div>
                <span class="text-sm font-semibold">{{ $consultTestimonial->rating }}/5 Rating</span>
            </div>

            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                {{ $consultTestimonial->client_name }}'s<br>
                <span class="text-yellow-300">Incredible Journey</span>
            </h1>

            <p class="text-xl md:text-2xl mb-8 opacity-90">
                From struggle to success with our {{ $consultTestimonial->program_type }} program
            </p>

            <div class="flex flex-wrap justify-center gap-4">
                @if($consultTestimonial->program_duration_weeks)
                <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                    <span class="text-2xl font-bold block">{{ $consultTestimonial->program_duration_weeks }}</span>
                    <span class="text-sm">Weeks</span>
                </div>
                @endif

                @if($consultTestimonial->weight_loss_kg)
                <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                    <span class="text-2xl font-bold block">-{{ $consultTestimonial->weight_loss_kg }}kg</span>
                    <span class="text-sm">Weight Loss</span>
                </div>
                @endif

                @if($consultTestimonial->inches_lost)
                <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                    <span class="text-2xl font-bold block">-{{ $consultTestimonial->inches_lost }}"</span>
                    <span class="text-sm">Inches Lost</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="fill-white w-full h-12">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"></path>
        </svg>
    </div>
</section>

<!-- Breadcrumb Navigation -->
<nav class="bg-gray-50 py-4 border-b">
    <div class="container mx-auto px-4">
        <ol class="flex items-center space-x-2 text-sm">
            <li><a href="/" class="text-green-600 hover:text-green-700 transition-colors">Home</a></li>
            <li><span class="text-gray-400">›</span></li>
            <li><a href="{{ route('testimonials.index') }}" class="text-green-600 hover:text-green-700 transition-colors">Success Stories</a></li>
            <li><span class="text-gray-400">›</span></li>
            <li class="text-gray-600 font-medium">{{ $consultTestimonial->client_name }}'s Story</li>
        </ol>
    </div>
</nav>

<!-- Transformation Showcase -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Before/After Comparison -->
            <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-3xl shadow-2xl overflow-hidden mb-16">
                <div class="grid lg:grid-cols-2 gap-0">
                    <!-- Before -->
                    <div class="relative p-8 lg:p-12">
                        <div class="text-center">
                            <div class="inline-flex items-center bg-red-500 text-white px-6 py-3 rounded-full mb-6">
                                <i class="fas fa-arrow-down mr-2"></i>
                                <span class="font-bold text-lg">BEFORE</span>
                            </div>

                            <div class="relative mb-6">
                                <img src="{{ Storage::url($consultTestimonial->before_image) }}"
                                     alt="{{ $consultTestimonial->client_name }} before transformation"
                                     class="w-full max-w-md mx-auto h-80 lg:h-96 object-cover rounded-2xl shadow-lg">
                                <div class="absolute -top-4 -left-4 bg-red-500 text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg">
                                    ?
                                </div>
                            </div>

                            <h3 class="text-2xl font-bold text-gray-800 mb-4">The Starting Point</h3>

                            @if($consultTestimonial->weight_loss_kg || ($consultTestimonial->measurements && $consultTestimonial->measurements->count() > 0))
                            <div class="space-y-3 text-left max-w-sm mx-auto">
                                @if($consultTestimonial->weight_loss_kg)
                                <div class="flex justify-between items-center p-3 bg-white rounded-lg shadow-sm">
                                    <span class="text-gray-600 font-medium">Weight</span>
                                    <span class="text-red-600 font-bold">+{{ $consultTestimonial->weight_loss_kg }}kg</span>
                                </div>
                                @endif

                                @if($consultTestimonial->measurements)
                                    @foreach($consultTestimonial->measurements->take(2) as $measurement)
                                    <div class="flex justify-between items-center p-3 bg-white rounded-lg shadow-sm">
                                        <span class="text-gray-600 font-medium">{{ $measurement->measurement_type }}</span>
                                        <span class="text-gray-800 font-bold">{{ $measurement->before_value }}{{ $measurement->unit }}</span>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- After -->
                    <div class="relative p-8 lg:p-12 bg-white">
                        <div class="text-center">
                            <div class="inline-flex items-center bg-green-500 text-white px-6 py-3 rounded-full mb-6">
                                <i class="fas fa-arrow-up mr-2"></i>
                                <span class="font-bold text-lg">AFTER</span>
                            </div>

                            <div class="relative mb-6">
                                <img src="{{ Storage::url($consultTestimonial->after_image) }}"
                                     alt="{{ $consultTestimonial->client_name }} after transformation"
                                     class="w-full max-w-md mx-auto h-80 lg:h-96 object-cover rounded-2xl shadow-lg">
                                <div class="absolute -top-4 -right-4 bg-green-500 text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg">
                                    !
                                </div>
                            </div>

                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Incredible Results</h3>

                            @if($consultTestimonial->weight_loss_kg || $consultTestimonial->inches_lost || ($consultTestimonial->measurements && $consultTestimonial->measurements->count() > 0))
                            <div class="space-y-3 text-left max-w-sm mx-auto">
                                @if($consultTestimonial->weight_loss_kg)
                                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg shadow-sm">
                                    <span class="text-gray-600 font-medium">Weight Loss</span>
                                    <span class="text-green-600 font-bold">-{{ $consultTestimonial->weight_loss_kg }}kg</span>
                                </div>
                                @endif

                                @if($consultTestimonial->inches_lost)
                                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg shadow-sm">
                                    <span class="text-gray-600 font-medium">Inches Lost</span>
                                    <span class="text-green-600 font-bold">-{{ $consultTestimonial->inches_lost }}"</span>
                                </div>
                                @endif

                                @if($consultTestimonial->measurements)
                                    @foreach($consultTestimonial->measurements->take(2) as $measurement)
                                        @php
                                            $difference = $measurement->after_value - $measurement->before_value;
                                            $isImprovement = $difference < 0;
                                        @endphp
                                    <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg shadow-sm">
                                        <span class="text-gray-600 font-medium">{{ $measurement->measurement_type }}</span>
                                        <div class="text-right">
                                            <span class="text-green-600 font-bold">{{ $measurement->after_value }}{{ $measurement->unit }}</span>
                                            @if($isImprovement)
                                            <span class="text-xs text-green-500 block">↓ {{ abs($difference) }}{{ $measurement->unit }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-12">
                    <!-- The Story -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-book-open text-green-600 text-xl"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-800">The Transformation Story</h2>
                        </div>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! $consultTestimonial->testimonial_text !!}
                        </div>
                    </div>

                    <!-- Challenges & Achievements Grid -->
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Challenges Overcome -->
                        @if($consultTestimonial->challenges_overcome)
                        <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl shadow-lg p-8">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-mountain text-red-600 text-xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800">Challenges Overcome</h3>
                            </div>
                            <div class="prose prose-lg max-w-none text-gray-700">
                                {!! $consultTestimonial->challenges_overcome !!}
                            </div>
                        </div>
                        @endif

                        <!-- Key Achievements -->
                        @if($consultTestimonial->key_achievements)
                        <div class="bg-gradient-to-br from-green-50 to-teal-50 rounded-2xl shadow-lg p-8">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-trophy text-green-600 text-xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800">Key Achievements</h3>
                            </div>
                            <div class="prose prose-lg max-w-none text-gray-700">
                                {!! $consultTestimonial->key_achievements !!}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Client Profile Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr($consultTestimonial->client_name, 0, 1) }}
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $consultTestimonial->client_name }}</h3>
                            <p class="text-green-600 font-semibold">{{ $consultTestimonial->program_type }}</p>
                        </div>

                        <div class="space-y-4">
                            @if($consultTestimonial->client_age)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-birthday-cake w-5 mr-3 text-green-500"></i>
                                <span>{{ $consultTestimonial->client_age }} years old</span>
                            </div>
                            @endif

                            @if($consultTestimonial->client_location)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt w-5 mr-3 text-green-500"></i>
                                <span>{{ $consultTestimonial->client_location }}</span>
                            </div>
                            @endif

                            @if($consultTestimonial->client_occupation)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-briefcase w-5 mr-3 text-green-500"></i>
                                <span>{{ $consultTestimonial->client_occupation }}</span>
                            </div>
                            @endif

                            @if($consultTestimonial->program_duration_weeks)
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-clock w-5 mr-3 text-green-500"></i>
                                <span>{{ $consultTestimonial->program_duration_weeks }} week program</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Results Summary -->
                    <div class="bg-gradient-to-br from-green-500 to-teal-600 text-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-xl font-bold mb-4 flex items-center">
                            <i class="fas fa-chart-line mr-2"></i>
                            Results Summary
                        </h3>
                        <div class="space-y-3">
                            @if($consultTestimonial->weight_loss_kg)
                            <div class="flex justify-between items-center bg-white/20 backdrop-blur-sm rounded-lg p-3">
                                <span>Weight Loss</span>
                                <span class="font-bold text-lg">-{{ $consultTestimonial->weight_loss_kg }}kg</span>
                            </div>
                            @endif

                            @if($consultTestimonial->inches_lost)
                            <div class="flex justify-between items-center bg-white/20 backdrop-blur-sm rounded-lg p-3">
                                <span>Inches Lost</span>
                                <span class="font-bold text-lg">-{{ $consultTestimonial->inches_lost }}"</span>
                            </div>
                            @endif

                            <div class="flex justify-between items-center bg-white/20 backdrop-blur-sm rounded-lg p-3">
                                <span>Overall Rating</span>
                                <div class="flex items-center">
                                    <div class="flex text-yellow-300 mr-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $consultTestimonial->rating ? '' : '-o' }} text-sm"></i>
                                        @endfor
                                    </div>
                                    <span class="font-bold">{{ $consultTestimonial->rating }}/5</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Measurements -->
                    @if($consultTestimonial->measurements && $consultTestimonial->measurements->count() > 0)
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-ruler-combined mr-2 text-green-500"></i>
                            Body Measurements
                        </h3>
                        <div class="space-y-4">
                            @foreach($consultTestimonial->measurements as $measurement)
                                @php
                                    $difference = $measurement->after_value - $measurement->before_value;
                                    $isImprovement = $difference < 0;
                                    $percentage = abs(round(($difference / $measurement->before_value) * 100, 1));
                                @endphp
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-700">{{ $measurement->measurement_type }}</span>
                                    <span class="text-sm {{ $isImprovement ? 'text-green-600' : 'text-red-600' }} font-bold">
                                        {{ $isImprovement ? '↓' : '↑' }} {{ abs($difference) }}{{ $measurement->unit }}
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Before: {{ $measurement->before_value }}{{ $measurement->unit }}</span>
                                    <span>After: {{ $measurement->after_value }}{{ $measurement->unit }}</span>
                                </div>
                                @if($isImprovement)
                                <div class="mt-2 bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full text-center">
                                    {{ $percentage }}% improvement
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Social Proof -->
                    @if($consultTestimonial->social_media_handle)
                    <div class="bg-white rounded-2xl shadow-lg p-6 text-center border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Follow {{ $consultTestimonial->client_name }}</h3>
                        <a href="https://instagram.com/{{ str_replace('@', '', $consultTestimonial->social_media_handle) }}"
                           target="_blank"
                           class="inline-flex items-center justify-center bg-gradient-to-r from-purple-500 to-pink-500 text-white px-6 py-3 rounded-lg hover:opacity-90 transition-opacity w-full">
                            <i class="fab fa-instagram mr-2 text-lg"></i>
                            {{ $consultTestimonial->social_media_handle }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-green-600 to-teal-700 text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Ready for Your<br>
                <span class="text-yellow-300">Transformation?</span>
            </h2>
            <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                Join {{ $consultTestimonial->client_name }} and hundreds of other success stories. Start your journey to a healthier, happier you today!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('custompackages.create') }}"
                   class="bg-white text-green-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-star mr-2"></i>
                    Start My Transformation
                </a>
                <a href="{{ route('contact.health') }}"
                   class="border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-green-600 transition-colors">
                    <i class="fas fa-comments mr-2"></i>
                    Free Consultation
                </a>
            </div>
            <p class="text-green-200 mt-6 text-sm">
                * 90% of our clients see results within the first 30 days
            </p>
        </div>
    </div>
</section>

<!-- Related Testimonials -->
@if($relatedTestimonials && $relatedTestimonials->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    More Inspiring Stories
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Discover how others have transformed their lives with our programs
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($relatedTestimonials as $related)
                <a href="{{ route('testimonials.show', $related->slug) }}"
                   class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="relative h-48 overflow-hidden">
                        <div class="absolute inset-0 flex">
                            <div class="w-1/2 relative">
                                <img src="{{ Storage::url($related->before_image) }}"
                                     alt="{{ $related->client_name }} before"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute bottom-0 left-0 right-0 bg-black/70 text-white text-center py-1 text-xs">
                                    Before
                                </div>
                            </div>
                            <div class="w-1/2 relative">
                                <img src="{{ Storage::url($related->after_image) }}"
                                     alt="{{ $related->client_name }} after"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute bottom-0 left-0 right-0 bg-green-600/80 text-white text-center py-1 text-xs">
                                    After
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-gray-800 mb-2 text-lg">{{ $related->client_name }}</h3>
                        <span class="text-green-600 text-sm font-medium bg-green-50 px-3 py-1 rounded-full">
                            {{ $related->program_type }}
                        </span>
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex text-yellow-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $related->rating ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                            <span class="text-gray-500 text-sm group-hover:text-green-600 transition-colors">
                                Read Story →
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('testimonials.index') }}"
                   class="inline-block bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    View All Success Stories
                </a>
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@push('styles')
<style>
.prose {
    line-height: 1.75;
}
.prose p {
    margin-bottom: 1.25em;
}
.prose ul, .prose ol {
    margin-bottom: 1.25em;
    padding-left: 1.625em;
}
.prose li {
    margin-bottom: 0.5em;
}
.prose strong {
    color: #1f2937;
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('.bg-white.rounded-2xl').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endpush
