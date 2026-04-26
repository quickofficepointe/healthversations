@extends('layouts.app')

@section('title', 'Latest Health & Wellness Articles | Health Versations Blog')
@section('meta_description', 'Discover expert insights on natural wellness, gut health, weight loss, and holistic living. Read the latest articles from Health Versations to transform your health journey.')
@section('meta_keywords', 'health blog, wellness articles, gut health, weight loss tips, natural healing, fermented foods, holistic health, Health Versations blog')
@section('meta_author', 'Health Versations Team')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('frontend.blogs.index'))

@section('og_title', 'Health & Wellness Blog | Expert Insights from Health Versations')
@section('og_description', 'Explore our collection of health and wellness articles. Learn about natural healing, nutrition tips, and holistic lifestyle changes for optimal health.')
@section('og_image', asset('Assets/images/blog-banner.jpg'))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', 'Health Versations Blog - Wellness Articles and Health Tips')
@section('og_type', 'website')

@section('twitter_title', 'Health & Wellness Blog | Health Versations')
@section('twitter_description', 'Discover expert health tips, nutrition advice, and wellness insights on the Health Versations blog.')
@section('twitter_image', asset('Assets/images/blog-banner.jpg'))
@section('twitter_card', 'summary_large_image')

@section('content')
<!-- JSON-LD: Blog Schema -->
@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Blog",
  "name": "Health Versations Blog",
  "description": "Expert insights on natural wellness, gut health, weight loss, and holistic living.",
  "url": "{{ route('frontend.blogs.index') }}",
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

<!-- JSON-LD: Breadcrumb Schema -->
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
      "name": "Blog",
      "item": "{{ route('frontend.blogs.index') }}"
    }
  ]
}
</script>
@endpush

<!-- JSON-LD: ItemList Schema for Blog Posts -->
@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Latest Blog Posts",
  "description": "Recent health and wellness articles from Health Versations",
  "numberOfItems": {{ $blogs->count() }},
  "itemListElement": [
    @foreach($blogs as $index => $blog)
    {
      "@type": "ListItem",
      "position": {{ $index + 1 }},
      "url": "{{ route('frontend.blogs.show', $blog->slug) }}",
      "name": "{{ addslashes($blog->blog_title) }}"
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endpush

<main class="bg-gray-50 py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <header class="text-center max-w-4xl mx-auto mb-12">
            <div class="inline-block bg-[#93C754]/10 rounded-full px-4 py-1 mb-4">
                <span class="text-[#0A4040] text-sm font-semibold">Our Blog</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Latest Health & Wellness Articles
            </h1>
            <div class="w-24 h-1 bg-gradient-to-r from-[#93C754] to-[#0A4040] mx-auto mb-6 rounded-full"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Discover expert insights, nutrition tips, and holistic wellness strategies to transform your health journey naturally.
            </p>
        </header>

        <!-- Featured Post (if first blog exists) -->
        @if($blogs->isNotEmpty())
        <div class="mb-16">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                <div class="grid md:grid-cols-2 gap-0">
                    <div class="relative h-64 md:h-auto">
                        @php $featuredBlog = $blogs->first(); @endphp
                        <img src="{{ asset($featuredBlog->cover_image) }}"
                             alt="{{ $featuredBlog->blog_title }}"
                             class="w-full h-full object-cover"
                             width="600"
                             height="400"
                             loading="eager">
                        <div class="absolute top-4 left-4">
                            <span class="bg-[#93C754] text-[#0A4040] px-3 py-1 rounded-full text-xs font-semibold">
                                Featured Article
                            </span>
                        </div>
                    </div>
                    <div class="p-8 flex flex-col justify-center">
                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                            <span class="bg-gray-100 px-2 py-1 rounded">
                                {{ $featuredBlog->category->categoryname ?? 'Wellness' }}
                            </span>
                            <span>•</span>
                            <span>{{ $featuredBlog->created_at->format('F d, Y') }}</span>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                            <a href="{{ route('frontend.blogs.show', $featuredBlog->slug) }}"
                               class="hover:text-[#93C754] transition-colors">
                                {{ $featuredBlog->blog_title }}
                            </a>
                        </h2>
                        <p class="text-gray-600 mb-6 line-clamp-3">
                            {!! Str::limit(strip_tags($featuredBlog->blog_description), 180) !!}
                        </p>
                        <a href="{{ route('frontend.blogs.show', $featuredBlog->slug) }}"
                           class="inline-flex items-center text-[#0A4040] font-semibold hover:text-[#93C754] transition-colors group">
                            Read Full Article
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Blog Grid -->
        <section aria-labelledby="blog-heading">
            <h2 id="blog-heading" class="sr-only">All Blog Posts</h2>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($blogs->skip(1) as $blog)
                <article class="group flex flex-col overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 bg-white">
                    <!-- Blog Image -->
                    @if($blog->cover_image)
                    <div class="relative h-56 w-full overflow-hidden">
                        <img src="{{ asset($blog->cover_image) }}"
                             alt="{{ $blog->blog_title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             width="400"
                             height="250"
                             loading="lazy"
                             decoding="async">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                            <span class="bg-[#93C754] text-[#0A4040] text-xs font-semibold px-2 py-1 rounded">
                                {{ $blog->category->categoryname ?? 'Wellness' }}
                            </span>
                        </div>
                    </div>
                    @endif

                    <!-- Blog Content -->
                    <div class="flex-1 p-6 flex flex-col">
                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                            <i class="far fa-calendar-alt text-[#93C754]"></i>
                            <span>{{ $blog->created_at->format('M d, Y') }}</span>
                            <span>•</span>
                            <i class="far fa-clock text-[#93C754]"></i>
                            <span>{{ $blog->reading_time ?? '5 min read' }}</span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                            <a href="{{ route('frontend.blogs.show', $blog->slug) }}"
                               class="hover:text-[#93C754] transition-colors">
                                {{ $blog->blog_title }}
                            </a>
                        </h3>

                        <p class="text-gray-600 mb-4 line-clamp-3 text-sm leading-relaxed">
                            {!! Str::limit(strip_tags($blog->blog_description), 120) !!}
                        </p>

                        <!-- Read More Link -->
                        <div class="mt-auto pt-4">
                            <a href="{{ route('frontend.blogs.show', $blog->slug) }}"
                               class="inline-flex items-center text-[#0A4040] font-medium hover:text-[#93C754] transition-colors group"
                               aria-label="Read more about {{ $blog->blog_title }}">
                                Read More
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($blogs->isEmpty())
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-newspaper text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">No Articles Yet</h3>
                <p class="text-gray-500">Check back soon for new wellness articles and health tips!</p>
            </div>
            @endif

            <!-- Pagination -->
            @if($blogs instanceof \Illuminate\Pagination\AbstractPaginator && $blogs->hasPages())
            <div class="mt-12">
                {{ $blogs->links() }}
            </div>
            @endif
        </section>

        <!-- Newsletter Subscription Section -->
        <section class="mt-20 bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] rounded-2xl p-8 md:p-12 text-center">
            <div class="max-w-2xl mx-auto">
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope-open-text text-2xl text-[#93C754]"></i>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">Subscribe to Our Newsletter</h2>
                <p class="text-gray-200 mb-6">Get weekly wellness tips, recipes, and exclusive offers delivered to your inbox.</p>

                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="email" name="email" required
                           placeholder="Enter your email address"
                           class="flex-1 px-5 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[#93C754] outline-none"
                           aria-label="Email for newsletter subscription">
                    <button type="submit"
                            class="bg-[#93C754] text-[#0A4040] font-semibold px-6 py-3 rounded-xl hover:bg-white transition-all duration-300">
                        Subscribe Now
                    </button>
                </form>
                <p class="text-xs text-gray-300 mt-4">No spam. Unsubscribe anytime.</p>
            </div>
        </section>
    </div>
</main>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
