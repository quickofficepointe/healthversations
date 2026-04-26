@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Video Links</h1>
        <!-- Add Video Button -->
        <button onclick="openModal('addVideoModal')" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200">
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
            <table id="videosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Video Link</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($videos as $video)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $video->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <a href="{{ $video->link }}" target="_blank" class="text-primary-600 hover:text-primary-700 break-all">{{ Str::limit($video->link, 50) }}</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <button onclick="openEditModal('{{ $video->id }}', '{{ $video->title }}', '{{ $video->link }}')" 
                                        class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200">
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
    <div id="addVideoModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Add New Video</h3>
                <button onclick="closeModal('addVideoModal')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('videos.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Video Title*</label>
                    <input type="text" name="title" id="title" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="mb-4">
                    <label for="link" class="block text-sm font-medium text-gray-700">Video URL*</label>
                    <input type="url" name="link" id="link" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="https://youtube.com/... or https://vimeo.com/...">
                    <p class="mt-1 text-sm text-gray-500">Supports YouTube, Vimeo, and other video platforms</p>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('addVideoModal')" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Save Video
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Video Modal -->
    <div id="editVideoModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Edit Video</h3>
                <button onclick="closeModal('editVideoModal')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editVideoForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_title" class="block text-sm font-medium text-gray-700">Video Title*</label>
                    <input type="text" name="title" id="edit_title" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="mb-4">
                    <label for="edit_link" class="block text-sm font-medium text-gray-700">Video URL*</label>
                    <input type="url" name="link" id="edit_link" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('editVideoModal')" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Update Video
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Modal functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Function to open edit modal with data
    function openEditModal(videoId, title, link) {
        // Set form action
        document.getElementById('editVideoForm').action = "{{ route('videos.update', '') }}/" + videoId;
        
        // Populate form fields
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_link').value = link;
        
        // Open modal
        openModal('editVideoModal');
    }

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

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fixed')) {
                e.target.classList.add('hidden');
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.fixed').forEach(modal => {
                    modal.classList.add('hidden');
                });
            }
        });

        // Clear add modal when closed
        document.getElementById('addVideoModal').addEventListener('click', function(e) {
            if (e.target === this) {
                document.getElementById('title').value = '';
                document.getElementById('link').value = '';
            }
        });
    });
</script>
@endsection