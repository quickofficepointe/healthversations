@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage FAQs</h1>
        <!-- Add FAQ Button -->
        <button class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200" data-modal-toggle="addFaqModal">
            Add FAQ
        </button>
    </div>

    <!-- FAQs Table -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
        <h2 class="text-xl font-semibold text-gray-800 p-4 border-b">FAQs List</h2>
        <div class="overflow-x-auto">
            <table id="faqsTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Question</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Answer</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($faqs as $faq)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($faq->question, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($faq->answer, 50) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <button class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200"
                                        data-modal-toggle="editFaqModal{{ $faq->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
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

    <!-- Add FAQ Modal -->
    <div id="addFaqModal" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Add FAQ</h3>
                <button class="text-gray-400 hover:text-gray-500" data-modal-toggle="addFaqModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('faqs.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="question" class="block text-sm font-medium text-gray-700">Question</label>
                    <textarea name="question" id="question" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Enter your question" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="answer" class="block text-sm font-medium text-gray-700">Answer</label>
                    <textarea name="answer" id="answer" rows="5" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" placeholder="Enter your answer" required></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="addFaqModal">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Save FAQ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit FAQ Modals -->
    @foreach($faqs as $faq)
    <div id="editFaqModal{{ $faq->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Edit FAQ</h3>
                <button class="text-gray-400 hover:text-gray-500" data-modal-toggle="editFaqModal{{ $faq->id }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('faqs.update', $faq->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_question{{ $faq->id }}" class="block text-sm font-medium text-gray-700">Question</label>
                    <textarea name="question" id="edit_question{{ $faq->id }}" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>{{ $faq->question }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="edit_answer{{ $faq->id }}" class="block text-sm font-medium text-gray-700">Answer</label>
                    <textarea name="answer" id="edit_answer{{ $faq->id }}" rows="5" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500" required>{{ $faq->answer }}</textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="editFaqModal{{ $faq->id }}">
                        Close
                    </button>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Update FAQ
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
        $('#faqsTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search FAQs...",
            },
            columnDefs: [
                { orderable: false, targets: [2] } // Actions column
            ],
            order: [[0, 'asc']] // Order by Question column by default
        });

        // Toggle Modals
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', (e) => {
                const modalId = e.target.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                modal.classList.toggle('hidden');
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
