@extends('healthversations.admin.layout.adminlayout')

@section('title', 'Consultation Orders')

@section('content')
@php
    $statusColors = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'approved' => 'bg-green-100 text-green-800',
        'confirmed' => 'bg-blue-100 text-blue-800',
        'completed' => 'bg-purple-100 text-purple-800',
        'cancelled' => 'bg-red-100 text-red-800',
    ];
    $paymentColors = [
        'paid' => 'bg-green-100 text-green-800',
        'failed' => 'bg-red-100 text-red-800',
        'refunded' => 'bg-gray-200 text-gray-700',
        'processing' => 'bg-indigo-100 text-indigo-800',
    ];
    $statuses = [
        \App\Models\Consultation::STATUS_PENDING,
        \App\Models\Consultation::STATUS_APPROVED,
        \App\Models\Consultation::STATUS_CONFIRMED,
        \App\Models\Consultation::STATUS_COMPLETED,
        \App\Models\Consultation::STATUS_CANCELLED,
    ];
@endphp
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Consultation Orders</h1>
        @if($etimsPendingCount > 0)
            <a href="{{ route('admin.const-orders.index', ['etims' => 'pending']) }}"
               class="inline-flex items-center bg-orange-100 text-orange-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-200">
                <i class="fas fa-file-invoice mr-2"></i>
                {{ $etimsPendingCount }} eTIMS {{ Str::plural('invoice', $etimsPendingCount) }} awaiting upload
            </a>
        @endif
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-xs text-gray-500 uppercase">Total</div>
            <div class="text-2xl font-semibold">{{ $totalCount }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-xs text-gray-500 uppercase">Pending</div>
            <div class="text-2xl font-semibold text-yellow-600">{{ $pendingCount }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-xs text-gray-500 uppercase">Approved</div>
            <div class="text-2xl font-semibold text-green-600">{{ $approvedCount }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-xs text-gray-500 uppercase">Unpaid</div>
            <div class="text-2xl font-semibold text-red-600">{{ $unpaidCount }}</div>
        </div>
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
    <form method="GET" action="{{ route('admin.const-orders.index') }}" class="bg-white rounded-lg shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-5 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email or phone"
               class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500">
        <select name="status" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">All statuses</option>
            @foreach($statuses as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <select name="payment" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">All payments</option>
            @foreach(\App\Models\Consultation::PAYMENT_STATUSES as $payment)
                <option value="{{ $payment }}" @selected(request('payment') === $payment)>{{ ucfirst($payment) }}</option>
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
            <a href="{{ route('admin.const-orders.index') }}" class="px-4 py-2 rounded-lg text-sm border text-gray-600 hover:bg-gray-50">Reset</a>
        </div>
    </form>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Consultation</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Schedule</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">eTIMS</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($consultations as $consultation)
                        <tr class="{{ $consultation->etims_requested && !$consultation->etims_invoice_path ? 'bg-orange-50' : '' }}">
                            <td class="px-4 py-3 max-w-[14rem]">
                                <div class="font-medium text-gray-900">#{{ $consultation->id }} · {{ $consultation->type_label }}</div>
                                <div class="text-xs text-gray-500">Booked {{ $consultation->created_at->format('M d, Y H:i') }}</div>
                            </td>
                            <td class="px-4 py-3 max-w-[14rem]">
                                <div class="text-gray-900">{{ $consultation->name }}</div>
                                <div class="text-xs text-gray-500 truncate" title="{{ $consultation->email }}">{{ $consultation->email }}</div>
                                <div class="text-xs text-gray-500">{{ $consultation->phone }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div>{{ \Carbon\Carbon::parse($consultation->consultation_date)->format('M d, Y') }} at {{ substr($consultation->consultation_time, 0, 5) }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $consultation->type === \App\Models\Consultation::TYPE_PHYSICAL ? 'Physical (Nairobi)' : ucfirst($consultation->location) }}{{ $consultation->timezone ? ' · ' . $consultation->timezone : '' }}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="font-medium">{{ $consultation->display_amount['formatted'] }}</div>
                                @if($consultation->payment_method)
                                    <div class="text-xs text-gray-500">{{ $consultation->payment_method === 'kcb' ? 'M-Pesa' : 'Card' }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <form action="{{ route('admin.const-orders.update', $consultation->id) }}" method="POST" class="flex flex-col gap-1">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()"
                                            class="text-xs font-semibold rounded-full px-2 py-1 border-0 {{ $statusColors[$consultation->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" @selected($consultation->status === $status)>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                    <select name="payment_status" onchange="this.form.submit()"
                                            class="text-xs font-semibold rounded-full px-2 py-1 border-0 {{ $paymentColors[$consultation->payment_status] ?? 'bg-yellow-100 text-yellow-800' }}">
                                        @foreach(\App\Models\Consultation::PAYMENT_STATUSES as $payment)
                                            <option value="{{ $payment }}" @selected($consultation->payment_status === $payment)>{{ ucfirst($payment) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if(!$consultation->etims_requested)
                                    <span class="text-gray-400">—</span>
                                @elseif($consultation->etims_invoice_path)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Sent</span>
                                    <div class="text-xs text-gray-500 mt-1">{{ optional($consultation->etims_invoice_sent_at)->format('M d, H:i') ?? 'Not emailed' }}</div>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Requested</span>
                                    <div class="text-xs text-gray-500 mt-1">PIN: {{ $consultation->etims_kra_pin }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex flex-col items-stretch gap-1">
                                    <button type="button" onclick="viewConsultation({{ $consultation->id }})"
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </button>
                                    @if($consultation->etims_requested)
                                        <button type="button" onclick="openEtimsModal({{ $consultation->id }}, @js('#' . $consultation->id), @js($consultation->etims_kra_pin), @js($consultation->etims_business_name ?: $consultation->name), @js($consultation->etims_invoice_number))"
                                                class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-xs"
                                                title="{{ $consultation->etims_invoice_path ? 'Replace' : 'Attach' }} eTIMS invoice">
                                            <i class="fas fa-upload mr-1"></i>{{ $consultation->etims_invoice_path ? 'Replace' : 'eTIMS' }}
                                        </button>
                                    @endif
                                    @if($consultation->hasEtimsInvoice())
                                        <a href="{{ route('admin.const-orders.etims.download', $consultation->id) }}"
                                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs text-center">
                                            <i class="fas fa-download mr-1"></i>Invoice
                                        </a>
                                        <form action="{{ route('admin.const-orders.etims.resend', $consultation->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs">
                                                <i class="fas fa-paper-plane mr-1"></i>Resend
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr id="details-{{ $consultation->id }}" class="hidden bg-gray-50">
                            <td colspan="7" class="px-4 py-4 text-sm">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-700 mb-1">Health Concerns</h4>
                                        <p class="text-gray-600 whitespace-pre-line">{{ $consultation->health_concerns }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-700 mb-1">Additional Notes</h4>
                                        <p class="text-gray-600 whitespace-pre-line">{{ $consultation->notes ?: '—' }}</p>
                                        @if($consultation->etims_requested)
                                            <h4 class="font-semibold text-gray-700 mt-3 mb-1">eTIMS Details</h4>
                                            <p class="text-gray-600">KRA PIN: {{ $consultation->etims_kra_pin }}</p>
                                            <p class="text-gray-600">Invoice name: {{ $consultation->etims_business_name ?: $consultation->name }}</p>
                                            @if($consultation->etims_invoice_number)
                                                <p class="text-gray-600">Invoice number: {{ $consultation->etims_invoice_number }}</p>
                                            @endif
                                        @endif
                                        @if($consultation->payment_reference)
                                            <p class="text-gray-600 mt-3">Payment ref: {{ $consultation->payment_reference }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-500">No consultations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t">{{ $consultations->links() }}</div>
    </div>
</div>

<!-- eTIMS Upload Modal -->
<div id="etimsModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Attach eTIMS Invoice — Consultation <span id="etimsOrderId"></span></h3>
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
            <p class="text-xs text-gray-500">The invoice is emailed to the client (cc sales) as soon as you save it.</p>
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

    function viewConsultation(id) {
        document.getElementById(`details-${id}`).classList.toggle('hidden');
    }

    function openEtimsModal(id, label, pin, name, number) {
        document.getElementById('etimsForm').action = `{{ url('/admin/consultations') }}/${id}/etims`;
        document.getElementById('etimsOrderId').textContent = label;
        document.getElementById('etimsPin').textContent = pin || '—';
        document.getElementById('etimsName').textContent = name || '—';
        document.getElementById('etimsNumber').value = number || '';
        openModal('etimsModal');
    }
</script>
@endsection
