@extends('healthversations.user.layout.userlayout')

@section('title', 'Profile Settings - Health Versation')
@section('page-title', 'Profile Settings')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl">
    @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500">
            <p class="text-xs text-gray-500 mt-1">Your orders and bookings are linked to this email address.</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
            <input type="tel" name="phone_number" value="{{ old('phone_number', optional($user->profile)->phone_number) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                <input type="text" name="city" value="{{ old('city', optional($user->profile)->city) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                <input type="text" name="country" value="{{ old('country', optional($user->profile)->country) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500">
            </div>
        </div>

        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">Save Changes</button>
    </form>
</div>
@endsection
