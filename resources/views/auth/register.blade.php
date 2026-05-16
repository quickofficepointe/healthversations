@extends('layouts.app')

@section('meta_description', 'Contact Health Versations for personalized health packages, wellness tips, and inquiries. Reach us via email, phone, or visit our office.')
@section('meta_keywords', 'contact, health inquiries, wellness tips, Health Versations, email, phone')
@section('title', 'Contact Us - Health Versations')
@section('og_title', 'Contact Us - Health Versations')
@section('og_description', 'Contact Health Versations for personalized health packages, wellness tips, and inquiries. Reach us via email, phone, or visit our office.')
@section('og_image', 'https://www.healthversation.com/Assets/images/contact-banner.png')
@section('twitter_title', 'Contact Us - Health Versations')
@section('twitter_description', 'Contact Health Versations for personalized health packages, wellness tips, and inquiries. Reach us via email, phone, or visit our office.')
@section('twitter_image', 'https://www.healthversation.com/Assets/images/contact-banner.png')
@section('canonical_url', 'https://www.healthversation.com/contact')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('Assets/images/logo.png') }}" alt="Health Versations" class="h-16 w-auto mx-auto mb-4">
            <h2 class="text-3xl font-bold text-teal-800 mb-2">Create Your Account</h2>
            <p class="text-gray-600">Join us on your wellness journey</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-transparent transition @error('name') border-red-500 @enderror"
                    placeholder="Enter your full name">

                @error('name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-transparent transition @error('email') border-red-500 @enderror"
                    placeholder="you@example.com">

                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-transparent transition @error('password') border-red-500 @enderror"
                    placeholder="Create a password">

                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password-confirm" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-transparent transition"
                    placeholder="Confirm your password">
            </div>

            <button type="submit"
                class="w-full bg-[#93C754] text-white py-3 rounded-lg font-semibold uppercase tracking-wide hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#93C754]">
                Create Account
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#93C754] hover:text-green-700 font-medium hover:underline transition">
                    Log In
                </a>
            </p>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 text-center">
            <p class="text-xs text-gray-500">
                By creating an account, you agree to our
                <a href="{{ route('terms.versation') }}" class="text-[#93C754] hover:underline">Terms & Conditions</a>
                and
                <a href="{{ route('privacypolicy.versation') }}" class="text-[#93C754] hover:underline">Privacy Policy</a>
            </p>
        </div>
    </div>
</div>
@endsection
