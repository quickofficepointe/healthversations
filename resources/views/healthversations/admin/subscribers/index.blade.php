@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Manage Newsletter Subscriptions</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Subscription Form -->
    <div class="bg-gray-50 p-6 rounded-lg mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Add New Subscriber</h2>
        <form method="POST" action="{{ route('newsletter.subscribe') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#93C754] focus:border-transparent"
                    placeholder="Enter full name"
                    required
                />
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#93C754] focus:border-transparent"
                    placeholder="Enter email address"
                    required
                />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Consent Checkbox -->
            <div class="flex items-center">
                <input
                    type="checkbox"
                    name="consent"
                    id="consent"
                    class="h-4 w-4 text-[#93C754] rounded border-gray-300 focus:ring-[#93C754]"
                    required
                />
                <label for="consent" class="ml-2 block text-sm text-gray-700">
                    I agree to receive emails from Health Versations
                </label>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-[#0A4040] hover:bg-[#072b2b] text-white font-bold py-2 px-4 rounded-md transition-colors duration-300"
            >
                Add Subscriber
            </button>
        </form>
    </div>

    <!-- List of Subscribers -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <h2 class="text-xl font-semibold px-6 py-4 bg-gray-100 border-b border-gray-200">Current Subscribers</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Consent</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($subscribers as $subscriber)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $subscriber->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $subscriber->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($subscriber->consent)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">No</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button
                                onclick="editSubscriber('{{ $subscriber->id }}', '{{ $subscriber->name }}', '{{ $subscriber->email }}', {{ $subscriber->consent ? 'true' : 'false' }})"
                                class="text-blue-600 hover:text-blue-900 mr-4"
                                data-modal-target="editModal"
                            >
                                Edit
                            </button>
                            <form action="{{ route('newsletter.destroy', $subscriber->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Are you sure you want to delete this subscriber?');"
                                >
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Edit Subscriber</h2>
            <form method="POST" id="editForm" action="">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label for="editName" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input
                        type="text"
                        name="name"
                        id="editName"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#93C754] focus:border-transparent"
                        required
                    />
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="editEmail" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input
                        type="email"
                        name="email"
                        id="editEmail"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#93C754] focus:border-transparent"
                        required
                    />
                </div>

                <!-- Consent Checkbox -->
                <div class="flex items-center mb-6">
                    <input
                        type="checkbox"
                        name="consent"
                        id="editConsent"
                        class="h-4 w-4 text-[#93C754] rounded border-gray-300 focus:ring-[#93C754]"
                    />
                    <label for="editConsent" class="ml-2 block text-sm text-gray-700">
                        I agree to receive emails from Health Versations
                    </label>
                </div>

                <div class="flex justify-end space-x-3">
                    <button
                        type="button"
                        onclick="document.getElementById('editModal').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-[#0A4040] text-white rounded-md hover:bg-[#072b2b]"
                    >
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Populate the edit modal with subscriber data
    function editSubscriber(id, name, email, consent) {
        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editConsent').checked = consent;
        document.getElementById('editForm').action = `/newsletter/${id}`;
        document.getElementById('editModal').classList.remove('hidden');
    }
</script>
@endsection
