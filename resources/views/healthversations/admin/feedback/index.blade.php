@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Testimonials</h1>
    </div>

    <!-- Testimonials Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <h2 class="text-xl font-semibold text-gray-800 p-4 border-b">Testimonials</h2>
        <div class="overflow-x-auto">
            <table id="testimonialsTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($testimonies as $testimony)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $testimony->full_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $testimony->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <button 
                                type="button" 
                                class="text-blue-600 hover:text-blue-800 transition-colors duration-200 message-preview"
                                data-message="{{ $testimony->message }}"
                                data-name="{{ $testimony->full_name }}"
                            >
                                {{ Str::limit($testimony->message, 50) }}
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center">
                                <span class="text-yellow-500 mr-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimony->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                                <span>({{ $testimony->rating }}/5)</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $testimony->is_enabled ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $testimony->is_enabled ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <form action="{{ route('admin.testimonials.update', $testimony->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-1 rounded-lg transition duration-200">
                                    {{ $testimony->is_enabled ? 'Disable' : 'Enable' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No testimonials found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Message Modal -->
<div id="messageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800" id="modalTitle">Testimonial Message</h3>
            <button type="button" id="closeModal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4">
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-1">From: <span id="modalName" class="font-medium"></span></p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <p id="modalMessage" class="text-gray-700 whitespace-pre-wrap"></p>
            </div>
            <div class="flex justify-end space-x-2">
                <button id="copyMessage" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Copy Message
                </button>
                <button id="closeModalBtn" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('messageModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalName = document.getElementById('modalName');
    const modalMessage = document.getElementById('modalMessage');
    const closeModal = document.getElementById('closeModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const copyMessageBtn = document.getElementById('copyMessage');
    const messagePreviewButtons = document.querySelectorAll('.message-preview');
    
    // Show modal when clicking on a message preview
    messagePreviewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const message = this.getAttribute('data-message');
            const name = this.getAttribute('data-name');
            
            modalName.textContent = name;
            modalMessage.textContent = message;
            
            modal.classList.remove('hidden');
        });
    });
    
    // Close modal when clicking close buttons
    closeModal.addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    
    closeModalBtn.addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    
    // Close modal when clicking outside the modal content
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
    
    // Copy message to clipboard
    copyMessageBtn.addEventListener('click', function() {
        const messageText = modalMessage.textContent;
        
        navigator.clipboard.writeText(messageText).then(function() {
            // Show success feedback
            const originalText = copyMessageBtn.innerHTML;
            copyMessageBtn.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Copied!
            `;
            copyMessageBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            copyMessageBtn.classList.add('bg-green-600');
            
            setTimeout(function() {
                copyMessageBtn.innerHTML = originalText;
                copyMessageBtn.classList.remove('bg-green-600');
                copyMessageBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }, 2000);
        }).catch(function(err) {
            console.error('Failed to copy text: ', err);
            alert('Failed to copy message to clipboard');
        });
    });
});
</script>
@endsection
@endsection