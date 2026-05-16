@extends('layouts.app')

@section('meta_title', 'Edit Profile - Health Versations')
@section('meta_description', 'Update your profile information, health goals, and preferences on Health Versations.')
@section('title', 'Edit Profile - Health Versations')
@section('og_title', 'Edit Profile - Health Versations')
@section('og_description', 'Update your profile information, health goals, and preferences on Health Versations.')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('Assets/images/logo.png') }}" alt="Health Versations" class="h-16 w-auto mx-auto mb-4">
            <h1 class="text-3xl font-bold text-teal-800 mb-2">Edit Profile</h1>
            <div class="w-20 h-1 bg-[#93C754] mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4">Update your personal information and wellness preferences</p>
        </div>

        <!-- Profile Form -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            {{-- Use POST method (not PUT) since route only accepts POST --}}
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6 md:p-8">
                @csrf
                {{-- No @method('PUT') here since route expects POST --}}

                <!-- Current Profile Picture Preview -->
                @if(isset($user->profile->profile_picture) && $user->profile->profile_picture)
                <div class="text-center pb-4 border-b border-gray-200">
                    <label class="block text-gray-700 font-medium mb-2">Current Profile Picture</label>
                    <img src="{{ asset('storage/' . $user->profile->profile_picture) }}" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-[#93C754]">
                </div>
                @endif

                <div>
                    <label for="country" class="block text-gray-700 font-medium mb-2">Country <span class="text-red-500">*</span></label>
                    <select name="country" id="country" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-transparent transition @error('country') border-red-500 @enderror" required>
                        <option value="">Loading countries...</option>
                    </select>
                    @error('country')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block text-gray-700 font-medium mb-2">City <span class="text-red-500">*</span></label>
                    <input type="text" name="city" id="city" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-transparent transition @error('city') border-red-500 @enderror" value="{{ old('city', $user->profile->city ?? '') }}" placeholder="Enter your city" required>
                    @error('city')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="phone_number" class="block text-gray-700 font-medium mb-2">Phone Number <span class="text-red-500">*</span></label>
                    <div class="flex items-center border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-[#93C754] focus-within:border-transparent transition overflow-hidden">
                        <span id="country-code" class="px-4 py-3 bg-gray-50 text-gray-600 border-r border-gray-300">+</span>
                        <input type="tel" name="phone_number" id="phone_number" class="w-full p-3 focus:outline-none" value="{{ old('phone_number', $user->profile->phone_number ?? '') }}" placeholder="712345678" required>
                    </div>
                    @error('phone_number')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-gray-700 font-medium mb-2">Bio / Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-transparent transition @error('description') border-red-500 @enderror" placeholder="Tell us a little about yourself...">{{ old('description', $user->profile->description ?? '') }}</textarea>
                    @error('description')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Share your wellness journey, interests, or any relevant information</p>
                </div>

                <div>
                    <label for="health_goals" class="block text-gray-700 font-medium mb-2">Health Goals</label>
                    <textarea name="health_goals" id="health_goals" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#93C754] focus:border-transparent transition @error('health_goals') border-red-500 @enderror" placeholder="What are your wellness objectives?">{{ old('health_goals', $user->profile->health_goals ?? '') }}</textarea>
                    @error('health_goals')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Examples: Weight management, stress reduction, better sleep, increased energy</p>
                </div>

                <div>
                    <label for="profile_picture" class="block text-gray-700 font-medium mb-2">Profile Picture</label>
                    <div class="mt-1 flex items-center gap-4">
                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#93C754] file:text-white hover:file:bg-green-700 transition cursor-pointer">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Upload a profile picture (JPEG, PNG - Max 2MB)</p>
                    @error('profile_picture')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-[#93C754] text-white font-semibold py-3 px-4 rounded-lg hover:bg-green-700 transition-colors duration-300 uppercase tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#93C754]">
                        Update Profile
                    </button>
                  
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countrySelect = document.getElementById('country');
        const countryCodeSpan = document.getElementById('country-code');
        const savedCountry = "{{ old('country', $user->profile->country ?? '') }}";

        // Fallback country data (in case API fails)
        const fallbackCountries = [
            { name: "United States", code: "+1" },
            { name: "United Kingdom", code: "+44" },
            { name: "Kenya", code: "+254" },
            { name: "Canada", code: "+1" },
            { name: "Australia", code: "+61" },
            { name: "Germany", code: "+49" },
            { name: "France", code: "+33" },
            { name: "India", code: "+91" },
            { name: "Nigeria", code: "+234" },
            { name: "South Africa", code: "+27" },
            { name: "Ghana", code: "+233" },
            { name: "Tanzania", code: "+255" },
            { name: "Uganda", code: "+256" },
            { name: "Rwanda", code: "+250" },
            { name: "Egypt", code: "+20" },
            { name: "Morocco", code: "+212" },
            { name: "Ethiopia", code: "+251" },
            { name: "Zambia", code: "+260" },
            { name: "Zimbabwe", code: "+263" },
            { name: "Sweden", code: "+46" },
            { name: "Norway", code: "+47" },
            { name: "Denmark", code: "+45" },
            { name: "Netherlands", code: "+31" },
            { name: "Spain", code: "+34" },
            { name: "Italy", code: "+39" },
            { name: "Portugal", code: "+351" },
            { name: "Ireland", code: "+353" },
            { name: "New Zealand", code: "+64" },
            { name: "Japan", code: "+81" },
            { name: "China", code: "+86" },
            { name: "Brazil", code: "+55" },
            { name: "Mexico", code: "+52" },
            { name: "Argentina", code: "+54" },
            { name: "Chile", code: "+56" },
            { name: "Colombia", code: "+57" },
            { name: "Peru", code: "+51" },
            { name: "Venezuela", code: "+58" },
            { name: "Malaysia", code: "+60" },
            { name: "Singapore", code: "+65" },
            { name: "Indonesia", code: "+62" },
            { name: "Philippines", code: "+63" },
            { name: "Thailand", code: "+66" },
            { name: "Vietnam", code: "+84" },
            { name: "Pakistan", code: "+92" },
            { name: "Bangladesh", code: "+880" },
            { name: "Sri Lanka", code: "+94" },
            { name: "Nepal", code: "+977" },
            { name: "Turkey", code: "+90" },
            { name: "Israel", code: "+972" },
            { name: "Saudi Arabia", code: "+966" },
            { name: "UAE", code: "+971" }
        ];

        // Fetch countries from REST Countries API (requires fields parameter)
        fetch('https://restcountries.com/v3.1/all?fields=name,idd')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Clear loading option
                countrySelect.innerHTML = '<option value="" disabled>Select a country</option>';

                // Sort countries alphabetically by common name
                const sortedCountries = data.sort((a, b) =>
                    a.name.common.localeCompare(b.name.common)
                );

                // Add countries to dropdown
                sortedCountries.forEach(country => {
                    const option = document.createElement('option');
                    const countryName = country.name.common;
                    let countryCode = '';

                    // Extract calling code correctly
                    if (country.idd && country.idd.root) {
                        const suffix = country.idd.suffixes && country.idd.suffixes[0] ? country.idd.suffixes[0] : '';
                        countryCode = country.idd.root + suffix;
                    }

                    option.value = countryName;
                    option.textContent = countryCode ? `${countryName} (${countryCode})` : countryName;
                    option.dataset.code = countryCode ? countryCode.replace('+', '') : '';

                    // Preselect saved country
                    if (savedCountry === countryName) {
                        option.selected = true;
                        if (countryCode) {
                            countryCodeSpan.textContent = countryCode;
                        }
                    }

                    countrySelect.appendChild(option);
                });

                // If no country was selected and we have data, ensure placeholder is there
                if (!countrySelect.value && sortedCountries.length > 0) {
                    const placeholderOption = document.createElement('option');
                    placeholderOption.value = '';
                    placeholderOption.textContent = 'Select a country';
                    placeholderOption.disabled = true;
                    placeholderOption.selected = true;
                    countrySelect.insertBefore(placeholderOption, countrySelect.firstChild);
                }
            })
            .catch(error => {
                console.error('Error fetching countries from API:', error);

                // Clear loading option and use fallback data
                countrySelect.innerHTML = '<option value="" disabled>Select a country</option>';

                // Add fallback countries
                fallbackCountries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name;
                    option.textContent = `${country.name} (${country.code})`;
                    option.dataset.code = country.code.replace('+', '');

                    if (savedCountry === country.name) {
                        option.selected = true;
                        countryCodeSpan.textContent = country.code;
                    }

                    countrySelect.appendChild(option);
                });

                // If saved country not in fallback list, add placeholder
                if (!countrySelect.value) {
                    const placeholderOption = document.createElement('option');
                    placeholderOption.value = '';
                    placeholderOption.textContent = 'Select a country';
                    placeholderOption.disabled = true;
                    placeholderOption.selected = true;
                    countrySelect.insertBefore(placeholderOption, countrySelect.firstChild);
                }
            });

        // Update country code display when selection changes
        countrySelect.addEventListener('change', function () {
            const selectedOption = countrySelect.options[countrySelect.selectedIndex];
            let countryCode = selectedOption.dataset.code;

            if (countryCode && countryCode !== 'undefined') {
                // Remove any existing + sign and add one
                countryCode = countryCode.replace(/^\+/, '');
                countryCodeSpan.textContent = `+${countryCode}`;
            } else {
                countryCodeSpan.textContent = '+';
            }
        });

        // Phone number formatting (digits only)
        const phoneInput = document.getElementById('phone_number');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                // Remove non-digits
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }

        // Profile picture preview
        const pictureInput = document.getElementById('profile_picture');
        if (pictureInput) {
            pictureInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (2MB max)
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Too Large',
                            text: 'Profile picture must be less than 2MB',
                            confirmButtonColor: '#93C754'
                        });
                        this.value = '';
                        return;
                    }

                    // Validate file type
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!allowedTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File Type',
                            text: 'Please upload a JPEG or PNG image',
                            confirmButtonColor: '#93C754'
                        });
                        this.value = '';
                        return;
                    }
                }
            });
        }
    });
</script>
@endsection
