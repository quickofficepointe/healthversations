@extends('layouts.app')

@section('title', 'Digital Ebooks - Health & Wellness Guides | Health Versations')
@section('meta_description', 'Download premium health and wellness ebooks. Get expert guides on nutrition, gut health, weight loss, and holistic living. Start your journey to better health today.')
@section('meta_keywords', 'health ebooks, wellness guides, nutrition ebooks, weight loss guide, gut health book, holistic health, digital downloads, Health Versations')
@section('meta_author', 'Health Versations Team')
@section('meta_robots', 'index, follow')
@section('canonical_url', route('ebooks.show'))

@section('og_title', 'Digital Ebooks - Expert Health & Wellness Guides')
@section('og_description', 'Premium health ebooks covering nutrition, gut health, weight loss, and holistic wellness. Download instantly and start your transformation.')
@section('og_image', asset('Assets/images/ebooks-og.jpg'))
@section('og_image:width', '1200')
@section('og_image:height', '630')
@section('og_image:alt', 'Health Versations Ebook Library')
@section('og_type', 'website')

@section('twitter_title', 'Digital Health Ebooks | Health Versations')
@section('twitter_description', 'Download premium wellness guides and start your health journey today.')
@section('twitter_image', asset('Assets/images/ebooks-og.jpg'))
@section('twitter_card', 'summary_large_image')

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Health Ebooks Collection",
  "description": "Premium digital guides for health and wellness",
  "url": "{{ route('ebooks.show') }}",
  "numberOfItems": {{ $ebooks->count() }},
  "itemListElement": [
    @foreach($ebooks as $index => $ebook)
    {
      "@type": "ListItem",
      "position": {{ $index + 1 }},
      "item": {
        "@type": "Product",
        "name": "{{ addslashes($ebook->title) }}",
        "description": "{{ addslashes(Str::limit(strip_tags($ebook->description), 200)) }}",
        "image": "{{ asset('storage/' . $ebook->cover_image) }}",
        "offers": {
          "@type": "Offer",
          "price": "{{ $ebook->ebook_price }}",
          "priceCurrency": "KES",
          "availability": "https://schema.org/InStock",
          "url": "{{ url()->current() }}"
        }
      }
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endpush

@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "{{ url('/') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Ebooks",
      "item": "{{ route('ebooks.show') }}"
    }
  ]
}
</script>
@endpush

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-white py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-block bg-[#93C754]/10 rounded-full px-4 py-1 mb-4">
                <span class="text-[#0A4040] text-sm font-semibold">Digital Library</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Health & Wellness Ebooks
            </h1>
            <div class="w-24 h-1 bg-gradient-to-r from-[#93C754] to-[#0A4040] mx-auto mb-6 rounded-full"></div>
            <p class="text-lg text-gray-600">
                Download expert guides to transform your health. Instant access after purchase.
            </p>
        </div>

        <!-- Ebooks Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($ebooks as $ebook)
            @php
                $hasDiscount = false; // Set based on your discount logic
                $originalPrice = $ebook->ebook_price;
                $currentPrice = $originalPrice;
                $savings = 0;
            @endphp
            <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2"
                 data-ebook-id="{{ $ebook->id }}"
                 data-ebook-title="{{ $ebook->title }}"
                 data-ebook-price="{{ $ebook->ebook_price }}">

                <!-- Ebook Cover -->
                <div class="relative h-64 overflow-hidden bg-gradient-to-br from-[#0A4040] to-[#1a6b6b]">
                    @if($ebook->cover_image)
                        <img src="{{ asset('storage/' . $ebook->cover_image) }}"
                             alt="{{ $ebook->title }} - Health Ebook Cover"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             width="400"
                             height="300"
                             loading="lazy">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-book-open text-white text-6xl opacity-50"></i>
                        </div>
                    @endif

                    <!-- Badge -->
                    <div class="absolute top-4 right-4 bg-[#93C754] text-[#0A4040] text-xs font-bold px-3 py-1 rounded-full z-10 shadow-lg">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </div>
                </div>

                <!-- Ebook Content -->
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-[#93C754] transition-colors">
                        {{ $ebook->title }}
                    </h2>

                    <!-- Page Count Info -->
                    <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                        <span class="flex items-center">
                            <i class="fas fa-file-alt mr-1 text-[#93C754]"></i>
                            {{ $ebook->page_count ?? 'N/A' }} pages
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-download mr-1 text-[#93C754]"></i>
                            Instant Download
                        </span>
                    </div>

                    <!-- Description with Read More -->
                    <div class="mb-4">
                        <div class="description-container collapsed" id="desc-{{ $ebook->id }}">
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {!! Str::limit(strip_tags($ebook->description), 120) !!}
                            </p>
                            @if(strlen(strip_tags($ebook->description)) > 120)
                                <span class="hidden full-description">{!! $ebook->description !!}</span>
                            @endif
                        </div>
                        @if(strlen(strip_tags($ebook->description)) > 120)
                            <div class="flex justify-end mt-2">
                                <button class="read-more-btn text-[#93C754] font-medium text-sm hover:text-[#7eae47] transition-colors flex items-center gap-1"
                                        onclick="toggleDescription('desc-{{ $ebook->id }}', this)">
                                    Read More <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Preview Button -->
                    <button onclick="showPdfPreview('{{ asset('storage/' . $ebook->file_path) }}', {{ $ebook->page_count ?? 0 }})"
                            class="w-full border-2 border-[#93C754] text-[#93C754] py-2.5 rounded-xl font-semibold hover:bg-[#93C754] hover:text-white transition-all duration-300 mb-4 flex items-center justify-center gap-2">
                        <i class="fas fa-eye"></i>
                        Preview First 5 Pages
                    </button>

                    <!-- Price and Purchase -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <div>
                            @if($hasDiscount)
                                <span class="text-gray-400 line-through text-sm">KSH {{ number_format($originalPrice, 2) }}</span>
                                <span class="text-2xl font-bold text-[#93C754] block">KSH {{ number_format($currentPrice, 2) }}</span>
                                <span class="text-xs text-green-600">Save KSH {{ number_format($savings, 2) }}</span>
                            @else
                                <span class="text-2xl font-bold text-[#0A4040]">KSH {{ number_format($ebook->ebook_price, 2) }}</span>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <button onclick="showKcbPaymentModal({{ $ebook->id }}, '{{ addslashes($ebook->title) }}', {{ $ebook->ebook_price }})"
                                    class="px-4 py-2 bg-[#0A4040] text-white rounded-xl hover:bg-[#1a6b6b] transition-all text-sm font-semibold flex items-center gap-1">
                                <i class="fas fa-mobile-alt"></i> M-Pesa
                            </button>
                            <button onclick="showPurchaseModal({{ $ebook->id }}, '{{ addslashes($ebook->title) }}', {{ $ebook->ebook_price }})"
                                    class="px-4 py-2 bg-[#93C754] text-white rounded-xl hover:bg-[#7eae47] transition-all text-sm font-semibold flex items-center gap-1">
                                <i class="fas fa-credit-card"></i> Card
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if($ebooks->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-book-open text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Ebooks Available</h3>
            <p class="text-gray-500">Check back soon for new health and wellness guides!</p>
        </div>
        @endif

        <!-- Custom Packages CTA -->
        <div class="mt-16 bg-gradient-to-r from-[#0A4040] to-[#1a6b6b] rounded-2xl p-8 md:p-12 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Looking for something specific?</h2>
            <p class="text-gray-200 mb-8 max-w-2xl mx-auto">
                We can create custom products and personalized guides tailored to your unique health needs
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('custompackages.create') }}"
                   class="bg-[#93C754] hover:bg-[#7eae47] text-[#0A4040] font-bold px-8 py-3 rounded-xl transition-all transform hover:scale-105 inline-flex items-center justify-center gap-2">
                    <i class="fas fa-customize"></i>
                    Request Custom Product
                </a>
                <a href="{{ route('contact.health') }}"
                   class="bg-white hover:bg-gray-100 text-[#0A4040] font-bold px-8 py-3 rounded-xl transition-all transform hover:scale-105 inline-flex items-center justify-center gap-2">
                    <i class="fas fa-envelope"></i>
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</div>

<!-- PDF Preview Modal -->
<div id="pdf-preview-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 p-4 overflow-auto">
    <div class="bg-white max-w-4xl mx-auto rounded-2xl p-6 relative min-h-[80vh]">
        <button onclick="hideModal('pdf-preview-modal')"
                class="absolute top-4 right-4 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors z-10">
            <i class="fas fa-times"></i>
        </button>

        <h3 class="text-xl font-bold text-gray-800 mb-4">Ebook Preview</h3>

        <div id="pdf-viewer" class="w-full h-[70vh] overflow-auto bg-gray-100 rounded-lg p-4">
            <canvas id="pdf-canvas" class="mx-auto"></canvas>
        </div>

        <div class="flex justify-between items-center mt-4">
            <button id="prev-page" class="px-4 py-2 bg-gray-200 rounded-xl hover:bg-gray-300 transition-colors disabled:opacity-50" disabled>
                <i class="fas fa-chevron-left mr-1"></i> Previous
            </button>
            <span id="page-num" class="text-sm text-gray-600">Page: 1 of 5</span>
            <button id="next-page" class="px-4 py-2 bg-gray-200 rounded-xl hover:bg-gray-300 transition-colors">
                Next <i class="fas fa-chevron-right ml-1"></i>
            </button>
        </div>
        <div class="text-center mt-3 text-xs text-gray-400">
            Preview limited to first 5 pages
        </div>
    </div>
</div>

<!-- iVeri Purchase Modal -->
<div id="purchase-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 p-4 overflow-auto">
    <div class="bg-white max-w-md mx-auto rounded-2xl p-6 relative">
        <button onclick="hideModal('purchase-modal')"
                class="absolute top-4 right-4 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-[#93C754]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-book-open text-[#93C754] text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">Complete Purchase</h3>
        </div>

        <p class="text-gray-600 mb-2" id="ebook-title"></p>
        <p class="text-2xl font-bold text-[#93C754] mb-6">KSH <span id="ebook-price"></span></p>

        <form id="purchase-form" method="post" action="{{ route('ebook.order.process') }}">
            @csrf
            <input type="hidden" name="Lite_Version" value="4.0">
            <input type="hidden" name="Lite_Merchant_ApplicationId" value="3a7f44fd-4bb4-432c-b483-32e5a19e100d">
            <input type="hidden" name="Lite_Order_Amount" id="form-order-amount">
            <input type="hidden" name="Ecom_ConsumerOrderID" id="form-order-id">
            <input type="hidden" name="Lite_Website_Successful_Url" value="{{ route('payment.success') }}">
            <input type="hidden" name="Lite_Website_Fail_Url" value="{{ route('payment.fail') }}">
            <input type="hidden" name="Lite_Website_TryLater_Url" value="{{ route('payment.retry') }}">
            <input type="hidden" name="Lite_Website_Error_Url" value="{{ route('payment.error') }}">
            <input type="hidden" name="Lite_ConsumerOrderID_PreFix" value="EBOOK">
            <input type="hidden" name="Ecom_Payment_Card_Protocols" value="iVeri">
            <input type="hidden" name="Ecom_TransactionComplete" value="false">
            <input type="hidden" name="Lite_Currency_AlphaCode" value="KES">
            <input type="hidden" name="Lite_Transaction_Token" id="transaction-token">
            <input type="hidden" name="ebook_id" id="ebook-id">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="Ecom_BillTo_Postal_Name_First" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="Ecom_BillTo_Online_Email" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                    <input type="tel" name="Ecom_BillTo_Telecom_Phone_Number" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#93C754] focus:border-[#93C754] transition">
                </div>
            </div>

            <button type="submit" class="w-full bg-[#93C754] text-white py-3 rounded-xl font-bold hover:bg-[#7eae47] transition-all mt-6">
                Proceed to Payment
            </button>
        </form>
    </div>
</div>

<!-- KCB Payment Modal -->
<div id="kcb-payment-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 p-4 overflow-auto">
    <div class="bg-white max-w-md mx-auto rounded-2xl p-6 relative">
        <button onclick="hideModal('kcb-payment-modal')"
                class="absolute top-4 right-4 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-[#0A4040]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-mobile-alt text-[#0A4040] text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">Pay with M-Pesa</h3>
        </div>

        <p class="text-gray-600 mb-2" id="kcb-ebook-title"></p>
        <p class="text-2xl font-bold text-[#0A4040] mb-6">KSH <span id="kcb-ebook-price"></span></p>

        <form id="kcb-payment-form">
            @csrf
            <input type="hidden" name="payment_type" value="ebook">
            <input type="hidden" name="ebook_id" id="kcb-ebook-id">
            <input type="hidden" name="amount" id="kcb-order-amount">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="customer_name" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0A4040] focus:border-[#0A4040] transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0A4040] focus:border-[#0A4040] transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">M-Pesa Phone Number <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone_number" required placeholder="2547XXXXXXXX"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0A4040] focus:border-[#0A4040] transition">
                    <p class="text-xs text-gray-500 mt-1">Enter your M-Pesa registered phone number</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                    <select name="currency" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0A4040] focus:border-[#0A4040] transition">
                        <option value="KES">Kenya Shillings (KES)</option>
                    </select>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 my-6">
                <div class="flex items-start gap-2">
                    <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                    <p class="text-sm text-blue-700">
                        You will receive an M-Pesa prompt on your phone to complete the payment. Keep your phone handy.
                    </p>
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-[#0A4040] text-white py-3 rounded-xl font-bold hover:bg-[#1a6b6b] transition-all flex items-center justify-center gap-2">
                <i class="fas fa-mobile-alt"></i>
                Pay with M-Pesa
            </button>
        </form>
    </div>
</div>

<!-- Payment Status Modal -->
<div id="payment-status-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 p-4 overflow-auto">
    <div class="bg-white max-w-md mx-auto rounded-2xl p-6 relative text-center">
        <div id="payment-status-content"></div>
        <button onclick="hideModal('payment-status-modal')"
                class="mt-6 px-6 py-2 bg-[#93C754] text-white rounded-xl hover:bg-[#7eae47] transition">
            Close
        </button>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

<script>
// Initialize PDF.js
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

let currentPdf = null;
let currentPageNum = 1;
const PREVIEW_LIMIT = 5;
let paymentStatusInterval = null;

// Modal Functions
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    if (modalId === 'payment-status-modal' && paymentStatusInterval) {
        clearInterval(paymentStatusInterval);
        paymentStatusInterval = null;
    }
}

// Read More Toggle
function toggleDescription(descId, button) {
    const descContainer = document.getElementById(descId);
    const fullText = descContainer.querySelector('.full-description');

    if (descContainer.classList.contains('collapsed')) {
        if (fullText) {
            descContainer.querySelector('p').innerHTML = fullText.innerHTML;
        }
        descContainer.classList.remove('collapsed');
        button.innerHTML = 'Read Less <i class="fas fa-chevron-up text-xs"></i>';
    } else {
        const shortText = descContainer.querySelector('p').innerHTML.substring(0, 120);
        descContainer.querySelector('p').innerHTML = shortText + '...';
        descContainer.classList.add('collapsed');
        button.innerHTML = 'Read More <i class="fas fa-chevron-down text-xs"></i>';
    }
}

// PDF Preview
async function showPdfPreview(pdfUrl, totalPages) {
    showModal('pdf-preview-modal');

    try {
        const loadingTask = pdfjsLib.getDocument(pdfUrl);
        currentPdf = await loadingTask.promise;
        renderPage(1);
    } catch (error) {
        console.error('Error loading PDF:', error);
        alert('Failed to load PDF preview. Please try again.');
        hideModal('pdf-preview-modal');
    }
}

async function renderPage(num) {
    if (num > PREVIEW_LIMIT) {
        hideModal('pdf-preview-modal');
        return;
    }

    const page = await currentPdf.getPage(num);
    const canvas = document.getElementById('pdf-canvas');
    const context = canvas.getContext('2d');
    const viewport = page.getViewport({ scale: 1.5 });

    canvas.height = viewport.height;
    canvas.width = viewport.width;

    await page.render({ canvasContext: context, viewport: viewport }).promise;

    document.getElementById('page-num').textContent = `Page: ${num} of ${PREVIEW_LIMIT}`;
    currentPageNum = num;

    document.getElementById('prev-page').disabled = num <= 1;
    document.getElementById('next-page').disabled = num >= PREVIEW_LIMIT;
}

// Purchase Modals
function showPurchaseModal(ebookId, title, price) {
    document.getElementById('ebook-title').textContent = title;
    document.getElementById('ebook-price').textContent = price.toFixed(2);
    document.getElementById('ebook-id').value = ebookId;
    document.getElementById('form-order-amount').value = price * 100;
    document.getElementById('form-order-id').value = 'EBOOK-' + Math.floor(100000 + Math.random() * 900000);
    showModal('purchase-modal');
}

function showKcbPaymentModal(ebookId, title, price) {
    document.getElementById('kcb-ebook-title').textContent = title;
    document.getElementById('kcb-ebook-price').textContent = price.toFixed(2);
    document.getElementById('kcb-ebook-id').value = ebookId;
    document.getElementById('kcb-order-amount').value = price;
    showModal('kcb-payment-modal');
}

// Initialize Read More on load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.description-container').forEach(container => {
        if (container.scrollHeight <= 80) {
            const btn = container.parentElement.querySelector('.read-more-btn');
            if (btn) btn.style.display = 'none';
        }
    });

    // PDF Navigation
    document.getElementById('prev-page')?.addEventListener('click', () => {
        if (currentPageNum > 1) renderPage(currentPageNum - 1);
    });

    document.getElementById('next-page')?.addEventListener('click', () => {
        if (currentPageNum < PREVIEW_LIMIT) renderPage(currentPageNum + 1);
    });

    // KCB Payment Form
    document.getElementById('kcb-payment-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<div class="spinner"></div> Processing...';

        try {
            const formData = new FormData(this);
            const response = await fetch('{{ route("kcb.payment.initiate") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                hideModal('kcb-payment-modal');
                document.getElementById('payment-status-content').innerHTML = `
                    <div class="text-blue-600">
                        <i class="fas fa-spinner fa-spin text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Payment Initiated</h3>
                        <p class="text-gray-600">Check your phone for M-Pesa prompt...</p>
                    </div>
                `;
                showModal('payment-status-modal');

                paymentStatusInterval = setInterval(async () => {
                    const statusResponse = await fetch('{{ route("kcb.payment.status") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ checkout_request_id: data.checkout_request_id })
                    });
                    const statusData = await statusResponse.json();

                    if (statusData.status === 'completed') {
                        clearInterval(paymentStatusInterval);
                        document.getElementById('payment-status-content').innerHTML = `
                            <div class="text-green-600">
                                <i class="fas fa-check-circle text-4xl mb-4"></i>
                                <h3 class="text-xl font-semibold mb-2">Payment Successful!</h3>
                                <p class="text-gray-600">Your ebook has been purchased.</p>
                            </div>
                        `;
                        setTimeout(() => window.location.reload(), 3000);
                    } else if (statusData.status === 'failed') {
                        clearInterval(paymentStatusInterval);
                        document.getElementById('payment-status-content').innerHTML = `
                            <div class="text-red-600">
                                <i class="fas fa-times-circle text-4xl mb-4"></i>
                                <h3 class="text-xl font-semibold mb-2">Payment Failed</h3>
                                <p class="text-gray-600">Please try again.</p>
                            </div>
                        `;
                    }
                }, 3000);
            }
        } catch (error) {
            alert('Payment failed: ' + error.message);
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-mobile-alt mr-2"></i> Pay with M-Pesa';
        }
    });
});

// Close modals on escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        hideModal('pdf-preview-modal');
        hideModal('purchase-modal');
        hideModal('kcb-payment-modal');
        hideModal('payment-status-modal');
    }
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.description-container.collapsed {
    max-height: 4.5em;
    overflow: hidden;
}

.spinner {
    border: 2px solid #f3f3f3;
    border-top: 2px solid #93C754;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 1s linear infinite;
    display: inline-block;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endsection
