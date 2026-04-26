@extends('layouts.app')

@section('title', $blog->blog_title . ' | Health Versations Blog')
@section('meta_description', $blog->meta_description ?? Str::limit(strip_tags($blog->blog_description), 160))
@section('meta_keywords', $blog->meta_keywords ?? implode(', ', array_merge([$blog->blog_title, $blog->category->categoryname ?? 'wellness', 'health tips'], explode(' ', $blog->blog_title, 5))))
@section('meta_author', $blog->author ?? 'Health Versations Team')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('frontend.blogs.show', $blog->slug))

@section('og_title', $blog->blog_title . ' | Health Versations Blog')
@section('og_description', $blog->meta_description ?? Str::limit(strip_tags($blog->blog_description), 155))
@section('og_image', $blog->cover_image ? asset($blog->cover_image) : asset('Assets/images/blog-banner.jpg'))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', $blog->blog_title)
@section('og_type', 'article')
@section('og:article:published_time', $blog->created_at->toIso8601String())
@section('og:article:modified_time', $blog->updated_at->toIso8601String())
@section('og:article:author', 'Health Versations Team')
@section('og:article:section', $blog->category->categoryname ?? 'Wellness')

@section('twitter_title', $blog->blog_title . ' | Health Versations')
@section('twitter_description', $blog->meta_description ?? Str::limit(strip_tags($blog->blog_description), 200))
@section('twitter_image', $blog->cover_image ? asset($blog->cover_image) : asset('Assets/images/blog-banner.jpg'))
@section('twitter_card', 'summary_large_image')

@section('content')
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
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "{{ addslashes($blog->blog_title) }}",
      "item": "{{ route('frontend.blogs.show', $blog->slug) }}"
    }
  ]
}
</script>
@endpush

<!-- JSON-LD: Article Schema for SEO -->
@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{{ addslashes($blog->blog_title) }}",
  "description": "{{ addslashes(strip_tags(substr($blog->blog_description, 0, 200))) }}",
  "image": "{{ $blog->cover_image ? asset($blog->cover_image) : asset('Assets/images/blog-banner.jpg') }}",
  "datePublished": "{{ $blog->created_at->toIso8601String() }}",
  "dateModified": "{{ $blog->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "{{ $blog->author ?? 'Health Versations Team' }}",
    "url": "{{ url('/about') }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Health Versations",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('Assets/images/logo.png') }}"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ route('frontend.blogs.show', $blog->slug) }}"
  },
  "keywords": "{{ addslashes($blog->meta_keywords ?? $blog->category->categoryname ?? 'wellness, health, nutrition') }}",
  "articleSection": "{{ $blog->category->categoryname ?? 'Wellness' }}",
  "wordCount": {{ str_word_count(strip_tags($blog->blog_description)) }}
}
</script>
@endpush

<!-- JSON-LD: AboutPage Schema -->
@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "AboutPage",
  "name": "{{ addslashes($blog->blog_title) }}",
  "description": "{{ addslashes(strip_tags(substr($blog->blog_description, 0, 200))) }}",
  "url": "{{ route('frontend.blogs.show', $blog->slug) }}"
}
</script>
@endpush

<div class="bg-gray-50 py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">

        <!-- Back to Blog Link -->
        <div class="mb-6">
            <a href="{{ route('frontend.blogs.index') }}" class="inline-flex items-center text-[#0A4040] hover:text-[#93C754] transition-colors text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to all articles
            </a>
        </div>

        <!-- Blog Header -->
        <header class="mb-8">
            <!-- Category Badge -->
            <div class="mb-4">
                <span class="bg-[#93C754]/20 text-[#0A4040] text-sm font-semibold px-3 py-1 rounded-full">
                    {{ $blog->category->categoryname ?? 'Wellness & Health' }}
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                {{ $blog->blog_title }}
            </h1>

            <!-- Meta Info -->
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-4">
                <div class="flex items-center">
                    <i class="far fa-calendar-alt mr-2 text-[#93C754]"></i>
                    <span>Published: {{ $blog->created_at->format('F d, Y') }}</span>
                </div>
                @if($blog->updated_at && $blog->updated_at->diffInDays($blog->created_at) > 0)
                <div class="flex items-center">
                    <i class="far fa-edit mr-2 text-[#93C754]"></i>
                    <span>Updated: {{ $blog->updated_at->format('F d, Y') }}</span>
                </div>
                @endif
                <div class="flex items-center">
                    <i class="far fa-clock mr-2 text-[#93C754]"></i>
                    <span>{{ ceil(str_word_count(strip_tags($blog->blog_description)) / 200) }} min read</span>
                </div>
                <div class="flex items-center">
                    <i class="far fa-user mr-2 text-[#93C754]"></i>
                    <span>{{ $blog->author ?? 'Health Versations Team' }}</span>
                </div>
            </div>
        </header>

        <!-- Featured Image -->
        @if($blog->cover_image)
        <div class="mb-8 rounded-2xl overflow-hidden shadow-lg">
            <img src="{{ asset($blog->cover_image) }}"
                 alt="{{ $blog->blog_title }} - Featured image"
                 class="w-full h-auto object-cover"
                 width="800"
                 height="450"
                 loading="eager"
                 decoding="async">
            @if($blog->image_caption)
            <p class="text-sm text-gray-500 text-center mt-2">{{ $blog->image_caption }}</p>
            @endif
        </div>
        @endif

        <!-- Blog Content -->
        <article class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 md:p-8 lg:p-10">
                <!-- Content Body -->
                <div class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-headings:font-bold prose-a:text-[#93C754] prose-a:no-underline hover:prose-a:underline prose-strong:text-gray-900 prose-img:rounded-lg prose-img:shadow-md">
                    {!! $blog->blog_description !!}
                </div>

                <!-- Tags Section -->
                @if($blog->tags)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Tags:</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $blog->tags) as $tag)
                        <span class="bg-gray-100 text-gray-600 text-sm px-3 py-1 rounded-full">
                            {{ trim($tag) }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Share Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Share this article:</h3>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('frontend.blogs.show', $blog->slug)) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="w-10 h-10 bg-[#1877F2] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"
                           aria-label="Share on Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('frontend.blogs.show', $blog->slug)) }}&text={{ urlencode($blog->blog_title) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="w-10 h-10 bg-[#1DA1F2] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"
                           aria-label="Share on Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('frontend.blogs.show', $blog->slug)) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="w-10 h-10 bg-[#0A66C2] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"
                           aria-label="Share on LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($blog->blog_title . ' - ' . route('frontend.blogs.show', $blog->slug)) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="w-10 h-10 bg-[#25D366] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"
                           aria-label="Share on WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <button onclick="copyToClipboard('{{ route('frontend.blogs.show', $blog->slug) }}')"
                                class="w-10 h-10 bg-gray-600 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"
                                aria-label="Copy link">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>

                <!-- Author Bio -->
                <div class="mt-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#0A4040] rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user-circle text-2xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">About the Author</h4>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $blog->author ?? 'Health Versations Team' }} is dedicated to providing evidence-based health and wellness information to help you achieve optimal well-being naturally.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Related Posts Section -->
        @if(isset($relatedPosts) && $relatedPosts->count() > 0)
        <section class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">You Might Also Like</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedPosts as $related)
                <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                    @if($related->cover_image)
                    <a href="{{ route('frontend.blogs.show', $related->slug) }}">
                        <img src="{{ asset($related->cover_image) }}"
                             alt="{{ $related->blog_title }}"
                             class="w-full h-40 object-cover"
                             loading="lazy"
                             width="300"
                             height="160">
                    </a>
                    @endif
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">
                            <a href="{{ route('frontend.blogs.show', $related->slug) }}" class="hover:text-[#93C754] transition-colors">
                                {{ $related->blog_title }}
                            </a>
                        </h3>
                        <a href="{{ route('frontend.blogs.show', $related->slug) }}"
                           class="text-sm text-[#0A4040] font-medium hover:text-[#93C754] transition-colors">
                            Read More →
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Newsletter Section -->
        <section class="mt-12 bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] rounded-2xl p-8 text-center">
            <h3 class="text-xl font-bold text-white mb-2">Enjoyed this article?</h3>
            <p class="text-gray-200 mb-4">Subscribe to our newsletter for more wellness tips and exclusive offers.</p>
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                @csrf
                <input type="email" name="email" required
                       placeholder="Enter your email"
                       class="flex-1 px-4 py-2 rounded-lg border-0 focus:ring-2 focus:ring-[#93C754] outline-none"
                       aria-label="Email for newsletter">
                <button type="submit" class="bg-[#93C754] text-[#0A4040] font-semibold px-6 py-2 rounded-lg hover:bg-white transition">
                    Subscribe
                </button>
            </form>
        </section>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        Swal.fire({
            icon: 'success',
            title: 'Link Copied!',
            text: 'Article link copied to clipboard',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });
    });
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Prose styles for blog content */
.prose h2 {
    font-size: 1.5rem;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.prose h3 {
    font-size: 1.25rem;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
}

.prose ul, .prose ol {
    margin-top: 0.75rem;
    margin-bottom: 0.75rem;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.25rem;
}

.prose blockquote {
    border-left: 4px solid #93C754;
    padding-left: 1rem;
    font-style: italic;
    margin: 1rem 0;
    color: #4b5563;
}

.prose img {
    margin: 1.5rem 0;
    border-radius: 0.5rem;
}
</style>
@endsection
