<?php

namespace App\Http\Controllers;

use App\Models\checkout;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function success(Request $request)
{
    // Verify the payment with iVeri (recommended)
    $reference = $request->query('reference');

    // Process successful payment
    // Save order to database, clear cart, etc.

    return view('checkout.success', [
        'reference' => $reference
    ]);
}
public function verifyPayment($transactionId, $merchantReference)
{
    $url = 'https://portal.host.iveri.com/Lite/AuthoriseInfo.aspx';

    $data = [
        'Lite_Merchant_ApplicationId' => env('IVERI_APP_ID'),
        'Lite_Merchant_Trace' => $merchantReference,
    ];

    $client = new \GuzzleHttp\Client();
    $response = $client->post($url, ['form_params' => $data]);

    $responseData = [];
    parse_str($response->getBody(), $responseData);

    if ($responseData['Lite_Payment_Card_Status'] == '0') {
        return true; // Payment is verified
    }

    return false;
}
public function failure(Request $request)
{
    return view('checkout.failure', [
        'error' => $request->query('error', 'Payment was not successful')
    ]);
}
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(checkout $checkout)
    {
        //
    }
}
