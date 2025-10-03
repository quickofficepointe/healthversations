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
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $package->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->phone_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->service }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($package->package_details, 50) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $package->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($package->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $package->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-primary-600 hover:text-primary-900 mr-3" data-modal-toggle="quoteDetailsModal-{{ $package->id }}">
                                    View
                                </a>
                                @if($package->status !== 'completed')
                                    <form action="{{ route('custom.qoutes.update', $package->id) }}" method="POST" class="inline">
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

                        <!-- Quote Details Modal -->
                        <div id="quoteDetailsModal-{{ $package->id }}" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-2/3 p-6 max-h-screen overflow-y-auto">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Custom Quote Details - #{{ $package->id }}</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <h4 class="font-medium text-gray-700 mb-2">Customer Information</h4>
                                        <p class="text-gray-600"><strong>Name:</strong> {{ $package->name }}</p>
                                        <p class="text-gray-600"><strong>Email:</strong> {{ $package->email }}</p>
                                        <p class="text-gray-600"><strong>Phone:</strong> {{ $package->phone_number }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-700 mb-2">Request Information</h4>
                                        <p class="text-gray-600"><strong>Service:</strong> {{ $package->service }}</p>
                                        <p class="text-gray-600"><strong>Status:</strong>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $package->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($package->status) }}
                                            </span>
                                        </p>
                                        <p class="text-gray-600"><strong>Submitted:</strong> {{ $package->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 pt-4 mb-4">
                                    <h4 class="font-medium text-gray-700 mb-2">Package Details</h4>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-gray-600 whitespace-pre-line">{{ $package->package_details }}</p>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-md transition duration-200" data-modal-toggle="quoteDetailsModal-{{ $package->id }}">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">No custom quotes requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')

@endsection
@endsection
