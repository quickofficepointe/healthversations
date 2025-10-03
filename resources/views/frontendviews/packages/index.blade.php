@extends('layouts.app')

@section('title', 'Premium Packages - Healthversations')
@section('meta_description', 'Discover premium healthy packages tailored for your wellness journey. Achieve sustainable weight loss, gut health, and overall well-being with our expert-curated plans.')
@section('meta_keywords', 'premium health packages, wellness, nutrition plans, weight loss, gut health, metabolic health')
@section('canonical_url', url()->current())

@section('og_title', 'Premium Health Packages - Healthversations')
@section('og_description', 'Explore our expertly designed premium wellness packages to help you achieve optimal health and sustainable well-being.')
@section('og_image', asset('Assets/images/premium-packages.jpg'))
@section('og_url', url()->current())

@section('twitter_title', 'Premium Health Packages - Healthversations')
@section('twitter_description', 'Discover our top-tier health and wellness packages designed to improve your lifestyle naturally.')
@section('twitter_image', asset('Assets/images/premium-packages.jpg'))

@section('content')

<section id="premium-packages" class="mx-4 pt-4 text-center">
    <h1 class="text-[#0A4040] text-center font-bold" id="premium_title"
        style="font-family: 'Tangerine', cursive; font-size: 4rem;">
        Premium
    </h1>
    <h2 class="text-black text-2xl">Healthy packages for you</h2>

    <div class="flex flex-wrap justify-center items-stretch gap-4 mt-8">
        @foreach ($termsandconditions as $terms)
        <div class="w-full sm:w-64 md:w-64 lg:w-64 xl:w-64 p-4 text-center flex flex-col"
            style="background-color: {{ $terms->bg_color ?? '#0A4040' }};">

            <!-- Package Name -->
            <h2 class="text-xl font-bold mb-2"
                style="color: {{ $terms->text_color ?? 'white' }};">
                {{ Str::limit($terms->terms, 50) }}
            </h2>
        </div>
        @endforeach
    </div>
</section>

<!-- Structured Data (JSON-LD) for SEO -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "Premium Health Packages",
    "description": "Explore premium wellness packages tailored to support sustainable health, weight management, and gut health.",
    "brand": {
        "@type": "Brand",
        "name": "Healthversations"
    },
    "image": "{{ asset('Assets/images/premium-packages.jpg') }}",
    "url": "{{ url()->current() }}",
    "offers": {
        "@type": "Offer",
        "url": "{{ url()->current() }}",
        "priceCurrency": "USD",
        "availability": "https://schema.org/InStock"
    }
}
</script>

@endsection
