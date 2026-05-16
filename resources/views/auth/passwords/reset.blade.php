@extends('layouts.app')

@section('meta_title', 'Reset Password - Health Versations')
@section('meta_description', 'Create a new password for your Health Versations account.')
@section('title', 'Reset Password - Health Versations')
@section('og_title', 'Reset Password - Health Versations')
@section('og_description', 'Create a new password for your Health Versations account.')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('Assets/images/logo.png') }}" alt="Health Versations" class="h-16 w-auto mx-auto mb-4">
            <h2 class="text-2xl font-bold text-teal-800 mb-2">Create New Password</h2>
            <div class="w-20 h-1 bg-[#93C754] mx-auto rounded-full"></div>
        </div>

        <div class="mb-6">
            <div class="flex justify-center mb-4">
                <div class="bg-teal-50 rounded-full p-4">
                    <svg class="w-12 h-12 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>

            <p class="text-gray-600 text-center mb-4">
                {{ __('Please enter your email address and create a new password for your account.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ $email ?? old('email') }}"
                    required
                    autocomplete="email"
                    autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-transparent transition @error('email') border-red-500 @enderror"
                    placeholder="you@example.com"
                >
                @error('email')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">New Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-transparent transition @error('password') border-red-500 @enderror"
                    placeholder="••••••••"
                >
                @error('password')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Password must be at least 8 characters</p>
            </div>

            <div class="mb-6">
                <label for="password-confirm" class="block text-gray-700 font-medium mb-2">Confirm New Password</label>
                <input
                    id="password-confirm"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-transparent transition"
                    placeholder="••••••••"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-[#93C754] text-white font-semibold py-3 px-4 rounded-lg hover:bg-green-700 transition-colors duration-300 uppercase tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#93C754]"
            >
                Reset Password
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-[#93C754] transition">
                ← Back to Login
            </a>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">
                Remember your password?
                <a href="{{ route('login') }}" class="text-[#93C754] hover:text-green-700 hover:underline">
                    Sign in here
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
