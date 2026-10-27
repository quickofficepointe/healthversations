@extends('healthversations.admin.layout.adminlayout')

@section('content')
@php
    $statusColors = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'confirmed' => 'bg-blue-100 text-blue-800',
        'processing' => 'bg-indigo-100 text-indigo-800',
        'completed' => 'bg-green-100 text-green-800',
        'failed' => 'bg-red-100 text-red-800',
        'cancelled' => 'bg-gray-200 text-gray-700',
    ];
@endphp
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Product Orders</h1>
        @if($etimsPendingCount > 0)
            <a href="{{ route('admin.cart-orders.index', ['etims' => 'pending']) }}"
               class="inline-flex items-center bg-orange-100 text-orange-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-200">
                <i class="fas fa-file-invoice mr-2"></i>
                {{ $etimsPendingCount }} eTIMS {{ Str::plural('invoice', $etimsPendingCount) }} awaiting upload
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.cart-orders.index') }}" class="bg-white rounded-lg shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Order ID, name, email or phone"
               class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">
        <select name="status" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">All statuses</option>
            @foreach(\App\Models\CartOrder::STATUSES as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <select name="etims" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">eTIMS: any</option>
            <option value="requested" @selected(request('etims') === 'requested')>eTIMS requested</option>
            <option value="pending" @selected(request('etims') === 'pending')>eTIMS awaiting upload</option>
            <option value="sent" @selected(request('etims') === 'sent')>eTIMS sent</option>
        </select>
        <div class="flex gap-2">
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
            <a href="{{ route('admin.cart-orders.index') }}" class="px-4 py-2 rounded-lg text-sm border text-gray-600 hover:bg-gray-50">Reset</a>
        </div>
    </form>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Delivery</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">eTIMS</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="{{ $order->etims_requested && !$order->etims_invoice_path ? 'bg-orange-50' : '' }}">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $order->order_id }}</div>
                                <div class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</div>
                            </td>
                            <td class="px-4 py-3 max-w-[14rem]">
                                <div class="text-gray-900">{{ $order->customer_name }}</div>
                                <div class="text-xs text-gray-500 truncate" title="{{ $order->customer_email }}">{{ $order->customer_email }}</div>
                                <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="font-medium">KES {{ number_format($order->amount, 2) }}</div>
                                <div class="text-xs text-gray-500">{{ count($order->items ?? []) }} {{ Str::plural('item', count($order->items ?? [])) }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($order->delivery_method === 'delivery')
                                    <div>Delivery (Zone {{ $order->delivery_zone }})</div>
                                    <div class="text-xs text-gray-500">{{ $order->county }}{{ $order->location ? ', ' . $order->location : '' }}</div>
                                @else
                                    Pickup
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <form action="{{ route('admin.cart-orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()"
                                            class="text-xs font-semibold rounded-full px-2 py-1 border-0 {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        @foreach(\App\Models\CartOrder::STATUSES as $status)
                                            <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                                @if($order->payment_method)
                                    <div class="text-xs text-gray-500 mt-1">{{ in_array($order->payment_method, ['kcb', 'kcb_mpesa']) ? 'M-Pesa' : 'Card' }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if(!$order->etims_requested)
                                    <span class="text-gray-400">—</span>
                                @elseif($order->etims_invoice_path)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Sent</span>
                                    <div class="text-xs text-gray-500 mt-1">{{ optional($order->etims_invoice_sent_at)->format('M d, H:i') ?? 'Not emailed' }}</div>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Requested</span>
                                    <div class="text-xs text-gray-500 mt-1">PIN: {{ $order->etims_kra_pin }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex flex-col items-stretch gap-1">
                                    <button type="button" onclick="viewOrder({{ $order->id }})"
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </button>
                                    @if($order->etims_requested)
                                        <button type="button" onclick="openEtimsModal({{ $order->id }}, @js($order->order_id), @js($order->etims_kra_pin), @js($order->etims_business_name ?: $order->customer_name), @js($order->etims_invoice_number))"
                                                class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-xs"
                                                title="{{ $order->etims_invoice_path ? 'Replace' : 'Attach' }} eTIMS invoice">
                                            <i class="fas fa-upload mr-1"></i>{{ $order->etims_invoice_path ? 'Replace' : 'eTIMS' }}
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-500">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t">{{ $orders->links() }}</div>
    </div>
</div>

<!-- Order Details Modal -->
<div id="orderModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Order Details</h3>
            <button type="button" onclick="closeModal('orderModal')" class="text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></button>
        </div>
        <div id="orderModalBody" class="p-6">Loading...</div>
    </div>
</div>

<!-- eTIMS Upload Modal -->
<div id="etimsModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Attach eTIMS Invoice — <span id="etimsOrderId"></span></h3>
            <button type="button" onclick="closeModal('etimsModal')" class="text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></button>
        </div>
        <form id="etimsForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="bg-gray-50 rounded p-3 text-sm">
                <p><span class="text-gray-500">KRA PIN:</span> <strong id="etimsPin"></strong></p>
                <p><span class="text-gray-500">Invoice name:</span> <strong id="etimsName"></strong></p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">eTIMS Invoice Number</label>
                <input type="text" name="etims_invoice_number" id="etimsNumber" maxlength="100" class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Invoice File (PDF, JPG or PNG, max 5MB) <span class="text-red-500">*</span></label>
                <input type="file" name="etims_invoice" accept=".pdf,.jpg,.jpeg,.png" required class="w-full text-sm">
            </div>
            <p class="text-xs text-gray-500">The invoice is emailed to the customer (cc sales) as soon as you save it.</p>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('etimsModal')" class="px-4 py-2 border rounded-lg text-sm">Cancel</button>
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm">
                    <i class="fas fa-paper-plane mr-1"></i>Save &amp; Send
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModal(id) {
        const el = document.getElementById(id);
        el.classList.remove('hidden');
        el.classList.add('flex');
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        el.classList.add('hidden');
        el.classList.remove('flex');
    }

    function viewOrder(id) {
        document.getElementById('orderModalBody').innerHTML = 'Loading...';
        openModal('orderModal');
        fetch(`{{ url('/admin/cart-orders') }}/${id}/details`, { headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(data => { document.getElementById('orderModalBody').innerHTML = data.html; })
            .catch(() => { document.getElementById('orderModalBody').innerHTML = '<p class="text-red-500">Error loading order details.</p>'; });
    }

    function openEtimsModal(id, orderId, pin, name, number) {
        document.getElementById('etimsForm').action = `{{ url('/admin/cart-orders') }}/${id}/etims`;
        document.getElementById('etimsOrderId').textContent = orderId;
        document.getElementById('etimsPin').textContent = pin || '—';
        document.getElementById('etimsName').textContent = name || '—';
        document.getElementById('etimsNumber').value = number || '';
        openModal('etimsModal');
    }
</script>
@endsection
