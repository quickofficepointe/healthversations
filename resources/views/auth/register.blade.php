@extends('layouts.app')

@section('meta_description', 'Contact Health Versations for personalized health packages, wellness tips, and inquiries. Reach us via email, phone, or visit our office.')
@section('meta_keywords', 'contact, health inquiries, wellness tips, Health Versations, email, phone')
@section('title', 'Contact Us - Health Versations')
@section('og_title', 'Contact Us - Health Versations')
@section('og_description', 'Contact Health Versations for personalized health packages, wellness tips, and inquiries. Reach us via email, phone, or visit our office.')
@section('og_image', 'https://www.healthversation.com/Assets/images/contact-banner.png') <!-- Update with contact-specific image -->
@section('twitter_title', 'Contact Us - Health Versations')
@section('twitter_description', 'Contact Health Versations for personalized health packages, wellness tips, and inquiries. Reach us via email, phone, or visit our office.')
@section('twitter_image', 'https://www.healthversation.com/Assets/images/contact-banner.png') <!-- Update with contact-specific image -->
@section('canonical_url', 'https://www.healthversation.com/contact')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-3xl font-bold text-center text-gray-700 mb-4">Create Your Account</h2>
        <p class="text-center text-gray-600 mb-6">Join us by creating an account.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-1">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">

                @error('name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">

                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">

                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password-confirm" class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Register
                </button>
            </div>
        </form>

        <div class="text-center">
            <p class="text-gray-600">Already have an account?
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Log In</a>
            </p>
        </div>
    </div>
</div>
@endsection
