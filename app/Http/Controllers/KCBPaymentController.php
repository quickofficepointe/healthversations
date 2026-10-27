<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KcbService;
use Illuminate\Support\Facades\Log;
use App\Models\KcbPayment;
use App\Models\CartOrder;
use App\Models\Consultation;
use App\Models\EbookOrder;
use App\Models\Eorder;
use App\Models\CoachingEnrollment;
use App\Models\CustomPackage;
use Illuminate\Support\Str;

class KCBPaymentController extends Controller
{
    private $kcbService;

    public function __construct(KcbService $kcbService)
    {
        $this->kcbService = $kcbService;
    }

    /**
     * Unified KCB payment initiation for all payment types
     */
    public function initiateKcbPayment(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'payment_type' => 'required|in:product,consultation,ebook,coaching,custom_package',
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email',
            'currency' => 'required|string|in:KES,USD',
            'reference_data' => 'required|array' // Contains type-specific data
        ]);

        try {
            // Convert amount if needed
            $amount = $this->convertAmount($request->amount, $request->currency);

            // Create order record based on payment type
            $order = $this->createOrderRecord($request->payment_type, [
                'existing_order_id' => $request->existing_order_id,
                'amount' => $amount,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone_number,
                'currency' => $request->currency,
                'reference_data' => $request->reference_data
            ]);

            if (!$order) {
                throw new \Exception('Failed to create order record');
            }

            $paymentData = [
                'phone_number' => $request->phone_number,
                'amount' => $amount,
                'description' => $this->getPaymentDescription($request->payment_type, $order, $request->reference_data)
            ];

            $result = $this->kcbService->initiatePayment($paymentData, $request->payment_type);

            if (isset($result['success'])) {
                // Create KCB payment record
                $kcbPayment = KcbPayment::create([
                    'invoice_number' => $result['invoice_number'],
                    'checkout_request_id' => $result['checkout_request_id'],
                    'merchant_request_id' => $result['merchant_request_id'],
                    'phone_number' => $request->phone_number,
                    'amount' => $amount,
                    'payment_type' => $request->payment_type,
                    'reference_id' => $order->id,
                    'reference_type' => get_class($order),
                    'status' => 'pending',
                    'org_short_code' => '8234000'
                ]);

                // Update order with KCB payment references
                $order->update([
                    'kcb_payment_reference' => $result['checkout_request_id'],
                    'kcb_invoice_number' => $result['invoice_number'],
                    'payment_method' => 'kcb',
                    'payment_status' => 'pending'
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Payment initiated successfully',
                    'checkout_request_id' => $result['checkout_request_id'],
                    'invoice_number' => $result['invoice_number'],
                    'customer_message' => $result['customer_message'] ?? 'Check your phone for M-Pesa prompt',
                    'order_id' => $order->id,
                    'order_type' => $request->payment_type
                ]);
            }

            // If payment initiation fails, update order status
            $order->update(['status' => 'failed', 'payment_status' => 'failed']);

            return response()->json([
                'success' => false,
                'message' => $result['error'] ?? 'Failed to initiate payment'
            ], 400);

        } catch (\Exception $e) {
            Log::error('KCB Payment Error: ' . $e->getMessage(), [
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create order record based on payment type
     */
    private function createOrderRecord($paymentType, $data)
    {
        switch ($paymentType) {
            case 'product':
                return $this->createCartOrder($data);

            case 'consultation':
                return $this->createConsultationOrder($data);

            case 'ebook':
                return $this->createEbookOrder($data);

            case 'coaching':
                return $this->createCoachingEnrollment($data);

            case 'custom_package':
                return $this->createCustomPackage($data);

            default:
                throw new \Exception("Unknown payment type: {$paymentType}");
        }
    }

    /**
     * Create cart order for products
     */
    private function createCartOrder($data)
    {
        $referenceData = $data['reference_data'];

        // Checkout already created the order (with items, address and eTIMS details); reuse it
        if (!empty($data['existing_order_id'])) {
            $existing = CartOrder::where('order_id', $data['existing_order_id'])->first();
            if ($existing) {
                return $existing;
            }
        }

        return CartOrder::create([
            'order_id' => 'CART-' . Str::random(10),
            'amount' => $data['amount'],
            'items' => $referenceData['items'] ?? [],
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'county' => $referenceData['county'] ?? null,
            'subcounty' => $referenceData['subcounty'] ?? null,
            'location' => $referenceData['location'] ?? null,
            'address' => $referenceData['address'] ?? null,
            'delivery_method' => $referenceData['delivery_method'] ?? 'pickup',
            'delivery_zone' => $referenceData['delivery_zone'] ?? null,
            'delivery_cost' => $referenceData['delivery_cost'] ?? 0,
            'status' => 'pending',
            'payment_method' => 'kcb_mpesa'
        ]);
    }

    /**
     * Create consultation order
     */
/**
 * Create consultation order - UPDATE existing consultation instead of creating new one
 */
private function createConsultationOrder($data)
{
    $referenceData = $data['reference_data'];

    // Find the existing consultation instead of creating a new one
    $consultation = Consultation::find($referenceData['consultation_id']);

    if (!$consultation) {
        throw new \Exception('Consultation not found');
    }

    // Update the existing consultation with payment method
    $consultation->update([
        'payment_method' => 'kcb', // Use 'kcb' instead of 'kcb_mpesa'
        'payment_status' => 'processing'
    ]);

    return $consultation;
}

    /**
     * Create ebook order
     */
    private function createEbookOrder($data)
    {
        $referenceData = $data['reference_data'];

        return EbookOrder::create([
            'order_id' => 'EBOOK-' . time() . '-' . rand(1000, 9999),
            'ebook_id' => $referenceData['ebook_id'],
            'amount' => $data['amount'],
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'status' => 'pending',
            'payment_method' => 'kcb_mpesa'
        ]);
    }

    /**
     * Create coaching enrollment
     */
    private function createCoachingEnrollment($data)
    {
        $referenceData = $data['reference_data'];

        return CoachingEnrollment::create([
            'order_id' => 'COACH-' . Str::random(10),
            'package_id' => $referenceData['package_id'],
            'amount' => $data['amount'],
            'original_amount' => $data['amount'],
            'original_currency' => 'KES',
            'conversion_rate' => 1,
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'country' => $referenceData['country'] ?? 'Kenya',
            'status' => 'pending',
            'payment_method' => 'kcb_mpesa'
        ]);
    }

    /**
     * Create custom package
     */
    private function createCustomPackage($data)
    {
        $referenceData = $data['reference_data'];

        return CustomPackage::create([
            'package_name' => $referenceData['package_name'] ?? 'Custom Health Package',
            'description' => $referenceData['description'] ?? 'Custom health package',
            'amount' => $data['amount'],
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'status' => 'pending',
            'payment_method' => 'kcb_mpesa',
            'requirements' => $referenceData['requirements'] ?? null
        ]);
    }

    /**
     * Convert amount based on currency
     */
    private function convertAmount($amount, $currency)
    {
        if ($currency === 'USD') {
            // Add your currency conversion logic here
            return $amount * 150; // Example conversion rate
        }
        return $amount;
    }

    /**
     * Get payment description based on type
     */
    private function getPaymentDescription($paymentType, $order, $referenceData)
    {
        $descriptions = [
            'product' => 'Health Versation Products',
            'consultation' => 'Health Consultation',
            'ebook' => 'Health Versation Ebook',
            'coaching' => 'Health Coaching Program',
            'custom_package' => 'Custom Health Package'
        ];

        return $descriptions[$paymentType] ?? 'Payment';
    }

    /**
     * KCB Payment callback handler for all types
     */
    public function handleKcbCallback(Request $request)
    {
        $callbackData = $request->all();
        Log::info("KCB Callback Received:", $callbackData);

        try {
            // Use the correct callback format from KCB
            $body = $callbackData['Body'] ?? [];
            $stkCallback = $body['stkCallback'] ?? [];

            $checkoutRequestId = $stkCallback['CheckoutRequestID'] ?? null;
            $resultCode = $stkCallback['ResultCode'] ?? null;
            $resultDesc = $stkCallback['ResultDesc'] ?? null;

            // Extract callback metadata
            $callbackMetadata = $stkCallback['CallbackMetadata'] ?? [];
            $items = $callbackMetadata['Item'] ?? [];
            $mpesaReceiptNumber = null;
            $amount = null;
            $phoneNumber = null;

            foreach ($items as $item) {
                if (isset($item['Name']) && isset($item['Value'])) {
                    switch ($item['Name']) {
                        case 'MpesaReceiptNumber':
                            $mpesaReceiptNumber = $item['Value'];
                            break;
                        case 'Amount':
                            $amount = $item['Value'];
                            break;
                        case 'PhoneNumber':
                            $phoneNumber = $item['Value'];
                            break;
                    }
                }
            }

            // Find KCB payment record
            $kcbPayment = KcbPayment::where('checkout_request_id', $checkoutRequestId)->first();

            if ($kcbPayment) {
                // Update KCB payment record
                $kcbPayment->update([
                    'result_code' => $resultCode,
                    'result_description' => $resultDesc,
                    'mpesa_receipt_number' => $mpesaReceiptNumber,
                    'callback_payload' => $callbackData,
                    'transaction_date' => now()
                ]);

                if ($resultCode == 0) {
                    // Payment successful
                    $kcbPayment->update(['status' => 'completed']);
                    $this->updateOrderStatus($kcbPayment, 'completed');

                    Log::info("KCB Payment completed: {$checkoutRequestId}", [
                        'payment_type' => $kcbPayment->payment_type,
                        'reference_id' => $kcbPayment->reference_id
                    ]);
                } else {
                    // Payment failed
                    $kcbPayment->update(['status' => 'failed']);
                    $this->updateOrderStatus($kcbPayment, 'failed');

                    Log::warning("KCB Payment failed: {$checkoutRequestId}", [
                        'result_code' => $resultCode,
                        'result_desc' => $resultDesc
                    ]);
                }
            } else {
                Log::error("KCB Payment not found for callback: {$checkoutRequestId}");
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('KCB Callback Processing Error: ' . $e->getMessage(), [
                'callback_data' => $callbackData
            ]);
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Update order status based on payment result
     */
  private function updateOrderStatus(KcbPayment $kcbPayment, $status)
{
    try {
        $order = $kcbPayment->reference;

        if (!$order) {
            Log::error("Order not found for KCB payment: {$kcbPayment->id}");
            return;
        }

        $updateData = ['payment_status' => $status]; // ✅ This is correct

        if ($status === 'completed') {
            if ($order instanceof \App\Models\Consultation) {
                // For consultations, mark as approved when payment succeeds
                $updateData['status'] = 'approved';
                $updateData['payment_status'] = 'paid'; // ✅ Use string with quotes
            } else {
                // For all other references (orders, ebooks, etc.)
                $updateData['status'] = 'confirmed';
            }
        } else {
            if ($order instanceof \App\Models\Consultation) {
                // For consultations, mark as cancelled when payment fails
                $updateData['status'] = 'cancelled';
                $updateData['payment_status'] = 'failed'; // ✅ Use string with quotes
            } else {
                // For all other types
                $updateData['status'] = 'failed';
            }
        }

        $order->update($updateData);

        Log::info("Order status updated", [
            'order_type' => get_class($order),
            'order_id' => $order->id,
            'status' => $status
        ]);

    } catch (\Exception $e) {
        Log::error('Error updating order status: ' . $e->getMessage(), [
            'kcb_payment_id' => $kcbPayment->id
        ]);
    }
}

    /**
     * Send success notifications
     */
    private function sendSuccessNotifications($order, $kcbPayment)
    {
        // Implement your notification logic here
        // Send emails, download links, etc. based on order type
        Log::info("Sending success notifications for order", [
            'order_type' => get_class($order),
            'order_id' => $order->id
        ]);
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(Request $request)
    {
        $request->validate([
            'checkout_request_id' => 'required|string'
        ]);

        $kcbPayment = KcbPayment::where('checkout_request_id', $request->checkout_request_id)->first();

        if (!$kcbPayment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'status' => $kcbPayment->status,
            'result_description' => $kcbPayment->result_description,
            'mpesa_receipt_number' => $kcbPayment->mpesa_receipt_number,
            'invoice_number' => $kcbPayment->invoice_number,
            'payment_type' => $kcbPayment->payment_type
        ]);
    }

    /**
     * Test KCB service authentication
     */
    public function testKcbAuth()
    {
        $result = $this->kcbService->testAuth();
        return response()->json($result);
    }
}
