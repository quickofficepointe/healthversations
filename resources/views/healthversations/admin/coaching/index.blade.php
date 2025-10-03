@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Coaching Packages</h1>
        <!-- Add Package Button -->
        <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200" data-modal-toggle="addPackageModal">
            Add New Package
        </button>
    </div>

    <!-- Packages Table -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="packagesTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Image</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Package Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Duration</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">USD Price</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">KSH Price</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="sortable-packages">
                    @foreach($packages as $package)
                    <tr class="hover:bg-gray-50 transition duration-200" data-id="{{ $package->id }}">
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <span class="drag-handle cursor-move">↕️</span>
                            {{ $package->sort_order }}
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
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $package->package_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $package->duration }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">${{ number_format($package->price_usd, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">KSh {{ number_format($package->price_kes, 2) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $package->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-2">
                                <button class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200"
                                        data-modal-toggle="editPackageModal{{ $package->id }}">
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
                        <input type="hidden" name="is_active" value="0"> <!-- This ensures a value is always sent -->
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
                            </button>
                        </div>
                    </div>
                    <button type="button" onclick="addFeature()" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Add Feature
                    </button>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Package Description</label>
                    <textarea name="description" id="description" class="summernote mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="addPackageModal">
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
                        <input type="hidden" name="is_active" value="0"> <!-- This ensures a value is always sent -->
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 极 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 极 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
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
                    <textarea name="description" id="description{{ $package->id }}" class="summernote mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">{{ $package->description }}</textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="editPackageModal{{ $package->id }}">
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
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#packagesTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search packages...",
            },
            columnDefs: [
                { orderable: false, targets: [0, 1, 7] } // Order, Image, and Actions columns
            ],
            order: [[0, 'asc']] // Order by Order column by default
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

                // Check if it's a package modal
                if (modalId.includes('PackageModal')) {
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

            // Reinitialize Summernote when package modal is opened
            if (modalId.includes('PackageModal') && !modal.classList.contains('hidden')) {
                setTimeout(function() {
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

    // Initialize Sortable for package ordering
    new Sortable(document.getElementById('sortable-packages'), {
        handle: '.drag-handle',
        animation: 150,
        onEnd: function() {
            const rows = document.querySelectorAll('#sortable-packages tr');
            const order = Array.from(rows).map(row => {
                return { id: row.getAttribute('data-id'), position: Array.from(rows).indexOf(row) + 1 };
            });

            fetch("{{ route('admin.coaching-packages.update-order') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order })
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
                    <path fill-rule="evenodd" d="M9 极a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        `;
        container.appendChild(div);
    }

    function removeFeature(button) {
        button.parentElement.remove();
    }
</script>
@endsection
@endsection
