{{-- resources/views/healthversations/admin/products/product/index.blade.php --}}
@extends('healthversations.admin.layout.adminlayout')

@section('title', 'Product Management | Health Versations Admin')
@section('page-title', 'Product Management')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Products</h1>
            <p class="text-gray-600 mt-1">Manage your product inventory, prices, and discounts</p>
        </div>
        <button onclick="openCreateProductModal()"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-all transform hover:scale-105 flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Add New Product
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Products</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $products->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-box text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Categories</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $productcategory->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-tags text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">On Discount</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $products->where('has_discount', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-percent text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Low Stock</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $products->where('stock', '<', 10)->where('has_variations', false)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <div class="flex flex-wrap gap-4 items-center justify-between">
            <div class="flex flex-wrap gap-3">
                <select id="categoryFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    <option value="">All Categories</option>
                    @foreach($productcategory as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
                <select id="discountFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    <option value="">All Products</option>
                    <option value="discounted">On Discount</option>
                    <option value="no_discount">No Discount</option>
                </select>
                <select id="stockFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    <option value="">All Stock Status</option>
                    <option value="low">Low Stock (&lt;10)</option>
                    <option value="out">Out of Stock</option>
                    <option value="in">In Stock</option>
                </select>
            </div>
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Search products..."
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 w-64">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price (KES)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="productsTableBody" class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    @php
                        $hasDiscount = $product->has_discount && $product->discount_percent > 0;
                        $discountedPrice = $hasDiscount ? $product->price_kes * (1 - $product->discount_percent / 100) : $product->price_kes;
                        $isLowStock = !$product->has_variations && $product->stock < 10 && $product->stock > 0;
                        $isOutOfStock = !$product->has_variations && $product->stock == 0;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors product-row"
                        data-category="{{ $product->category_id }}"
                        data-has-discount="{{ $hasDiscount ? '1' : '0' }}"
                        data-stock="{{ $product->stock }}"
                        data-name="{{ strtolower($product->product_name) }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="product-checkbox rounded border-gray-300" value="{{ $product->id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100">
                                <img src="{{ asset($product->cover_image) }}"
                                     alt="{{ $product->product_name }}"
                                     class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $product->product_name }}</div>
                            <div class="text-xs text-gray-500">SKU: #{{ $product->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                {{ $product->category->category_name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($hasDiscount)
                                <div class="text-sm">
                                    <span class="text-gray-400 line-through text-xs">KES {{ number_format($product->price_kes, 2) }}</span>
                                    <span class="text-green-600 font-bold ml-1">KES {{ number_format($discountedPrice, 2) }}</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-900">KES {{ number_format($product->price_kes, 2) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($hasDiscount)
                                <div class="flex flex-col">
                                    <span class="text-xs text-red-600 font-bold">-{{ number_format($product->discount_percent) }}%</span>
                                    <span class="text-xs text-green-600">Save KES {{ number_format($product->price_kes - $discountedPrice, 2) }}</span>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">No discount</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->has_variations)
                                <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                                    <i class="fas fa-layer-group mr-1"></i> Variants
                                </span>
                            @else
                                @if($isOutOfStock)
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Out of Stock
                                    </span>
                                @elseif($isLowStock)
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Low Stock ({{ $product->stock }})
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> In Stock ({{ $product->stock }})
                                    </span>
                                @endif
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->has_variations)
                                <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-800">
                                    <i class="fas fa-code-branch mr-1"></i> Variable
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                    <i class="fas fa-tag mr-1"></i> Simple
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer status-toggle" data-product-id="{{ $product->id }}"
                                       {{ $product->status !== 'inactive' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button onclick="editProduct({{ $product->id }})"
                                        class="text-blue-600 hover:text-blue-900 transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="viewProduct({{ $product->id }})"
                                        class="text-green-600 hover:text-green-900 transition-colors" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="openDiscountModal({{ $product->id }}, {{ $product->discount_percent ?? 0 }}, {{ $product->has_discount ? 'true' : 'false' }})"
                                        class="text-yellow-600 hover:text-yellow-900 transition-colors" title="Set Discount">
                                    <i class="fas fa-percent"></i>
                                </button>
                                <button onclick="deleteProduct({{ $product->id }})"
                                        class="text-red-600 hover:text-red-900 transition-colors" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-box-open text-5xl mb-3 block"></i>
                            <p class="text-lg">No products found</p>
                            <button onclick="openCreateProductModal()" class="mt-3 text-green-600 hover:text-green-700">
                                Add your first product →
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bulk Actions -->
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <span id="selectedCount" class="text-sm text-gray-600">0 selected</span>
                <button id="bulkDeleteBtn" class="text-red-600 hover:text-red-800 text-sm font-medium hidden">
                    <i class="fas fa-trash-alt mr-1"></i> Delete Selected
                </button>
                <button id="bulkDiscountBtn" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium hidden">
                    <i class="fas fa-percent mr-1"></i> Apply Discount
                </button>
            </div>
            <div>
                <button onclick="exportProducts()" class="text-gray-600 hover:text-gray-800 text-sm">
                    <i class="fas fa-download mr-1"></i> Export
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit Product Modal -->
<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
                <h3 id="modalTitle" class="text-xl font-bold text-gray-800">Add New Product</h3>
                <button onclick="closeProductModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <form id="productForm" enctype="multipart/form-data" class="p-6">
                @csrf
                <input type="hidden" name="product_id" id="productId">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                            <input type="text" name="product_name" id="productName" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                            <select name="category_id" id="categoryId" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                <option value="">Select Category</option>
                                @foreach($productcategory as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cover Image *</label>
                            <input type="file" name="cover_image" id="coverImage" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                            <div id="currentImage" class="mt-2 hidden">
                                <img id="currentImageView" src="" class="w-20 h-20 object-cover rounded-lg">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Type *</label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="has_variations" value="0" checked class="mr-2">
                                    <span>Simple Product</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="has_variations" value="1" class="mr-2">
                                    <span>Variable Product (with variants)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                            <input type="text" name="tags" id="tags"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                   placeholder="Comma separated tags">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords (SEO)</label>
                            <input type="text" name="meta_keywords" id="metaKeywords"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                   placeholder="For search engines">
                        </div>

                        <!-- Discount Section -->
                        <div class="border-t pt-4">
                            <label class="flex items-center mb-3">
                                <input type="checkbox" name="has_discount" id="hasDiscount" value="1" class="mr-2">
                                <span class="font-medium text-gray-700">Enable Discount</span>
                            </label>
                            <div id="discountFields" style="display: none;">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Discount Percentage (%)</label>
                                <input type="number" name="discount_percent" id="discountPercent" step="0.01" min="0" max="100"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                <p class="text-xs text-gray-500 mt-1">Enter 20 for 20% off</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="5"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"></textarea>
                </div>

                <!-- Simple Product Fields -->
                <div id="simpleFields" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price (KES) *</label>
                        <input type="number" name="price_kes" id="priceKes" step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price (USD) *</label>
                        <input type="number" name="price_usd" id="priceUsd" step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                        <input type="number" name="stock" id="stock"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    </div>
                </div>

                <!-- Variable Product Fields -->
                <div id="variableFields" class="hidden mt-4">
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-center mb-3">
                            <label class="font-medium text-gray-700">Product Variants</label>
                            <button type="button" onclick="addVariant()"
                                    class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-700">
                                <i class="fas fa-plus mr-1"></i> Add Variant
                            </button>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Measurement Unit</label>
                            <select name="measurement_unit" id="measurementUnit"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                <option value="kg">Kilogram (kg)</option>
                                <option value="g">Gram (g)</option>
                                <option value="L">Liter (L)</option>
                                <option value="ml">Milliliter (ml)</option>
                                <option value="pcs">Pieces (pcs)</option>
                            </select>
                        </div>
                        <div id="variantsList" class="mt-4 space-y-3"></div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <button type="button" onclick="closeProductModal()"
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Discount Modal -->
<div id="discountModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Set Product Discount</h3>
            <button onclick="closeDiscountModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <form id="discountForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="product_id" id="discountProductId">
            <div class="mb-4">
                <label class="flex items-center mb-3">
                    <input type="checkbox" name="has_discount" id="discountHasDiscount" class="mr-2">
                    <span class="font-medium text-gray-700">Enable discount for this product</span>
                </label>
            </div>
            <div id="discountPercentFields" style="display: none;">
                <label class="block text-sm font-medium text-gray-700 mb-2">Discount Percentage (%)</label>
                <input type="number" name="discount_percent" id="discountPercentValue" step="0.01" min="0" max="100"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                <div id="discountPreview" class="mt-3 p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">Preview:</p>
                    <p class="text-sm">Original: KES <span id="previewOriginal">0</span></p>
                    <p class="text-sm text-green-600 font-bold">Discounted: KES <span id="previewDiscounted">0</span></p>
                    <p class="text-sm text-red-600">You save: KES <span id="previewSavings">0</span> (<span id="previewPercent">0</span>%)</p>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeDiscountModal()"
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                    Apply Discount
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let variantIndex = 0;
let currentProductPrice = 0;

// Initialize filters and search
document.getElementById('categoryFilter').addEventListener('change', filterProducts);
document.getElementById('discountFilter').addEventListener('change', filterProducts);
document.getElementById('stockFilter').addEventListener('change', filterProducts);
document.getElementById('searchInput').addEventListener('keyup', filterProducts);

function filterProducts() {
    const category = document.getElementById('categoryFilter').value;
    const discount = document.getElementById('discountFilter').value;
    const stock = document.getElementById('stockFilter').value;
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();

    const rows = document.querySelectorAll('.product-row');
    let visibleCount = 0;

    rows.forEach(row => {
        let show = true;

        if (category && row.dataset.category !== category) show = false;
        if (discount === 'discounted' && row.dataset.hasDiscount !== '1') show = false;
        if (discount === 'no_discount' && row.dataset.hasDiscount !== '0') show = false;
        if (stock === 'low' && parseInt(row.dataset.stock) >= 10) show = false;
        if (stock === 'out' && parseInt(row.dataset.stock) > 0) show = false;
        if (stock === 'in' && parseInt(row.dataset.stock) <= 0) show = false;
        if (searchTerm && !row.dataset.name.includes(searchTerm)) show = false;

        row.style.display = show ? '' : 'none';
        if (show) visibleCount++;
    });

    // Show/hide no results message
    let noResultsMsg = document.getElementById('noResultsMsg');
    if (!noResultsMsg && visibleCount === 0) {
        const tbody = document.getElementById('productsTableBody');
        noResultsMsg = document.createElement('tr');
        noResultsMsg.id = 'noResultsMsg';
        noResultsMsg.innerHTML = `<td colspan="10" class="px-6 py-12 text-center text-gray-500">
            <i class="fas fa-search text-5xl mb-3 block"></i>
            <p class="text-lg">No products match your filters</p>
            <button onclick="clearFilters()" class="mt-3 text-green-600 hover:text-green-700">Clear filters →</button>
        </td>`;
        tbody.appendChild(noResultsMsg);
    } else if (noResultsMsg && visibleCount > 0) {
        noResultsMsg.remove();
    }
}

function clearFilters() {
    document.getElementById('categoryFilter').value = '';
    document.getElementById('discountFilter').value = '';
    document.getElementById('stockFilter').value = '';
    document.getElementById('searchInput').value = '';
    filterProducts();
}

// Bulk selection
let selectedProducts = new Set();

document.getElementById('selectAll')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.product-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        if (this.checked) {
            selectedProducts.add(checkbox.value);
        } else {
            selectedProducts.delete(checkbox.value);
        }
    });
    updateBulkActions();
});

document.querySelectorAll('.product-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            selectedProducts.add(this.value);
        } else {
            selectedProducts.delete(this.value);
            document.getElementById('selectAll').checked = false;
        }
        updateBulkActions();
    });
});

function updateBulkActions() {
    const count = selectedProducts.size;
    document.getElementById('selectedCount').textContent = `${count} selected`;

    const bulkDelete = document.getElementById('bulkDeleteBtn');
    const bulkDiscount = document.getElementById('bulkDiscountBtn');

    if (count > 0) {
        bulkDelete.classList.remove('hidden');
        bulkDiscount.classList.remove('hidden');
    } else {
        bulkDelete.classList.add('hidden');
        bulkDiscount.classList.add('hidden');
    }
}

// Toggle between simple and variable product fields
document.querySelectorAll('input[name="has_variations"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const isVariable = this.value === '1';
        document.getElementById('simpleFields').style.display = isVariable ? 'none' : 'grid';
        document.getElementById('variableFields').style.display = isVariable ? 'block' : 'none';
    });
});

// Discount checkbox toggle
document.getElementById('hasDiscount')?.addEventListener('change', function() {
    const discountFields = document.getElementById('discountFields');
    discountFields.style.display = this.checked ? 'block' : 'none';
});

// Variant management
function addVariant() {
    const unit = document.getElementById('measurementUnit').value;
    const unitLabel = document.getElementById('measurementUnit').options[document.getElementById('measurementUnit').selectedIndex]?.text || '';

    const variantHtml = `
        <div class="variant-item border rounded-lg p-3 bg-gray-50">
            <div class="grid grid-cols-4 gap-3">
                <div>
                    <label class="text-xs text-gray-600">Quantity</label>
                    <input type="number" name="variants[${variantIndex}][quantity]" step="0.01" required
                           class="w-full px-2 py-1 border rounded text-sm">
                </div>
                <div>
                    <label class="text-xs text-gray-600">Price (KES)</label>
                    <input type="number" name="variants[${variantIndex}][price_kes]" step="0.01" required
                           class="w-full px-2 py-1 border rounded text-sm">
                </div>
                <div>
                    <label class="text-xs text-gray-600">Price (USD)</label>
                    <input type="number" name="variants[${variantIndex}][price_usd]" step="0.01" required
                           class="w-full px-2 py-1 border rounded text-sm">
                </div>
                <div>
                    <label class="text-xs text-gray-600">Stock</label>
                    <div class="flex gap-2">
                        <input type="number" name="variants[${variantIndex}][stock]" required
                               class="w-full px-2 py-1 border rounded text-sm">
                        <button type="button" onclick="this.closest('.variant-item').remove()"
                                class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.getElementById('variantsList').insertAdjacentHTML('beforeend', variantHtml);
    variantIndex++;
}

// Product CRUD Operations
function openCreateProductModal() {
    document.getElementById('modalTitle').textContent = 'Add New Product';
    document.getElementById('productForm').reset();
    document.getElementById('productId').value = '';
    document.getElementById('currentImage').classList.add('hidden');
    document.getElementById('simpleFields').style.display = 'grid';
    document.getElementById('variableFields').style.display = 'none';
    document.getElementById('variantsList').innerHTML = '';
    variantIndex = 0;
    document.getElementById('productModal').classList.remove('hidden');
}

function editProduct(id) {
    fetch(`/admin/products/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const product = data.product;
                document.getElementById('modalTitle').textContent = 'Edit Product';
                document.getElementById('productId').value = product.id;
                document.getElementById('productName').value = product.product_name;
                document.getElementById('categoryId').value = product.category_id;
                document.getElementById('description').value = product.description;
                document.getElementById('tags').value = product.tags;
                document.getElementById('metaKeywords').value = product.meta_keywords;

                // Set product type
                const isVariable = product.has_variations;
                document.querySelector(`input[name="has_variations"][value="${isVariable ? '1' : '0'}"]`).checked = true;

                if (isVariable) {
                    document.getElementById('simpleFields').style.display = 'none';
                    document.getElementById('variableFields').style.display = 'block';
                    document.getElementById('measurementUnit').value = product.measurement_unit;
                    // Load variants
                    if (product.variants) {
                        product.variants.forEach(variant => {
                            addVariantWithData(variant);
                        });
                    }
                } else {
                    document.getElementById('simpleFields').style.display = 'grid';
                    document.getElementById('variableFields').style.display = 'none';
                    document.getElementById('priceKes').value = product.price_kes;
                    document.getElementById('priceUsd').value = product.price_usd;
                    document.getElementById('stock').value = product.stock;
                }

                // Set discount
                if (product.has_discount) {
                    document.getElementById('hasDiscount').checked = true;
                    document.getElementById('discountFields').style.display = 'block';
                    document.getElementById('discountPercent').value = product.discount_percent;
                }

                if (product.cover_image) {
                    document.getElementById('currentImageView').src = product.cover_image;
                    document.getElementById('currentImage').classList.remove('hidden');
                }

                document.getElementById('productModal').classList.remove('hidden');
            }
        })
        .catch(error => console.error('Error:', error));
}

function addVariantWithData(variant) {
    const unit = document.getElementById('measurementUnit').value;
    const variantHtml = `
        <div class="variant-item border rounded-lg p-3 bg-gray-50">
            <input type="hidden" name="variants[${variantIndex}][id]" value="${variant.id}">
            <div class="grid grid-cols-4 gap-3">
                <div>
                    <label class="text-xs text-gray-600">Quantity</label>
                    <input type="number" name="variants[${variantIndex}][quantity]" value="${variant.name}" step="0.01" required
                           class="w-full px-2 py-1 border rounded text-sm">
                </div>
                <div>
                    <label class="text-xs text-gray-600">Price (KES)</label>
                    <input type="number" name="variants[${variantIndex}][price_kes]" value="${variant.price_kes}" step="0.01" required
                           class="w-full px-2 py-1 border rounded text-sm">
                </div>
                <div>
                    <label class="text-xs text-gray-600">Price (USD)</label>
                    <input type="number" name="variants[${variantIndex}][price_usd]" value="${variant.price_usd}" step="0.01" required
                           class="w-full px-2 py-1 border rounded text-sm">
                </div>
                <div>
                    <label class="text-xs text-gray-600">Stock</label>
                    <div class="flex gap-2">
                        <input type="number" name="variants[${variantIndex}][stock]" value="${variant.stock}" required
                               class="w-full px-2 py-1 border rounded text-sm">
                        <button type="button" onclick="this.closest('.variant-item').remove()"
                                class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.getElementById('variantsList').insertAdjacentHTML('beforeend', variantHtml);
    variantIndex++;
}

// Form submission
document.getElementById('productForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const productId = document.getElementById('productId').value;
    const url = productId ? `/allproducts/${productId}` : '/allproducts';
    const method = productId ? 'POST' : 'POST';

    if (productId) {
        formData.append('_method', 'PUT');
    }

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success || response.ok) {
            window.location.reload();
        } else {
            alert('Error saving product');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error saving product');
    }
});

function closeProductModal() {
    document.getElementById('productModal').classList.add('hidden');
}

// Discount Modal
function openDiscountModal(productId, discountPercent, hasDiscount) {
    document.getElementById('discountProductId').value = productId;
    document.getElementById('discountHasDiscount').checked = hasDiscount;
    document.getElementById('discountPercentValue').value = discountPercent;

    // Get current product price
    fetch(`/admin/products/${productId}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentProductPrice = data.product.price_kes;
                document.getElementById('previewOriginal').textContent = currentProductPrice.toFixed(2);
                updateDiscountPreview();
            }
        });

    const discountPercentFields = document.getElementById('discountPercentFields');
    discountPercentFields.style.display = hasDiscount ? 'block' : 'none';

    document.getElementById('discountModal').classList.remove('hidden');
    document.getElementById('discountModal').classList.add('flex');
}

function updateDiscountPreview() {
    const percent = parseFloat(document.getElementById('discountPercentValue').value) || 0;
    const discounted = currentProductPrice * (1 - percent / 100);
    const savings = currentProductPrice - discounted;

    document.getElementById('previewDiscounted').textContent = discounted.toFixed(2);
    document.getElementById('previewSavings').textContent = savings.toFixed(2);
    document.getElementById('previewPercent').textContent = percent;
}

document.getElementById('discountPercentValue')?.addEventListener('input', updateDiscountPreview);
document.getElementById('discountHasDiscount')?.addEventListener('change', function() {
    const discountPercentFields = document.getElementById('discountPercentFields');
    discountPercentFields.style.display = this.checked ? 'block' : 'none';
});

document.getElementById('discountForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();

    const productId = document.getElementById('discountProductId').value;
    const hasDiscount = document.getElementById('discountHasDiscount').checked;
    const discountPercent = document.getElementById('discountPercentValue').value;

    try {
        const response = await fetch(`/admin/products/${productId}/discount`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                has_discount: hasDiscount,
                discount_percent: discountPercent || 0
            })
        });

        if (response.ok) {
            window.location.reload();
        } else {
            alert('Error updating discount');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error updating discount');
    }
});

function closeDiscountModal() {
    document.getElementById('discountModal').classList.add('hidden');
    document.getElementById('discountModal').classList.remove('flex');
}

function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        fetch(`/allproducts/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            window.location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
}

function viewProduct(id) {
    window.open(`/product/${id}`, '_blank');
}

function exportProducts() {
    window.location.href = '/admin/products/export';
}
</script>

<!-- Add discount update route in ProductController -->
@push('scripts')
<script>
// Add this method to your ProductController if not exists
/*
public function updateDiscount(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $product->has_discount = $request->has_discount;
    $product->discount_percent = $request->discount_percent ?? 0;
    $product->save();

    return response()->json(['success' => true]);
}
*/
</script>
@endpush

<style>
.product-row {
    transition: background-color 0.2s ease;
}

.variant-item {
    transition: all 0.2s ease;
}

.variant-item:hover {
    background-color: #f9fafb;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endsection
