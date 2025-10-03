@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Terms and Conditions</h1>
        <!-- Add Button -->
        <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200"
                data-modal-toggle="addTermsModal">
            Add Terms and Conditions
        </button>
    </div>

    <!-- Terms and Conditions Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <h2 class="text-xl font-semibold text-gray-800 p-4 border-b">Terms and Conditions</h2>
        <div class="overflow-x-auto">
            <table id="termsTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                            Terms Content
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($termsandconditions as $terms)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {!! Str::limit(strip_tags($terms->terms), 100) !!}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <!-- Edit Button -->
                                <button class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200"
                                        data-modal-toggle="editTermsModal{{ $terms->id }}">
                                    Edit
                                </button>
                                <!-- Delete Button -->
                                <form action="{{ route('terms.destroy', $terms->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this Terms and Conditions entry?');">
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

    <!-- Add Terms Modal -->
    <div id="addTermsModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-xl font-semibold text-gray-800">Add Terms and Conditions</h3>
                <button class="text-gray-500 hover:text-gray-700 transition-colors" data-modal-toggle="addTermsModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form action="{{ route('terms.store') }}" method="POST" id="addTermsForm">
                    @csrf
                    <div class="mb-4">
                        <label for="terms" class="block text-sm font-medium text-gray-700 mb-1">Terms Content</label>
                        <textarea name="terms" id="add_terms" class="summernote"></textarea>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="border-t p-4 flex justify-end space-x-3">
                <button type="button"
                        class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200"
                        data-modal-toggle="addTermsModal">
                    Cancel
                </button>
                <button type="submit" form="addTermsForm"
                        class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                    Save
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Terms Modal -->
    @foreach($termsandconditions as $terms)
    <div id="editTermsModal{{ $terms->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-xl font-semibold text-gray-800">Edit Terms and Conditions</h3>
                <button class="text-gray-500 hover:text-gray-700 transition-colors" data-modal-toggle="editTermsModal{{ $terms->id }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form action="{{ route('terms.update') }}" method="POST" id="editTermsForm{{ $terms->id }}">
                    @csrf
                    <input type="hidden" name="terms_id" value="{{ $terms->id }}">
                    <div class="mb-4">
                        <label for="terms" class="block text-sm font-medium text-gray-700 mb-1">Terms Content</label>
                        <textarea name="terms" id="edit_terms_{{ $terms->id }}" class="summernote">{{ $terms->terms }}</textarea>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="border-t p-4 flex justify-end space-x-3">
                <button type="button"
                        class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200"
                        data-modal-toggle="editTermsModal{{ $terms->id }}">
                    Cancel
                </button>
                <button type="submit" form="editTermsForm{{ $terms->id }}"
                        class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
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
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Modal toggle
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', (e) => {
                const modalId = e.target.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                modal.classList.toggle('hidden');
            });
        });

        // Close modals when clicking outside content
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
