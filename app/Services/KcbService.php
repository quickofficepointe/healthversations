<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class KcbService
{
    private $baseUrl;
    private $consumerKey;
    private $consumerSecret;
    private $callbackBaseUrl;
    private $paybillNumber;

    public function __construct()
    {
        $this->baseUrl = config('services.kcb_buni.base_url', 'https://api.buni.kcbgroup.com');
        $this->consumerKey = config('services.kcb_buni.consumer_key');
        $this->consumerSecret = config('services.kcb_buni.consumer_secret');
        $this->callbackBaseUrl = config('services.kcb_buni.callback_base_url', config('app.url'));
        $this->paybillNumber = '8234000';
    }

    /**
     * Get access token from KCB Buni API
     */
    private function getAccessToken()
    {
        $cacheKey = 'kcb_buni_access_token';
        $cachedToken = Cache::get($cacheKey);

        if ($cachedToken) {
            Log::info('Using cached KCB Buni access token');
            return $cachedToken;
        }

        $authUrl = $this->baseUrl . '/token?grant_type=client_credentials';

        try {
            Log::info('Requesting new KCB Buni access token');

            $response = Http::asForm()
                ->withBasicAuth($this->consumerKey, $this->consumerSecret)
                ->withOptions([
                    'verify' => false,
                    'timeout' => 30,
                    'connect_timeout' => 10
                ])
                ->post($authUrl);

            if ($response->failed()) {
                Log::error('KCB Buni Auth Failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => $authUrl
                ]);
                return null;
            }

            $tokenData = $response->json();
            $accessToken = $tokenData['access_token'] ?? null;
            $expiresIn = $tokenData['expires_in'] ?? 3600;

            if ($accessToken) {
                $cacheTime = (int) ($expiresIn * 0.95);
                Cache::put($cacheKey, $accessToken, $cacheTime);

                Log::info('KCB Buni Access Token Obtained', [
                    'expires_in' => $expiresIn,
                    'cache_time' => $cacheTime
                ]);
                return $accessToken;
            }

            Log::error('KCB Buni Auth - No access token in response', ['response' => $tokenData]);
            return null;

        } catch (\Exception $e) {
            Log::error('KCB Buni Auth Exception', [
                'message' => $e->getMessage(),
                'exception' => $e
            ]);
            return null;
        }
    }

    /**
     * Core STK Push initiator with proper callback URL handling
     */
    private function initiateStkPush(array $data, string $callbackRoute)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return ['error' => 'Payment service authentication failed'];
        }

        $stkPushUrl = $this->baseUrl . '/mm/api/request/1.0.0/stkpush';

        try {
            $amountString = number_format($data['amount'], 0, '', '');

            // PROPER WAY: Build callback URL using configurable base URL + route path
            $callbackUrl = rtrim($this->callbackBaseUrl, '/') . $callbackRoute;

            Log::info('KCB Callback URL Generated', [
                'callback_url' => $callbackUrl,
                'callback_base_url' => $this->callbackBaseUrl,
                'callback_route' => $callbackRoute
            ]);

            $payload = [
                "phoneNumber" => $this->validatePhoneNumber($data['phone_number']),
                "amount" => $amountString,
                "invoiceNumber" => $this->generateInvoiceNumber($data['payment_type'] ?? 'product'),
                "sharedShortCode" => true,
                "orgShortCode" => "",
                "orgPassKey" => "",
                "callbackUrl" => $callbackUrl,
                "transactionDescription" => substr($data['description'] ?? 'Payment', 0, 30)
            ];

            Log::info('KCB Buni STK Push Request', ['payload' => $payload]);

            $response = Http::withToken($accessToken)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])
                ->withOptions(['verify' => false])
                ->post($stkPushUrl, $payload);

            $responseBody = $response->json();
            Log::info('KCB Buni STK Push Response', ['response' => $responseBody]);

            if (isset($responseBody['fault'])) {
                $errorMessage = $responseBody['fault']['message'] ?? 'Payment request failed';
                Log::error('KCB Buni STK Push Fault', ['fault' => $responseBody]);
                return ['error' => $errorMessage];
            }

            $statusCode = $responseBody['header']['statusCode'] ?? '1';
            if ($response->failed() || $statusCode !== '0') {
                Log::error('KCB Buni STK Push Failed', [
                    'http_status' => $response->status(),
                    'response_body' => $responseBody,
                    'request_payload' => $payload,
                ]);
                return [
                    'error' => $responseBody['header']['statusDescription']
                        ?? $responseBody['response']['ResponseDescription']
                        ?? 'Failed to initiate payment'
                ];
            }

            return [
                'success' => true,
                'merchant_request_id' => $responseBody['response']['MerchantRequestID'],
                'checkout_request_id' => $responseBody['response']['CheckoutRequestID'] ?? null,
                'response_code' => $responseBody['response']['ResponseCode'] ?? null,
                'response_description' => $responseBody['response']['ResponseDescription'] ?? null,
                'customer_message' => $responseBody['response']['CustomerMessage'] ?? 'Check your phone for M-Pesa prompt',
                'invoice_number' => $payload['invoiceNumber']
            ];

        } catch (\Exception $e) {
            Log::error('KCB Buni STK Push Exception', [
                'message' => $e->getMessage(),
                'exception' => $e
            ]);
            return ['error' => 'An unexpected error occurred. Please try again.'];
        }
    }

    /**
     * Unified payment initiation for all payment types
     */
    public function initiatePayment(array $data, string $paymentType = 'product')
    {
        // Use the route path only (without domain) combined with configurable base URL
        $callbackRoute = route('kcb.payment.callback', [], false);

        return $this->initiateStkPush(array_merge($data, [
            'payment_type' => $paymentType
        ]), $callbackRoute);
    }

    /**
     * Validate and format phone number
     */
    public function validatePhoneNumber($phoneNumber)
    {
        // Remove any non-digit characters
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Ensure it starts with 254
        if (strlen($phoneNumber) === 9 && str_starts_with($phoneNumber, '7')) {
            return '254' . $phoneNumber;
        }

        if (strlen($phoneNumber) === 10 && str_starts_with($phoneNumber, '07')) {
            return '254' . substr($phoneNumber, 1);
        }

        return $phoneNumber;
    }

    /**
     * Test KCB service authentication and callback URL
     */
    public function testAuth()
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return [
                'success' => false,
                'message' => 'Failed to obtain access token'
            ];
        }

        // Test callback URL generation using the proper method
        $callbackRoute = route('kcb.payment.callback', [], false);
        $callbackUrl = rtrim($this->callbackBaseUrl, '/') . $callbackRoute;

        return [
            'success' => true,
            'message' => 'Authentication successful',
            'access_token' => substr($accessToken, 0, 50) . '...',
            'callback_url' => $callbackUrl,
            'callback_base_url' => $this->callbackBaseUrl,
            'callback_route' => $callbackRoute,
            'app_url' => config('app.url')
        ];
    }

    /**
     * Generate invoice number based on payment type
     */
    public function generateInvoiceNumber($type = 'PROD')
    {
        $typePrefix = match($type) {
            'consultation' => 'CONS',
            'ebook' => 'EBOOK',
            'coaching' => 'COACH',
            'custom_package' => 'CUST',
            'product' => 'PROD',
            default => 'INV'
        };

        $timestamp = time();
        $random = rand(1000, 9999);

        return "{$this->paybillNumber}-{$typePrefix}-{$timestamp}-{$random}";
    }

    /**
     * Check transaction status
     */
    public function checkTransactionStatus($checkoutRequestId)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return ['error' => 'Authentication failed'];
        }

        $statusUrl = $this->baseUrl . '/mm/api/query/1.0.0/stkpush';

        try {
            $payload = [
                "checkoutRequestID" => $checkoutRequestId
            ];

            Log::info('KCB Buni Transaction Status Request', ['payload' => $payload]);

            $response = Http::withToken($accessToken)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])
                ->withOptions(['verify' => false])
                ->post($statusUrl, $payload);

            $responseBody = $response->json();
            Log::info('KCB Buni Transaction Status Response', ['response' => $responseBody]);

            if (isset($responseBody['fault'])) {
                return ['error' => $responseBody['fault']['message'] ?? 'Status check failed'];
            }

            return [
                'success' => true,
                'response' => $responseBody
            ];

        } catch (\Exception $e) {
            Log::error('KCB Buni Status Check Exception', [
                'message' => $e->getMessage(),
                'exception' => $e
            ]);
            return ['error' => 'Failed to check transaction status'];
        }
    }
}
