@extends('layouts.app')

@section('content')
<!-- Returns and Refunds Policy Section -->
<div class="container mx-auto px-4 py-10 my-10">
    <div class="w-24 h-1 bg-[#0A4040] mx-auto mb-6"></div>
    <h2 class="text-3xl font-bold text-center mb-8 text-[#0A4040]">Returns & Refund Policy</h2>

    <div class="max-w-5xl mx-auto text-gray-800 space-y-10 leading-relaxed text-lg">

        <!-- Returns Section -->
        <div>
            <h3 class="text-2xl font-semibold text-[#0A4040] mb-4">Returns</h3>
            <p>
                At <strong>Healthversation</strong>, we strive to ensure every customer is completely satisfied with their purchase. If you are not entirely happy with your order, we offer a simple and fair return policy.
            </p>

            <ul class="list-disc pl-6 space-y-2 mt-4">
                <li>Returns are accepted within <strong>7 days</strong> from the date of delivery.</li>
                <li>To be eligible for a return, the item must be unused, unopened, and in the original packaging.</li>
                <li>Items such as perishable goods (e.g., food, supplements, beverages) are not eligible for returns unless damaged or defective.</li>
                <li>You must provide proof of purchase or receipt.</li>
                <li>All returns must be approved by our support team before being sent back.</li>
            </ul>

            <p class="mt-4">
                To initiate a return, please contact us at 
                <a href="mailto:support@healthversation.com" class="text-[#0A4040] underline">support@healthversation.com</a> 
                or call our hotline at <strong>+254 700 123 456</strong>. Our team will guide you through the return process.
            </p>
        </div>

        <!-- Refunds Section -->
        <div>
            <h3 class="text-2xl font-semibold text-[#0A4040] mb-4">Refunds</h3>
            <p>
                Once we receive your returned item, we will inspect it and notify you of the status of your refund.
            </p>

            <ul class="list-disc pl-6 space-y-2 mt-4">
                <li>If your return is approved, a refund will be processed to your original method of payment within <strong>7–14 business days</strong>.</li>
                <li>Shipping costs are non-refundable unless the return is due to our error (e.g., wrong or damaged item).</li>
                <li>Late or missing refunds should be reported within 5 business days of the refund confirmation.</li>
            </ul>

            <p class="mt-4">
                If you experience any delay or issue with your refund, feel free to reach out to our support team for assistance.
            </p>
        </div>

        <!-- Final Note -->
        <div class="border-t border-gray-300 pt-6">
            <p class="italic">
                Thank you for choosing <strong>Healthversation</strong>. Your satisfaction and well-being are our top priorities.
            </p>
        </div>
    </div>
</div>
@endsection
