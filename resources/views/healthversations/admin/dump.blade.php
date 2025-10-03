@extends('healthversations.admin.layout.adminlayout')

@section('content')
@if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
        <h3 class="font-medium">Please fix the following errors:</h3>
        <ul class="mt-1 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Product Management</h1>
            <p class="text-gray-600 mt-1">Manage your products and categories</p>
        </div>
        <div class="flex flex-wrap gap-3 mt-4 md:mt-0">
            <button id="showCategoryModalBtn" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-200 flex items-center">
                <i class="fas fa-folder-plus mr-2"></i> Add Category
            </button>
            <button id="showProductModalBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Add Product
            </button>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Product Categories</h2>
            <span class="text-sm text-gray-500">{{ $productcategory->count() }} categories</span>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table id="categoriesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tag</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($productcategory as $category)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->category_name }}" class="h-10 w-10 rounded-lg object-cover shadow-sm">
                            @else
                                <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-folder text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $category->category_name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600 max-w-xs">{{ Str::limit($category->category_description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-primary-100 text-primary-800">
                                {{ $category->category_tag }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $category->products->count() }} products
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <!-- Edit Button -->
                                <button onclick="openEditCategoryModal({{ $category->id }})"
                                    class="text-primary-600 hover:text-primary-800 p-1 rounded-md hover:bg-primary-50 transition duration-150"
                                    title="Edit category">
                                    <i class="fas fa-edit fa-sm"></i>
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('productcategories.destroy', $category->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 p-1 rounded-md hover:bg-red-50 transition duration-150"
                                        title="Delete category">
                                        <i class="fas fa-trash fa-sm"></i>
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

    <!-- Products Table -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Products</h2>
            <span class="text-sm text-gray-500">{{ $products->count() }} products</span>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table id="productsTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price (KES)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price (USD)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    @if($product->cover_image)
                                        <img class="h-12 w-12 rounded-lg object-cover shadow-sm" src="{{ asset($product->cover_image) }}" alt="{{ $product->product_name }}">
                                    @else
                                        <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-box text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->product_name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit(strip_tags($product->description), 40) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-primary-100 text-primary-800">
                                {{ $product->category->category_name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->has_variations)
                                <div class="flex flex-col">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mb-1">
                                        {{ $product->variants->count() }} variants
                                    </span>
                                    <div class="text-xs text-gray-500">
                                        @foreach($product->variants->take(2) as $variant)
                                            <div>{{ $variant->display_name }}</div>
                                        @endforeach
                                        @if($product->variants->count() > 2)
                                            <div>+{{ $product->variants->count() - 2 }} more</div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Simple
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            @if($product->has_variations)
                                KES {{ number_format($product->variants->min('price_kes'), 2) }} - {{ number_format($product->variants->max('price_kes'), 2) }}
                            @else
                                KES {{ number_format($product->price_kes, 2) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            @if($product->has_variations)
                                ${{ number_format($product->variants->min('price_usd'), 2) }} - {{ number_format($product->variants->max('price_usd'), 2) }}
                            @else
                                ${{ number_format($product->price_usd, 2) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->has_variations)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $product->variants->sum('stock') }} total
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $product->stock }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <!-- Edit Button -->
                                <button onclick="openEditModal({{ $product->id }})"
                                    class="text-primary-600 hover:text-primary-800 p-1 rounded-md hover:bg-primary-50 transition duration-150"
                                    title="Edit product">
                                    <i class="fas fa-edit fa-sm"></i>
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 p-1 rounded-md hover:bg-red-50 transition duration-150"
                                        title="Delete product">
                                        <i class="fas fa-trash fa-sm"></i>
                                    </button>
                                </form>

                                <!-- Variants Button -->
                                @if($product->has_variations)
                                <button onclick="manageVariants({{ $product->id }})"
                                    class="text-green-600 hover:text-green-800 p-1 rounded-md hover:bg-green-50 transition duration-150"
                                    title="Manage variants">
                                    <i class="fas fa-cubes fa-sm"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Product Category Modal -->
<div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Add New Product Category</h2>
            <button onclick="closeModal('categoryModal')" class="text-gray-400 hover:text-gray-600 transition duration-150">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form action="{{ route('productcategories.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div>
                <label for="category_name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                <input type="text" id="category_name" name="category_name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
            </div>
            <div>
                <label for="category_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="category_description" name="category_description" required rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200"></textarea>
            </div>
            <div>
                <label for="category_tag" class="block text-sm font-medium text-gray-700 mb-2">Category Tag</label>
                <input type="text" id="category_tag" name="category_tag" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category Image</label>
                <div class="flex items-center space-x-4">
                    <div id="categoryImagePreview" class="hidden">
                        <img id="categoryPreviewImage" class="h-20 w-20 rounded-lg object-cover border shadow-sm" src="#" alt="Preview">
                    </div>
                    <label class="cursor-pointer">
                        <div class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-200 flex items-center">
                            <i class="fas fa-image mr-2"></i>
                            <span>Choose Image</span>
                        </div>
                        <input type="file" id="image" name="image" class="hidden" accept="image/*" onchange="previewCategoryImage(this)">
                    </label>
                </div>
                <p class="mt-1 text-sm text-gray-500">JPG, PNG, or GIF (Max 2MB)</p>
            </div>
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeModal('categoryModal')"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-200">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Product Modal -->
<div id="productModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Add New Product</h2>
            <button onclick="closeModal('productModal')" class="text-gray-400 hover:text-gray-600 transition duration-150">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Basic Product Info -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Basic Information</h3>
                    <div>
                        <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">Product Name*</label>
                        <input type="text" id="product_name" name="product_name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                    </div>
                    <div>
                        <label for="product_description" class="block text-sm font-medium text-gray-700 mb-2">Description*</label>
                        <textarea id="product_description" name="description" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 summernote"></textarea>
                    </div>
                    <div>
                        <label for="product_category" class="block text-sm font-medium text-gray-700 mb-2">Category*</label>
                        <div class="flex">
                            <select name="category_id" id="product_category" required
                                class="flex-grow px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                <option value="" selected disabled>Select Category</option>
                                @foreach($productcategory as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            <button type="button" id="addCategoryBtn"
                                class="px-4 py-2 bg-primary-600 text-white rounded-r-lg hover:bg-primary-700 transition duration-200">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="product_tags" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                        <input type="text" id="product_tags" name="tags"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                    </div>
                    <div>
                        <label for="product_keywords" class="block text-sm font-medium text-gray-700 mb-2">Keywords</label>
                        <input type="text" id="product_keywords" name="meta_keywords"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                    </div>
                </div>

                <!-- Product Configuration -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Configuration</h3>

                    <!-- Product Type Selection -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Product Type*</label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="has_variations" value="0" checked
                                       class="form-radio text-green-600" onchange="toggleProductType(this)">
                                <span class="ml-2">Simple Product</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="has_variations" value="1"
                                       class="form-radio text-green-600" onchange="toggleProductType(this)">
                                <span class="ml-2">Product with Variants</span>
                            </label>
                        </div>
                    </div>

                    <!-- Simple Product Section -->
                    <div id="simpleProductSection">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="price_kes" class="block text-sm font-medium text-gray-700 mb-2">Price (KES)*</label>
                                <input type="number" id="price_kes" name="price_kes" step="0.01" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            </div>
                            <div>
                                <label for="price_usd" class="block text-sm font-medium text-gray-700 mb-2">Price (USD)*</label>
                                <input type="number" id="price_usd" name="price_usd" step="0.01" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stock*</label>
                            <input type="number" id="stock" name="stock" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>

                    <!-- Variant Product Section -->
                    <div id="variantProductSection" class="hidden space-y-4">
                        <div>
                            <label for="measurement_unit" class="block text-sm font-medium text-gray-700 mb-2">Measurement Unit*</label>
                            <select id="measurement_unit" name="measurement_unit" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                <option value="">Select Unit</option>
                                <option value="kg">Kilograms (kg)</option>
                                <option value="g">Grams (g)</option>
                                <option value="L">Liters (L)</option>
                                <option value="ml">Milliliters (ml)</option>
                                <option value="pcs">Pieces (pcs)</option>
                            </select>
                        </div>

                        <div id="variantsContainer" class="space-y-4">
                            <!-- Variants will be added here -->
                        </div>

                        <button type="button" onclick="addVariant()"
                                class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-200">
                            <i class="fas fa-plus mr-2"></i> Add Variant
                        </button>
                    </div>

                    <!-- Images Section -->
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-700 mb-2">Images</h4>
                        <div class="space-y-4">
                            <div>
                                <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">Cover Image*</label>
                                <div class="flex items-center space-x-4">
                                    <div id="coverImagePreview" class="hidden">
                                        <img id="coverPreviewImage" class="h-20 w-20 rounded-lg object-cover border shadow-sm" src="#" alt="Preview">
                                    </div>
                                    <label class="cursor-pointer">
                                        <div class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-200 flex items-center">
                                            <i class="fas fa-image mr-2"></i>
                                            <span>Choose Cover Image</span>
                                        </div>
                                        <input type="file" id="cover_image" name="cover_image" class="hidden" accept="image/*" onchange="previewCoverImage(this)" required>
                                    </label>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">JPG, PNG, or GIF (Max 2MB)</p>
                            </div>
                            <div>
                                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Additional Images</label>
                                <div id="additionalImagesPreview" class="flex flex-wrap gap-2 mb-2"></div>
                                <label class="cursor-pointer">
                                    <div class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-200 flex items-center">
                                        <i class="fas fa-images mr-2"></i>
                                        <span>Choose Multiple Images</span>
                                    </div>
                                    <input type="file" id="images" name="images[]" multiple class="hidden" accept="image/*" onchange="previewAdditionalImages(this)">
                                </label>
                                <p class="mt-1 text-sm text-gray-500">Select multiple JPG, PNG, or GIF files (Max 2MB each)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-6 mt-6 border-t border-gray-200">
                <button type="button" onclick="closeModal('productModal')"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 max-h-screen overflow-y-auto">
        <!-- Content will be loaded dynamically -->
    </div>
</div>

<!-- Variant Management Modal -->
<div id="variantModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-2/3 p-6 max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800" id="variantModalTitle">Product Variants</h2>
            <button onclick="closeModal('variantModal')" class="text-gray-400 hover:text-gray-600 transition duration-150">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <div id="variantModalContent">
            <!-- Content will be loaded here dynamically -->
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTables with responsive plugin
        $('#categoriesTable').DataTable({
            responsive: true,
            dom: "<'flex flex-col md:flex-row md:items-center md:justify-between mb-4'<'mb-4 md:mb-0'l><'flex flex-col sm:flex-row sm:items-center'<'mb-2 sm:mb-0 sm:mr-4'f><'dt-buttons'B>>>" +
                 "<'w-full overflow-x-auto'tr>" +
                 "<'flex flex-col md:flex-row md:items-center md:justify-between mt-4'<'mb-4 md:mb-0'i><'p'>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search categories...",
            },
            buttons: [
                {
                    extend: 'copy',
                    className: 'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 mb-2 sm:mb-0 sm:mr-2'
                },
                {
                    extend: 'csv',
                    className: 'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 mb-2 sm:mb-0 sm:mr-2'
                },
                {
                    extend: 'excel',
                    className: 'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 mb-2 sm:mb-0 sm:mr-2'
                },
                {
                    extend: 'pdf',
                    className: 'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 mb-2 sm:mb-0 sm:mr-2'
                },
                {
                    extend: 'print',
                    className: 'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200'
                }
            ],
            columnDefs: [
                { orderable: false, targets: [0, 5] } // Image and Actions columns
            ],
            order: [[1, 'asc']] // Order by Name column by default
        });

        $('#productsTable').DataTable({
            responsive: true,
            dom: "<'flex flex-col md:flex-row md:items-center md:justify-between mb-4'<'mb-4 md:mb-0'l><'flex flex-col sm:flex-row sm:items-center'<'mb-2 sm:mb-0 sm:mr-4'f><'dt-buttons'B>>>" +
                 "<'w-full overflow-x-auto'tr>" +
                 "<'flex flex-col md:flex-row md:items-center md:justify-between mt-4'<'mb-4 md:mb-0'i><'p'>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search products...",
            },
            buttons: [
                {
                    extend: 'copy',
                    className: 'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 mb-2 sm:mb-0 sm:mr-2'
                },
                {
                    extend: 'csv',
                    className: 'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 mb-2 sm:mb-0 sm:mr-2'
                },
                {
                    extend: 'excel',
                    className: 'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 mb-2 sm:mb-0 sm:mr-2'
                },
                {
                    extend: 'pdf',
                    className: 'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 mb-2 sm:mb-0 sm:mr-2'
                },
                {
                    extend: 'print',
                    className: 'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200'
                }
            ],
            columnDefs: [
                { orderable: false, targets: [0, 6] } // Product image and Actions columns
            ],
            order: [[0, 'asc']] // Order by Product name by default
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
                onChange: function(contents) {
                    // Trigger change event for form validation
                    $(this).val(contents).trigger('change');
                }
            }
        });
    });

    // Toggle between simple and variant product types
    function toggleProductType(radio) {
        const isVariant = radio.value === '1';

        // Toggle sections visibility
        document.getElementById('simpleProductSection').classList.toggle('hidden', isVariant);
        document.getElementById('variantProductSection').classList.toggle('hidden', !isVariant);

        // Set required fields
        document.getElementById('price_kes').required = !isVariant;
        document.getElementById('price_usd').required = !isVariant;
        document.getElementById('stock').required = !isVariant;
        document.getElementById('measurement_unit').required = isVariant;

        // Clear variants if switching to simple product
        if (!isVariant) {
            document.getElementById('variantsContainer').innerHTML = '';
        } else if (document.querySelectorAll('.variant-item').length === 0) {
            // Add first variant if none exists
            addVariant();
        }
    }

    // Add a new variant
    function addVariant() {
        const container = document.getElementById('variantsContainer');
        const variantId = Date.now();
        const measurementUnit = document.getElementById('measurement_unit').value || 'unit';

        const variantDiv = document.createElement('div');
        variantDiv.className = 'variant-item border border-gray-200 p-4 rounded-lg';
        variantDiv.dataset.id = variantId;

        variantDiv.innerHTML = `
            <div class="flex justify-between items-center mb-3">
                <h5 class="font-medium text-gray-700">Variant</h5>
                <button type="button" onclick="removeVariant(${variantId})" class="text-red-500 hover:text-red-700 transition duration-150">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="variant_quantity_${variantId}" class="block text-sm font-medium text-gray-700 mb-1">Quantity*</label>
                    <input type="number" id="variant_quantity_${variantId}" name="variants[${variantId}][quantity]" required min="0" step="0.01"
                        class="w
