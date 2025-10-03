@extends('layouts.app') {{-- Adjust based on your layout --}}

@section('content')
<section id="premium-packages" class="mx-4 pt-4 text-center">
    <h1 class="text-[#0A4040] text-center font-bold" id="premium_title" style="font-family: 'Tangerine', cursive; font-size: 4rem;">Premium</h1>
    <h2 class="text-black text-2xl">Terms and Conditions </h2>
    <div class="flex flex-wrap justify-center items-stretch gap-4 mt-8">
        @foreach ($termsandconditions as $terms)
        <div
            class="w-full sm:w-64 md:w-64 lg:w-64 xl:w-64 p-4 text-center flex flex-col"
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
@endsection
