@extends('layouts.app')

@section('meta_description', 'Frequently Asked Questions about Health Versations - Find answers to common questions about our personalized health packages and wellness tips.')
@section('meta_keywords', 'FAQ, health questions, wellness tips, Health Versations, health packages')
@section('title', 'FAQs - Health Versations')
@section('og_title', 'FAQs - Health Versations')
@section('og_description', 'Frequently Asked Questions about Health Versations - Find answers to common questions about our personalized health packages and wellness tips.')
@section('og_image', 'https://www.healthversation.com/Assets/images/faq-banner.png') <!-- Update with FAQ-specific image -->
@section('twitter_title', 'FAQs - Health Versations')
@section('twitter_description', 'Frequently Asked Questions about Health Versations - Find answers to common questions about our personalized health packages and wellness tips.')
@section('twitter_image', 'https://www.healthversation.com/Assets/images/faq-banner.png') <!-- Update with FAQ-specific image -->
@section('canonical_url', 'https://www.healthversation.com/faqs')

@section('content')
<!-- Main FAQs Section -->
<div class="container mx-auto px-4 py-8 my-10">
    <div class="w-24 h-1 bg-[#0A4040] mx-auto mb-6"></div>
    <h2 class="text-3xl font-bold text-center mb-8 text-[#0A4040]">FAQS</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($faqs as $faq)
            <!-- Dynamic FAQ Card -->
            <div class="bg-white p-6 border rounded-lg shadow-md">
                <h3 class="text-xl font-bold mb-4"
                    style="color: {{ $faq->text_color ?? '#0A4040' }};">
                    {{ $faq->question }}
                </h3>
                <p style="color: {{ $faq->text_color ?? 'gray' }};">
                    {{ $faq->answer }}
                </p>
            </div>
        @empty
            <div class="text-center col-span-3">
                <p class="text-gray-500">No FAQS available.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
