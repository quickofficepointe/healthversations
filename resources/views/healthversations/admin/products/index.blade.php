@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Cart Orders</h1>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Order ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Items
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Customer
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cartOrders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $order->order_id }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                @foreach($order->items as $item)
                                    <div class="mb-1">
                                        {{ $item['product'] ?? 'N/A' }} 
                                        (x{{ $item['quantity'] ?? 1 }})
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->customer_email }}</div>
                            <div class="text-sm text-gray-500">{{ $order->customer_phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Ksh {{ number_format($order->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($order->status === 'completed')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            @elseif($order->status === 'failed')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Failed
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-blue-600 hover:text-blue-900 mr-3" data-modal-toggle="cartOrderDetailsModal-{{ $order->id }}">
                                View
                            </a>
                            @if($order->status === 'pending')
                                <form action="{{ route('admin.cart-orders.update', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="text-green-600 hover:text-green-900">
                                        Complete
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>

                    <!-- Order Details Modal -->
                    <div id="cartOrderDetailsModal-{{ $order->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-3/4 p-6 max-h-screen overflow-y-auto">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Order Details - {{ $order->order_id }}</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <h4 class="font-medium text-gray-700">Customer Information</h4>
                                    <p class="text-gray-600">{{ $order->customer_name }}</p>
                                    <p class="text-gray-600">{{ $order->customer_email }}</p>
                                    <p class="text-gray-600">{{ $order->customer_phone }}</p>
                                    
                                    @if($order->address || $order->county)
                                    <h4 class="font-medium text-gray-700 mt-3">Delivery Information</h4>
                                    @if($order->county)<p class="text-gray-600">{{ $order->county }}</p>@endif
                                    @if($order->subcounty)<p class="text-gray-600">{{ $order->subcounty }}</p>@endif
                                    @if($order->location)<p class="text-gray-600">{{ $order->location }}</p>@endif
                                    @if($order->address)<p class="text-gray-600">{{ $order->address }}</p>@endif
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-700">Order Information</h4>
                                    <p class="text-gray-600"><span class="font-medium">Date:</span> {{ $order->created_at->format('d M Y, H:i') }}</p>
                                    <p class="text-gray-600"><span class="font-medium">Amount:</span> Ksh {{ number_format($order->amount, 2) }}</p>
                                    <p class="text-gray-600"><span class="font-medium">Status:</span> 
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                               ($order->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </p>
                                    @if($order->iveri_reference)
                                        <p class="text-gray-600"><span class="font-medium">iVeri Reference:</span> {{ $order->iveri_reference }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="font-medium text-gray-700 mb-2">Order Items</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Item
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Quantity
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Price
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($order->items as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        @if(isset($item['cover_image']))
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $item['cover_image']) }}" alt="{{ $item['product'] ?? 'Item' }}">
                                                        </div>
                                                        @endif
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">{{ $item['product'] ?? 'Unnamed Product' }}</div>
                                                            @if(isset($item['type']))
                                                            <div class="text-sm text-gray-500">{{ ucfirst($item['type']) }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $item['quantity'] ?? 1 }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Ksh {{ number_format($item['price'] ?? 0, 2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Ksh {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="cartOrderDetailsModal-{{ $order->id }}">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($cartOrders->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $cartOrders->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Toggle Script -->
<script>
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
</script>
@endsection