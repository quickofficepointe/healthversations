@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Versation Cards</h1>
        <!-- Add New Card Button -->
        <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200" data-modal-toggle="addCardModal">
            Add New Versation Card
        </button>
    </div>

    <!-- Versation Cards Table -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
        <h2 class="text-xl font-semibold text-gray-800 p-4 border-b">Versation Cards</h2>
        <div class="overflow-x-auto">
            <table id="versationCardsTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Tags</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Cover Image</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($versationscard as $card)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $card->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($card->description, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $card->tags }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            @if($card->cover_image)
                                <img src="{{ asset('storage/' . $card->cover_image) }}" alt="Cover Image" class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <button class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200"
                                        data-modal-toggle="editCardModal{{ $card->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('versation.destroy', $card->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this card?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg transition duration-200">
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

    <!-- Add Card Modal -->
    <div id="addCardModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Add New Versation Card</h3>
                <button class="text-gray-400 hover:text-gray-500" data-modal-toggle="addCardModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('versation.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>
                <div class="mb-4">
                    <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                    <input type="text" name="tags" id="tags" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="mb-4">
                    <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover Image</label>
                    <input type="file" name="cover_image" id="cover_image" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="addCardModal">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Card Modals -->
    @foreach($versationscard as $card)
    <div id="editCardModal{{ $card->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Edit Versation Card</h3>
                <button class="text-gray-400 hover:text-gray-500" data-modal-toggle="editCardModal{{ $card->id }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('versation.update', $card->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_name{{ $card->id }}" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="edit_name{{ $card->id }}" value="{{ $card->name }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>
                </div>
                <div class="mb-4">
                    <label for="edit_description{{ $card->id }}" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="edit_description{{ $card->id }}" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">{{ $card->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="edit_tags{{ $card->id }}" class="block text-sm font-medium text-gray-700">Tags</label>
                    <input type="text" name="tags" id="edit_tags{{ $card->id }}" value="{{ $card->tags }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="mb-4">
                    <label for="edit_cover_image{{ $card->id }}" class="block text-sm font-medium text-gray-700">Cover Image</label>
                    @if($card->cover_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $card->cover_image) }}" alt="Current Cover Image" class="w-16 h-16 object-cover rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="cover_image" id="edit_cover_image{{ $card->id }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="editCardModal{{ $card->id }}">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#versationCardsTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search cards...",
            },
            columnDefs: [
                { orderable: false, targets: [3, 4] } // Image and Actions columns
            ],
            order: [[0, 'asc']] // Order by Name column by default
        });

        // Toggle Modals
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', (e) => {
                const modalId = e.target.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                modal.classList.toggle('hidden');
            });
        });

        // Close modals when clicking outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    });
</script>
@endsection
@endsection
