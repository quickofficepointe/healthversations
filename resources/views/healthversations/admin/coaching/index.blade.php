@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Coaching Packages</h1>
        <!-- Add Package Button -->
        <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200" onclick="toggleModal('addPackageModal')">
            Add New Package
        </button>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" id="searchInput" placeholder="Search packages..." class="w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div class="flex gap-2">
                <select id="statusFilter" class="p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <button onclick="resetFilters()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200">
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Packages Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase cursor-pointer" onclick="sortTable(0)">
                            Order <span class="sort-icon">↕️</span>
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Image</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase cursor-pointer" onclick="sortTable(2)">
                            Package Name <span class="sort-icon">↕️</span>
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Duration</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase cursor-pointer" onclick="sortTable(4)">
                            USD Price <span class="sort-icon">↕️</span>
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase cursor-pointer" onclick="sortTable(5)">
                            KSH Price <span class="sort-icon">↕️</span>
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase cursor-pointer" onclick="sortTable(6)">
                            Status <span class="sort-icon">↕️</span>
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="packagesTableBody">
                    @foreach($packages as $package)
                    <tr class="hover:bg-gray-50 transition duration-200 package-row" data-id="{{ $package->id }}" data-status="{{ $package->is_active ? 'active' : 'inactive' }}">
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <div class="flex items-center">
                                <span class="drag-handle cursor-move mr-2">↕️</span>
                                <span class="order-value">{{ $package->sort_order }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            @if($package->image)
                            <img src="{{ asset('storage/' . $package->image) }}" alt="Package Image" class="w-16 h-16 object-cover rounded-lg">
                            @else
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                No Image
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 package-name">{{ $package->package_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $package->duration }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">${{ number_format($package->price_usd, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">KSh {{ number_format($package->price_kes, 2) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium status-badge {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $package->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-2">
                                <button class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200"
                                        onclick="toggleModal('editPackageModal{{ $package->id }}')">
                                    Edit
                                </button>
                                <form action="{{ route('admin.coaching-packages.destroy', $package->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this package?');">
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

        <!-- Pagination -->
        @if($packages->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-700">
                    Showing {{ $packages->firstItem() }} to {{ $packages->lastItem() }} of {{ $packages->total() }} results
                </div>
                <div class="flex space-x-2">
                    @if($packages->onFirstPage())
                    <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">Previous</span>
                    @else
                    <a href="{{ $packages->previousPageUrl() }}" class="px-3 py-1 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition duration-200">Previous</a>
                    @endif

                    @if($packages->hasMorePages())
                    <a href="{{ $packages->nextPageUrl() }}" class="px-3 py-1 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition duration-200">Next</a>
                    @else
                    <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">Next</span>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Empty State -->
        @if($packages->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No packages</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating a new coaching package.</p>
            <div class="mt-6">
                <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200" onclick="toggleModal('addPackageModal')">
                    Add New Package
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Add Package Modal -->
<div id="addPackageModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Add New Coaching Package</h3>
        <form action="{{ route('admin.coaching-packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="package_name" class="block text-sm font-medium text-gray-700">Package Name*</label>
                    <input type="text" name="package_name" id="package_name" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700">Duration*</label>
                    <input type="text" name="duration" id="duration" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="price_usd" class="block text-sm font-medium text-gray-700">Price (USD)*</label>
                    <input type="number" step="0.01" name="price_usd" id="price_usd" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="price_kes" class="block text-sm font-medium text-gray-700">Price (KSH)*</label>
                    <input type="number" step="0.01" name="price_kes" id="price_kes" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="bg_color" class="block text-sm font-medium text-gray-700">Background Color*</label>
                    <input type="color" name="bg_color" id="bg_color" value="#93C754" required class="mt-1 block w-full h-10 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="button_text" class="block text-sm font-medium text-gray-700">Button Text*</label>
                    <input type="text" name="button_text" id="button_text" value="Enroll Now" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="md:col-span-2">
                    <label for="button_link" class="block text-sm font-medium text-gray-700">Button URL</label>
                    <input type="url" name="button_link" id="button_link" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Package Image</label>
                <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                <p class="mt-1 text-sm text-gray-500">Recommended size: 800x600px</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Features*</label>
                <div id="features-container" class="space-y-2">
                    <div class="flex items-center">
                        <input type="text" name="features[]" required class="flex-1 p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                        <button type="button" class="ml-2 text-red-500 hover:text-red-700" onclick="removeFeature(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="button" onclick="addFeature()" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Add Feature
                </button>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Package Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500"></textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" onclick="toggleModal('addPackageModal')">
                    Close
                </button>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                    Save Package
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Package Modals -->
@foreach($packages as $package)
<div id="editPackageModal{{ $package->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Edit Coaching Package</h3>
        <form action="{{ route('admin.coaching-packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="package_name{{ $package->id }}" class="block text-sm font-medium text-gray-700">Package Name*</label>
                    <input type="text" name="package_name" id="package_name{{ $package->id }}" value="{{ $package->package_name }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="duration{{ $package->id }}" class="block text-sm font-medium text-gray-700">Duration*</label>
                    <input type="text" name="duration" id="duration{{ $package->id }}" value="{{ $package->duration }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="price_usd{{ $package->id }}" class="block text-sm font-medium text-gray-700">Price (USD)*</label>
                    <input type="number" step="0.01" name="price_usd" id="price_usd{{ $package->id }}" value="{{ $package->price_usd }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="price_kes{{ $package->id }}" class="block text-sm font-medium text-gray-700">Price (KSH)*</label>
                    <input type="number" step="0.01" name="price_kes" id="price_kes{{ $package->id }}" value="{{ $package->price_kes }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="bg_color{{ $package->id }}" class="block text-sm font-medium text-gray-700">Background Color*</label>
                    <input type="color" name="bg_color" id="bg_color{{ $package->id }}" value="{{ $package->bg_color }}" required class="mt-1 block w-full h-10 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label for="button_text{{ $package->id }}" class="block text-sm font-medium text-gray-700">Button Text*</label>
                    <input type="text" name="button_text" id="button_text{{ $package->id }}" value="{{ $package->button_text }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="md:col-span-2">
                    <label for="button_link{{ $package->id }}" class="block text-sm font-medium text-gray-700">Button URL</label>
                    <input type="url" name="button_link" id="button_link{{ $package->id }}" value="{{ $package->button_link }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active{{ $package->id }}" value="1" {{ $package->is_active ? 'checked' : '' }} class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="is_active{{ $package->id }}" class="ml-2 block text-sm text-gray-700">Active</label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Package Image</label>
                <input type="file" name="image" id="image{{ $package->id }}" accept="image/*" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                @if($package->image)
                <p class="mt-1 text-sm text-gray-500">Current image:</p>
                <img src="{{ asset('storage/' . $package->image) }}" alt="Current Package Image" class="mt-2 w-32 h-auto rounded">
                @endif
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Features*</label>
                <div id="features-container-{{ $package->id }}" class="space-y-2">
                    @foreach($package->features as $index => $feature)
                    <div class="flex items-center">
                        <input type="text" name="features[]" value="{{ $feature->feature }}" required class="flex-1 p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                        @if($index > 0)
                        <button type="button" class="ml-2 text-red-500 hover:text-red-700" onclick="removeFeature(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        @endif
                    </div>
                    @endforeach
                </div>
                <button type="button" onclick="addFeature('features-container-{{ $package->id }}')" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Add Feature
                </button>
            </div>

            <div class="mb-4">
                <label for="description{{ $package->id }}" class="block text-sm font-medium text-gray-700">Package Description</label>
                <textarea name="description" id="description{{ $package->id }}" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">{{ $package->description }}</textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" onclick="toggleModal('editPackageModal{{ $package->id }}')">
                    Close
                </button>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                    Update Package
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    // Modal functionality
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
        
        // Close modal when clicking outside
        if (!modal.classList.contains('hidden')) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        }
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.package-row');
        
        rows.forEach(row => {
            const packageName = row.querySelector('.package-name').textContent.toLowerCase();
            if (packageName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Filter functionality
    document.getElementById('statusFilter').addEventListener('change', function(e) {
        const status = e.target.value;
        const rows = document.querySelectorAll('.package-row');
        
        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            if (status === 'all' || rowStatus === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Reset filters
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = 'all';
        const rows = document.querySelectorAll('.package-row');
        rows.forEach(row => row.style.display = '');
    }

    // Sort functionality
    let sortDirection = true; // true = ascending, false = descending
    
    function sortTable(columnIndex) {
        const tbody = document.getElementById('packagesTableBody');
        const rows = Array.from(tbody.querySelectorAll('.package-row'));
        
        rows.sort((a, b) => {
            let aValue, bValue;
            
            switch(columnIndex) {
                case 0: // Order
                    aValue = parseInt(a.querySelector('.order-value').textContent);
                    bValue = parseInt(b.querySelector('.order-value').textContent);
                    break;
                case 2: // Package Name
                    aValue = a.querySelector('.package-name').textContent.toLowerCase();
                    bValue = b.querySelector('.package-name').textContent.toLowerCase();
                    break;
                case 4: // USD Price
                    aValue = parseFloat(a.cells[4].textContent.replace('$', ''));
                    bValue = parseFloat(b.cells[4].textContent.replace('$', ''));
                    break;
                case 5: // KSH Price
                    aValue = parseFloat(a.cells[5].textContent.replace('KSh', '').replace(',', ''));
                    bValue = parseFloat(b.cells[5].textContent.replace('KSh', '').replace(',', ''));
                    break;
                case 6: // Status
                    aValue = a.cells[6].querySelector('.status-badge').textContent.toLowerCase();
                    bValue = b.cells[6].querySelector('.status-badge').textContent.toLowerCase();
                    break;
                default:
                    return 0;
            }
            
            if (sortDirection) {
                return aValue > bValue ? 1 : -1;
            } else {
                return aValue < bValue ? 1 : -1;
            }
        });
        
        // Clear and re-append sorted rows
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }
        
        rows.forEach(row => tbody.appendChild(row));
        sortDirection = !sortDirection;
        
        // Update sort icons
        updateSortIcons(columnIndex);
    }

    function updateSortIcons(activeColumn) {
        const headers = document.querySelectorAll('th');
        headers.forEach((header, index) => {
            const icon = header.querySelector('.sort-icon');
            if (icon) {
                if (index === activeColumn) {
                    icon.textContent = sortDirection ? '↑' : '↓';
                } else {
                    icon.textContent = '↕️';
                }
            }
        });
    }

    // Initialize Sortable for package ordering
    new Sortable(document.getElementById('packagesTableBody'), {
        handle: '.drag-handle',
        animation: 150,
        onEnd: function() {
            const rows = document.querySelectorAll('#packagesTableBody tr');
            const order = Array.from(rows).map((row, index) => {
                return { 
                    id: row.getAttribute('data-id'), 
                    position: index + 1 
                };
            });

            // Update order numbers visually
            rows.forEach((row, index) => {
                row.querySelector('.order-value').textContent = index + 1;
            });

            // Send update to server
            fetch("{{ route('admin.coaching-packages.update-order') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Order updated successfully');
                }
            })
            .catch(error => {
                console.error('Error updating order:', error);
            });
        }
    });

    // Feature management functions
    function addFeature(containerId = 'features-container') {
        const container = document.getElementById(containerId);
        const div = document.createElement('div');
        div.className = 'flex items-center';
        div.innerHTML = `
            <input type="text" name="features[]" required class="flex-1 p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
            <button type="button" class="ml-2 text-red-500 hover:text-red-700" onclick="removeFeature(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        `;
        container.appendChild(div);
    }

    function removeFeature(button) {
        button.parentElement.remove();
    }

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal').forEach(modal => {
                modal.classList.add('hidden');
            });
        }
    });
</script>
@endsection