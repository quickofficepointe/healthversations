@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Privacy Policies</h1>
        <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200"
                data-modal-toggle="addPrivacyPolicyModal">
            Add Privacy Policy
        </button>
    </div>

    <!-- Privacy Policies Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <h2 class="text-xl font-semibold text-gray-800 p-4 border-b">Privacy Policies</h2>
        <div class="overflow-x-auto">
            <table id="privacyTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Privacy Content</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($privacypolicy as $policy)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 text-sm text-gray-700">{!! Str::limit(strip_tags($policy->privacy), 100) !!}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <button class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200"
                                        data-modal-toggle="editPrivacyPolicyModal{{ $policy->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('privacy.destroy', $policy->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this policy?');">
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

    <!-- Add Privacy Policy Modal -->
    <div id="addPrivacyPolicyModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-xl font-semibold text-gray-800">Add Privacy Policy</h3>
                <button class="text-gray-500 hover:text-gray-700" data-modal-toggle="addPrivacyPolicyModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form action="{{ route('privacy.store') }}" method="POST" id="addPrivacyForm">
                    @csrf
                    <div class="mb-4">
                        <label for="privacy" class="block text-sm font-medium text-gray-700 mb-1">Privacy Content</label>
                        <textarea name="privacy" id="add_privacy" class="summernote"></textarea>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="border-t p-4 flex justify-end space-x-3">
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200"
                        data-modal-toggle="addPrivacyPolicyModal">
                    Cancel
                </button>
                <button type="submit" form="addPrivacyForm" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                    Save
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Privacy Policy Modals -->
    @foreach($privacypolicy as $policy)
    <div id="editPrivacyPolicyModal{{ $policy->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-xl font-semibold text-gray-800">Edit Privacy Policy</h3>
                <button class="text-gray-500 hover:text-gray-700" data-modal-toggle="editPrivacyPolicyModal{{ $policy->id }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form action="{{ route('privacy.update', $policy->id) }}" method="POST" id="editPrivacyForm{{ $policy->id }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="privacy" class="block text-sm font-medium text-gray-700 mb-1">Privacy Content</label>
                        <textarea name="privacy" id="edit_privacy_{{ $policy->id }}" class="summernote">{{ $policy->privacy }}</textarea>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="border-t p-4 flex justify-end space-x-3">
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200"
                        data-modal-toggle="editPrivacyPolicyModal{{ $policy->id }}">
                    Cancel
                </button>
                <button type="submit" form="editPrivacyForm{{ $policy->id }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                    Update
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

@section('scripts')
<script>
    $(document).ready(function () {
        // Initialize DataTable
        $('#privacyTable').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search privacy policies..."
            },
            columnDefs: [
                { orderable: false, targets: [1] }
            ],
            order: [[0, 'asc']]
        });

        // Summernote initialization
        $('.summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onInit: function() {
                    $('.note-btn').removeClass('btn-light').addClass('btn-outline-secondary');
                }
            }
        });

        // Modal toggles
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', (e) => {
                const modalId = e.target.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                modal.classList.toggle('hidden');

                // Reinitialize Summernote if modal is opened
                if (!modal.classList.contains('hidden')) {
                    setTimeout(() => {
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
                                ['insert', ['link', 'picture', 'video']],
                                ['view', ['fullscreen', 'codeview', 'help']]
                            ]
                        });
                    }, 200);
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
    });
</script>
@endsection
@endsection
