@extends('layouts.app')

@section('meta_title', 'Confirm Password - Health Versations')
@section('meta_description', 'Confirm your password to continue accessing your Health Versations account securely.')
@section('title', 'Confirm Password - Health Versations')
@section('og_title', 'Confirm Password - Health Versations')
@section('og_description', 'Confirm your password to continue accessing your Health Versations account securely.')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('Assets/images/logo.png') }}" alt="Health Versations" class="h-16 w-auto mx-auto mb-4">
            <h2 class="text-2xl font-bold text-teal-800 mb-2">Confirm Password</h2>
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

            <p class="text-gray-600 text-center mb-6">
                {{ __('Please confirm your password before continuing.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-transparent transition @error('password') border-red-500 @enderror"
                    placeholder="Enter your password"
                >
                @error('password')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full bg-[#93C754] text-white font-semibold py-3 px-4 rounded-lg hover:bg-green-700 transition-colors duration-300 uppercase tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#93C754]"
            >
                Confirm Password
            </button>

            @if (Route::has('password.request'))
                <div class="text-center mt-4">
                    <a class="text-[#93C754] hover:text-green-700 hover:underline transition text-sm" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            @endif
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-[#93C754] transition">
                ← Back to Login
            </a>
        </div>
    </div>
</div>
@endsection
