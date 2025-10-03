@extends('layouts.app')

@section('meta_description', $blog->meta_description ?? 'Read this insightful blog post from Health Versations. Learn more about ' . $blog->blog_title . ' and discover tips for a healthier lifestyle.')
@section('meta_keywords', $blog->meta_keywords ?? 'blog, health, wellness, ' . $blog->category->categoryname . ', Health Versations')
@section('title', $blog->blog_title . ' - Health Versations')
@section('og_title', $blog->blog_title . ' - Health Versations')
@section('og_description', $blog->meta_description ?? 'Read this insightful blog post from Health Versations. Learn more about ' . $blog->blog_title . ' and discover tips for a healthier lifestyle.')
@section('og_image', $blog->cover_image ? asset($blog->cover_image) : 'https://www.healthversation.com/Assets/images/blog-banner.png') <!-- Use blog cover image or default -->
@section('twitter_title', $blog->blog_title . ' - Health Versations')
@section('twitter_description', $blog->meta_description ?? 'Read this insightful blog post from Health Versations. Learn more about ' . $blog->blog_title . ' and discover tips for a healthier lifestyle.')
@section('twitter_image', $blog->cover_image ? asset($blog->cover_image) : 'https://www.healthversation.com/Assets/images/blog-banner.png') <!-- Use blog cover image or default -->
@section('canonical_url', route('frontend.blogs.show', $blog->id))

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        @if($blog->cover_image)
            <img src="{{ asset($blog->cover_image) }}" alt="{{ $blog->blog_title }}" class="w-full h-60 object-cover">
        @endif
        <div class="p-4">
            <h1 class="text-3xl font-semibold mb-2">{{ $blog->blog_title }}</h1>
            <p class="text-gray-600 text-sm mb-2">Category: {{ $blog->category->categoryname }}</p>
            <p class="text-gray-700">{!! $blog->blog_description !!}</p>
        </div>
    </div>
</div>
@endsection
