@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Blogs and Categories</h1>
        <!-- Add Category and Blog Buttons -->
        <div class="flex space-x-4">
            <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200" data-modal-toggle="addCategoryModal">
                Add Category
            </button>
            <button class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition duration-200" data-modal-toggle="addBlogModal">
                Add Blog
            </button>
        </div>
    </div>

    <!-- Blog Category Table -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
        <h2 class="text-xl font-semibold text-gray-800 p-4 border-b">Blog Categories</h2>
        <div class="overflow-x-auto">
            <table id="categoriesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Category Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Cover Image</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($blogcategory as $category)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $category->categoryname }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($category->description, 50) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            @if($category->cover_image)
                                <img src="{{ asset('storage/' . $category->cover_image) }}" alt="Cover Image" class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <button class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200"
                                        data-modal-toggle="editCategoryModal{{ $category->id }}">
                                    Edit
                                </button>
                               <form action="{{ route('blogscategory.destroy', $category->id) }}" method="POST"
      onsubmit="return confirm('Are you sure you want to delete the category: {{ addslashes($category->categoryname) }}?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg transition duration-200">
        <i class="fas fa-trash-alt mr-1"></i> Delete
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

    <!-- Blog Table -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
        <h2 class="text-xl font-semibold text-gray-800 p-4 border-b">Blogs</h2>
        <div class="overflow-x-auto">
            <table id="blogsTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Cover Image</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Blog Title</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($blog as $b)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset($b->cover_image) }}" alt="Cover Image" class="w-16 h-16 object-cover rounded-lg">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $b->blog_title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $b->category->categoryname }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <button class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200"
                                        data-modal-toggle="editBlogModal{{ $b->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('blogs.destroy', $b->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this blog?');">
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

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Add New Blog Category</h3>
                <button class="text-gray-400 hover:text-gray-500" data-modal-toggle="addCategoryModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('blogscategory.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="categoryname" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="categoryname" id="categoryname" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>
                <div class="mb-4">
                    <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover Image</label>
                    <input type="file" name="cover_image" id="cover_image" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="addCategoryModal">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

   <!-- Add Blog Modal -->
<div id="addBlogModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col">
        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b p-4 sticky top-0 bg-white z-10">
            <h3 class="text-xl font-bold text-gray-800">Add New Blog</h3>
            <button class="text-gray-500 hover:text-gray-700 transition-colors" data-modal-toggle="addBlogModal">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Modal Body - Scrollable Content -->
        <div class="overflow-y-auto flex-1 p-6">
            <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data" id="addBlogForm">
                @csrf
                <div class="space-y-4">
                    <!-- Category Select -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="blogcategory_id" id="category_id" class="w-full rounded border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                            @foreach($blogcategory as $category)
                                <option value="{{ $category->id }}">{{ $category->categoryname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Blog Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Blog Title</label>
                        <input type="text" name="blog_title" id="title" class="w-full rounded border-gray-300 focus:border-primary-500 focus:ring-primary-500" required>
                    </div>

                    <!-- Summernote Editor -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                        <div class="border border-gray-300 rounded">
                            <textarea name="blog_description" id="blogContent" class="summernote"></textarea>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                        <input type="text" name="tags" id="tags" class="w-full rounded border-gray-300 focus:border-primary-500 focus:ring-primary-500" placeholder="Laravel, PHP, Web Development">
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                        <input type="file" name="cover_image" id="cover_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-primary-600 file:text-white hover:file:bg-primary-700">
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="border-t p-4 sticky bottom-0 bg-white">
            <div class="flex justify-end space-x-3">
                <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded transition-colors" data-modal-toggle="addBlogModal">
                    Cancel
                </button>
                <button type="submit" form="addBlogForm" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                    Save Blog
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- Edit Category Modals -->
    @foreach($blogcategory as $category)
    <div id="editCategoryModal{{ $category->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Edit Blog Category</h3>
                <button class="text-gray-400 hover:text-gray-500" data-modal-toggle="editCategoryModal{{ $category->id }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('blogscategory.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_categoryname{{ $category->id }}" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="categoryname" id="edit_categoryname{{ $category->id }}"
                           value="{{ $category->categoryname }}"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>
                </div>
                <div class="mb-4">
                    <label for="edit_description{{ $category->id }}" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="edit_description{{ $category->id }}" rows="3"
                              class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">{{ $category->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="edit_cover_image{{ $category->id }}" class="block text-sm font-medium text-gray-700">Cover Image</label>
                    @if($category->cover_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $category->cover_image) }}" alt="Current Cover Image" class="w-16 h-16 object-cover rounded-lg">
                        </div>
                    @endif
                    <input type="file" name="cover_image" id="edit_cover_image{{ $category->id }}"
                           class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200"
                            data-modal-toggle="editCategoryModal{{ $category->id }}">
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

<!-- Edit Blog Modals -->
@foreach($blog as $b)
<div id="editBlogModal{{ $b->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-4/5 p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Edit Blog</h3>
            <button class="text-gray-400 hover:text-gray-500" data-modal-toggle="editBlogModal{{ $b->id }}">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('blogs.update', $b->id) }}" method="POST" enctype="multipart/form-data" id="editBlogForm{{ $b->id }}">
            @csrf
            @method('PUT')

            <!-- Hidden user_id field -->
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <div class="mb-4">
                <label for="edit_category_id{{ $b->id }}" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="blogcategory_id" id="edit_category_id{{ $b->id }}"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>
                    @foreach($blogcategory as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $b->blogcategory_id ? 'selected' : '' }}>
                            {{ $category->categoryname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="edit_title{{ $b->id }}" class="block text-sm font-medium text-gray-700">Blog Title</label>
                <input type="text" name="blog_title" id="edit_title{{ $b->id }}"
                       value="{{ $b->blog_title }}"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>
            </div>
            <div class="mb-4">
                <label for="edit_content{{ $b->id }}" class="block text-sm font-medium text-gray-700">Content</label>
                <div class="border border-gray-300 rounded">
                    <textarea name="blog_description" id="edit_content{{ $b->id }}" class="summernote">{{ $b->blog_description }}</textarea>
                </div>
            </div>
            <div class="mb-4">
                <label for="edit_tags{{ $b->id }}" class="block text-sm font-medium text-gray-700">Tags (comma separated)</label>
                <input type="text" name="tags" id="edit_tags{{ $b->id }}"
                       value="{{ $b->tags }}"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div class="mb-4">
                <label for="edit_cover_image{{ $b->id }}" class="block text-sm font-medium text-gray-700">Cover Image</label>
                @if($b->cover_image)
                    <div class="mb-2">
                        <img src="{{ asset($b->cover_image) }}" alt="Current Cover Image" class="w-16 h-16 object-cover rounded-lg">
                    </div>
                @endif
                <input type="file" name="cover_image" id="edit_cover_image{{ $b->id }}"
                       class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200"
                        data-modal-toggle="editBlogModal{{ $b->id }}">
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
        $('#categoriesTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search categories...",
            },
            columnDefs: [
                { orderable: false, targets: [2, 3] } // Image and Actions columns
            ],
            order: [[0, 'asc']] // Order by Name column by default
        });

        $('#blogsTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search blogs...",
            },
            columnDefs: [
                { orderable: false, targets: [0, 3] } // Image and Actions columns
            ],
            order: [[1, 'asc']] // Order by Title column by default
        });

        // Initialize Summernote
        $('.summernote').summernote({
            height: 300,
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

                // Check if it's a blog modal
                if (modalId.includes('BlogModal')) {
                    setTimeout(function() {
                        // Destroy and reinitialize Summernote in the modal
                        $(`#${modalId} .summernote`).summernote('destroy');
                        $(`#${modalId} .summernote`).summernote({
                            height: 300,
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

            // Reinitialize Summernote when blog modal is opened
            if (modalId.includes('BlogModal') && !modal.classList.contains('hidden')) {
                setTimeout(function() {
                    $(`#${modalId} .summernote`).summernote('destroy');
                    $(`#${modalId} .summernote`).summernote({
                        height: 300,
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

    // Close modals when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>
@endsection
@endsection
