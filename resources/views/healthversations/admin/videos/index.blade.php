@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Video Links</h1>
        <!-- Add Video Button -->
        <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200" data-modal-toggle="addVideoModal">
            Add New Video
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Videos Table -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="videosTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Video Link</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($videos as $video)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $video->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <a href="{{ $video->link }}" target="_blank" class="text-primary-600 hover:text-primary-700">{{ Str::limit($video->link, 50) }}</a>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-2">
                                <button class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200"
                                        data-modal-toggle="editVideoModal{{ $video->id }}"
                                        data-title="{{ $video->title }}"
                                        data-link="{{ $video->link }}">
                                    Edit
                                </button>
                                <form action="{{ route('videos.destroy', $video->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this video?');">
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

    <!-- Add Video Modal -->
    <div id="addVideoModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 max-h-[90vh] overflow-y-auto">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Add New Video</h3>
            <form action="{{ route('videos.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Video Title*</label>
                    <input type="text" name="title" id="title" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="mb-4">
                    <label for="link" class="block text-sm font-medium text-gray-700">Video URL*</label>
                    <input type="url" name="link" id="link" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="addVideoModal">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Save Video
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Video Modals -->
    @foreach($videos as $video)
    <div id="editVideoModal{{ $video->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 max-h-[90vh] overflow-y-auto">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Edit Video</h3>
            <form action="{{ route('videos.update', $video->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="title{{ $video->id }}" class="block text-sm font-medium text-gray-700">Video Title*</label>
                    <input type="text" name="title" id="title{{ $video->id }}" value="{{ $video->title }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="mb-4">
                    <label for="link{{ $video->id }}" class="block text-sm font-medium text-gray-700">Video URL*</label>
                    <input type="url" name="link" id="link{{ $video->id }}" value="{{ $video->link }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="editVideoModal{{ $video->id }}">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Update Video
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
        $('#videosTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search videos...",
            },
            columnDefs: [
                { orderable: false, targets: [2] } // Actions column
            ]
        });

        // Edit button click handler to populate modal with data
        document.querySelectorAll('[data-modal-toggle^="editVideoModal"]').forEach(button => {
            button.addEventListener('click', (e) => {
                const title = e.target.getAttribute('data-title');
                const link = e.target.getAttribute('data-link');
                const modalId = e.target.getAttribute('data-modal-toggle');

                // Find the modal and populate the form
                const modal = document.getElementById(modalId);
                if (modal) {
                    const titleInput = modal.querySelector('input[name="title"]');
                    const linkInput = modal.querySelector('input[name="link"]');

                    if (titleInput) titleInput.value = title;
                    if (linkInput) linkInput.value = link;
                }
            });
        });

        // Toggle Modals
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', (e) => {
                const modalId = e.target.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                modal.classList.toggle('hidden');
            });
        });
    });
</script>
@endsection
@endsection
