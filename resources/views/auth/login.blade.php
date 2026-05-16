@extends('layouts.app')

@section('meta_description', 'Contact Health Versations for personalized health packages, wellness tips, and inquiries. Reach us via email, phone, or visit our office.')
@section('meta_keywords', 'contact, health inquiries, wellness tips, Health Versations, email, phone')
@section('title', 'Login - Health Versations')
@section('og_title', 'Login - Health Versations')
@section('og_description', 'Login to your Health Versations account to access personalized health packages, wellness tips, and more.')
@section('og_image', 'https://www.healthversation.com/Assets/images/login-banner.png')
@section('twitter_title', 'Login - Health Versations')
@section('twitter_description', 'Login to your Health Versations account to access personalized health packages, wellness tips, and more.')
@section('twitter_image', 'https://www.healthversation.com/Assets/images/login-banner.png')
@section('canonical_url', 'https://www.healthversation.com/login')

@section('content')
    <!-- Login Form Section -->
    <section class="container mx-auto px-4 py-12 min-h-screen flex items-center justify-center">
        <div class="bg-white overflow-hidden max-w-4xl w-full flex flex-col md:flex-row shadow-lg rounded-lg">
            <!-- Left Side - Image -->
            <div class="w-full h-60 sm:h-72 md:h-auto md:w-1/2 relative bg-teal-800 flex items-center justify-center">
                <img
                    src="{{ asset('Assets/images/login_lady.png') }}"
                    alt="Welcome to Health Versations"
                    class="object-cover h-full w-full md:absolute"
                />
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full md:w-1/2 p-6 sm:p-8 md:p-12 bg-white flex flex-col justify-center">
                <div class="mb-8 text-center">
                    <img src="{{ asset('Assets/images/logo.png') }}" alt="Health Versations" class="h-16 w-auto mx-auto mb-4">
                    <h2 class="text-2xl font-bold text-teal-800">Welcome Back!</h2>
                    <p class="text-gray-600 mt-2">
                        Enter your details to proceed
                    </p>
                </div>

                <form class="space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Input -->
                    <div class="relative">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="peer w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition @error('email') border-red-500 @enderror"
                            placeholder=" "
                            required
                        />
                        <label
                            for="email"
                            class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-placeholder-shown:left-4 peer-focus:top-[-8px] peer-focus:left-3 peer-focus:text-sm peer-focus:text-[#93C754] bg-white px-1"
                        >
                            Email Address
                        </label>
                        @error('email')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="peer w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition @error('password') border-red-500 @enderror"
                            placeholder=" "
                            required
                        />
                        <label
                            for="password"
                            class="absolute left-4 top-3 text-gray-500 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-placeholder-shown:left-4 peer-focus:top-[-8px] peer-focus:left-3 peer-focus:text-sm peer-focus:text-[#93C754] bg-white px-1"
                        >
                            Password
                        </label>
                        @error('password')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-[#93C754] text-white font-semibold py-3 px-4 hover:bg-green-700 transition-colors duration-300 rounded-lg uppercase tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#93C754]"
                    >
                        Login Now
                    </button>

                    <div class="flex items-center justify-between">
                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                class="h-4 w-4 text-[#93C754] focus:ring-[#93C754] border-gray-300 rounded"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>

                        <!-- Forgot Password -->
                        <a href="{{ route('password.request') }}" class="text-sm text-red-600 hover:text-red-700 hover:underline transition">
                            Forgot password?
                        </a>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600 text-sm">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-[#93C754] hover:text-green-700 font-medium hover:underline transition">
                            Create an account
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
