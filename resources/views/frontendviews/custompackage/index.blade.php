@extends('layouts.app')

@section('meta_description', 'Request a custom health package from Health Versations. Tailor-made wellness plans to suit
    your needs and goals.')
@section('meta_keywords', 'custom health package, wellness plans, health goals, personalized health, Health Versations')
@section('title', 'Custom Package Form - Health Versations')
@section('og_title', 'Custom Package Form - Health Versations')
@section('og_description', 'Request a custom health package from Health Versations. Tailor-made wellness plans to suit
    your needs and goals.')
@section('og_image', 'https://www.healthversation.com/Assets/images/custom-package-banner.png')
<!-- Update with form-specific image -->
@section('twitter_title', 'Custom Package Form - Health Versations')
@section('twitter_description', 'Request a custom health package from Health Versations. Tailor-made wellness plans to
    suit your needs and goals.')
@section('twitter_image', 'https://www.healthversation.com/Assets/images/custom-package-banner.png')
<!-- Update with form-specific image -->
@section('canonical_url', 'https://www.healthversation.com/custom-package-form')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Custom Package Form</h1>

        <!-- Display Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any()))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('custompackages.store') }}" method="POST"
            class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
            @csrf
            <!-- Name Field -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Email Field -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Phone Number Field -->
            <div class="mb-6">
                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Service Field -->
            <div class="mb-6">
                <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                <select name="service" id="service"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754]">
            <option value="" disabled selected>Select a service</option>
            <option value="Weight Loss">Weight Loss</option>
            <option value="Gut Health">Gut Health</option>
            <option value="Hypertension Reversal">Hypertension Reversal</option>
            <option value="Managing Type 2 Diabetes">Managing Type 2 Diabetes</option>
            <option value="Ulcers/Acid Reflux Reversal">Ulcers/Acid Reflux Reversal</option>
            <option value="Arthritis Management">Arthritis Management</option>
            <option value="Allergies Management">Allergies Management</option>
            <option value="Diet for Pregnant Women">Diet for Pregnant Women</option>
            <option value="Diet for Breastfeeding Women">Diet for Breastfeeding Women</option>
            <option value="Reversing PCOS">Reversing PCOS</option>
            <option value="Fitness Training">Fitness Training</option>
            <option value="Nutrition Plan">Nutrition Plan</option>
            <option value="Other">Other (Please specify)</option>
        </select>
            </div>

            <!-- Message Field -->
            <div class="mb-6">
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea name="message" id="message" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('message') }}</textarea>
            </div>

            <!-- Package Details Field -->
            <div class="mb-6">
                <label for="package_details" class="block text-sm font-medium text-gray-700 mb-1">Package Details</label>
                <textarea name="package_details" id="package_details" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('package_details') }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="mt-8">
                <button type="submit"
                    class="w-full bg-[#93C754] text-white px-6 py-2 text-sm font-semibold uppercase hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
@endsection
