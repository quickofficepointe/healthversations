@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Users</h1>
        <button onclick="toggleModal('addUserModal')"
            class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200">
            Add User
        </button>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <h2 class="text-xl font-semibold text-gray-800 p-4 border-b">Registered Users</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($user->role === 0)
                                <span class="text-purple-600 font-semibold">Super Admin</span>
                            @elseif($user->role === 1)
                                <span class="text-red-600 font-semibold">Admin</span>
                            @elseif($user->role === 2)
                                <span class="text-blue-600 font-semibold">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <!-- Edit Button -->
                                <button onclick="toggleModal('editUserModal{{ $user->id }}')"
                                    class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200">
                                    Edit
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg transition duration-200">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-xl font-semibold text-gray-800">Add New User</h3>
                <button onclick="toggleModal('addUserModal')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form action="{{ route('register') }}" method="POST" id="addUserForm">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" class="mt-1 block w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" class="mt-1 block w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" class="mt-1 block w-full p-2 border rounded-md" required>
                            <option value="0">Super Admin</option>
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" class="mt-1 block w-full p-2 border rounded-md" required>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="border-t p-4 flex justify-end space-x-3">
                <button onclick="toggleModal('addUserModal')" type="button" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md">
                    Close
                </button>
                <button type="submit" form="addUserForm" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md">
                    Save
                </button>
            </div>
        </div>
    </div>

    <!-- Edit User Modals -->
    @foreach($users as $user)
    <div id="editUserModal{{ $user->id }}" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-xl font-semibold text-gray-800">Edit User</h3>
                <button onclick="toggleModal('editUserModal{{ $user->id }}')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form action="{{ route('users.update', $user->id) }}" method="POST" id="editUserForm{{ $user->id }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="mt-1 block w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="mt-1 block w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" class="mt-1 block w-full p-2 border rounded-md" required>
                            <option value="0" @if($user->role === 0) selected @endif>Super Admin</option>
                            <option value="1" @if($user->role === 1) selected @endif>Admin</option>
                            <option value="2" @if($user->role === 2) selected @endif>User</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="border-t p-4 flex justify-end space-x-3">
                <button onclick="toggleModal('editUserModal{{ $user->id }}')" type="button" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md">
                    Close
                </button>
                <button type="submit" form="editUserForm{{ $user->id }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md">
                    Update
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Toggle Script -->
<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>
@endsection
