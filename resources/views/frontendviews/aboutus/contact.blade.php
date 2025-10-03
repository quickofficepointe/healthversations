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
    <!-- Contact Section -->
    <section class="bg-gray-100 py-8">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row gap-8 items-stretch">
            <!-- Contact Form and Info -->
            <div class="flex flex-col w-full md:w-1/2">
                <!-- Contact Form -->
                <div class="bg-[#D9D9D9] shadow-lg p-6 flex flex-col justify-between flex-grow">
                    <h2 class="text-xl font-bold mb-4 text-center text-black">Contact us</h2>
                    <form class="space-y-4" method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                                placeholder="Enter your full name"
                                required
                            />
                        </div>

                        <!-- Phone Number (Optional) -->
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number (Optional)</label>
                            <input
                                type="text"
                                id="phone_number"
                                name="phone_number"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                                placeholder="Enter your phone number"
                            />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                                placeholder="Enter your email address"
                                required
                            />
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea
                                id="message"
                                name="message"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                                rows="4"
                                placeholder="Enter your message"
                                required
                            ></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full bg-[#0A4040] text-[#93C754] font-bold py-3 px-4 hover:bg-emerald-700 transition-colors duration-300 font-medium rounded-lg"
                        >
                            Submit
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="bg-white shadow-lg p-6 mt-8">
                    <h2 class="text-xl font-bold mb-4 text-center text-black">Contact Information</h2>
                    <div class="space-y-4">
                        <!-- Email -->
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-[#0A4040] mr-3"></i>
                            <a href="mailto:info@healthversation.com" class="text-gray-700 hover:text-[#93C754] transition-colors duration-300">
                                info@healthversation.com
                            </a>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-center">
                            <i class="fas fa-phone text-[#0A4040] mr-3"></i>
                            <a href="tel:+254717813291" class="text-gray-700 hover:text-[#93C754] transition-colors duration-300">
                                +254717813291 <!-- Replace with your actual phone number -->
                            </a>
                        </div>

                        <!-- Address -->
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-[#0A4040] mr-3"></i>
                            <p class="text-gray-700">
                               Nairobi CBD
                            </p>
                        </div>

                        <!-- Social Media Links -->
                        <div class="flex space-x-4 justify-center mt-4">
                            <a href="https://facebook.com/healthversation" target="_blank" class="text-[#0A4040] hover:text-[#93C754] transition-colors duration-300">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/healthversation" target="_blank" class="text-[#0A4040] hover:text-[#93C754] transition-colors duration-300">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://instagram.com/healthversation" target="_blank" class="text-[#0A4040] hover:text-[#93C754] transition-colors duration-300">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://linkedin.com/company/healthversation" target="_blank" class="text-[#0A4040] hover:text-[#93C754] transition-colors duration-300">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Google Maps Area -->
            <div class="flex flex-col w-full md:w-1/2">
                <div class="bg-white shadow-lg flex-grow">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15955.30959006591!2d36.9095031!3d-1.2071505!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zLTEuMjA3MTUwNSwgMzYuOTA5NTAzMQ!5e0!3m2!1sen!2sus!4v1615227611123!5m2!1sen!2sus"
                        width="100%"
                        height="100%"
                        allowfullscreen=""
                        loading="lazy"
                        class="h-full"
                    ></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection
