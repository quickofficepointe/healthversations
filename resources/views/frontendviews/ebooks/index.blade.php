@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($ebooks as $ebook)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            <div class="h-48 overflow-hidden">
                <img src="{{ asset('storage/' . $ebook->cover_image) }}"
                     alt="{{ $ebook->title }}"
                     class="w-full h-full object-cover">
            </div>

            <div class="p-4">
                <h3 class="text-xl font-semibold mb-2">{{ $ebook->title }}</h3>
                <p class="text-gray-600 mb-4">{!! Str::limit($ebook->description, 100) !!}</p>

                <!-- Preview Button -->
                <button onclick="showPdfPreview('{{ asset('storage/' . $ebook->file_path) }}', {{ $ebook->page_count }})"
                        class="w-full bg-[#93C754] text-white py-2 rounded hover:bg-[#7eae47] transition">
                    Preview First 5 Pages ({{ $ebook->page_count }} total)
                </button>

                <!-- Purchase Button -->
                <div class="mt-4 flex justify-between items-center">
                    <span class="font-bold text-lg">${{ number_format($ebook->ebook_price, 2) }}</span>
                    <button onclick="showPurchaseModal({{ $ebook->id }}, '{{ $ebook->title }}', {{ $ebook->ebook_price }})"
                       class="px-4 py-2 bg-[#93C754] text-white rounded hover:bg-[#7eae47] transition">
                        Purchase Now
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
 <div class="mt-16 bg-[#0A4040] rounded-lg p-8 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">Looking for something specific?</h3>
            <p class="text-gray-200 mb-6">We can create custom products tailored to your unique health needs</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('custompackages.create') }}" class="bg-[#93C754] hover:bg-[#7eae47] text-[#0A4040] font-bold px-6 py-3 rounded-lg transition-colors">
                    Request Custom Product
                </a>
                <a href="" class="bg-white hover:bg-gray-100 text-[#0A4040] font-bold px-6 py-3 rounded-lg transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
<!-- PDF Preview Modal -->
<div id="pdf-preview-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 p-4 overflow-auto">
    <div class="bg-white max-w-4xl mx-auto rounded-lg p-6 relative min-h-[80vh]">
        <button onclick="hidePdfPreview()"
                class="absolute top-4 right-4 text-2xl text-gray-500 hover:text-gray-700">
            &times;
        </button>

        <div id="pdf-viewer" class="w-full h-[70vh] overflow-auto">
            <canvas id="pdf-canvas"></canvas>
        </div>

        <div class="flex justify-between mt-4">
            <button id="prev-page" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                Previous
            </button>
            <span id="page-num">Page: 1 of 5</span>
            <button id="next-page" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                Next
            </button>
        </div>
        <div class="text-center mt-2 text-sm text-gray-500">
            Preview limited to first 5 pages
        </div>
    </div>
</div>

<!-- Purchase Modal -->
<div id="purchase-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 p-4 overflow-auto">
    <div class="bg-white max-w-md mx-auto rounded-lg p-6 relative">
        <button onclick="hidePurchaseModal()"
                class="absolute top-4 right-4 text-2xl text-gray-500 hover:text-gray-700">
            &times;
        </button>

        <h3 class="text-xl font-semibold mb-4">Purchase Ebook</h3>
        <p class="text-gray-600 mb-2" id="ebook-title"></p>
        <p class="text-lg font-bold mb-6">Price: $<span id="ebook-price"></span></p>

        <form id="purchase-form" method="post" action="{{ route('ebook.order.process') }}">
            @csrf
            <!-- iVeri Required Fields -->
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

            <!-- Customer Information -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="Ecom_BillTo_Postal_Name_First" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754]">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="Ecom_BillTo_Online_Email" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754]">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                <input type="tel" name="Ecom_BillTo_Telecom_Phone_Number" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#93C754]">
            </div>

            <button type="submit" class="w-full bg-[#93C754] text-white py-3 rounded-md hover:bg-[#7eae47] transition">
                Proceed to Payment
            </button>
        </form>
    </div>
</div>

<!-- Add PDF.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script>
// Set PDF.js worker path
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

let currentPdf = null;
let currentPageNum = 1;
const PREVIEW_LIMIT = 5; // Restrict to first 5 pages

// PDF Preview Functions
function showPdfPreview(pdfUrl, totalPages) {
    const modal = document.getElementById('pdf-preview-modal');
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');

    // Load the PDF
    pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
        currentPdf = pdf;
        renderPage(1);
    });
}

function renderPage(num) {
    if (num > PREVIEW_LIMIT) {
        hidePdfPreview();
        return;
    }

    currentPdf.getPage(num).then(function(page) {
        const canvas = document.getElementById('pdf-canvas');
        const context = canvas.getContext('2d');
        const viewport = page.getViewport({ scale: 1.0 });

        canvas.height = viewport.height;
        canvas.width = viewport.width;

        page.render({
            canvasContext: context,
            viewport: viewport
        });

        document.getElementById('page-num').textContent = `Page: ${num} of ${PREVIEW_LIMIT}`;
        currentPageNum = num;

        // Disable next button if we're at the preview limit
        document.getElementById('next-page').disabled = num >= PREVIEW_LIMIT;
        document.getElementById('prev-page').disabled = num <= 1;
    });
}

function hidePdfPreview() {
    document.getElementById('pdf-preview-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    currentPdf = null;
    currentPageNum = 1;
}

// Purchase Modal Functions
function showPurchaseModal(ebookId, title, price) {
    document.getElementById('ebook-title').textContent = title;
    document.getElementById('ebook-price').textContent = price.toFixed(2);
    document.getElementById('ebook-id').value = ebookId;
    document.getElementById('form-order-amount').value = price * 100; // Convert to cents

    // Generate random order ID
    const orderId = 'EBOOK-' + Math.floor(100000 + Math.random() * 900000);
    document.getElementById('form-order-id').value = orderId;

    document.getElementById('purchase-modal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function hidePurchaseModal() {
    document.getElementById('purchase-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Event Listeners
document.getElementById('prev-page').addEventListener('click', function() {
    if (currentPageNum > 1) {
        renderPage(currentPageNum - 1);
    }
});

document.getElementById('next-page').addEventListener('click', function() {
    if (currentPageNum < PREVIEW_LIMIT) {
        renderPage(currentPageNum + 1);
    }
});

// Form submission handler
document.getElementById('purchase-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    // Validate required fields
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('border-red-500');
            isValid = false;
        } else {
            field.classList.remove('border-red-500');
        }
    });

    if (!isValid) {
        alert('Please fill in all required fields');
        return;
    }

    // Generate security token
    const email = this.querySelector('input[name="Ecom_BillTo_Online_Email"]').value;
    const amount = this.querySelector('input[name="Lite_Order_Amount"]').value;

    try {
        const token = await generateTransactionToken('YOUR_SHARED_SECRET', amount, email);
        document.getElementById('transaction-token').value = token;

        // Submit the form if token generation was successful
        this.submit();
    } catch (error) {
        console.error('Error generating token:', error);
        alert('Failed to generate security token. Please try again.');
    }
});

// Token generation function from your cart blade
async function generateTransactionToken(secretKey, amount, email) {
    const time = Math.floor(Date.now() / 1000);
    const resource = '/Lite/Authorise.aspx';
    const applicationId = '3a7f44fd-4bb4-432c-b483-32e5a19e100d';
    const tokenData = secretKey + time + resource + applicationId + amount + email;

    // SHA256 implementation
    async function sha256(message) {
        // Encode as UTF-8
        const msgBuffer = new TextEncoder().encode(message);

        // Hash the message
        const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);

        // Convert to hex string
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

        return hashHex;
    }

    const hash = await sha256(tokenData);
    return `x:${time}-${hash}`;
}
</script>
@endsection
