@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Ebook Orders</h1>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="ebookOrdersTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Ebook</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($ebookOrders as $order)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $order->order_id }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $order->ebook->title }}</div>
                            <div class="text-sm text-gray-500">ID: {{ $order->ebook_id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->customer_email }}</div>
                            <div class="text-sm text-gray-500">{{ $order->customer_phone }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            Ksh {{ number_format($order->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($order->status === 'completed')
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Completed
                                </span>
                            @elseif($order->status === 'failed')
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Failed
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-2">
                                <button class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1 rounded-lg transition duration-200"
                                        data-modal-toggle="orderDetailsModal{{ $order->id }}">
                                    View
                                </button>
                                @if($order->status === 'pending')
                                <form action="{{ route('admin.ebook-orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg transition duration-200">
                                        Complete
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Order Details Modals -->
    @foreach($ebookOrders as $order)
    <div id="orderDetailsModal{{ $order->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-6 max-h-[90vh] overflow-y-auto">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Order Details - {{ $order->order_id }}</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <h4 class="font-medium text-gray-700">Customer Information</h4>
                    <p class="text-sm text-gray-600">{{ $order->customer_name }}</p>
                    <p class="text-sm text-gray-600">{{ $order->customer_email }}</p>
                    <p class="text-sm text-gray-600">{{ $order->customer_phone }}</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-700">Order Information</h4>
                    <p class="text-sm text-gray-600"><span class="font-medium">Date:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-sm text-gray-600"><span class="font-medium">Amount:</span> Ksh {{ number_format($order->amount, 2) }}</p>
                    <p class="text-sm text-gray-600"><span class="font-medium">Status:</span>
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' :
                               ($order->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    @if($order->iveri_reference)
                        <p class="text-sm text-gray-600"><span class="font-medium">iVeri Reference:</span> {{ $order->iveri_reference }}</p>
                    @endif
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4 mb-4">
                <h4 class="font-medium text-gray-700 mb-2">Ebook Details</h4>
                <div class="flex items-start space-x-4">
                    <img src="{{ asset('storage/' . $order->ebook->cover_image) }}" alt="{{ $order->ebook->title }}" class="h-16 w-16 object-cover rounded">
                    <div>
                        <p class="font-medium text-gray-900">{{ $order->ebook->title }}</p>
                        <p class="text-sm text-gray-600">Price: Ksh {{ number_format($order->ebook->ebook_price, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="orderDetailsModal{{ $order->id }}">
                    Close
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#ebookOrdersTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search orders...",
            },
            order: [[5, 'desc']], // Order by Date column (index 5) descending by default
            columnDefs: [
                { orderable: false, targets: [6] } // Actions column
            ],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
        });

        // Toggle Modals
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', (e) => {
                const modalId = e.target.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                modal.classList.toggle('hidden');
            });
        });
    });
</script>
@endsection
@endsection
