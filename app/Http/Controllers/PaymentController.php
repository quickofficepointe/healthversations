<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Handle successful iVeri payment response.
     */
    public function success(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'LITE_TRANSACTIONINDEX' => 'required|string',
            'LITE_ORDER_AMOUNT' => 'required|numeric',
            'MERCHANTREFERENCE' => 'required|string',
            'LITE_TRANSACTION_TOKEN' => 'required|string',
        ]);

        if ($validator->fails()) {
            Log::error('Invalid iVeri success response', [
                'errors' => $validator->errors()->toArray(),
                'request' => $request->except(['ECOM_PAYMENT_CARD_NUMBER'])
            ]);
            return redirect()->route('payment.error')->with('error', 'Invalid payment response');
        }

        try {
            // Verify the transaction token
            $isValid = $this->verifyTransactionToken(
                $request->input('LITE_TRANSACTION_TOKEN'),
                $request->input('LITE_ORDER_AMOUNT'),
                $request->input('ECOM_BILLTO_ONLINE_EMAIL', '')
            );

            if (!$isValid) {
                Log::error('Invalid transaction token', [
                    'token' => $request->input('LITE_TRANSACTION_TOKEN'),
                    'amount' => $request->input('LITE_ORDER_AMOUNT')
                ]);
                return redirect()->route('payment.error')->with('error', 'Payment verification failed');
            }

            // Create and save the order
            $order = $this->createOrderFromRequest($request);

            Log::info('Payment successful', [
                'transaction_id' => $request->input('LITE_TRANSACTIONINDEX'),
                'amount' => $request->input('LITE_ORDER_AMOUNT'),
                'order_id' => $order->id
            ]);

            return view('payment.success', [
                'order' => $order,
                'transaction_id' => $request->input('LITE_TRANSACTIONINDEX'),
                'amount' => $request->input('LITE_ORDER_AMOUNT') / 100,
                'reference' => $request->input('MERCHANTREFERENCE')
            ]);

        } catch (\Exception $e) {
            Log::error('Payment processing error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['ECOM_PAYMENT_CARD_NUMBER'])
            ]);
            return redirect()->route('payment.error')->with('error', 'Payment processing failed');
        }
    }

    /**
     * Handle failed payment response.
     */
    public function fail(Request $request)
    {
        $transactionId = $request->input('LITE_TRANSACTIONINDEX', 'unknown');
        $statusCode = $request->input('LITE_PAYMENT_CARD_STATUS', 'unknown');
        $errorMessage = $request->input('LITE_RESPONSE_MESSAGE', 'Payment failed');

        Log::warning('Payment failed', [
            'transaction_id' => $transactionId,
            'status_code' => $statusCode,
            'error_message' => $errorMessage,
            'amount' => $request->input('LITE_ORDER_AMOUNT'),
            'reason' => $this->getFailureReason($statusCode)
        ]);

        return view('frontendviews.orders.fail', [
            'error' => $errorMessage,
            'status_code' => $statusCode,
            'transaction_id' => $transactionId,
            'can_retry' => $this->isRetryableStatus($statusCode),
            'support_email' => config('mail.support_email')
        ]);
    }

    /**
     * Handle payment processing errors.
     */
    public function error(Request $request)
    {
        $errorMessage = $request->input('error', $request->input('LITE_RESPONSE_MESSAGE', 'Payment processing error'));
        $transactionId = $request->input('LITE_TRANSACTIONINDEX', 'unknown');

        Log::error('Payment error', [
            'transaction_id' => $transactionId,
            'error' => $errorMessage,
            'request' => $request->except(['ECOM_PAYMENT_CARD_NUMBER'])
        ]);

        return view('frontendviews.orders.error', [
            'error' => $errorMessage,
            'transaction_id' => $transactionId,
            'support_email' => config('mail.support_email')
        ]);
    }

    /**
     * Handle cases that require retry.
     */
    public function retry(Request $request)
    {
        $retryMessage = $request->input('LITE_RESPONSE_MESSAGE', 'Please try again later');
        $retryAfter = $request->input('Retry-After', 30); // Default 30 minutes
        $transactionId = $request->input('LITE_TRANSACTIONINDEX', 'unknown');

        Log::notice('Payment requires retry', [
            'transaction_id' => $transactionId,
            'message' => $retryMessage,
            'retry_after_minutes' => $retryAfter
        ]);

        return view('frontendviews.orders.retry', [
            'message' => $retryMessage,
            'transaction_id' => $transactionId,
            'retry_time' => now()->addMinutes($retryAfter)->format('H:i'),
            'support_email' => config('mail.support_email')
        ]);
    }

    /**
     * Verify the transaction token integrity.
     */
    private function verifyTransactionToken(string $token, string $amount, string $email): bool
    {
        try {
            $parts = explode('-', $token);
            if (count($parts) !== 2 || !str_starts_with($parts[0], 'x:')) {
                throw new \InvalidArgumentException('Invalid token format');
            }

            $time = substr($parts[0], 2);
            $receivedHash = $parts[1];

            $secret = config('services.iveri.shared_secret');
            $appId = config('services.iveri.application_id');
            $resource = '/Lite/Authorise.aspx';

            $expectedString = $secret . $time . $resource . $appId . $amount . $email;
            $expectedHash = hash('sha256', $expectedString);

            if (!hash_equals($expectedHash, $receivedHash)) {
                Log::error('Token verification failed', [
                    'expected' => $expectedHash,
                    'received' => $receivedHash
                ]);
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Token verification error', [
                'error' => $e->getMessage(),
                'token' => $token
            ]);
            return false;
        }
    }

    /**
     * Create an order from payment request.
     */
    private function createOrderFromRequest(Request $request): Order
    {
        $orderData = [
            'transaction_id' => $request->input('LITE_TRANSACTIONINDEX'),
            'amount' => $request->input('LITE_ORDER_AMOUNT') / 100,
            'status' => 'completed',
            'customer_email' => $request->input('ECOM_BILLTO_ONLINE_EMAIL'),
            'customer_name' => $request->input('ECOM_BILLTO_POSTAL_NAME_FIRST') . ' ' .
                              $request->input('ECOM_BILLTO_POSTAL_NAME_LAST'),
            'payment_method' => 'card',
            'card_last_four' => substr($request->input('ECOM_PAYMENT_CARD_NUMBER', ''), -4),
            'billing_address' => json_encode([
                'street' => $request->input('ECOM_BILLTO_POSTAL_STREET_LINE1'),
                'city' => $request->input('ECOM_BILLTO_POSTAL_CITY'),
                'state' => $request->input('ECOM_BILLTO_POSTAL_STATEPROV'),
            ]),
        ];

        // Add delivery/pickup info based on order type
        if ($request->input('ORDER_TYPE') === 'delivery') {
            $orderData['shipping_address'] = json_encode([
                'street' => $request->input('ECOM_SHIPTO_POSTAL_STREET_LINE1'),
                'city' => $request->input('ECOM_SHIPTO_POSTAL_CITY'),
                'state' => $request->input('ECOM_SHIPTO_POSTAL_STATEPROV'),
            ]);
            $orderData['delivery_fee'] = 300; // 300 KSH
        } else {
            $orderData['pickup_location'] = $request->input('pickup_location');
            $orderData['pickup_instructions'] = $request->input('pickup_instructions');
        }

        return Order::create($orderData);
    }

    /**
     * Get failure reason by status code.
     */
    private function getFailureReason(string $statusCode): string
    {
        $reasons = [
            '1' => 'System error',
            '3' => 'Card blocked',
            '4' => 'Payment denied',
            '5' => 'Please call your bank',
            '9' => 'Unable to process',
            '14' => 'Invalid card number',
            '51' => 'Insufficient funds',
            '54' => 'Expired card',
            '61' => 'Transaction limit exceeded',
        ];

        return $reasons[$statusCode] ?? 'Unknown error';
    }

    /**
     * Determine if failure status is retryable.
     */
    private function isRetryableStatus(string $statusCode): bool
    {
        $retryableCodes = ['1', '5', '9'];
        return in_array($statusCode, $retryableCodes);
    }
}