@extends('layouts.app')

@section('meta_title', 'Verify Email Address - Health Versations')
@section('meta_description', 'Verify your email address to complete registration and access your Health Versations account.')
@section('title', 'Verify Email - Health Versations')
@section('og_title', 'Verify Email - Health Versations')
@section('og_description', 'Verify your email address to complete registration and access your Health Versations account.')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('Assets/images/logo.png') }}" alt="Health Versations" class="h-16 w-auto mx-auto mb-4">
            <h2 class="text-2xl font-bold text-teal-800 mb-2">Verify Your Email Address</h2>
            <div class="w-20 h-1 bg-[#93C754] mx-auto rounded-full"></div>
        </div>

        <div class="mb-6">
            @if (session('resent'))
                <div class="mb-4 bg-green-50 text-green-700 border border-green-200 rounded-lg p-4 text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <div class="space-y-4 text-center text-gray-600">
                <div class="flex justify-center mb-4">
                    <div class="bg-teal-50 rounded-full p-4">
                        <svg class="w-12 h-12 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>

                <p class="text-lg font-medium text-gray-800">{{ __('Before proceeding, please check your email for a verification link.') }}</p>

                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600">{{ __('If you did not receive the email') }},</p>
                    <form method="POST" action="{{ route('verification.resend') }}" class="mt-2">
                        @csrf
                        <button type="submit"
                            class="text-[#93C754] hover:text-green-700 font-medium hover:underline focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:ring-offset-2 rounded-lg px-3 py-1 transition">
                            {{ __('Click here to request another verification link') }}
                        </button>
                    </form>
                </div>

                <div class="pt-4 text-sm text-gray-500 border-t border-gray-100">
                    <p>Once verified, you'll have full access to:</p>
                    <ul class="mt-2 space-y-1">
                        <li>✓ Personalized health packages</li>
                        <li>✓ Exclusive wellness tips</li>
                        <li>✓ Order tracking</li>
                        <li>✓ Special offers</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-[#93C754] transition">
                ← Back to Login
            </a>
        </div>
    </div>
</div>
@endsection
