@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Custom Quotes Requests</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table id="customQuotesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($customPackages as $package)
                        <tr class="hover:bg-gray-50 transition duration-200" data-quote-id="{{ $package->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $package->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->phone_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->service }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($package->package_details, 50) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $package->status === 'completed' ? 'bg-green-100 text-green-800' : ($package->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst(str_replace('_', ' ', $package->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="openQuoteModal({{ $package->id }})" 
                                        class="text-primary-600 hover:text-primary-900 mr-3">
                                    View Details
                                </button>
                                @if($package->status !== 'completed')
                                    <form action="{{ route('custompackages.updateStatus', $package->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Mark this quote as completed?')">
                                            Complete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">No custom quotes requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Single Quote Details Modal -->
    <div id="quoteDetailsModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-3/4 lg:w-2/3 p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Custom Quote Details - #<span id="modalQuoteId"></span></h3>
                <button onclick="closeQuoteModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h4 class="font-medium text-gray-700 mb-3">Customer Information</h4>
                    <div class="space-y-2">
                        <p class="text-gray-600"><strong>Name:</strong> <span id="modalName"></span></p>
                        <p class="text-gray-600"><strong>Email:</strong> <span id="modalEmail"></span></p>
                        <p class="text-gray-600"><strong>Phone:</strong> <span id="modalPhone"></span></p>
                    </div>
                </div>
                <div>
                    <h4 class="font-medium text-gray-700 mb-3">Request Information</h4>
                    <div class="space-y-2">
                        <p class="text-gray-600"><strong>Service:</strong> <span id="modalService"></span></p>
                        <p class="text-gray-600"><strong>Status:</strong> <span id="modalStatus"></span></p>
                        <p class="text-gray-600"><strong>Submitted:</strong> <span id="modalCreatedAt"></span></p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4 mb-4">
                <h4 class="font-medium text-gray-700 mb-3">Package Details</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-600 whitespace-pre-line" id="modalPackageDetails"></p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <div class="flex justify-between items-center">
                    <div>
                        <form id="statusUpdateForm" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="updateStatus(this)" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </form>
                    </div>
                    <div class="flex space-x-2">
                        <a href="#" id="modalEmailLink" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200 text-sm">
                            <i class="fas fa-envelope mr-1"></i> Email Customer
                        </a>
                        <button onclick="closeQuoteModal()" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200 text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Store quote data for easy access
    const quoteData = {!! json_encode($customPackages->keyBy('id')->toArray()) !!};

    // Modal functions
    function openQuoteModal(quoteId) {
        const quote = quoteData[quoteId];
        
        if (!quote) {
            console.error('Quote not found:', quoteId);
            return;
        }

        // Populate modal with data
        document.getElementById('modalQuoteId').textContent = quote.id;
        document.getElementById('modalName').textContent = quote.name;
        document.getElementById('modalEmail').textContent = quote.email;
        document.getElementById('modalPhone').textContent = quote.phone_number;
        document.getElementById('modalService').textContent = quote.service;
        document.getElementById('modalPackageDetails').textContent = quote.package_details;
        
        // Set status
        const statusClass = quote.status === 'completed' ? 'bg-green-100 text-green-800' : 
                           (quote.status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800');
        const statusText = quote.status.replace('_', ' ');
        document.getElementById('modalStatus').innerHTML = 
            `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">${statusText.charAt(0).toUpperCase() + statusText.slice(1)}</span>`;
        
        // Set created at
        const createdAt = new Date(quote.created_at).toLocaleString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        document.getElementById('modalCreatedAt').textContent = createdAt;
        
        // Set email link
        document.getElementById('modalEmailLink').href = `mailto:${quote.email}?subject=Regarding Your Custom Quote Request #${quote.id}`;
        
        // Set form action
        document.getElementById('statusUpdateForm').action = `{{ route('custompackages.updateStatus', '') }}/${quote.id}`;
        
        // Set current status in select
        const statusSelect = document.querySelector('select[name="status"]');
        statusSelect.value = quote.status;
        
        // Show modal
        document.getElementById('quoteDetailsModal').classList.remove('hidden');
    }

    function closeQuoteModal() {
        document.getElementById('quoteDetailsModal').classList.add('hidden');
    }

    function updateStatus(select) {
        if (confirm('Are you sure you want to update the status?')) {
            document.getElementById('statusUpdateForm').submit();
        } else {
            // Reset to original value
            const quoteId = document.getElementById('modalQuoteId').textContent;
            const originalStatus = quoteData[quoteId].status;
            select.value = originalStatus;
        }
    }

    $(document).ready(function() {
        // Initialize DataTables
        $('#customQuotesTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search quotes...",
            },
            columnDefs: [
                { orderable: false, targets: [8] } // Actions column
            ],
            order: [[0, 'desc']] // Order by ID descending
        });

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id === 'quoteDetailsModal') {
                closeQuoteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeQuoteModal();
            }
        });
    });
</script>
@endsection