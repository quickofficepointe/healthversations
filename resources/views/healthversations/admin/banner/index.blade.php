@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Banners</h1>
        <!-- Add Banner Button -->
        <button onclick="openModal('addBannerModal')" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200">
            Add New Banner
        </button>
    </div>

    <!-- Banners Table -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="bannersTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtitle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="sortable-banners">
                    @foreach($banners as $banner)
                    <tr class="hover:bg-gray-50 transition duration-200" data-id="{{ $banner->id }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <span class="drag-handle cursor-move inline-block mr-2">↕️</span>
                            {{ $banner->order }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner Image" class="w-24 h-16 object-cover rounded-lg">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $banner->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $banner->subtitle }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $banner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <button onclick="openModal('editBannerModal{{ $banner->id }}')" 
                                        class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200">
                                    Edit
                                </button>
                                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this banner?');">
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

    <!-- Add Banner Modal -->
    <div id="addBannerModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Add New Banner</h3>
                <button onclick="closeModal('addBannerModal')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title*</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
                        <input type="text" name="subtitle" id="subtitle" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="mb-4">
                        <label for="button_text" class="block text-sm font-medium text-gray-700">Button Text</label>
                        <input type="text" name="button_text" id="button_text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="e.g. Learn More">
                    </div>
                    <div class="mb-4">
                        <label for="button_url" class="block text-sm font-medium text-gray-700">Button URL</label>
                        <input type="url" name="button_url" id="button_url" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="https://example.com">
                    </div>
                    <div class="mb-4">
                        <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
                        <input type="number" name="order" id="order" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" min="0">
                    </div>
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" checked>
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Banner Image*</label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>
                    <p class="mt-1 text-sm text-gray-500">Recommended size: 1920x600px</p>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" class="summernote mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('addBannerModal')" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Save Banner
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Banner Modals -->
    @foreach($banners as $banner)
    <div id="editBannerModal{{ $banner->id }}" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Edit Banner</h3>
                <button onclick="closeModal('editBannerModal{{ $banner->id }}')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="title{{ $banner->id }}" class="block text-sm font-medium text-gray-700">Title*</label>
                        <input type="text" name="title" id="title{{ $banner->id }}" value="{{ $banner->title }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="subtitle{{ $banner->id }}" class="block text-sm font-medium text-gray-700">Subtitle</label>
                        <input type="text" name="subtitle" id="subtitle{{ $banner->id }}" value="{{ $banner->subtitle }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="mb-4">
                        <label for="button_text{{ $banner->id }}" class="block text-sm font-medium text-gray-700">Button Text</label>
                        <input type="text" name="button_text" id="button_text{{ $banner->id }}" value="{{ $banner->button_text }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="mb-4">
                        <label for="button_url{{ $banner->id }}" class="block text-sm font-medium text-gray-700">Button URL</label>
                        <input type="url" name="button_url" id="button_url{{ $banner->id }}" value="{{ $banner->button_url }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="mb-4">
                        <label for="order{{ $banner->id }}" class="block text-sm font-medium text-gray-700">Order</label>
                        <input type="number" name="order" id="order{{ $banner->id }}" value="{{ $banner->order }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" min="0">
                    </div>
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" name="is_active" id="is_active{{ $banner->id }}" value="1" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" {{ $banner->is_active ? 'checked' : '' }}>
                        <label for="is_active{{ $banner->id }}" class="ml-2 block text-sm text-gray-700">Active</label>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="image{{ $banner->id }}" class="block text-sm font-medium text-gray-700">Banner Image</label>
                    <input type="file" name="image" id="image{{ $banner->id }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                    <p class="mt-1 text-sm text-gray-500">Current image:</p>
                    <img src="{{ asset('storage/' . $banner->image) }}" alt="Current Banner" class="mt-2 w-48 h-auto rounded-md">
                </div>
                <div class="mb-4">
                    <label for="description{{ $banner->id }}" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description{{ $banner->id }}" class="summernote mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">{{ $banner->description }}</textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('editBannerModal{{ $banner->id }}')" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Update Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    // Modal functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        // Reinitialize Summernote when modal opens
        setTimeout(() => {
            $(`#${modalId} .summernote`).summernote('destroy');
            $(`#${modalId} .summernote`).summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        }, 100);
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('fixed')) {
            e.target.classList.add('hidden');
        }
    });

    $(document).ready(function() {
        // Initialize Summernote for existing textareas
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Initialize Sortable for banner ordering
        new Sortable(document.getElementById('sortable-banners'), {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function() {
                const rows = document.querySelectorAll('#sortable-banners tr');
                const order = Array.from(rows).map(row => {
                    return { id: row.getAttribute('data-id'), position: Array.from(rows).indexOf(row) + 1 };
                });

                fetch("{{ route('admin.banners.update-order') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order })
                }).then(response => {
                    if (response.ok) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Order Updated',
                            text: 'Banner order has been updated successfully',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });
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
    });
</script>
@endsection