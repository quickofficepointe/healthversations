@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Manage Packages and Categories</h1>

    <!-- Alerts -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Category Table -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Categories</h2>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-md" data-modal-toggle="addCategoryModal">Add Category</button>
        </div>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Category Name</th>
                    <th class="border border-gray-300 px-4 py-2">Slug</th>
                    <th class="border border-gray-300 px-4 py-2">Category Description</th>
                    <th class="border border-gray-300 px-4 py-2">Category Image</th>
                    <th class="border border-gray-300 px-4 py-2">Category Tags</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($packagecategory as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->category_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->slug }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->category_description }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if($category->category_image)
                                 <img src="{{ asset('storage/' .$category->category_image) }}" alt="Category Image" class="w-20 h-20 object-cover rounded">

                             @endif
                                 {{-- @if($card->cover_image)
                                <img src="{{ asset('storage/' . $card->cover_image) }}" alt="Cover Image" class="w-20 h-20 object-cover">
                            @else
                                No Image
                            @endif --}}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->category_tags }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <button class="bg-yellow-500 text-white px-2 py-1 rounded-md" data-modal-toggle="editCategoryModal_{{ $category->id }}">Edit</button>
                            <form action="{{ route('packagecategories.destroy', $category->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Category Modal -->
                    <div id="editCategoryModal_{{ $category->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
                        <div class="modal-content bg-white p-6 rounded-lg w-1/3">
                            <h3 class="text-xl font-semibold mb-4">Edit Category</h3>
                            <form action="{{ route('packagecategories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label for="category_name" class="block text-gray-700">Category Name</label>
                                    <input type="text" id="category_name" name="category_name" value="{{ $category->category_name }}" class="w-full border-gray-300 rounded-md p-2">
                                    @error('category_name')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="category_description" class="block text-gray-700">Category Description</label>
                                    <textarea id="category_description" name="category_description" class="w-full border-gray-300 rounded-md p-2">{{ $category->category_description }}</textarea>
                                    @error('category_description')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror


                                </div>

                                <div class="mb-4">
                                    <label for="category_image" class="block text-gray-700">Category Image</label>

                                    <input type="file" id="category_image" name="category_image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">

                                </div>
                                <div class="mb-4">
                                    <label for="category_tags" class="block text-gray-700">Category Tags</label>
                                    <input type="text" id="category_tags" name="category_tags" value="{{ $category->category_tags }}" class="w-full border-gray-300 rounded-md p-2">
                                    @error('category_tags')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
                                    <button type="button" class="bg-gray-300 text-black px-4 py-2 rounded-md ml-2" data-modal-toggle="editCategoryModal_{{ $category->id }}">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                @endforeach
            </tbody>
        </table>

    </div>

    <!-- Package Table -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Packages</h2>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-md" data-modal-toggle="addPackageModal">Add Package</button>
        </div>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Package Name</th>
                    <th class="border border-gray-300 px-4 py-2">Slug</th>
                    <th class="border border-gray-300 px-4 py-2">Description</th>
                    <th class="border border-gray-300 px-4 py-2">Tags</th>
                    <th class="border border-gray-300 px-4 py-2">Image</th>
                    <th class="border border-gray-300 px-4 py-2">Category</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($package as $pkg)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $pkg->package_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $pkg->slug }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $pkg->package_description }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $pkg->package_tags }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if($pkg->package_image)
                                <img src="{{ asset($pkg->package_image) }}" alt="Package Image" class="h-12 w-12 object-cover rounded">
                            @else
                                <span>No Image</span>
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $pkg->category->category_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <button class="bg-yellow-500 text-white px-2 py-1 rounded-md" data-modal-toggle="editPackageModal_{{ $pkg->id }}">Edit</button>
                            <form action="{{ route('packages.destroy', $pkg->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md"
                                        onclick="return confirm('Are you sure you want to delete this package?')">
                                    Delete
                                </button>
                            </form>


                        </td>
                    </tr>

                    <!-- Edit Package Modal -->
                    <div id="editPackageModal_{{ $pkg->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
                        <div class="modal-content bg-white p-6 rounded-lg w-1/3">
                            <h3 class="text-xl font-semibold mb-4">Edit Package</h3>
                            <form id="editPackageForm_{{ $pkg->id }}" action="{{ route('packages.update', $pkg->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="package_name" class="block text-gray-700">Package Name</label>
                                    <input type="text" id="package_name" name="package_name" value="{{ $pkg->package_name }}" class="w-full border-gray-300 rounded-md p-2">
                                    @error('package_name')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="slug" class="block text-gray-700">Slug</label>
                                    <input type="text" id="slug" name="slug" value="{{ $pkg->slug }}" class="w-full border-gray-300 rounded-md p-2">
                                    @error('slug')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="package_description" class="block text-gray-700">Package Description</label>
                                    <textarea id="package_description" name="package_description" class="w-full border-gray-300 rounded-md p-2">{{ $pkg->package_description }}</textarea>
                                    @error('package_description')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="package_tags" class="block text-gray-700">Package Tags</label>
                                    <input type="text" id="package_tags" name="package_tags" value="{{ $pkg->package_tags }}" class="w-full border-gray-300 rounded-md p-2">
                                    @error('package_tags')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="package_image" class="block text-gray-700">Package Image</label>
                                    <input type="file" id="package_image" name="package_image" class="w-full border-gray-300 rounded-md p-2">
                                    @if($pkg->package_image)
                                        <img src="{{ asset($pkg->package_image) }}" alt="Current Image" class="mt-2 h-12 w-12 object-cover rounded">
                                    @endif
                                    @error('package_image')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="category_id" class="block text-gray-700">Category</label>
                                    <select id="category_id" name="category_id" class="w-full border-gray-300 rounded-md p-2">
                                        @foreach($packagecategory as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $pkg->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
                                    <button type="button" class="bg-gray-300 text-black px-4 py-2 rounded-md ml-2" data-modal-toggle="editPackageModal_{{ $pkg->id }}">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
    <div class="modal-content bg-white p-6 rounded-lg w-1/3">
        <h3 class="text-xl font-semibold mb-4">Add New Category</h3>
        <form action="{{ route('packagecategories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="category_name" class="block text-gray-700">Category Name</label>
                <input type="text" id="category_name" name="category_name" class="w-full border-gray-300 rounded-md p-2" required>
                @error('category_name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="category_description" class="block text-gray-700">Category Description</label>
                <textarea id="category_description" name="category_description" class="w-full border-gray-300 rounded-md p-2"></textarea>
                @error('category_description')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="category_tag" class="block text-gray-700">Category Tag</label>
                <input type="text" id="category_tags" name="category_tags" class="w-full border-gray-300 rounded-md p-2">
                @error('category_tag')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700">Upload Image</label>
                <input type="file" id="category_image" name="category_image" class="w-full border-gray-300 rounded-md p-2">
                @error('image')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add</button>
                <button type="button" class="bg-gray-300 text-black px-4 py-2 rounded-md ml-2" data-modal-toggle="addCategoryModal">Cancel</button>
            </div>
        </form>
    </div>
</div>


<!-- Add Package Modal -->
<div id="addPackageModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
    <div class="modal-content bg-white p-6 rounded-lg w-1/3 max-h-[80vh] overflow-y-auto">
        <h3 class="text-xl font-semibold mb-4">Add New Package</h3>
        <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="package_name" class="block text-gray-700">Package Name</label>
                <input type="text" id="package_name" name="package_name" class="w-full border-gray-300 rounded-md p-2">
                @error('package_name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="slug" class="block text-gray-700">Slug</label>
                <input type="text" id="slug" name="slug" class="w-full border-gray-300 rounded-md p-2">
                @error('slug')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="package_description" class="block text-gray-700">Package Description</label>
                <textarea id="package_description" name="package_description" class="w-full border-gray-300 rounded-md p-2"></textarea>
                @error('package_description')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="package_tags" class="block text-gray-700">Package Tags</label>
                <input type="text" id="package_tags" name="package_tags" class="w-full border-gray-300 rounded-md p-2">
                @error('package_tags')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="package_image" class="block text-gray-700">Package Image</label>
                <input type="file" id="package_image" name="package_image" class="w-full border-gray-300 rounded-md p-2">

            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Category</label>
                <select id="category_id" name="category_id" class="w-full border-gray-300 rounded-md p-2">
                    @foreach($packagecategory as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add</button>
                <button type="button" class="bg-gray-300 text-black px-4 py-2 rounded-md ml-2" data-modal-toggle="addPackageModal">Cancel</button>
            </div>
        </form>
    </div>
</div>



<!-- JavaScript to Handle Modal Toggle -->
<script>
    document.querySelectorAll('[data-modal-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        });
    });
</script>
@endsection
