@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold mb-6">Edit Profile</h1>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="country" class="block font-medium">Country:</label>
            <select name="country" id="country" class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
                <option value="">Select a country</option>
            </select>
        </div>

        <div>
            <label for="city" class="block font-medium">City:</label>
            <input type="text" name="city" id="city" class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300" value="{{ old('city', $user->profile->city ?? '') }}" required>
        </div>

        <div>
            <label for="phone_number" class="block font-medium">Phone Number:</label>
            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                <span id="country-code" class="px-4 bg-gray-200"></span>
                <input type="text" name="phone_number" id="phone_number" class="w-full p-2 focus:ring focus:ring-blue-300" value="{{ old('phone_number', $user->profile->phone_number ?? '') }}" required>
            </div>
        </div>

        <div>
            <label for="description" class="block font-medium">Description:</label>
            <textarea name="description" id="description" class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">{{ old('description', $user->profile->description ?? '') }}</textarea>
        </div>

        <div>
            <label for="health_goals" class="block font-medium">Health Goals:</label>
            <textarea name="health_goals" id="health_goals" class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">{{ old('health_goals', $user->profile->health_goals ?? '') }}</textarea>
        </div>

        <div>
            <label for="profile_picture" class="block font-medium">Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture" class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">Update Profile</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countrySelect = document.getElementById('country');
        const countryCodeSpan = document.getElementById('country-code');

        fetch('https://restcountries.com/v3.1/all')
            .then(response => response.json())
            .then(data => {
                data.forEach(country => {
                    const option = document.createElement('option');
                    const countryName = country.name.common;
                    const countryCode = country.idd.root + (country.idd.suffixes ? country.idd.suffixes[0] : '');
                    option.value = countryName;
                    option.textContent = `${countryName} (${countryCode})`;
                    option.dataset.code = countryCode;
                    countrySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching country data:', error));

        countrySelect.addEventListener('change', function () {
            const selectedOption = countrySelect.options[countrySelect.selectedIndex];
            const countryCode = selectedOption.dataset.code;
            countryCodeSpan.textContent = `+${countryCode}`;
        });
    });
</script>
@endsection
