@extends('layouts.app')

@section('meta_description', 'Explore the latest blogs from Health Versations. Discover insightful articles on health, wellness, and personalized health packages.')
@section('meta_keywords', 'blogs, health articles, wellness tips, Health Versations, health packages')
@section('title', 'Latest Blogs - Health Versations')
@section('og_title', 'Latest Blogs - Health Versations')
@section('og_description', 'Explore the latest blogs from Health Versations. Discover insightful articles on health, wellness, and personalized health packages.')
@section('og_image', 'https://www.healthversation.com/Assets/images/blog-banner.png')
@section('twitter_title', 'Latest Blogs - Health Versations')
@section('twitter_description', 'Explore the latest blogs from Health Versations. Discover insightful articles on health, wellness, and personalized health packages.')
@section('twitter_image', 'https://www.healthversation.com/Assets/images/blog-banner.png')
@section('canonical_url', 'https://www.healthversation.com/blogs')

@section('content')
<main class="bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Latest Health & Wellness Articles</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">Discover expert insights and tips for your health journey</p>
        </header>

        <!-- Blog Grid -->
        <section aria-labelledby="blog-heading">
            <h2 id="blog-heading" class="sr-only">Blog Posts</h2>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($blogs as $blog)
                <article class="flex flex-col overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl bg-white">
                    <!-- Blog Image -->
                    @if($blog->cover_image)
                    <figure class="relative h-56 w-full">
                        <img
                            src="{{ asset($blog->cover_image) }}"
                            alt="{{ $blog->blog_title }}"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        >
                        <div class="absolute bottom-0 left-0 bg-blue-600 text-white px-3 py-1 text-sm font-medium">
                            {{ $blog->category->categoryname }}
                        </div>
                    </figure>
                    @endif

                    <!-- Blog Content -->
                    <div class="flex-1 p-6 flex flex-col">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                <a href="{{ route('frontend.blogs.show', $blog->slug) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $blog->blog_title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {!! Str::limit($blog->blog_description, 150) !!}
                            </p>
                        </div>

                        <!-- Read More Link -->
                        <div class="mt-auto">
                            <a
                                href="{{ route('frontend.blogs.show', $blog->slug) }}"
                                class="text-blue-600 font-medium hover:text-blue-800 inline-flex items-center transition-colors"
                                aria-label="Read more about {{ $blog->blog_title }}"
                            >
                                Read More
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination (if applicable) -->
            @if($blogs->hasPages())
            <div class="mt-12">
                {{ $blogs->links() }}
            </div>
            @endif
        </section>
    </div>
</main>
@endsection
