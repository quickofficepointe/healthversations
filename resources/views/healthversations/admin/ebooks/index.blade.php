@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Ebooks</h1>
        <!-- Add Ebook Button -->
        <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200" data-modal-toggle="addEbookModal">
            Add New Ebook
        </button>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Ebooks Table -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="ebooksTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Cover</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Ebook Price</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Hardcopy Price</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($ebooks as $ebook)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex-shrink-0 h-16 w-16">
                                <img class="h-16 w-16 rounded-md object-cover" src="{{ asset('storage/' . $ebook->cover_image) }}" alt="{{ $ebook->title }}">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $ebook->title }}</div>
                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($ebook->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            Ksh {{ number_format($ebook->ebook_price, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            @if($ebook->is_hardcopy_available)
                                Ksh {{ number_format($ebook->hardcopy_price, 2) }}
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $ebook->is_featured ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $ebook->is_featured ? 'Featured' : 'Regular' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-2">
                                <button class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200"
                                        data-modal-toggle="editEbookModal{{ $ebook->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('admin.ebooks.destroy', $ebook->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this ebook?');">
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

    <!-- Add Ebook Modal -->
    <div id="addEbookModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-3/4 p-6 max-h-[90vh] overflow-y-auto">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Add New Ebook</h3>
            <form action="{{ route('admin.ebooks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title*</label>
                        <input type="text" name="title" id="title" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover Image*</label>
                        <input type="file" name="cover_image" id="cover_image" accept="image/*" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                        <p class="mt-1 text-sm text-gray-500">Recommended size: 800x600px</p>
                    </div>

                    <!-- Ebook File -->
                    <div>
                        <label for="ebook_file" class="block text-sm font-medium text-gray-700">Ebook File (PDF)*</label>
                        <input type="file" name="ebook_file" id="ebook_file" accept=".pdf" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <!-- Ebook Price -->
                    <div>
                        <label for="ebook_price" class="block text-sm font-medium text-gray-700">Ebook Price (Ksh)*</label>
                        <input type="number" name="ebook_price" id="ebook_price" min="0" step="0.01" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <!-- Hardcopy Price -->
                    <div>
                        <label for="hardcopy_price" class="block text-sm font-medium text-gray-700">Hardcopy Price (Ksh)</label>
                        <input type="number" name="hardcopy_price" id="hardcopy_price" min="0" step="0.01" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                        <div class="flex items-center mt-2">
                            <input type="hidden" name="is_hardcopy_available" value="0">
                            <input type="checkbox" name="is_hardcopy_available" id="is_hardcopy_available" value="1" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_hardcopy_available" class="ml-2 block text-sm text-gray-700">Hardcopy Available</label>
                        </div>
                    </div>

                    <!-- Featured -->
                    <div class="flex items-center">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_featured" class="ml-2 block text-sm text-gray-700">Featured Ebook</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description*</label>
                    <textarea name="description" id="description" required class="summernote mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>

                <div class="mb-4">
                    <label for="preview_content" class="block text-sm font-medium text-gray-700">Preview Content*</label>
                    <textarea name="preview_content" id="preview_content" required class="summernote mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="addEbookModal">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Save Ebook
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Ebook Modals -->
    @foreach($ebooks as $ebook)
    <div id="editEbookModal{{ $ebook->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-3/4 p-6 max-h-[90vh] overflow-y-auto">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Edit Ebook</h3>
            <form action="{{ route('admin.ebooks.update', $ebook->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title{{ $ebook->id }}" class="block text-sm font-medium text-gray-700">Title*</label>
                        <input type="text" name="title" id="title{{ $ebook->id }}" value="{{ $ebook->title }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cover Image</label>
                        <input type="file" name="cover_image" id="cover_image{{ $ebook->id }}" accept="image/*" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                        @if($ebook->cover_image)
                        <p class="mt-1 text-sm text-gray-500">Current image:</p>
                        <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="Current Cover Image" class="mt-2 w-32 h-auto rounded">
                        @endif
                    </div>

                    <!-- Ebook File -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ebook File (PDF)</label>
                        <div class="mb-2">
                            <span class="text-sm text-gray-600">Current file: {{ basename($ebook->file_path) }}</span>
                        </div>
                        <input type="file" name="ebook_file" id="ebook_file{{ $ebook->id }}" accept=".pdf" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <!-- Ebook Price -->
                    <div>
                        <label for="ebook_price{{ $ebook->id }}" class="block text-sm font-medium text-gray-700">Ebook Price (Ksh)*</label>
                        <input type="number" name="ebook_price" id="ebook_price{{ $ebook->id }}" value="{{ $ebook->ebook_price }}" min="0" step="0.01" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <!-- Hardcopy Price -->
                    <div>
                        <label for="hardcopy_price{{ $ebook->id }}" class="block text-sm font-medium text-gray-700">Hardcopy Price (Ksh)</label>
                        <input type="number" name="hardcopy_price" id="hardcopy_price{{ $ebook->id }}" value="{{ $ebook->hardcopy_price }}" min="0" step="0.01" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                        <div class="flex items-center mt-2">
                            <input type="hidden" name="is_hardcopy_available" value="0">
                            <input type="checkbox" name="is_hardcopy_available" id="is_hardcopy_available{{ $ebook->id }}" value="1" {{ $ebook->is_hardcopy_available ? 'checked' : '' }} class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_hardcopy_available{{ $ebook->id }}" class="ml-2 block text-sm text-gray-700">Hardcopy Available</label>
                        </div>
                    </div>

                    <!-- Featured -->
                    <div class="flex items-center">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" id="is_featured{{ $ebook->id }}" value="1" {{ $ebook->is_featured ? 'checked' : '' }} class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_featured{{ $ebook->id }}" class="ml-2 block text-sm text-gray-700">Featured Ebook</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description{{ $ebook->id }}" class="block text-sm font-medium text-gray-700">Description*</label>
                    <textarea name="description" id="description{{ $ebook->id }}" required class="summernote mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">{{ $ebook->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="preview_content{{ $ebook->id }}" class="block text-sm font-medium text-gray-700">Preview Content*</label>
                    <textarea name="preview_content" id="preview_content{{ $ebook->id }}" required class="summernote mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">{{ $ebook->preview_content }}</textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="editEbookModal{{ $ebook->id }}">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Update Ebook
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
        $('#ebooksTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search ebooks...",
            },
            columnDefs: [
                { orderable: false, targets: [0, 5] } // Cover and Actions columns
            ]
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

        // Reinitialize Summernote when modals are opened
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', (e) => {
                const modalId = e.target.getAttribute('data-modal-toggle');

                // Check if it's an ebook modal
                if (modalId.includes('EbookModal')) {
                    setTimeout(function() {
                        // Destroy and reinitialize Summernote in the modal
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
    });

    // Toggle Modals
    document.querySelectorAll('[data-modal-toggle]').forEach(button => {
        button.addEventListener('click', (e) => {
            const modalId = e.target.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        });
    });
</script>
@endsection
@endsection
