@extends('layouts.app')

@section('title', 'Book Your Health Consultation | Personalized Wellness Coaching')
@section('meta_description', 'Book a personalized health consultation with our expert wellness coaches. Choose from initial assessments, follow-ups, nutrition reviews, or specialized consultations. Start your wellness journey today.')
@section('meta_keywords', 'health consultation, wellness coaching, nutrition consultation, health assessment, personalized wellness, Health Versations, online consultation')
@section('meta_author', 'Health Versations Team')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('consultations.create'))

@section('og_title', 'Book Your Health Consultation | Health Versations')
@section('og_description', 'Transform your health with personalized wellness coaching. Book your consultation today and get expert guidance on nutrition, gut health, and holistic wellness.')
@section('og_image', asset('Assets/images/consultation-banner.jpg'))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', 'Health Consultation Booking - Health Versations')
@section('og_type', 'website')

@section('twitter_title', 'Book Your Health Consultation | Health Versations')
@section('twitter_description', 'Expert wellness coaching personalized for your health goals. Book online today.')
@section('twitter_image', asset('Assets/images/consultation-banner.jpg'))
@section('twitter_card', 'summary_large_image')

@section('content')
<!-- JSON-LD: Service Schema -->
@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "MedicalWebPage",
  "name": "Health Consultation Booking",
  "description": "Book personalized health consultations with expert wellness coaches",
  "url": "{{ route('consultations.create') }}",
  "mainEntity": {
    "@type": "MedicalClinic",
    "name": "Health Versations",
    "description": "Professional health and wellness consultation services",
    "medicalSpecialty": "Wellness",
    "availableService": [
      {
        "@type": "MedicalProcedure",
        "name": "Initial Health Assessment",
        "description": "Comprehensive 60-minute health evaluation"
      },
      {
        "@type": "MedicalProcedure",
        "name": "Follow-up Consultation",
        "description": "30-minute progress review session"
      },
      {
        "@type": "MedicalProcedure",
        "name": "Nutrition Review",
        "description": "45-minute nutrition plan evaluation"
      }
    ]
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
      "name": "Consultations",
      "item": "{{ route('consultations.create') }}"
    }
  ]
}
</script>
@endpush

<div class="bg-gradient-to-b from-gray-50 to-white py-8 md:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="text-center mb-8">
            <div class="inline-block bg-[#93C754]/10 rounded-full px-4 py-1 mb-4">
                <span class="text-[#0A4040] text-sm font-semibold">Start Your Journey</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Book Your Health Consultation
            </h1>
            <div class="w-24 h-1 bg-gradient-to-r from-[#93C754] to-[#0A4040] mx-auto mb-6 rounded-full"></div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Take the first step towards better health with personalized guidance from our expert wellness coaches.
            </p>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2 text-green-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded shadow-sm">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle mr-2 text-red-500 mt-0.5"></i>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Consultation Form -->
        <form action="{{ route('consultations.store') }}" method="POST" class="space-y-6" id="consultationForm">
            @csrf

            <!-- Personal Information Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <h2 class="text-xl font-semibold text-[#0A4040] mb-6 flex items-center">
                    <i class="fas fa-user-circle mr-3 text-2xl text-[#93C754]"></i>
                    Personal Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition"
                               value="{{ old('name', Auth::user()->name ?? '') }}"
                               placeholder="Enter your full name">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition"
                               value="{{ old('email', Auth::user()->email ?? '') }}"
                               placeholder="you@example.com">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="phone" id="phone" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition"
                               value="{{ old('phone', Auth::user()->phone ?? '') }}"
                               placeholder="2547XXXXXXXX">
                        <p class="text-xs text-gray-500 mt-1">Format: 2547XXXXXXXX (e.g., 254712345678)</p>
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Location <span class="text-red-500">*</span>
                        </label>
                        <select name="location" id="location" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition">
                            <option value="international" {{ old('location', 'international') == 'international' ? 'selected' : '' }}>🌍 International</option>
                            <option value="kenya" {{ old('location') == 'kenya' ? 'selected' : '' }}>🇰🇪 Kenya</option>
                        </select>
                    </div>
                </div>

                <!-- Timezone Field (Visible for International) -->
                <div id="timezone-field" class="mt-6 {{ old('location', 'international') == 'kenya' ? 'hidden' : '' }}">
                    <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-globe mr-2 text-[#93C754]"></i>Your Timezone
                    </label>
                    <select name="timezone" id="timezone"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition">
                        @foreach(timezone_identifiers_list() as $tz)
                        <option value="{{ $tz }}" {{ old('timezone', 'UTC') == $tz ? 'selected' : '' }}>{{ $tz }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Consultation Type Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <h2 class="text-xl font-semibold text-[#0A4040] mb-6 flex items-center">
                    <i class="fas fa-stethoscope mr-3 text-2xl text-[#93C754]"></i>
                    Consultation Type
                </h2>
                <div class="space-y-4">
                    @foreach($consultationTypes as $value => $label)
                    <label class="consultation-type-card block cursor-pointer">
                        <input type="radio" name="type" value="{{ $value }}" class="sr-only peer"
                               {{ old('type', App\Models\Consultation::TYPE_INITIAL) == $value ? 'checked' : '' }} required>
                        <div class="p-5 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#93C754] peer-checked:border-[#93C754] peer-checked:bg-[#93C754]/5 transition-all">
                            <div class="flex flex-wrap justify-between items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 bg-[#93C754]/20 rounded-full flex items-center justify-center">
                                            @switch($value)
                                                @case(App\Models\Consultation::TYPE_INITIAL)
                                                    <i class="fas fa-clinic-medical text-[#0A4040]"></i>@break
                                                @case(App\Models\Consultation::TYPE_FOLLOWUP)
                                                    <i class="fas fa-chart-line text-[#0A4040]"></i>@break
                                                @case(App\Models\Consultation::TYPE_NUTRITION_REVIEW)
                                                    <i class="fas fa-apple-alt text-[#0A4040]"></i>@break
                                                @case(App\Models\Consultation::TYPE_SPECIALIZED)
                                                    <i class="fas fa-heartbeat text-[#0A4040]"></i>@break
                                            @endswitch
                                        </div>
                                        <h3 class="font-semibold text-lg text-[#0A4040]">{{ $label }}</h3>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        @switch($value)
                                            @case(App\Models\Consultation::TYPE_INITIAL)
                                                Comprehensive health assessment including medical history, lifestyle review, and personalized recommendations. (60 min)
                                                @break
                                            @case(App\Models\Consultation::TYPE_FOLLOWUP)
                                                Progress review session to track improvements and adjust your wellness plan. (30 min)
                                                @break
                                            @case(App\Models\Consultation::TYPE_NUTRITION_REVIEW)
                                                In-depth nutrition analysis with customized meal planning guidance. (45 min)
                                                @break
                                            @case(App\Models\Consultation::TYPE_SPECIALIZED)
                                                Focused consultation for specific health conditions including gut health, weight loss, or metabolic issues. (60 min)
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="bg-[#93C754] text-white text-xs px-3 py-1 rounded-full whitespace-nowrap">
                                        @switch($value)
                                            @case(App\Models\Consultation::TYPE_INITIAL) 60 min @break
                                            @case(App\Models\Consultation::TYPE_FOLLOWUP) 30 min @break
                                            @case(App\Models\Consultation::TYPE_NUTRITION_REVIEW) 45 min @break
                                            @case(App\Models\Consultation::TYPE_SPECIALIZED) 60 min @break
                                        @endswitch
                                    </span>
                                    <p class="text-lg font-bold text-[#52823C] mt-2" id="fee-{{ $value }}">
                                        {{ $defaultLocation === App\Models\Consultation::LOCATION_KENYA ? 'Ksh 3,000' : '$31' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Date & Time Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <h2 class="text-xl font-semibold text-[#0A4040] mb-6 flex items-center">
                    <i class="fas fa-calendar-alt mr-3 text-2xl text-[#93C754]"></i>
                    Schedule Your Consultation
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="consultation_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Preferred Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="consultation_date" id="consultation_date"
                               min="{{ date('Y-m-d') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition"
                               value="{{ old('consultation_date') }}">
                    </div>
                    <div>
                        <label for="consultation_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Preferred Time <span class="text-red-500">*</span>
                        </label>
                        <select name="consultation_time" id="consultation_time" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition">
                            <option value="">Select a time</option>
                            @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'] as $time)
                            <option value="{{ $time }}" {{ old('consultation_time') == $time ? 'selected' : '' }}>
                                {{ date('g:i A', strtotime($time)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Health Information Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <h2 class="text-xl font-semibold text-[#0A4040] mb-6 flex items-center">
                    <i class="fas fa-notes-medical mr-3 text-2xl text-[#93C754]"></i>
                    Health Information
                </h2>
                <div class="space-y-6">
                    <div>
                        <label for="health_concerns" class="block text-sm font-medium text-gray-700 mb-2">
                            Your Health Concerns <span class="text-red-500">*</span>
                        </label>
                        <textarea name="health_concerns" id="health_concerns" rows="4" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition"
                                  placeholder="Please describe your health goals, current challenges, and any specific concerns you'd like to address...">{{ old('health_concerns') }}</textarea>
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Additional Information (Optional)
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition"
                                  placeholder="Any other information you'd like us to know...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Payment Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <h2 class="text-xl font-semibold text-[#0A4040] mb-6 flex items-center">
                    <i class="fas fa-credit-card mr-3 text-2xl text-[#93C754]"></i>
                    Payment Details
                </h2>

                <!-- Consultation Fee Summary -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Consultation Fee:</span>
                        <span class="text-2xl font-bold text-[#52823C]" id="dynamic-fee">
                            $31.00
                        </span>
                    </div>
                </div>

                <!-- Payment Method Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Select Payment Method</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="payment-method-card cursor-pointer">
                            <input type="radio" name="payment_method" value="iveri" class="sr-only peer" checked>
                            <div class="p-5 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#93C754] peer-checked:border-[#93C754] peer-checked:bg-[#93C754]/5 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-credit-card text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Credit/Debit Card</h4>
                                        <p class="text-sm text-gray-500">Visa, Mastercard, Amex</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label class="payment-method-card cursor-pointer">
                            <input type="radio" name="payment_method" value="kcb" class="sr-only peer">
                            <div class="p-5 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#0A4040] peer-checked:border-[#0A4040] peer-checked:bg-[#0A4040]/5 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-mobile-alt text-green-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">M-Pesa</h4>
                                        <p class="text-sm text-gray-500">Pay with mobile money</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-[#93C754] to-[#7eae47] text-white px-6 py-4 font-bold rounded-xl hover:from-[#7eae47] hover:to-[#6a9a3a] transition-all duration-300 transform hover:scale-[1.02] shadow-lg text-lg">
                    <i class="fas fa-calendar-check mr-2"></i> Book Consultation & Pay
                </button>
                <p class="text-sm text-gray-500 mt-4 text-center">
                    <i class="fas fa-lock mr-1"></i> Your payment is secure and encrypted. You'll be redirected to our secure payment gateway.
                </p>
            </div>
        </form>

        <!-- Benefits Section -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4">
                <div class="w-14 h-14 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-user-md text-2xl text-[#0A4040]"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Expert Coaches</h3>
                <p class="text-sm text-gray-500">Certified wellness professionals</p>
            </div>
            <div class="text-center p-4">
                <div class="w-14 h-14 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-video text-2xl text-[#0A4040]"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Virtual Consultations</h3>
                <p class="text-sm text-gray-500">Connect from anywhere worldwide</p>
            </div>
            <div class="text-center p-4">
                <div class="w-14 h-14 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-calendar-week text-2xl text-[#0A4040]"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Flexible Scheduling</h3>
                <p class="text-sm text-gray-500">Choose times that work for you</p>
            </div>
        </div>
    </div>
</div>

<!-- Payment Status Modal -->
<div id="payment-status-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 p-4 overflow-auto flex items-center justify-center">
    <div class="bg-white max-w-md w-full mx-auto rounded-2xl p-6 relative text-center shadow-2xl">
        <div id="payment-status-content">
            <!-- Content populated by JavaScript -->
        </div>
        <button onclick="hidePaymentModal()"
                class="mt-6 px-6 py-2 bg-[#93C754] text-white rounded-lg hover:bg-[#7eae47] transition">
            Close
        </button>
    </div>
</div>

<script>
// Global modal functions
function showPaymentStatusModal(content) {
    const modal = document.getElementById('payment-status-modal');
    const contentElement = document.getElementById('payment-status-content');

    if (modal && contentElement) {
        contentElement.innerHTML = content;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}

function hidePaymentModal() {
    const modal = document.getElementById('payment-status-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    if (window.paymentStatusInterval) {
        clearInterval(window.paymentStatusInterval);
        window.paymentStatusInterval = null;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Show/hide timezone based on location
    const locationField = document.getElementById('location');
    const timezoneField = document.getElementById('timezone-field');

    if (locationField && timezoneField) {
        locationField.addEventListener('change', function() {
            timezoneField.classList.toggle('hidden', this.value === 'kenya');
            updateFees();
            updatePaymentMethods();
        });
    }

    // Update payment method availability
    function updatePaymentMethods() {
        const isKenya = locationField?.value === 'kenya';
        const kcbRadio = document.querySelector('input[name="payment_method"][value="kcb"]');

        if (kcbRadio) {
            const kcbCard = kcbRadio.closest('.payment-method-card');

            if (isKenya) {
                kcbCard?.classList.remove('opacity-50', 'cursor-not-allowed');
                kcbRadio.disabled = false;
            } else {
                kcbCard?.classList.add('opacity-50', 'cursor-not-allowed');
                kcbRadio.disabled = true;
                if (kcbRadio.checked) {
                    const iveriRadio = document.querySelector('input[name="payment_method"][value="iveri"]');
                    if (iveriRadio) iveriRadio.checked = true;
                }
            }
        }
    }

    // Update fees when location changes
    function updateFees() {
        const isKenya = locationField?.value === 'kenya';
        const feeDisplay = document.getElementById('dynamic-fee');
        const consultationType = document.querySelector('input[name="type"]:checked')?.value || 'initial';

        if (feeDisplay) {
            feeDisplay.textContent = isKenya ? 'Ksh 3,000' : '$31.00';
        }

        document.querySelectorAll('[id^="fee-"]').forEach(el => {
            el.textContent = isKenya ? 'Ksh 3,000' : '$31';
        });
    }

    // Update fees when consultation type changes
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', updateFees);
    });

    updateFees();
    updatePaymentMethods();

    // KCB Payment Functions
    async function checkKcbPaymentStatus(checkoutRequestId) {
        try {
            const response = await fetch('{{ route("kcb.payment.status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ checkout_request_id: checkoutRequestId })
            });

            const data = await response.json();

            if (data.status === 'completed') {
                showPaymentStatusModal(`
                    <div class="text-green-600">
                        <i class="fas fa-check-circle text-5xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Payment Successful!</h3>
                        <p class="text-gray-600">Your consultation has been booked successfully.</p>
                        <p class="text-sm text-gray-500 mt-2">Receipt: ${data.mpesa_receipt_number || 'N/A'}</p>
                    </div>
                `);
                clearInterval(window.paymentStatusInterval);
                setTimeout(() => window.location.href = '{{ route("payment.success") }}', 3000);
            } else if (data.status === 'failed') {
                showPaymentStatusModal(`
                    <div class="text-red-600">
                        <i class="fas fa-times-circle text-5xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Payment Failed</h3>
                        <p class="text-gray-600">${data.result_description || 'Please try again.'}</p>
                    </div>
                `);
                clearInterval(window.paymentStatusInterval);
            }
        } catch (error) {
            console.error('Error checking payment status:', error);
        }
    }

    async function initiateKcbPayment(paymentData) {
        const response = await fetch('{{ route("kcb.payment.initiate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(paymentData)
        });

        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Payment initiation failed');
        return data;
    }

    // Form submission handler
    const consultationForm = document.getElementById('consultationForm');
    if (consultationForm) {
        consultationForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                alert('Please select a payment method');
                return;
            }

            const submitButton = consultationForm.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            submitButton.innerHTML = '<div class="spinner mx-auto"></div> Processing...';
            submitButton.disabled = true;

            try {
                const formData = new FormData(consultationForm);
                const response = await fetch(consultationForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });

                const data = await response.json();

                if (data.success && data.consultation_id) {
                    if (paymentMethod.value === 'iveri') {
                        window.location.href = `/consultations/${data.consultation_id}/process-payment`;
                    } else if (paymentMethod.value === 'kcb') {
                        const kcbResult = await initiateKcbPayment({
                            payment_type: 'consultation',
                            phone_number: document.getElementById('phone').value,
                            amount: data.amount,
                            currency: data.currency,
                            customer_name: data.name,
                            email: data.email,
                            reference_data: {
                                consultation_id: data.consultation_id,
                                type: data.type,
                                consultation_date: data.consultation_date,
                                consultation_time: data.consultation_time
                            }
                        });

                        if (kcbResult.success) {
                            showPaymentStatusModal(`
                                <div class="text-blue-600">
                                    <i class="fas fa-spinner fa-spin text-4xl mb-4"></i>
                                    <h3 class="text-xl font-semibold mb-2">Payment Initiated</h3>
                                    <p class="text-gray-600">${kcbResult.customer_message || 'Check your phone for M-Pesa prompt...'}</p>
                                </div>
                            `);
                            window.paymentStatusInterval = setInterval(() => {
                                checkKcbPaymentStatus(kcbResult.checkout_request_id);
                            }, 3000);
                        }
                    }
                } else {
                    alert(data.message || 'Error creating consultation');
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') hidePaymentModal();
    });
});

// Loading spinner styles
const style = document.createElement('style');
style.textContent = `
.spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #93C754;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 1s linear infinite;
    display: inline-block;
    margin-right: 8px;
    vertical-align: middle;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.consultation-type-card input:checked + div {
    border-color: #93C754;
    box-shadow: 0 4px 12px rgba(147, 199, 84, 0.15);
}
.payment-method-card input:checked + div {
    border-color: #93C754;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.opacity-50 { opacity: 0.5; }
.cursor-not-allowed { cursor: not-allowed; }
`;
document.head.appendChild(style);
</script>
@endsection
