@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Banners</h1>
        <!-- Add Banner Button -->
        <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200" data-modal-toggle="addBannerModal">
            Add New Banner
        </button>
    </div>

    <!-- Banners Table -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="bannersTable" class="table table-striped table-bordered" style="width:100%">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Image</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Subtitle</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="sortable-banners">
                    @foreach($banners as $banner)
                    <tr class="hover:bg-gray-50 transition duration-200" data-id="{{ $banner->id }}">
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <span class="drag-handle cursor-move">↕️</span>
                            {{ $banner->order }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner Image" class="w-24 h-16 object-cover rounded-lg">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $banner->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $banner->subtitle }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $banner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-2">
                                <button class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200"
                                        data-modal-toggle="editBannerModal{{ $banner->id }}">
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
    <div id="addBannerModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Add New Banner</h3>
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
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="addBannerModal">
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
    <div id="editBannerModal{{ $banner->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Edit Banner</h3>
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
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="editBannerModal{{ $banner->id }}">
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#bannersTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search banners...",
            },
            columnDefs: [
                { orderable: true, targets: [0, 1, 2, 3, 4] },
                { orderable: false, targets: [5] } // Actions column
            ],
            order: [[0, 'asc']] // Order by the first column (Order) by default
        });

        // Initialize Summernote
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
            ],
            callbacks: {
                onInit: function() {
                    // Fix z-index issues
                    $('.note-modal').each(function() {
                        $(this).css('z-index', '1055');
                    });

                    // Fix button styles to match Bootstrap
                    $('.note-btn').removeClass('btn-light').addClass('btn-outline-secondary');
                }
            }
        });

        // Toggle Modals
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', (e) => {
                const modalId = e.target.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                modal.classList.toggle('hidden');

                // Reinitialize Summernote when modal is opened
                if (!modal.classList.contains('hidden')) {
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
                    }, 300);
                }
            });
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
                        // Reload the DataTable to reflect the new order
                        $('#bannersTable').DataTable().ajax.reload();
                    }
                });
            }
        });

        // Toggle banner status
        document.querySelectorAll('[data-toggle-status]').forEach(button => {
            button.addEventListener('click', async function() {
                const bannerId = this.getAttribute('data-banner-id');
                const response = await fetch(`/admin/banners/${bannerId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                if (data.success) {
                    const statusElement = document.querySelector(`#status-${bannerId}`);
                    statusElement.textContent = data.is_active ? 'Active' : 'Inactive';
                    statusElement.className = `px-2 py-1 rounded-full text-xs font-medium ${data.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;

                    // Show success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Updated',
                        text: 'Banner status has been updated successfully',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        background: '#f0fdf4',
                        iconColor: '#16a34a'
                    });
                }
            });
        });
    });
</script>
@endsection
@endsection
