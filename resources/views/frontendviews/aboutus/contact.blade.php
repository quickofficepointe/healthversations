@extends('layouts.app')

@section('title', 'Contact Health Versations - Get Personalized Wellness Support')
@section('meta_description', 'Contact Health Versations for personalized health packages, wellness tips, and expert guidance. Reach us via email, phone, or visit our office. Start your wellness journey today.')
@section('meta_keywords', 'contact, health inquiries, wellness tips, Health Versations, email, phone, Nairobi health coach, wellness consultation')
@section('meta_author', 'Health Versations Team')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('contact.health'))

@section('og_title', 'Contact Health Versations - Start Your Wellness Journey')
@section('og_description', 'Ready to transform your health? Contact Health Versations for personalized wellness packages, expert guidance, and holistic health support.')
@section('og_image', asset('Assets/images/contact-banner.jpg'))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', 'Health Versations Contact Information and Support')

@section('twitter_title', 'Contact Health Versations - Wellness Support')
@section('twitter_description', 'Get in touch with Health Versations for personalized health coaching and wellness products.')
@section('twitter_image', asset('Assets/images/contact-banner.jpg'))

@section('content')
<!-- JSON-LD: ContactPage Schema -->
@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ContactPage",
  "name": "Contact Health Versations",
  "description": "Contact us for personalized wellness packages, health consultations, and product inquiries.",
  "url": "{{ route('contact.health') }}",
  "mainEntity": {
    "@type": "Organization",
    "name": "Health Versations",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('Assets/images/logo.png') }}",
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "+254717813291",
      "contactType": "customer service",
      "email": "info@healthversation.com",
      "availableLanguage": ["English"],
      "areaServed": "KE"
    },
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Nairobi",
      "addressCountry": "KE"
    }
  }
}
</script>
@endpush

<!-- JSON-LD: Breadcrumb Schema -->
@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "{{ url('/') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Contact Us",
      "item": "{{ route('contact.health') }}"
    }
  ]
}
</script>
@endpush

<!-- Contact Section -->
<section class="bg-gray-50 py-12 md:py-16">
    <div class="container mx-auto px-4 md:px-6">
        <!-- Page Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Contact Us</h1>
            <div class="w-24 h-1 bg-gradient-to-r from-[#93C754] to-[#0A4040] mx-auto mb-6 rounded-full"></div>
            <p class="text-lg text-gray-600">
                Have questions about our wellness products or coaching programs? We're here to help you on your health journey.
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-stretch">
            <!-- Contact Form and Info -->
            <div class="flex flex-col w-full lg:w-1/2">
                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 flex flex-col justify-between flex-grow">
                    <div>
                        <h2 class="text-2xl font-bold mb-2 text-center text-[#0A4040]">Send us a Message</h2>
                        <p class="text-gray-500 text-center mb-6">We'll get back to you within 24 hours</p>

                        <form class="space-y-5" method="POST" action="{{ route('contact.store') }}">
                            @csrf
                            <!-- Full Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2 text-[#93C754]"></i>Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] focus:outline-none transition"
                                    placeholder="Enter your full name"
                                    required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2 text-[#93C754]"></i>Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] focus:outline-none transition"
                                    placeholder="you@example.com"
                                    required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-2 text-[#93C754]"></i>Phone Number
                                </label>
                                <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] focus:outline-none transition"
                                    placeholder="+254 XXX XXX XXX">
                            </div>

                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tag mr-2 text-[#93C754]"></i>Subject
                                </label>
                                <select id="subject" name="subject"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] focus:outline-none transition">
                                    <option value="general">General Inquiry</option>
                                    <option value="product">Product Information</option>
                                    <option value="coaching">Coaching Program</option>
                                    <option value="custom">Custom Package Request</option>
                                    <option value="support">Customer Support</option>
                                    <option value="partnership">Partnership Opportunity</option>
                                </select>
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-comment mr-2 text-[#93C754]"></i>Message <span class="text-red-500">*</span>
                                </label>
                                <textarea id="message" name="message" rows="5"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] focus:outline-none transition resize-none"
                                    placeholder="Tell us how we can help you..."
                                    required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] text-white font-bold py-3 px-4 rounded-xl hover:from-[#1a6b6b] hover:to-[#0A4040] transition-all duration-300 transform hover:scale-[1.02] shadow-md">
                                <i class="fas fa-paper-plane mr-2"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Contact Information Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-md p-5 text-center hover:shadow-lg transition">
                        <div class="w-12 h-12 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-phone text-[#0A4040] text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Call Us</h3>
                        <a href="tel:+254717813291" class="text-gray-600 hover:text-[#93C754] text-sm">+254 717 813 291</a>
                    </div>
                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-md p-5 text-center hover:shadow-lg transition">
                        <div class="w-12 h-12 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-envelope text-[#0A4040] text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Email Us</h3>
                        <a href="mailto:info@healthversation.com" class="text-gray-600 hover:text-[#93C754] text-sm break-all">info@healthversation.com</a>
                    </div>
                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-md p-5 text-center hover:shadow-lg transition">
                        <div class="w-12 h-12 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-clock text-[#0A4040] text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Business Hours</h3>
                        <p class="text-gray-600 text-sm">Mon-Fri: 9AM - 6PM<br>Sat: 10AM - 2PM</p>
                    </div>
                </div>
            </div>

            <!-- Google Maps Area -->
            <div class="flex flex-col w-full lg:w-1/2">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex-grow">
                    <div class="bg-[#0A4040] p-4">
                        <h3 class="text-white font-semibold text-center">
                            <i class="fas fa-map-marker-alt mr-2"></i> Visit Our Location
                        </h3>
                    </div>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.846415543777!2d36.821449214753!3d-1.292635399059569!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f10d3e4e5e5e5%3A0x0!2zLTEuMjkyNjM1NCwzNi44MjE0NDkx!5e0!3m2!1sen!2ske!4v1700000000000!5m2!1sen!2ske"
                        width="100%"
                        height="450"
                        style="border:0; min-height: 400px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Health Versations Location Map"
                        class="w-full">
                    </iframe>
                </div>

                <!-- Social Media Section -->
                <div class="bg-white rounded-2xl shadow-xl p-6 mt-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Connect With Us</h3>
                    <div class="flex justify-center space-x-6">
                        <a href="https://www.facebook.com/healthversations" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 bg-[#1877F2] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"
                            aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/healthversations" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 bg-[#1DA1F2] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"
                            aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com/health_versations" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 bg-gradient-to-r from-[#833AB4] via-[#E1306C] to-[#F56040] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"
                            aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/healthversations" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 bg-[#0A66C2] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"
                            aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://wa.me/254717813291" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 bg-[#25D366] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"
                            aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section for AEO -->
        <div class="mt-16 bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Frequently Asked Questions</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-[#0A4040] mb-2">How quickly do you respond to inquiries?</h3>
                    <p class="text-gray-600 text-sm">We typically respond within 24 hours during business days.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-[#0A4040] mb-2">Do you offer international shipping?</h3>
                    <p class="text-gray-600 text-sm">Yes, we ship worldwide. Contact us for international rates.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-[#0A4040] mb-2">Can I book a consultation online?</h3>
                    <p class="text-gray-600 text-sm">Yes! Fill out the form and we'll schedule a virtual consultation.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-[#0A4040] mb-2">Do you offer custom wellness packages?</h3>
                    <p class="text-gray-600 text-sm">Absolutely! We create personalized plans based on your health goals.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JSON-LD: FAQ Schema for AEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How quickly do you respond to inquiries?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "We typically respond within 24 hours during business days, Monday through Friday."
      }
    },
    {
      "@type": "Question",
      "name": "Do you offer international shipping?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, we ship worldwide. Please contact us for international shipping rates and delivery times."
      }
    },
    {
      "@type": "Question",
      "name": "Can I book a wellness consultation online?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes! You can fill out our contact form and our team will schedule a virtual consultation at your convenience."
      }
    },
    {
      "@type": "Question",
      "name": "Do you offer custom wellness packages?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Absolutely! We specialize in creating personalized wellness plans based on your unique health goals and needs."
      }
    }
  ]
}
</script>

<!-- Success/Error Alert Script -->
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Message Sent!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#15803d',
        timer: 5000,
        showConfirmButton: true
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        confirmButtonColor: '#dc2626'
    });
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        text: 'Please check the form for errors and try again.',
        confirmButtonColor: '#dc2626'
    });
</script>
@endif
@endsection
