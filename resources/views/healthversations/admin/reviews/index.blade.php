@extends('healthversations.admin.layout.adminlayout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Product Reviews</h1>
            <p class="text-sm text-gray-500">Approve reviews before they appear on product pages</p>
        </div>
        <div class="flex gap-2 text-sm">
            @foreach(['pending' => "Pending ($pendingCount)", 'approved' => "Approved ($approvedCount)", 'all' => "All ($totalCount)"] as $key => $label)
                <a href="{{ route('admin.reviews.index', ['status' => $key]) }}"
                   class="px-4 py-2 rounded-lg border {{ $status === $key ? 'bg-primary-600 text-white border-primary-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">{{ $label }}</a>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($reviews->isEmpty())
            <p class="p-8 text-center text-gray-500">No {{ $status === 'all' ? '' : $status }} reviews.</p>
        @else
            <div class="flex items-center gap-3 p-4 border-b border-gray-200">
                <select id="bulkAction" class="border rounded-lg px-3 py-2 text-sm">
                    <option value="">Bulk actions</option>
                    <option value="approve">Approve</option>
                    <option value="reject">Delete</option>
                </select>
                <button type="button" id="applyBulk" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm">Apply</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3"><input type="checkbox" id="selectAll"></th>
                            <th class="px-4 py-3">Reviewer</th>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3">Rating</th>
                            <th class="px-4 py-3">Review</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                            <tr class="border-t border-gray-200 hover:bg-gray-50 align-top" data-id="{{ $review->id }}">
                                <td class="px-4 py-3"><input type="checkbox" class="rowCheckbox" value="{{ $review->id }}"></td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $review->name }}</div>
                                    <div class="text-gray-500">{{ $review->email }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $review->reviewable->product_name ?? $review->reviewable->name ?? '—' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->star ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                </td>
                                <td class="px-4 py-3 text-gray-700 max-w-md">{{ $review->review }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $review->approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $review->approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $review->created_at->format('M j, Y') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @unless($review->approved)
                                        <button type="button" class="approve-btn text-green-600 hover:text-green-800 mr-3" data-id="{{ $review->id }}" title="Approve"><i class="fas fa-check"></i></button>
                                    @endunless
                                    <button type="button" class="delete-btn text-red-600 hover:text-red-800" data-id="{{ $review->id }}" title="Delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $reviews->appends(['status' => $status])->links() }}</div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
$(function () {
    const csrf = $('meta[name="csrf-token"]').attr('content');
    const done = (res) => Swal.fire(res.success ? 'Done' : 'Error', res.message, res.success ? 'success' : 'error').then(() => res.success && location.reload());
    const fail = () => Swal.fire('Error', 'Something went wrong. Please try again.', 'error');

    $('.approve-btn').on('click', function () {
        $.ajax({ url: `{{ url('admin/reviews') }}/${$(this).data('id')}/approve`, method: 'POST', headers: { 'X-CSRF-TOKEN': csrf } }).done(done).fail(fail);
    });

    $('.delete-btn').on('click', function () {
        const id = $(this).data('id');
        Swal.fire({ title: 'Delete this review?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc2626', confirmButtonText: 'Delete' })
            .then((r) => r.isConfirmed && $.ajax({ url: `{{ url('admin/reviews') }}/${id}/reject`, method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrf } }).done(done).fail(fail));
    });

    $('#selectAll').on('change', function () { $('.rowCheckbox').prop('checked', this.checked); });

    $('#applyBulk').on('click', function () {
        const action = $('#bulkAction').val();
        const ids = $('.rowCheckbox:checked').map(function () { return $(this).val(); }).get();
        if (!action || !ids.length) return Swal.fire('Select an action and at least one review', '', 'warning');
        $.ajax({ url: '{{ route('admin.reviews.bulk-action') }}', method: 'POST', data: { action, ids }, headers: { 'X-CSRF-TOKEN': csrf } }).done(done).fail(fail);
    });
});
</script>
@endsection
