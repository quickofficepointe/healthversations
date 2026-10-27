{{-- Site-wide modals, included by layouts/app.blade.php. Opened/closed by public/Assets/js/modal.js --}}

<!-- Rate Us Modal -->
<div id="rateUsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="rateUsTitle">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="bg-[#0A4040] text-white p-6 rounded-t-2xl">
            <div class="flex justify-between items-center">
                <h3 id="rateUsTitle" class="text-xl font-bold">Share Your Experience</h3>
                <button type="button" id="closeModal" class="text-white hover:text-gray-300 transition-colors" aria-label="Close">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <p class="text-green-200 mt-2">We'd love to hear about your journey with us!</p>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <form id="rateUsForm" action="{{ route('testimonials.store') }}" method="POST">
                @csrf
                @if($errors->hasAny(['full_name', 'email', 'message', 'rating']))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3">
                        @foreach(['full_name', 'email', 'message', 'rating'] as $field)
                            @if($errors->has($field))<p>{{ $errors->first($field) }}</p>@endif
                        @endforeach
                    </div>
                @endif
                <div class="mb-4">
                    <label for="rateUsName" class="block text-gray-700 font-medium mb-2">Your Name *</label>
                    <input type="text" id="rateUsName" name="full_name" maxlength="255" value="{{ old('full_name', optional(auth()->user())->name) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#93C754] focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <label for="rateUsEmail" class="block text-gray-700 font-medium mb-2">Your Email *</label>
                    <input type="email" id="rateUsEmail" name="email" maxlength="255" value="{{ old('email', optional(auth()->user())->email) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#93C754] focus:border-transparent" required>
                </div>

                <div class="mb-4">
                    <span class="block text-gray-700 font-medium mb-2">Your Rating *</span>
                    <div class="flex space-x-2" id="rateUsStars">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="text-3xl text-gray-300 hover:text-yellow-400 rate-us-star" data-rating="{{ $i }}" aria-label="{{ $i }} {{ Str::plural('star', $i) }}">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rateUsRating" value="{{ old('rating') }}">
                    <p id="rateUsRatingError" class="text-red-500 text-sm mt-1 hidden">Please choose a rating.</p>
                </div>

                <div class="mb-6">
                    <label for="rateUsMessage" class="block text-gray-700 font-medium mb-2">Your Experience *</label>
                    <textarea id="rateUsMessage" name="message" rows="4" placeholder="Share your health journey and results..."
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#93C754] focus:border-transparent" required>{{ old('message') }}</textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" id="rateUsCancel" class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium transition-colors">Cancel</button>
                    <button type="submit" class="bg-[#93C754] hover:bg-[#7eae47] text-white px-6 py-2 rounded-lg font-medium transition-colors">Share Experience</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('rateUsModal');
    if (!modal) return;

    const form = document.getElementById('rateUsForm');
    const ratingInput = document.getElementById('rateUsRating');
    const ratingError = document.getElementById('rateUsRatingError');
    const stars = modal.querySelectorAll('.rate-us-star');

    function paint(rating) {
        stars.forEach((star, i) => {
            star.classList.toggle('text-yellow-400', i < rating);
            star.classList.toggle('text-gray-300', i >= rating);
        });
    }

    stars.forEach(star => {
        star.addEventListener('click', function () {
            ratingInput.value = this.dataset.rating;
            ratingError.classList.add('hidden');
            paint(parseInt(this.dataset.rating, 10));
        });
    });
    paint(parseInt(ratingInput.value, 10) || 0);

    // Opening and the close (X) button are handled by modal.js; Cancel and Esc are handled here
    const hide = () => modal.classList.add('hidden');
    document.getElementById('rateUsCancel').addEventListener('click', hide);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') hide(); });

    form.addEventListener('submit', function (e) {
        if (!ratingInput.value) {
            e.preventDefault();
            ratingError.classList.remove('hidden');
        }
    });

    // Re-open with the user's input if the server rejected the submission
    @if($errors->hasAny(['full_name', 'email', 'message', 'rating']))
        modal.classList.remove('hidden');
    @endif
})();
</script>
