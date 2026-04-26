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
                        <tr class="hover:bg-gray-50 transition duration-200" data-contact-id="{{ $contact->id }}">
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
                                <button data-contact-id="{{ $contact->id }}" 
                                        class="view-message-btn text-primary-600 hover:text-primary-900 mr-3">
                                    View
                                </button>
                                <form action="{{ route('contact.destroy', $contact->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Are you sure you want to delete this message?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Single Message Details Modal -->
    <div id="messageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Message Details</h3>
                <button class="close-modal-btn text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <h4 class="font-medium text-gray-700 mb-2">Contact Information</h4>
                    <div class="space-y-1">
                        <p class="text-gray-600"><strong>Name:</strong> <span id="modalName"></span></p>
                        <p class="text-gray-600"><strong>Email:</strong> <span id="modalEmail"></span></p>
                        <p class="text-gray-600"><strong>Phone:</strong> <span id="modalPhone"></span></p>
                    </div>
                </div>
                <div>
                    <h4 class="font-medium text-gray-700 mb-2">Message Information</h4>
                    <div class="space-y-1">
                        <p class="text-gray-600"><strong>Date:</strong> <span id="modalDate"></span></p>
                        <p class="text-gray-600"><strong>Time:</strong> <span id="modalTime"></span></p>
                        <p class="text-gray-600"><strong>Message ID:</strong> <span id="modalId"></span></p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4 mb-4">
                <h4 class="font-medium text-gray-700 mb-2">Message Content</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-600 whitespace-pre-line" id="modalMessage"></p>
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" class="close-modal-btn bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200">
                    Close
                </button>
                <a href="#" id="modalReplyLink" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md transition duration-200">
                    <i class="fas fa-reply mr-1"></i> Reply
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<script>
    // Store contact data
    const contactData = {};
    
    // Initialize contact data
    function initializeContactData() {
        document.querySelectorAll('tr[data-contact-id]').forEach(row => {
            const contactId = row.getAttribute('data-contact-id');
            const cells = row.querySelectorAll('td');
            
            let fullMessage = '';
            const messageCell = cells[3];
            if (messageCell) {
                const truncatedDiv = messageCell.querySelector('.max-w-xs');
                fullMessage = truncatedDiv ? truncatedDiv.textContent.trim() : messageCell.textContent.trim();
            }
            
            contactData[contactId] = {
                id: contactId,
                name: cells[0].textContent.trim(),
                email: cells[1].textContent.trim(),
                phone: cells[2].textContent.trim(),
                message: fullMessage,
                date: cells[4].textContent.trim()
            };
        });
    }

    // Modal functions
    function openMessageModal(contactId) {
        const contact = contactData[contactId];
        
        if (!contact) {
            console.error('Contact not found:', contactId);
            return;
        }

        // Populate modal
        document.getElementById('modalId').textContent = contact.id;
        document.getElementById('modalName').textContent = contact.name;
        document.getElementById('modalEmail').textContent = contact.email;
        document.getElementById('modalPhone').textContent = contact.phone === '-' ? 'Not provided' : contact.phone;
        document.getElementById('modalMessage').textContent = contact.message;
        
        // Format date
        const dateParts = contact.date.split(' ');
        const [year, month, day] = dateParts[0].split('-');
        const [hours, minutes] = dateParts[1].split(':');
        const dateObj = new Date(year, month - 1, day, hours, minutes);
        
        document.getElementById('modalDate').textContent = dateObj.toLocaleDateString();
        document.getElementById('modalTime').textContent = dateObj.toLocaleTimeString();
        
        // Set reply link
        const subject = `Re: Your message from ${contact.name}`;
        const body = `Dear ${contact.name},\n\nThank you for your message.\n\nBest regards,\nHealth Versation Team`;
        document.getElementById('modalReplyLink').href = `mailto:${contact.email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        
        // Show modal
        document.getElementById('messageModal').classList.remove('hidden');
    }

    function closeMessageModal() {
        document.getElementById('messageModal').classList.add('hidden');
    }

    // Initialize everything when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize contact data
        initializeContactData();
        
        // Add event listeners to view buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('view-message-btn')) {
                const contactId = e.target.getAttribute('data-contact-id');
                openMessageModal(contactId);
            }
        });
        
        // Close modal events
        document.querySelectorAll('.close-modal-btn').forEach(btn => {
            btn.addEventListener('click', closeMessageModal);
        });
        
        document.getElementById('messageModal').addEventListener('click', function(e) {
            if (e.target === this) closeMessageModal();
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeMessageModal();
        });
    });
</script>
@endsection