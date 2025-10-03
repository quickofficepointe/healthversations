@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-3xl font-bold text-center text-gray-700 mb-4">Verify Your Email Address</h2>

        <div class="mb-6 text-center text-gray-600">
            @if (session('resent'))
                <div class="mb-4 bg-green-100 text-green-700 border border-green-200 p-4 rounded-lg">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
            <p>{{ __('If you did not receive the email') }},</p>
        </div>

        <form method="POST" action="{{ route('verification.resend') }}" class="text-center">
            @csrf
            <button type="submit" class="text-blue-500 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-500">
                {{ __('click here to request another') }}
            </button>
        </form>
    </div>
</div>
@endsection
