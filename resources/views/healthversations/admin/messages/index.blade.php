@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Contact Messages</h1>
    </div>

    <!-- Messages Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table id="contactsTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($contacts as $contact)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $contact->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $contact->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $contact->phone_number ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <div class="max-w-xs truncate">{{ $contact->message }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $contact->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-primary-600 hover:text-primary-900 mr-3"
                                        data-modal-toggle="messageModal{{ $contact->id }}">
                                    View
                                </button>
                                <form action="" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Are you sure you want to delete this message?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Message Details Modal -->
                        <div id="messageModal{{ $contact->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 max-h-screen overflow-y-auto">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Message Details</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <h4 class="font-medium text-gray-700 mb-2">Contact Information</h4>
                                        <p class="text-gray-600"><strong>Name:</strong> {{ $contact->name }}</p>
                                        <p class="text-gray-600"><strong>Email:</strong> {{ $contact->email }}</p>
                                        <p class="text-gray-600"><strong>Phone:</strong> {{ $contact->phone_number ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-700 mb-2">Message Information</h4>
                                        <p class="text-gray-600"><strong>Date:</strong> {{ $contact->created_at->format('M d, Y H:i') }}</p>
                                        <p class="text-gray-600"><strong>Time:</strong> {{ $contact->created_at->format('H:i A') }}</p>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 pt-4 mb-4">
                                    <h4 class="font-medium text-gray-700 mb-2">Message Content</h4>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-gray-600 whitespace-pre-line">{{ $contact->message }}</p>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-2">
                                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200"
                                            data-modal-toggle="messageModal{{ $contact->id }}">
                                        Close
                                    </button>
                                    <a href="mailto:{{ $contact->email }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                                        Reply
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#contactsTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search messages...",
            },
            order: [[4, 'desc']], // Order by Date column (index 4) descending by default
            columnDefs: [
                { orderable: false, targets: [5] }, // Actions column
                { width: "20%", targets: [3] } // Message column width
            ],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            buttons: [
                {
                    extend: 'excel',
                    text: 'Export Excel',
                    className: 'bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded'
                },
                {
                    extend: 'pdf',
                    text: 'Export PDF',
                    className: 'bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded'
                }
            ]
        });

        // Modal Toggle Script
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', e => {
                const modalId = e.currentTarget.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                modal.classList.toggle('hidden');
            });
        });

        // Close modal when clicking outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', e => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    });
</script>
@endsection
@endsection
