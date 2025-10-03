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
    <!-- Login Form Section -->
    <section class="container mx-auto px-4 h-screen flex items-center justify-center">
        <div class="bg-white overflow-hidden max-w-4xl w-full flex flex-col md:flex-row shadow-lg rounded-lg">
            <!-- Left Side - Image -->
            <div class="w-full h-60 sm:h-72 md:h-auto md:w-1/2 relative bg-emerald-600 flex items-center justify-center">
                <img
                    src="Assets/images/login_lady.png"
                    alt="Health Versations"
                    class="object-cover h-full w-full md:absolute"
                />
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full md:w-1/2 p-6 sm:p-8 md:p-12 bg-white flex flex-col justify-center">
                <div class="mb-6 text-center">
                    <p class="text-black font-semibold mt-2">
                        Hello, welcome back
                        <br>
                        Enter your details to proceed
                    </p>
                </div>

                <form class="space-y-8 relative"method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="relative">
                        <input
                            type="email"
                            id="email" name="email"
                            class="peer w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder=" "
                        />
                        <label
                            for="email"
                            class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-placeholder-shown:left-4 peer-focus:top-[-8px] peer-focus:left-3 peer-focus:text-sm peer-focus:text-emerald-500 bg-white px-1"
                        >
                            Email Address
                        </label>
                    </div>

                    <!-- Password Input -->
                    <div class="relative">
                        <input
                            type="password"
                            id="password" name="password"
                            class="peer w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder=" "
                        />
                        <label
                            for="password"
                            class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-placeholder-shown:left-4 peer-focus:top-[-8px] peer-focus:left-3 peer-focus:text-sm peer-focus:text-emerald-500 bg-white px-1"
                        >
                            Password
                        </label>
                    </div>


                    <button
                        type="submit"
                        class="w-full bg-[#0A4040] text-[#93C754] font-bold py-3 px-4 hover:bg-emerald-700 transition-colors duration-300 font-medium rounded-lg"
                    >
                        Login Now
                    </button>

                    <div class="flex items-center justify-between">
                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="remember"
                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>

                       <!-- Forgot Password -->
<a href="{{ route('password.request') }}" class="text-sm text-red-600 hover:text-red-500">Forgot password?</a>

                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
