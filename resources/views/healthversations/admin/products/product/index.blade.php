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

<div class="container mx-auto p-6">
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

<!-- Edit Product Modal -->
<div id="editProductModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Edit Product</h2>
            <button onclick="closeModal('editProductModal')" class="text-gray-400 hover:text-gray-600 transition duration-150">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <div id="editProductModalContent" class="p-6">
            <!-- Content will be loaded here dynamically -->
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Edit Category</h2>
            <button onclick="closeModal('editCategoryModal')" class="text-gray-400 hover:text-gray-600 transition duration-150">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <div id="editCategoryModalContent" class="p-6">
            <!-- Content will be loaded here dynamically -->
        </div>
    </div>
</div>

<!-- Variant Management Modal -->
<div id="variantModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800" id="variantModalTitle">Product Variants</h2>
            <button onclick="closeModal('variantModal')" class="text-gray-400 hover:text-gray-600 transition duration-150">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <div id="variantModalContent" class="p-6">
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

    // Initialize product form when modal opens
    initializeProductFormHandlers();
});

// Initialize product form handlers
function initializeProductFormHandlers() {
    // Set up radio button change listeners
    document.querySelectorAll('input[name="has_variations"]').forEach(radio => {
        radio.addEventListener('change', function() {
            toggleProductType(this);
        });
    });

    // Set up form submission handler for product form
    const productForm = document.querySelector('form[action="{{ route("products.store") }}"]');
    if (productForm) {
        productForm.addEventListener('submit', function(e) {
            if (!handleProductFormSubmit(this)) {
                e.preventDefault();
            }
        });
    }

    // Set up measurement unit change listener
    document.getElementById('measurement_unit')?.addEventListener('change', function() {
        document.querySelectorAll('.variant-item').forEach(item => {
            const variantId = item.dataset.id;
            updateVariantDisplayName(variantId);
        });
    });
}

// Toggle between simple and variant product types - FIXED VERSION
function toggleProductType(radio) {
    const isVariant = radio.value === '1';

    // Toggle sections visibility
    document.getElementById('simpleProductSection').classList.toggle('hidden', isVariant);
    document.getElementById('variantProductSection').classList.toggle('hidden', !isVariant);

    // Get form elements
    const priceKesInput = document.getElementById('price_kes');
    const priceUsdInput = document.getElementById('price_usd');
    const stockInput = document.getElementById('stock');
    const measurementUnitInput = document.getElementById('measurement_unit');

    // Remove required attribute when hidden, add when visible
    if (priceKesInput) {
        if (isVariant) {
            priceKesInput.removeAttribute('required');
            priceKesInput.value = ''; // Clear value when hidden
        } else {
            priceKesInput.required = true;
        }
    }

    if (priceUsdInput) {
        if (isVariant) {
            priceUsdInput.removeAttribute('required');
            priceUsdInput.value = ''; // Clear value when hidden
        } else {
            priceUsdInput.required = true;
        }
    }

    if (stockInput) {
        if (isVariant) {
            stockInput.removeAttribute('required');
            stockInput.value = ''; // Clear value when hidden
        } else {
            stockInput.required = true;
        }
    }

    if (measurementUnitInput) {
        if (!isVariant) {
            measurementUnitInput.removeAttribute('required');
            measurementUnitInput.value = ''; // Clear value when hidden
        } else {
            measurementUnitInput.required = true;
        }
    }

    // Clear variants if switching to simple product
    if (!isVariant) {
        document.getElementById('variantsContainer').innerHTML = '';
    } else if (document.querySelectorAll('.variant-item').length === 0) {
        // Add first variant if none exists
        addVariant();
    }
}

// Handle product form submission - FIXED VERSION
function handleProductFormSubmit(form) {
    const isVariant = form.querySelector('input[name="has_variations"]:checked').value === '1';

    // Remove all required attributes first to prevent browser validation issues
    const allRequired = form.querySelectorAll('[required]');
    allRequired.forEach(field => field.removeAttribute('required'));

    // Clear any validation messages
    clearValidationErrors();

    let isValid = true;
    const errors = [];

    // Validate based on product type
    if (!isVariant) {
        // Simple product validation
        const priceKes = form.querySelector('[name="price_kes"]');
        const priceUsd = form.querySelector('[name="price_usd"]');
        const stock = form.querySelector('[name="stock"]');

        if (!priceKes?.value) {
            errors.push('Price (KES) is required for simple products');
            isValid = false;
        }

        if (!priceUsd?.value) {
            errors.push('Price (USD) is required for simple products');
            isValid = false;
        }

        if (!stock?.value) {
            errors.push('Stock is required for simple products');
            isValid = false;
        }
    } else {
        // Variant product validation
        const measurementUnit = form.querySelector('[name="measurement_unit"]');
        const variants = form.querySelectorAll('.variant-item');

        if (!measurementUnit?.value) {
            errors.push('Measurement unit is required for variant products');
            isValid = false;
        }

        if (variants.length === 0) {
            errors.push('At least one variant is required for variant products');
            isValid = false;
        } else {
            // Validate each variant
            variants.forEach((variant, index) => {
                const quantity = variant.querySelector('input[name*="[quantity]"]');
                const priceKes = variant.querySelector('input[name*="[price_kes]"]');
                const priceUsd = variant.querySelector('input[name*="[price_usd]"]');
                const stock = variant.querySelector('input[name*="[stock]"]');

                if (!quantity?.value) {
                    errors.push(`Variant ${index + 1}: Quantity is required`);
                    isValid = false;
                }
                if (!priceKes?.value) {
                    errors.push(`Variant ${index + 1}: Price (KES) is required`);
                    isValid = false;
                }
                if (!priceUsd?.value) {
                    errors.push(`Variant ${index + 1}: Price (USD) is required`);
                    isValid = false;
                }
                if (!stock?.value) {
                    errors.push(`Variant ${index + 1}: Stock is required`);
                    isValid = false;
                }
            });
        }
    }

    // Show errors if any
    if (!isValid) {
        showValidationErrors(errors);
        return false;
    }

    return true;
}

// Clear validation errors
function clearValidationErrors() {
    const existingErrors = document.querySelectorAll('.dynamic-validation-error');
    existingErrors.forEach(error => error.remove());
}

// Show validation errors
function showValidationErrors(errors) {
    clearValidationErrors();

    const errorHtml = `
        <div class="dynamic-validation-error bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
            <h3 class="font-medium">Please fix the following errors:</h3>
            <ul class="mt-1 list-disc list-inside text-sm">
                ${errors.map(error => `<li>${error}</li>`).join('')}
            </ul>
        </div>
    `;

    const form = document.querySelector('form[action="{{ route("products.store") }}"]');
    if (form) {
        form.insertAdjacentHTML('afterbegin', errorHtml);

        // Scroll to top to show errors
        window.scrollTo({ top: 0, behavior: 'smooth' });
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
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500" oninput="updateVariantDisplayName(${variantId})">
            </div>
            <div>
                <label for="variant_price_kes_${variantId}" class="block text-sm font-medium text-gray-700 mb-1">Price (KES)*</label>
                <input type="number" id="variant_price_kes_${variantId}" name="variants[${variantId}][price_kes]" required min="0" step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label for="variant_price_usd_${variantId}" class="block text-sm font-medium text-gray-700 mb-1">Price (USD)*</label>
                <input type="number" id="variant_price_usd_${variantId}" name="variants[${variantId}][price_usd]" required min="0" step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <label for="variant_stock_${variantId}" class="block text-sm font-medium text-gray-700 mb-1">Stock*</label>
                <input type="number" id="variant_stock_${variantId}" name="variants[${variantId}][stock]" required min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label for="variant_display_${variantId}" class="block text-sm font-medium text-gray-700 mb-1">Display Name</label>
                <input type="text" id="variant_display_${variantId}" name="variants[${variantId}][display_name]" readonly
                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
            </div>
        </div>
        <div class="mt-4">
            <label for="variant_image_${variantId}" class="block text-sm font-medium text-gray-700 mb-1">Image (Optional)</label>
            <input type="file" id="variant_image_${variantId}" name="variants[${variantId}][image]"
                class="w-full px-3 py-2 border border-gray-300 rounded-md">
        </div>
    `;

    container.appendChild(variantDiv);
    updateVariantDisplayName(variantId);
}

// Update variant display name based on quantity and measurement unit
function updateVariantDisplayName(variantId) {
    const quantityInput = document.getElementById(`variant_quantity_${variantId}`);
    const displayInput = document.getElementById(`variant_display_${variantId}`);
    const measurementUnit = document.getElementById('measurement_unit').value || 'unit';

    if (quantityInput && displayInput) {
        const quantity = parseFloat(quantityInput.value);
        if (!isNaN(quantity)) {
            displayInput.value = `${quantity}${measurementUnit}`;
        }
    }
}

// Remove a variant
function removeVariant(id) {
    const element = document.querySelector(`.variant-item[data-id="${id}"]`);
    if (element) {
        element.remove();
    }
}

// Preview category image
function previewCategoryImage(input) {
    const preview = document.getElementById('categoryImagePreview');
    const previewImage = document.getElementById('categoryPreviewImage');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Preview cover image
function previewCoverImage(input) {
    const preview = document.getElementById('coverImagePreview');
    const previewImage = document.getElementById('coverPreviewImage');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Preview additional images
function previewAdditionalImages(input) {
    const previewContainer = document.getElementById('additionalImagesPreview');
    previewContainer.innerHTML = '';

    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'relative';
                imgContainer.innerHTML = `
                    <img src="${e.target.result}" class="h-20 w-20 object-cover rounded-lg border shadow-sm">
                    <button type="button" onclick="removePreviewImage(this)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 transition duration-150">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                previewContainer.appendChild(imgContainer);
            }
            reader.readAsDataURL(file);
        });
    }
}

// Remove preview image
function removePreviewImage(button) {
    button.parentElement.remove();
}

// Modal controls
document.getElementById('showCategoryModalBtn').addEventListener('click', function() {
    document.getElementById('categoryModal').classList.remove('hidden');
});

document.getElementById('showProductModalBtn').addEventListener('click', function() {
    document.getElementById('productModal').classList.remove('hidden');
    // Initialize the form state when modal opens
    initializeProductForm();
});

document.getElementById('addCategoryBtn').addEventListener('click', function() {
    closeModal('productModal');
    document.getElementById('categoryModal').classList.remove('hidden');
});

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    // Clear any validation errors when closing modal
    clearValidationErrors();
}

function initializeProductForm() {
    // Reset the form state
    const checkedRadio = document.querySelector('input[name="has_variations"]:checked');

    if (checkedRadio) {
        toggleProductType(checkedRadio);
    } else {
        // Default to simple product
        const simpleRadio = document.querySelector('input[name="has_variations"][value="0"]');
        if (simpleRadio) {
            simpleRadio.checked = true;
            toggleProductType(simpleRadio);
        }
    }

    // Clear any existing variants
    document.getElementById('variantsContainer').innerHTML = '';

    // Clear any validation errors
    clearValidationErrors();
}

// Function to open edit product modal
function openEditModal(productId) {
    // Show loading state
    const modal = document.getElementById('editProductModal');
    const modalContent = document.getElementById('editProductModalContent');
    modalContent.innerHTML = `
        <div class="flex justify-center items-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
            <span class="ml-3 text-gray-600">Loading product data...</span>
        </div>
    `;
    modal.classList.remove('hidden');

    // Fetch product data via AJAX
    fetch(`/admin/products/${productId}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Populate the modal with the edit form
                modalContent.innerHTML = `
                    <form action="/allproducts/${productId}" method="POST" enctype="multipart/form-data" id="editProductForm">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Basic Information</h3>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name*</label>
                                    <input type="text" name="product_name" value="${escapeHtml(data.product.product_name)}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description*</label>
                                    <textarea name="description" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg summernote">${escapeHtml(data.product.description)}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category*</label>
                                    <select name="category_id" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                        <option value="" disabled>Select Category</option>
                                        @foreach($productcategory as $category)
                                            <option value="{{ $category->id }}" ${data.product.category_id == {{ $category->id }} ? 'selected' : ''}>{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                                    <input type="text" name="tags" value="${escapeHtml(data.product.tags || '')}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Keywords</label>
                                    <input type="text" name="meta_keywords" value="${escapeHtml(data.product.meta_keywords || '')}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                </div>
                            </div>
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Product Configuration</h3>

                                <!-- Product Type Selection -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Type*</label>
                                    <div class="flex space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="has_variations" value="0" ${!data.product.has_variations ? 'checked' : ''}
                                                   class="form-radio text-green-600" onchange="toggleProductTypeEdit(this)">
                                            <span class="ml-2">Simple Product</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="has_variations" value="1" ${data.product.has_variations ? 'checked' : ''}
                                                   class="form-radio text-green-600" onchange="toggleProductTypeEdit(this)">
                                            <span class="ml-2">Product with Variants</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Simple Product Section -->
                                <div id="simpleProductSectionEdit" class="${data.product.has_variations ? 'hidden' : ''}">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Price (KES)*</label>
                                            <input type="number" name="price_kes" value="${data.product.price_kes || ''}" step="0.01" ${!data.product.has_variations ? 'required' : ''}
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Price (USD)*</label>
                                            <input type="number" name="price_usd" value="${data.product.price_usd || ''}" step="0.01" ${!data.product.has_variations ? 'required' : ''}
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock*</label>
                                        <input type="number" name="stock" value="${data.product.stock || ''}" ${!data.product.has_variations ? 'required' : ''}
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                    </div>
                                </div>

                                <!-- Variant Product Section -->
                                <div id="variantProductSectionEdit" class="${data.product.has_variations ? '' : 'hidden'} space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Measurement Unit*</label>
                                        <select name="measurement_unit" ${data.product.has_variations ? 'required' : ''}
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                            <option value="">Select Unit</option>
                                            <option value="kg" ${data.product.measurement_unit === 'kg' ? 'selected' : ''}>Kilograms (kg)</option>
                                            <option value="g" ${data.product.measurement_unit === 'g' ? 'selected' : ''}>Grams (g)</option>
                                            <option value="L" ${data.product.measurement_unit === 'L' ? 'selected' : ''}>Liters (L)</option>
                                            <option value="ml" ${data.product.measurement_unit === 'ml' ? 'selected' : ''}>Milliliters (ml)</option>
                                            <option value="pcs" ${data.product.measurement_unit === 'pcs' ? 'selected' : ''}>Pieces (pcs)</option>
                                        </select>
                                    </div>

                                    <div id="variantsContainerEdit" class="space-y-4">
                                        ${data.product.has_variations && data.product.variants ? renderEditVariants(data.product.variants, data.product.measurement_unit) : ''}
                                    </div>

                                    ${data.product.has_variations ? `
                                    <button type="button" onclick="addEditVariant()"
                                            class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-200">
                                        <i class="fas fa-plus mr-2"></i> Add Variant
                                    </button>
                                    ` : ''}
                                </div>

                                <!-- Images Section -->
                                <div class="mt-6">
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Images</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Cover Image</label>
                                            ${data.product.cover_image ? `<img src="${data.product.cover_image}" class="h-20 w-20 rounded-lg object-cover border mb-2">` : '<p class="text-gray-500">No image</p>'}
                                            <label class="block text-sm font-medium text-gray-700 mb-2 mt-4">Update Cover Image (Optional)</label>
                                            <input type="file" name="cover_image" accept="image/*"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                            <button type="button" onclick="closeModal('editProductModal')"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                                Update Product
                            </button>
                        </div>
                    </form>
                `;

                // Initialize Summernote for the description field
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

                // Add form submission handler for edit form
                const editForm = document.getElementById('editProductForm');
                if (editForm) {
                    editForm.addEventListener('submit', function(e) {
                        if (!handleEditProductFormSubmit(this)) {
                            e.preventDefault();
                        }
                    });
                }

            } else {
                throw new Error(data.error || 'Failed to load product');
            }
        })
        .catch(error => {
            console.error('Error loading product:', error);
            modalContent.innerHTML = `
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-red-700">Error loading product data: ${error.message}</p>
                </div>
                <div class="flex justify-end mt-4">
                    <button onclick="closeModal('editProductModal')"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                        Close
                    </button>
                </div>
            `;
        });
}

// Handle edit product form submission
function handleEditProductFormSubmit(form) {
    const isVariant = form.querySelector('input[name="has_variations"]:checked').value === '1';

    // Remove all required attributes first to prevent browser validation issues
    const allRequired = form.querySelectorAll('[required]');
    allRequired.forEach(field => field.removeAttribute('required'));

    let isValid = true;
    const errors = [];

    // Validate based on product type
    if (!isVariant) {
        // Simple product validation
        const priceKes = form.querySelector('[name="price_kes"]');
        const priceUsd = form.querySelector('[name="price_usd"]');
        const stock = form.querySelector('[name="stock"]');

        if (!priceKes?.value) {
            errors.push('Price (KES) is required for simple products');
            isValid = false;
        }

        if (!priceUsd?.value) {
            errors.push('Price (USD) is required for simple products');
            isValid = false;
        }

        if (!stock?.value) {
            errors.push('Stock is required for simple products');
            isValid = false;
        }
    } else {
        // Variant product validation
        const measurementUnit = form.querySelector('[name="measurement_unit"]');
        const variants = form.querySelectorAll('.variant-edit-item');

        if (!measurementUnit?.value) {
            errors.push('Measurement unit is required for variant products');
            isValid = false;
        }

        if (variants.length === 0) {
            errors.push('At least one variant is required for variant products');
            isValid = false;
        }
    }

    // Show errors if any
    if (!isValid) {
        alert('Please fix the following errors:\n' + errors.join('\n'));
        return false;
    }

    return true;
}

// Toggle product type in edit form
function toggleProductTypeEdit(radio) {
    const isVariant = radio.value === '1';

    document.getElementById('simpleProductSectionEdit').classList.toggle('hidden', isVariant);
    document.getElementById('variantProductSectionEdit').classList.toggle('hidden', !isVariant);

    // Get form elements
    const priceKesInput = document.querySelector('input[name="price_kes"]');
    const priceUsdInput = document.querySelector('input[name="price_usd"]');
    const stockInput = document.querySelector('input[name="stock"]');
    const measurementInput = document.querySelector('select[name="measurement_unit"]');

    // Remove required attribute when hidden, add when visible
    if (priceKesInput) {
        if (isVariant) {
            priceKesInput.removeAttribute('required');
        } else {
            priceKesInput.required = true;
        }
    }

    if (priceUsdInput) {
        if (isVariant) {
            priceUsdInput.removeAttribute('required');
        } else {
            priceUsdInput.required = true;
        }
    }

    if (stockInput) {
        if (isVariant) {
            stockInput.removeAttribute('required');
        } else {
            stockInput.required = true;
        }
    }

    if (measurementInput) {
        if (!isVariant) {
            measurementInput.removeAttribute('required');
        } else {
            measurementInput.required = true;
        }
    }

    // Add first variant if none exists and switching to variant type
    if (isVariant && document.querySelectorAll('.variant-edit-item').length === 0) {
        addEditVariant();
    }
}

// Helper function to render variants in edit form
function renderEditVariants(variants, measurementUnit) {
    if (!variants || variants.length === 0) return '';

    return variants.map(variant => `
        <div class="variant-edit-item border border-gray-200 p-4 rounded-lg" data-id="${variant.id}">
            <div class="flex justify-between items-center mb-3">
                <h5 class="font-medium text-gray-700">Variant</h5>
                <button type="button" onclick="removeEditVariant(${variant.id})" class="text-red-500 hover:text-red-700 transition duration-150">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <input type="hidden" name="variants[${variant.id}][id]" value="${variant.id}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity*</label>
                    <input type="number" name="variants[${variant.id}][quantity]" value="${variant.name || variant.quantity}" required min="0" step="0.01"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500" oninput="updateEditVariantDisplayName(${variant.id})">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price (KES)*</label>
                    <input type="number" name="variants[${variant.id}][price_kes]" value="${variant.price_kes}" required min="0" step="0.01"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price (USD)*</label>
                    <input type="number" name="variants[${variant.id}][price_usd]" value="${variant.price_usd}" required min="0" step="0.01"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock*</label>
                    <input type="number" name="variants[${variant.id}][stock]" value="${variant.stock}" required min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Display Name</label>
                    <input type="text" name="variants[${variant.id}][display_name]" value="${variant.display_name}" readonly
                        class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                </div>
            </div>
        </div>
    `).join('');
}

// Add new variant in edit form
function addEditVariant() {
    const container = document.getElementById('variantsContainerEdit');
    const variantId = 'new_' + Date.now();
    const measurementUnit = document.querySelector('select[name="measurement_unit"]').value || 'unit';

    const variantDiv = document.createElement('div');
    variantDiv.className = 'variant-edit-item border border-gray-200 p-4 rounded-lg';
    variantDiv.dataset.id = variantId;

    variantDiv.innerHTML = `
        <div class="flex justify-between items-center mb-3">
            <h5 class="font-medium text-gray-700">New Variant</h5>
            <button type="button" onclick="removeEditVariant('${variantId}')" class="text-red-500 hover:text-red-700 transition duration-150">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity*</label>
                <input type="number" name="variants[${variantId}][quantity]" required min="0" step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500" oninput="updateEditVariantDisplayName('${variantId}')">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price (KES)*</label>
                <input type="number" name="variants[${variantId}][price_kes]" required min="0" step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price (USD)*</label>
                <input type="number" name="variants[${variantId}][price_usd]" required min="0" step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock*</label>
                <input type="number" name="variants[${variantId}][stock]" required min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Display Name</label>
                <input type="text" name="variants[${variantId}][display_name]" readonly
                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
            </div>
        </div>
    `;

    container.appendChild(variantDiv);
    updateEditVariantDisplayName(variantId);
}

// Update variant display name in edit form
function updateEditVariantDisplayName(variantId) {
    const quantityInput = document.querySelector(`[name="variants[${variantId}][quantity]"]`);
    const displayInput = document.querySelector(`[name="variants[${variantId}][display_name]"]`);
    const measurementUnit = document.querySelector('select[name="measurement_unit"]').value || 'unit';

    if (quantityInput && displayInput) {
        const quantity = parseFloat(quantityInput.value);
        if (!isNaN(quantity)) {
            displayInput.value = `${quantity}${measurementUnit}`;
        }
    }
}

// Remove variant in edit form
function removeEditVariant(id) {
    const element = document.querySelector(`.variant-edit-item[data-id="${id}"]`);
    if (element) {
        element.remove();
    }
}

// Helper function to escape HTML
function escapeHtml(unsafe) {
    if (!unsafe) return '';
    return unsafe.toString()
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Function to open edit category modal
function openEditCategoryModal(categoryId) {
    // Show loading state
    const modal = document.getElementById('editCategoryModal');
    const modalContent = document.getElementById('editCategoryModalContent');
    modalContent.innerHTML = `
        <div class="flex justify-center items-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
            <span class="ml-3 text-gray-600">Loading category data...</span>
        </div>
    `;
    modal.classList.remove('hidden');

    // Fetch category data via AJAX
    fetch(`/admin/product-categories/${categoryId}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Populate the modal with the edit form
                modalContent.innerHTML = `
                    <form action="/admin/product-categories/${categoryId}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                                <input type="text" name="category_name" value="${escapeHtml(data.category.category_name)}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea name="category_description" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg" rows="3">${escapeHtml(data.category.category_description)}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category Tag</label>
                                <input type="text" name="category_tag" value="${escapeHtml(data.category.category_tag)}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                                ${data.category.image ? `<img src="/storage/${data.category.image}" class="h-20 w-20 rounded-lg object-cover border mb-2">` : '<p class="text-gray-500">No image</p>'}
                                <label class="block text-sm font-medium text-gray-700 mb-2 mt-4">Update Image (Optional)</label>
                                <input type="file" name="image" accept="image/*"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                            <button type="button" onclick="closeModal('editCategoryModal')"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-200">
                                Update Category
                            </button>
                        </div>
                    </form>
                `;
            } else {
                modalContent.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-red-700">Error loading category data. Please try again.</p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button onclick="closeModal('editCategoryModal')"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                            Close
                        </button>
                    </div>
                `;
            }
        })
        .catch(error => {
            modalContent.innerHTML = `
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-red-700">Error: ${error.message}</p>
                </div>
                <div class="flex justify-end mt-4">
                    <button onclick="closeModal('editCategoryModal')"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                        Close
                    </button>
                </div>
            `;
        });
}

// Function to manage variants
function manageVariants(productId) {
    // Show loading state
    const modal = document.getElementById('variantModal');
    const modalContent = document.getElementById('variantModalContent');
    modalContent.innerHTML = `
        <div class="flex justify-center items-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
            <span class="ml-3 text-gray-600">Loading variants...</span>
        </div>
    `;
    modal.classList.remove('hidden');
    document.getElementById('variantModalTitle').textContent = 'Manage Product Variants';

    // Fetch variants data via AJAX
    fetch(`/admin/products/${productId}/variants`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                let variantsHtml = `
                    <form action="/admin/products/${productId}/variants" method="POST">
                        @csrf
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-800">${escapeHtml(data.product.product_name)}</h3>
                            <p class="text-gray-600">Manage product variants</p>
                        </div>
                        <div id="variantsList" class="space-y-4 mb-4">
                `;

                if (data.variants.length > 0) {
                    data.variants.forEach(variant => {
                        variantsHtml += `
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                        <input type="number" name="variants[${variant.id}][quantity]" value="${variant.quantity}" step="0.01" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Price (KES)</label>
                                        <input type="number" name="variants[${variant.id}][price_kes]" value="${variant.price_kes}" step="0.01" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Price (USD)</label>
                                        <input type="number" name="variants[${variant.id}][price_usd]" value="${variant.price_usd}" step="0.01" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                                        <input type="number" name="variants[${variant.id}][stock]" value="${variant.stock}" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    variantsHtml += `
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                            <p class="text-gray-600">No variants found for this product.</p>
                        </div>
                    `;
                }

                variantsHtml += `
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                            <button type="button" onclick="addNewVariant()"
                                class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-200">
                                <i class="fas fa-plus mr-2"></i> Add New Variant
                            </button>
                            <div class="flex space-x-3">
                                <button type="button" onclick="closeModal('variantModal')"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                                    Save Variants
                                </button>
                            </div>
                        </div>
                    </form>
                `;

                modalContent.innerHTML = variantsHtml;
            } else {
                modalContent.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-red-700">Error loading variants. Please try again.</p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button onclick="closeModal('variantModal')"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                            Close
                        </button>
                    </div>
                `;
            }
        })
        .catch(error => {
            modalContent.innerHTML = `
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-red-700">Error: ${error.message}</p>
                </div>
                <div class="flex justify-end mt-4">
                    <button onclick="closeModal('variantModal')"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                        Close
                    </button>
                </div>
            `;
        });
}

// Helper function to add a new variant in the manage variants modal
function addNewVariant() {
    const variantsList = document.getElementById('variantsList');
    const newId = 'new_' + Date.now();

    const newVariantHtml = `
        <div class="border border-gray-200 rounded-lg p-4 bg-blue-50">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" name="variants[${newId}][quantity]" step="0.01" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price (KES)</label>
                    <input type="number" name="variants[${newId}][price_kes]" step="0.01" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price (USD)</label>
                    <input type="number" name="variants[${newId}][price_usd]" step="0.01" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                    <input type="number" name="variants[${newId}][stock]" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
            </div>
        </div>
    `;

    variantsList.insertAdjacentHTML('beforeend', newVariantHtml);
}
</script>
@endsection
