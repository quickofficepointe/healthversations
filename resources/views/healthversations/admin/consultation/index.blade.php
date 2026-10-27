@extends('healthversations.admin.layout.adminlayout')

@section('title', 'Manage Testimonials')

@section('content')
<div class="main-content">
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Testimonials Management</h1>
                <p class="text-gray-600 mt-1">Manage client testimonials and success stories</p>
            </div>
            <button id="addTestimonialBtn" class="mt-4 md:mt-0 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fas fa-plus mr-2"></i> Add New Testimonial
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="stat-card p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-star text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Testimonials</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $testimonials->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="stat-card p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Published</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $testimonials->where('is_public', true)->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="stat-card p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <i class="fas fa-feather-alt text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Featured</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $testimonials->where('featured', true)->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="stat-card p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <i class="fas fa-clock text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending Review</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $testimonials->where('images_approved', false)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                    <select id="bulkAction" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Bulk Actions</option>
                        <option value="publish">Publish</option>
                        <option value="unpublish">Unpublish</option>
                        <option value="feature">Mark as Featured</option>
                        <option value="unfeature">Remove Featured</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button id="applyBulkAction" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                        Apply
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600" id="selectedCount">0 items selected</span>
                </div>
            </div>
        </div>

        <!-- Testimonials Table -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="dataTables_wrapper">
                <table id="testimonialsTable" class="display data-table w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-3">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            </th>
                            <th class="px-4 py-3 text-left">Client</th>
                            <th class="px-4 py-3 text-left">Program</th>
                            <th class="px-4 py-3 text-left">Results</th>
                            <th class="px-4 py-3 text-left">Rating</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Featured</th>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testimonials as $testimonial)
                        <tr class="border-t border-gray-200 hover:bg-gray-50" data-id="{{ $testimonial->id }}">
                            <td class="px-4 py-3">
                                <input type="checkbox" class="rowCheckbox rounded border-gray-300 text-primary-600 focus:ring-primary-500" value="{{ $testimonial->id }}">
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 font-semibold mr-3">
                                        {{ substr($testimonial->client_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $testimonial->client_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $testimonial->client_age ? $testimonial->client_age . ' years' : 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $testimonial->program_type }}
                                </span>
                                @if($testimonial->program_duration_weeks)
                                <div class="text-sm text-gray-500 mt-1">{{ $testimonial->program_duration_weeks }} weeks</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($testimonial->weight_loss_kg)
                                <div class="text-sm font-medium text-green-600">-{{ $testimonial->weight_loss_kg }}kg</div>
                                @elseif($testimonial->weight_gain_kg)
                                <div class="text-sm font-medium text-blue-600">+{{ $testimonial->weight_gain_kg }}kg</div>
                                @endif
                                @if($testimonial->inches_lost)
                                <div class="text-sm text-gray-600">{{ $testimonial->inches_lost }}" lost</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $testimonial->rating ? '' : '-o' }} text-sm"></i>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600">({{ $testimonial->rating }})</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $testimonial->is_public ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $testimonial->is_public ? 'Published' : 'Draft' }}
                                </span>
                                @if(!$testimonial->images_approved)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-1">
                                    Pending
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <button class="toggle-featured inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $testimonial->featured ? 'bg-purple-100 text-purple-800 hover:bg-purple-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}"
                                    data-id="{{ $testimonial->id }}" data-featured="{{ $testimonial->featured ? 1 : 0 }}">
                                    {{ $testimonial->featured ? 'Featured' : 'Not Featured' }}
                                </button>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $testimonial->created_at->format('M j, Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-2">
                                    <button class="edit-btn text-blue-600 hover:text-blue-900 transition-colors" data-id="{{ $testimonial->id }}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="view-btn text-green-600 hover:text-green-900 transition-colors" data-id="{{ $testimonial->id }}" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="delete-btn text-red-600 hover:text-red-900 transition-colors" data-id="{{ $testimonial->id }}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Testimonial Modal -->
<div id="testimonialModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Add New Testimonial</h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="testimonialForm" enctype="multipart/form-data" class="overflow-y-auto" style="max-height: calc(90vh - 200px)">
            <div class="p-6 space-y-6">
                <!-- Client Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">Client Name *</label>
                        <input type="text" id="client_name" name="client_name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="client_location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input type="text" id="client_location" name="client_location" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="client_age" class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                        <input type="number" id="client_age" name="client_age" min="1" max="120" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="client_occupation" class="block text-sm font-medium text-gray-700 mb-2">Occupation</label>
                        <input type="text" id="client_occupation" name="client_occupation" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Program Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="program_type" class="block text-sm font-medium text-gray-700 mb-2">Program Type *</label>
                        <select id="program_type" name="program_type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Select Program Type</option>
                            <option value="Weight Loss">Weight Loss</option>
                            <option value="Muscle Gain">Muscle Gain</option>
                            <option value="Body Transformation">Body Transformation</option>
                            <option value="Fitness Coaching">Fitness Coaching</option>
                            <option value="Nutrition Planning">Nutrition Planning</option>
                            <option value="Lifestyle Change">Lifestyle Change</option>
                        </select>
                    </div>
                    <div>
                        <label for="program_duration_weeks" class="block text-sm font-medium text-gray-700 mb-2">Duration (Weeks)</label>
                        <input type="number" id="program_duration_weeks" name="program_duration_weeks" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Results -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="weight_loss_kg" class="block text-sm font-medium text-gray-700 mb-2">Weight Loss (kg)</label>
                        <input type="number" id="weight_loss_kg" name="weight_loss_kg" step="0.1" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="weight_gain_kg" class="block text-sm font-medium text-gray-700 mb-2">Weight Gain (kg)</label>
                        <input type="number" id="weight_gain_kg" name="weight_gain_kg" step="0.1" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="inches_lost" class="block text-sm font-medium text-gray-700 mb-2">Inches Lost</label>
                        <input type="number" id="inches_lost" name="inches_lost" step="0.1" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Images -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="before_image" class="block text-sm font-medium text-gray-700 mb-2">Before Image *</label>
                        <input type="file" id="before_image" name="before_image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <div id="beforeImagePreview" class="mt-2 hidden">
                            <img src="" alt="Before" class="h-32 object-cover rounded-lg border">
                        </div>
                    </div>
                    <div>
                        <label for="after_image" class="block text-sm font-medium text-gray-700 mb-2">After Image *</label>
                        <input type="file" id="after_image" name="after_image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <div id="afterImagePreview" class="mt-2 hidden">
                            <img src="" alt="After" class="h-32 object-cover rounded-lg border">
                        </div>
                    </div>
                </div>

                <!-- Testimonial Content -->
                <div>
                    <label for="testimonial_text" class="block text-sm font-medium text-gray-700 mb-2">Testimonial Text *</label>
                    <textarea id="testimonial_text" name="testimonial_text" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent summernote"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="challenges_overcome" class="block text-sm font-medium text-gray-700 mb-2">Challenges Overcome</label>
                        <textarea id="challenges_overcome" name="challenges_overcome" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                    </div>
                    <div>
                        <label for="key_achievements" class="block text-sm font-medium text-gray-700 mb-2">Key Achievements</label>
                        <textarea id="key_achievements" name="key_achievements" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                    </div>
                </div>

                <!-- Ratings & Social -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating *</label>
                        <div class="flex space-x-1" id="ratingStars">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 rating-star" data-rating="{{ $i }}">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" id="rating" name="rating" value="5" required>
                    </div>
                    <div>
                        <label for="social_media_handle" class="block text-sm font-medium text-gray-700 mb-2">Social Media Handle</label>
                        <input type="text" id="social_media_handle" name="social_media_handle" placeholder="@username" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Status Toggles -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="featured" name="featured" value="1" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="featured" class="ml-2 block text-sm text-gray-900">Featured Testimonial</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="is_verified" name="is_verified" value="1" checked class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_verified" class="ml-2 block text-sm text-gray-900">Verified</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="is_public" name="is_public" value="1" checked class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="is_public" class="ml-2 block text-sm text-gray-900">Publish Publicly</label>
                    </div>
                </div>

                <!-- Measurements Section -->
                <div id="measurementsSection">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-medium text-gray-900">Body Measurements</h4>
                        <button type="button" id="addMeasurement" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                            <i class="fas fa-plus mr-1"></i> Add Measurement
                        </button>
                    </div>
                    <div id="measurementsContainer" class="space-y-4">
                        <!-- Measurements will be added here dynamically -->
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 p-6 border-t border-gray-200 bg-gray-50">
                <button type="button" id="cancelBtn" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors">
                    Cancel
                </button>
                <button type="submit" id="submitBtn" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
                    Save Testimonial
                </button>
            </div>
        </form>
    </div>
</div>

<!-- View Testimonial Modal -->
<div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">View Testimonial</h3>
            <button id="closeViewModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 200px)" id="viewModalContent">
            <!-- Content will be loaded via AJAX -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let currentTestimonialId = null;
    let isEditMode = false;

    // Initialize DataTable
    const table = $('#testimonialsTable').DataTable({
        responsive: true,
        dom: "<'flex flex-col md:flex-row md:items-center md:justify-between p-4'<'mb-4 md:mb-0'l><'flex flex-col sm:flex-row sm:items-center'<'mb-2 sm:mb-0 sm:mr-4'f><'dt-buttons'B>>>" +
             "<'w-full overflow-x-auto'tr>" +
             "<'flex flex-col md:flex-row md:items-center md:justify-between p-4'<'mb-4 md:mb-0'i><'p'>>",
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search testimonials...",
        },
        buttons: [
            {
                extend: 'copy',
                className: 'px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 mb-2 sm:mb-0 sm:mr-2'
            },
            {
                extend: 'csv',
                className: 'px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 mb-2 sm:mb-0 sm:mr-2'
            },
            {
                extend: 'excel',
                className: 'px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 mb-2 sm:mb-0 sm:mr-2'
            },
            {
                extend: 'pdf',
                className: 'px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 mb-2 sm:mb-0 sm:mr-2'
            },
            {
                extend: 'print',
                className: 'px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 mb-2 sm:mb-0 sm:mr-2'
            }
        ]
    });

    // Initialize Summernote
    $('.summernote').summernote({
        height: 200,
        dialogsInBody: true,
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

    // Rating Stars
    $('#ratingStars .rating-star').on('click', function() {
        const rating = $(this).data('rating');
        $('#rating').val(rating);
        $('#ratingStars .rating-star').each(function(i) {
            if (i < rating) {
                $(this).find('i').removeClass('text-gray-300').addClass('text-yellow-400');
            } else {
                $(this).find('i').removeClass('text-yellow-400').addClass('text-gray-300');
            }
        });
    });

    // Image Preview
    $('#before_image, #after_image').on('change', function(e) {
        const input = $(this);
        const previewId = input.attr('id') + 'Preview';
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#' + previewId).html(`<img src="${e.target.result}" alt="${input.attr('id')}" class="h-32 object-cover rounded-lg border">`).removeClass('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Add Measurement Row
    $('#addMeasurement').on('click', function() {
        const measurementRow = `
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end measurement-row">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <input type="text" name="measurements[][type]" placeholder="e.g., Waist, Chest" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Before</label>
                    <input type="number" step="0.1" name="measurements[][before_value]" placeholder="0.0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">After</label>
                    <input type="number" step="0.1" name="measurements[][after_value]" placeholder="0.0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div class="flex items-end">
                    <select name="measurements[][unit]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="inches">Inches</option>
                        <option value="cm">Centimeters</option>
                    </select>
                    <button type="button" class="ml-2 text-red-600 hover:text-red-800 remove-measurement">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        $('#measurementsContainer').append(measurementRow);
    });

    // Remove Measurement Row
    $(document).on('click', '.remove-measurement', function() {
        $(this).closest('.measurement-row').remove();
    });

    // Modal Controls
    $('#addTestimonialBtn').on('click', function() {
        isEditMode = false;
        currentTestimonialId = null;
        $('#modalTitle').text('Add New Testimonial');
        $('#testimonialForm')[0].reset();
        $('#measurementsContainer').empty();
        $('.summernote').summernote('code', '');
        $('#beforeImagePreview, #afterImagePreview').addClass('hidden');
        $('#testimonialModal').removeClass('hidden');
    });

    $('#closeModal, #cancelBtn').on('click', function() {
        $('#testimonialModal').addClass('hidden');
    });

    $('#closeViewModal').on('click', function() {
        $('#viewModal').addClass('hidden');
    });

    // Edit Testimonial
    $(document).on('click', '.edit-btn', function() {
        const testimonialId = $(this).data('id');
        currentTestimonialId = testimonialId;
        isEditMode = true;

        // Show loading state
        $('#modalTitle').html('Loading... <i class="fas fa-spinner fa-spin ml-2"></i>');
        $('#testimonialModal').removeClass('hidden');

        // Load testimonial data via AJAX
        $.ajax({
            url: `/consult/testimonials/${testimonialId}/edit`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    // Populate form with response data
                    populateForm(response.testimonial);
                    $('#modalTitle').text('Edit Testimonial');
                } else {
                    Swal.fire('Error', 'Failed to load testimonial data', 'error');
                    $('#testimonialModal').addClass('hidden');
                }
            },
            error: function(xhr) {
                console.error('Edit error:', xhr);
                Swal.fire('Error', 'Failed to load testimonial data', 'error');
                $('#testimonialModal').addClass('hidden');
            }
        });
    });

    // View Testimonial
    $(document).on('click', '.view-btn', function() {
        const testimonialId = $(this).data('id');

        // Show loading state
        $('#viewModalContent').html('<div class="flex justify-center items-center h-32"><i class="fas fa-spinner fa-spin text-2xl text-primary-600"></i></div>');
        $('#viewModal').removeClass('hidden');

        $.ajax({
            url: `/consult/testimonials/${testimonialId}`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const testimonial = response.testimonial;
                    const viewContent = generateViewContent(testimonial);
                    $('#viewModalContent').html(viewContent);
                } else {
                    $('#viewModalContent').html('<div class="text-center text-red-600">Failed to load testimonial details</div>');
                }
            },
            error: function(xhr) {
                console.error('View error:', xhr);
                $('#viewModalContent').html('<div class="text-center text-red-600">Failed to load testimonial details</div>');
            }
        });
    });

    // Generate View Content
    function generateViewContent(testimonial) {
        return `
            <div class="space-y-6">
                <!-- Client Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Client Information</h4>
                        <div class="mt-2 space-y-2">
                            <p><strong>Name:</strong> ${testimonial.client_name}</p>
                            <p><strong>Location:</strong> ${testimonial.client_location || 'N/A'}</p>
                            <p><strong>Age:</strong> ${testimonial.client_age || 'N/A'} years</p>
                            <p><strong>Occupation:</strong> ${testimonial.client_occupation || 'N/A'}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Program Details</h4>
                        <div class="mt-2 space-y-2">
                            <p><strong>Program Type:</strong> ${testimonial.program_type}</p>
                            <p><strong>Duration:</strong> ${testimonial.program_duration_weeks || 'N/A'} weeks</p>
                            <p><strong>Rating:</strong> ${'★'.repeat(testimonial.rating)}${'☆'.repeat(5-testimonial.rating)} (${testimonial.rating}/5)</p>
                        </div>
                    </div>
                </div>

                <!-- Results -->
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Results</h4>
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                        ${testimonial.weight_loss_kg ? `<div class="text-center p-3 bg-green-50 rounded-lg"><p class="text-sm text-green-600">Weight Loss</p><p class="text-lg font-bold">${testimonial.weight_loss_kg} kg</p></div>` : ''}
                        ${testimonial.weight_gain_kg ? `<div class="text-center p-3 bg-blue-50 rounded-lg"><p class="text-sm text-blue-600">Weight Gain</p><p class="text-lg font-bold">${testimonial.weight_gain_kg} kg</p></div>` : ''}
                        ${testimonial.inches_lost ? `<div class="text-center p-3 bg-purple-50 rounded-lg"><p class="text-sm text-purple-600">Inches Lost</p><p class="text-lg font-bold">${testimonial.inches_lost}"</p></div>` : ''}
                    </div>
                </div>

                <!-- Images -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Before Image</h4>
                        <div class="mt-2">
                            <img src="/storage/${testimonial.before_image}" alt="Before" class="w-full h-48 object-cover rounded-lg border">
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">After Image</h4>
                        <div class="mt-2">
                            <img src="/storage/${testimonial.after_image}" alt="After" class="w-full h-48 object-cover rounded-lg border">
                        </div>
                    </div>
                </div>

                <!-- Testimonial Content -->
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Testimonial</h4>
                    <div class="mt-2 p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700">${testimonial.testimonial_text}</p>
                    </div>
                </div>

                ${testimonial.challenges_overcome ? `
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Challenges Overcome</h4>
                    <div class="mt-2 p-4 bg-yellow-50 rounded-lg">
                        <p class="text-gray-700">${testimonial.challenges_overcome}</p>
                    </div>
                </div>
                ` : ''}

                ${testimonial.key_achievements ? `
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Key Achievements</h4>
                    <div class="mt-2 p-4 bg-green-50 rounded-lg">
                        <p class="text-gray-700">${testimonial.key_achievements}</p>
                    </div>
                </div>
                ` : ''}

                <!-- Measurements -->
                ${testimonial.measurements && testimonial.measurements.length > 0 ? `
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Body Measurements</h4>
                    <div class="mt-2 space-y-2">
                        ${testimonial.measurements.map(measurement => `
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-medium">${measurement.measurement_type}</span>
                                <span class="text-sm text-gray-600">
                                    ${measurement.before_value} ${measurement.unit} → ${measurement.after_value} ${measurement.unit}
                                </span>
                            </div>
                        `).join('')}
                    </div>
                </div>
                ` : ''}

                <!-- Status -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-3 ${testimonial.featured ? 'bg-purple-50 text-purple-700' : 'bg-gray-50'} rounded-lg">
                        <p class="text-sm">Featured</p>
                        <p class="font-bold">${testimonial.featured ? 'Yes' : 'No'}</p>
                    </div>
                    <div class="text-center p-3 ${testimonial.is_public ? 'bg-green-50 text-green-700' : 'bg-gray-50'} rounded-lg">
                        <p class="text-sm">Published</p>
                        <p class="font-bold">${testimonial.is_public ? 'Yes' : 'No'}</p>
                    </div>
                    <div class="text-center p-3 ${testimonial.is_verified ? 'bg-blue-50 text-blue-700' : 'bg-gray-50'} rounded-lg">
                        <p class="text-sm">Verified</p>
                        <p class="font-bold">${testimonial.is_verified ? 'Yes' : 'No'}</p>
                    </div>
                </div>
            </div>
        `;
    }

    // Delete Testimonial
    $(document).on('click', '.delete-btn', function() {
        const testimonialId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This testimonial will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/consult/testimonials/${testimonialId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Deleted!', response.message, 'success');
                            // Remove the row from DataTable
                            table.row($(`tr[data-id="${testimonialId}"]`)).remove().draw();
                            updateStats();
                        }
                    },
                    error: function(xhr) {
                        console.error('Delete error:', xhr);
                        Swal.fire('Error', 'Failed to delete testimonial', 'error');
                    }
                });
            }
        });
    });

    // Toggle Featured
    $(document).on('click', '.toggle-featured', function() {
        const testimonialId = $(this).data('id');
        const currentlyFeatured = $(this).data('featured');

        $.ajax({
            url: `/consult/testimonials/${testimonialId}/toggle-featured`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    const button = $(`button[data-id="${testimonialId}"]`);
                    button.data('featured', response.featured ? 1 : 0);

                    if (response.featured) {
                        button.removeClass('bg-gray-100 text-gray-800 hover:bg-gray-200')
                              .addClass('bg-purple-100 text-purple-800 hover:bg-purple-200')
                              .text('Featured');
                    } else {
                        button.removeClass('bg-purple-100 text-purple-800 hover:bg-purple-200')
                              .addClass('bg-gray-100 text-gray-800 hover:bg-gray-200')
                              .text('Not Featured');
                    }

                    Swal.fire('Success', response.message, 'success');
                    updateStats();
                }
            },
            error: function(xhr) {
                console.error('Toggle featured error:', xhr);
                Swal.fire('Error', 'Failed to update featured status', 'error');
            }
        });
    });

    // Form Submission
    $('#testimonialForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const url = isEditMode ? `/consult/testimonials/${currentTestimonialId}` : '/consult/testimonials';
        const method = isEditMode ? 'PUT' : 'POST';

        // Make image fields optional for edit mode
        if (isEditMode) {
            if (!$('#before_image').val()) formData.delete('before_image');
            if (!$('#after_image').val()) formData.delete('after_image');
        }

        $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Saving...');

        $.ajax({
            url: url,
            method: method,
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', response.message, 'success');
                    $('#testimonialModal').addClass('hidden');
                    location.reload(); // Reload to show updated data
                }
            },
            error: function(xhr) {
                let errorMessage = 'Failed to save testimonial';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // Handle validation errors
                    const errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('<br>');
                }
                Swal.fire('Error', errorMessage, 'error');
            },
            complete: function() {
                $('#submitBtn').prop('disabled', false).html('Save Testimonial');
            }
        });
    });

    // Bulk Actions
    $('#selectAll').on('change', function() {
        $('.rowCheckbox').prop('checked', this.checked);
        updateSelectedCount();
    });

    $(document).on('change', '.rowCheckbox', function() {
        if (!$('.rowCheckbox').length) return;
        const allChecked = $('.rowCheckbox').length === $('.rowCheckbox:checked').length;
        $('#selectAll').prop('checked', allChecked);
        updateSelectedCount();
    });

    $('#applyBulkAction').on('click', function() {
        const action = $('#bulkAction').val();
        const selectedIds = $('.rowCheckbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (!action) {
            Swal.fire('Warning', 'Please select a bulk action', 'warning');
            return;
        }

        if (selectedIds.length === 0) {
            Swal.fire('Warning', 'Please select at least one testimonial', 'warning');
            return;
        }

        Swal.fire({
            title: 'Confirm Bulk Action',
            text: `Are you sure you want to ${action} ${selectedIds.length} testimonial(s)?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/consult/testimonials/bulk-action',
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        action: action
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        console.error('Bulk action error:', xhr);
                        Swal.fire('Error', 'Failed to perform bulk action', 'error');
                    }
                });
            }
        });
    });

    function updateSelectedCount() {
        const selectedCount = $('.rowCheckbox:checked').length;
        $('#selectedCount').text(`${selectedCount} item${selectedCount !== 1 ? 's' : ''} selected`);
    }

    function updateStats() {
        // This would typically be done via page reload, but you could implement AJAX updates here
        console.log('Stats would be updated here');
    }

    function populateForm(data) {
        $('#client_name').val(data.client_name || '');
        $('#client_location').val(data.client_location || '');
        $('#client_age').val(data.client_age || '');
        $('#client_occupation').val(data.client_occupation || '');
        $('#program_type').val(data.program_type || '');
        $('#program_duration_weeks').val(data.program_duration_weeks || '');
        $('#weight_loss_kg').val(data.weight_loss_kg || '');
        $('#weight_gain_kg').val(data.weight_gain_kg || '');
        $('#inches_lost').val(data.inches_lost || '');

        // Safely set summernote content
        if (data.testimonial_text) {
            $('#testimonial_text').summernote('code', data.testimonial_text);
        }

        $('#challenges_overcome').val(data.challenges_overcome || '');
        $('#key_achievements').val(data.key_achievements || '');
        $('#social_media_handle').val(data.social_media_handle || '');

        // Set rating
        const rating = data.rating || 5;
        $('#rating').val(rating);
        $('#ratingStars .rating-star').each(function(i) {
            if (i < rating) {
                $(this).find('i').removeClass('text-gray-300').addClass('text-yellow-400');
            } else {
                $(this).find('i').removeClass('text-yellow-400').addClass('text-gray-300');
            }
        });

        // Set checkboxes
        $('#featured').prop('checked', data.featured || false);
        $('#is_verified').prop('checked', data.is_verified !== undefined ? data.is_verified : true);
        $('#is_public').prop('checked', data.is_public !== undefined ? data.is_public : true);

        // Populate measurements
        $('#measurementsContainer').empty();
        if (data.measurements && data.measurements.length > 0) {
            data.measurements.forEach(measurement => {
                const measurementRow = `
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end measurement-row">
                        <input type="hidden" name="measurements[][id]" value="${measurement.id || ''}">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                            <input type="text" name="measurements[][type]" value="${measurement.measurement_type || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Before</label>
                            <input type="number" step="0.1" name="measurements[][before_value]" value="${measurement.before_value || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">After</label>
                            <input type="number" step="0.1" name="measurements[][after_value]" value="${measurement.after_value || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        <div class="flex items-end">
                            <select name="measurements[][unit]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="inches" ${(measurement.unit || 'inches') === 'inches' ? 'selected' : ''}>Inches</option>
                                <option value="cm" ${(measurement.unit || 'inches') === 'cm' ? 'selected' : ''}>Centimeters</option>
                            </select>
                            <button type="button" class="ml-2 text-red-600 hover:text-red-800 remove-measurement">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                $('#measurementsContainer').append(measurementRow);
            });
        }

        // Show existing images
        if (data.before_image) {
            const beforeImageUrl = data.before_image.startsWith('http') ? data.before_image : `/storage/${data.before_image}`;
            $('#beforeImagePreview').html(`<img src="${beforeImageUrl}" alt="Before" class="h-32 object-cover rounded-lg border">`).removeClass('hidden');
        }
        if (data.after_image) {
            const afterImageUrl = data.after_image.startsWith('http') ? data.after_image : `/storage/${data.after_image}`;
            $('#afterImagePreview').html(`<img src="${afterImageUrl}" alt="After" class="h-32 object-cover rounded-lg border">`).removeClass('hidden');
        }
    }
});
</script>
@endsection
