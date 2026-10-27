@extends('healthversations.user.layout.userlayout')

@section('title', 'Change Password - Health Versation')
@section('page-title', 'Change Password')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 max-w-lg">
    @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('user.change-password.update') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
            <input type="password" name="current_password" required autocomplete="current-password" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
            <input type="password" name="password" required minlength="8" autocomplete="new-password" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500">
            <p class="text-xs text-gray-500 mt-1">At least 8 characters.</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
            <input type="password" name="password_confirmation" required minlength="8" autocomplete="new-password" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500">
        </div>
        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">Update Password</button>
    </form>
</div>
@endsection
