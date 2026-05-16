@extends('layouts.app')

@section('meta_title', 'Reset Password - Health Versations')
@section('meta_description', 'Reset your password to regain access to your Health Versations account.')
@section('title', 'Reset Password - Health Versations')
@section('og_title', 'Reset Password - Health Versations')
@section('og_description', 'Reset your password to regain access to your Health Versations account.')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('Assets/images/logo.png') }}" alt="Health Versations" class="h-16 w-auto mx-auto mb-4">
            <h2 class="text-2xl font-bold text-teal-800 mb-2">Reset Password</h2>
            <div class="w-20 h-1 bg-[#93C754] mx-auto rounded-full"></div>
        </div>

        <div class="mb-6">
            <div class="flex justify-center mb-4">
                <div class="bg-teal-50 rounded-full p-4">
                    <svg class="w-12 h-12 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
            </div>

            <p class="text-gray-600 text-center mb-4">
                {{ __('Enter your email address and we\'ll send you a link to reset your password.') }}
            </p>
        </div>

        @if (session('status'))
            <div class="mb-6 bg-green-50 text-green-700 border border-green-200 rounded-lg p-4 text-sm flex items-center gap-3" role="alert">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-6">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
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

            <button
                type="submit"
                class="w-full bg-[#93C754] text-white font-semibold py-3 px-4 rounded-lg hover:bg-green-700 transition-colors duration-300 uppercase tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#93C754]"
            >
                Send Password Reset Link
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
                    Sign in
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
