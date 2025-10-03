@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto  p-6 rounded-lg">
    <h2 class="text-2xl font-bold text-[#0A4040] mb-6">Book Your Health Consultation</h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('consultations.store') }}" method="POST" class="space-y-6" id="consultationForm">
        @csrf

        <!-- Personal Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" id="name" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754]"
                       value="{{ old('name', Auth::user()->name ?? '') }}">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754]"
                       value="{{ old('email', Auth::user()->email ?? '') }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="tel" name="phone" id="phone" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754]"
                       value="{{ old('phone', Auth::user()->phone ?? '') }}">
            </div>
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                <select name="location" id="location" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754]">
                    <option value="international" {{ old('location', 'international') == 'international' ? 'selected' : '' }}>International</option>
                    <option value="kenya" {{ old('location') == 'kenya' ? 'selected' : '' }}>Kenya</option>
                </select>
            </div>
        </div>

        <!-- Timezone Field (Visible for International) -->
        <div id="timezone-field" class="{{ old('location', 'international') == 'kenya' ? 'hidden' : '' }}">
            <label for="timezone" class="block text-sm font-medium text-gray-700 mb-1">Your Timezone</label>
            <select name="timezone" id="timezone"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754]">
                @foreach(timezone_identifiers_list() as $tz)
                <option value="{{ $tz }}" {{ old('timezone', 'UTC') == $tz ? 'selected' : '' }}>{{ $tz }}</option>
                @endforeach
            </select>
        </div>

        <!-- Consultation Types -->
        <div class="space-y-4">
            @foreach($consultationTypes as $value => $label)
            <label class="consultation-type-card block">
                <input type="radio" name="type" value="{{ $value }}" class="sr-only peer"
                       {{ old('type', App\Models\Consultation::TYPE_INITIAL) == $value ? 'checked' : '' }} required>
                <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#93C754] peer-checked:border-[#93C754] peer-checked:bg-[#93C754]/10 h-full">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium text-[#0A4040]">{{ $label }}</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                @switch($value)
                                    @case(App\Models\Consultation::TYPE_INITIAL)
                                        Comprehensive health assessment (60 min)
                                        @break
                                    @case(App\Models\Consultation::TYPE_FOLLOWUP)
                                        Progress review session (30 min)
                                        @break
                                    @case(App\Models\Consultation::TYPE_NUTRITION_REVIEW)
                                        Nutrition plan evaluation (45 min)
                                        @break
                                    @case(App\Models\Consultation::TYPE_SPECIALIZED)
                                        Specialized condition consultation (60 min)
                                        @break
                                @endswitch
                            </p>
                        </div>
                        <span class="bg-[#93C754] text-white text-xs px-2 py-1 rounded-full">
                            @switch($value)
                                @case(App\Models\Consultation::TYPE_INITIAL) 60 min @break
                                @case(App\Models\Consultation::TYPE_FOLLOWUP) 30 min @break
                                @case(App\Models\Consultation::TYPE_NUTRITION_REVIEW) 45 min @break
                                @case(App\Models\Consultation::TYPE_SPECIALIZED) 60 min @break
                            @endswitch
                        </span>
                    </div>
                    <p class="text-sm text-[#52823C] font-medium mt-2" id="fee-{{ $value }}">
                        {{ $defaultLocation === App\Models\Consultation::LOCATION_KENYA ?
                           ($value === App\Models\Consultation::TYPE_SPECIALIZED ? 'Ksh 3,000' : 'Ksh 2,500') :
                           ($value === App\Models\Consultation::TYPE_SPECIALIZED ? '$28' : '$24') }}
                    </p>
                </div>
            </label>
            @endforeach
        </div>

        <!-- Date & Time -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="consultation_date" class="block text-sm font-medium text-gray-700 mb-1">Preferred Date</label>
                <input type="date" name="consultation_date" id="consultation_date" min="{{ date('Y-m-d') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754]"
                       value="{{ old('consultation_date') }}">
            </div>
            <div>
                <label for="consultation_time" class="block text-sm font-medium text-gray-700 mb-1">Preferred Time</label>
                <select name="consultation_time" id="consultation_time" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754]">
                    <option value="">Select a time</option>
                    @foreach(['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00'] as $time)
                    <option value="{{ $time }}" {{ old('consultation_time') == $time ? 'selected' : '' }}>{{ $time }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Health Information -->
        <div>
            <label for="health_concerns" class="block text-sm font-medium text-gray-700 mb-1">Your Health Concerns</label>
            <textarea name="health_concerns" id="health_concerns" rows="4" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754]"
                      placeholder="Please describe your health goals and any specific concerns">{{ old('health_concerns') }}</textarea>
        </div>

        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Information (Optional)</label>
            <textarea name="notes" id="notes" rows="2"
                      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754]"
                      placeholder="Any other information we should know">{{ old('notes') }}</textarea>
        </div>

        <!-- Payment Section -->
        <div class="pt-4 border-t border-gray-200">
            <div class="flex justify-between items-center text-xl font-semibold mb-6">
                <h3>Consultation Fee:</h3>
                <span class="text-[#52823C]" id="dynamic-fee">
                    $24.00
                </span>
            </div>

            <button type="submit"
                    class="w-full bg-[#93C754] hover:bg-[#7eae47] text-white px-6 py-3 font-bold rounded-md transition-colors duration-300">
                Book Consultation & Pay
            </button>

            <p class="text-sm text-gray-500 mt-3 text-center">
                You'll be redirected to our secure payment gateway after booking
            </p>
        </div>
    </form>
</div>

<!-- Hidden payment form for iVeri -->
<form id="iveriPaymentForm" method="POST" action="{{ config('services.iveri.url', 'https://portal.host.iveri.com/Lite/Authorise.aspx') }}" class="hidden">
    @csrf
    <input type="hidden" name="Lite_Version" value="4.0">
    <input type="hidden" name="Lite_Merchant_ApplicationId" value="{{ config('services.iveri.app_id', '3a7f44fd-4bb4-432c-b483-32e5a19e100d') }}">
    <input type="hidden" name="Lite_Order_Amount" id="iveriAmount">
    <input type="hidden" name="Ecom_ConsumerOrderID" id="iveriOrderId">
    <input type="hidden" name="Lite_Website_Successful_Url" value="{{ route('payment.success') }}">
    <input type="hidden" name="Lite_Website_Fail_Url" value="{{ route('payment.fail') }}">
    <input type="hidden" name="Lite_Website_TryLater_Url" value="{{ route('payment.retry') }}">
    <input type="hidden" name="Lite_Website_Error_Url" value="{{ route('payment.error') }}">
    <input type="hidden" name="Lite_ConsumerOrderID_PreFix" value="CONS">
    <input type="hidden" name="Ecom_Payment_Card_Protocols" value="iVeri">
    <input type="hidden" name="Ecom_TransactionComplete" value="false">
    <input type="hidden" name="Lite_Currency_AlphaCode" id="iveriCurrency">
    <input type="hidden" name="Lite_Transaction_Token" id="iveriToken">
    <input type="hidden" name="Ecom_BillTo_Online_Email" id="iveriEmail">
    <input type="hidden" name="Ecom_BillTo_Postal_Name_First" id="iveriFirstName">
    <input type="hidden" name="Ecom_BillTo_Postal_Name_Last" id="iveriLastName">
    <input type="hidden" name="consultation_id" id="iveriConsultationId">
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide timezone based on location
    const locationField = document.getElementById('location');
    const timezoneField = document.getElementById('timezone-field');

    locationField.addEventListener('change', function() {
        timezoneField.classList.toggle('hidden', this.value === 'kenya');
        updateFees();
    });

    // Update fees when location changes
    function updateFees() {
        const isKenya = locationField.value === 'kenya';
        const feeDisplay = document.getElementById('dynamic-fee');
        const consultationType = document.querySelector('input[name="type"]:checked')?.value || 'initial';

        // Update main fee display
        if (isKenya) {
            feeDisplay.textContent = consultationType === 'specialized' ? 'Ksh 3,000.00' : 'Ksh 2,500.00';
        } else {
            feeDisplay.textContent = consultationType === 'specialized' ? '$28.00' : '$24.00';
        }

        // Update all fee displays
        document.querySelectorAll('[id^="fee-"]').forEach(el => {
            const type = el.id.replace('fee-', '');
            el.textContent = isKenya ?
                (type === 'specialized' ? 'Ksh 3,000' : 'Ksh 2,500') :
                (type === 'specialized' ? '$28' : '$24');
        });
    }

    // Update fees when consultation type changes
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', updateFees);
    });

    // Initialize
    updateFees();

    // Handle form submission
    const consultationForm = document.getElementById('consultationForm');
    const iveriForm = document.getElementById('iveriPaymentForm');

    consultationForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Show loading state
        const submitButton = consultationForm.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'Processing...';
        submitButton.disabled = true;

        // Submit the consultation form via AJAX first
        fetch(consultationForm.action, {
            method: 'POST',
            body: new FormData(consultationForm),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.consultation_id) {
                // Set iVeri form values
                document.getElementById('iveriConsultationId').value = data.consultation_id;
                document.getElementById('iveriAmount').value = data.amount * 100;
                document.getElementById('iveriOrderId').value = data.order_id;
                document.getElementById('iveriCurrency').value = data.currency;
                document.getElementById('iveriEmail').value = data.email;
                document.getElementById('iveriToken').value = data.token;

                // Split name into first and last
                const fullName = data.name.split(' ');
                document.getElementById('iveriFirstName').value = fullName[0];
                document.getElementById('iveriLastName').value = fullName.slice(1).join(' ') || '';

                // Submit iVeri form
                iveriForm.submit();
            } else {
                alert('Error creating consultation. Please try again.');
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        });
    });
});
</script>

<style>
.consultation-type-card input:checked + div {
    border-color: #93C754;
    background-color: rgba(147, 199, 84, 0.1);
    box-shadow: 0 0 0 3px rgba(147, 199, 84, 0.2);
}
.consultation-type-card div {
    transition: all 0.2s ease;
}
.consultation-type-card:hover div {
    transform: translateY(-2px);
}
</style>
@endsection
