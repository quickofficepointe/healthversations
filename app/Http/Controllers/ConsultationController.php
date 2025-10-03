<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with('user')->latest()->paginate(10);
        return view('admin.consultations.index', compact('consultations'));
    }

    public function create()
    {
        $consultationTypes = Consultation::getTypes();

        return view('frontendviews.consultation.index', [
            'consultationTypes' => $consultationTypes,
            'defaultLocation' => 'international' // or get from user preferences
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:20',
            'type' => 'required|in:initial,followup,nutrition_review,specialized',
            'consultation_date' => 'required|date|after_or_equal:today',
            'consultation_time' => 'required|date_format:H:i',
            'location' => 'required|in:'.Consultation::LOCATION_KENYA.','.Consultation::LOCATION_INTERNATIONAL,
            'timezone' => 'required_if:location,'.Consultation::LOCATION_INTERNATIONAL.'|timezone',
            'health_concerns' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        $consultation = new Consultation($validated);

        // Calculate and set fees
        $consultation->calculateFee();

        // Set default statuses
        $consultation->status = Consultation::STATUS_PENDING;
        $consultation->payment_status = Consultation::PAYMENT_UNPAID;

        // Associate user if authenticated
        $consultation->user_id = auth()->id();

        $consultation->save();

        // Prepare iVeri payment data
        $amount = $consultation->location === Consultation::LOCATION_KENYA ?
                 ($consultation->type === Consultation::TYPE_SPECIALIZED ? 3000 : 2500) :
                 ($consultation->type === Consultation::TYPE_SPECIALIZED ? 28 : 24);

        $currency = $consultation->location === Consultation::LOCATION_KENYA ? 'KES' : 'USD';
        $orderId = 'CONS-' . $consultation->id . '-' . Str::random(6);

        // Generate token (this should be done server-side in a real implementation)
        $time = time();
        $token = 'x:' . $time . '-consultation-token-' . Str::random(10);

        // Return JSON response for AJAX handling
        return response()->json([
            'success' => true,
            'consultation_id' => $consultation->id,
            'amount' => $amount,
            'currency' => $currency,
            'order_id' => $orderId,
            'token' => $token,
            'email' => $consultation->email,
            'name' => $consultation->name
        ]);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'consultation_id' => 'required|exists:consultations,id',
        ]);

        $consultation = Consultation::find($request->consultation_id);

        // Verify the consultation belongs to the authenticated user
        if (auth()->check() && $consultation->user_id !== auth()->id()) {
            abort(403);
        }

        // Prepare iVeri data
        $iveriData = $this->prepareIveriData($consultation);

        // Use the same redirect blade as cart
        return view('payment.redirect-to-iveri', [
            'iveriUrl' => config('services.iveri.url', 'https://portal.host.iveri.com/Lite/Authorise.aspx'),
            'iveriData' => $iveriData
        ]);
    }

    private function prepareIveriData(Consultation $consultation)
    {
        $amount = $consultation->location === Consultation::LOCATION_KENYA ?
                 ($consultation->type === Consultation::TYPE_SPECIALIZED ? 3000 : 2500) :
                 ($consultation->type === Consultation::TYPE_SPECIALIZED ? 28 : 24);

        $currency = $consultation->location === Consultation::LOCATION_KENYA ? 'KES' : 'USD';
        $orderId = 'CONS-' . $consultation->id . '-' . Str::random(6);

        // Generate token
        $time = time();
        $token = $this->generateIveriToken($amount * 100, $consultation->email);

        $nameParts = explode(' ', $consultation->name, 2);
        $firstName = $nameParts[0];
        $lastName = count($nameParts) > 1 ? $nameParts[1] : '';

        return [
            'Lite_Version' => '4.0',
            'Lite_Merchant_ApplicationId' => config('services.iveri.app_id', '3a7f44fd-4bb4-432c-b483-32e5a19e100d'),
            'Lite_Order_Amount' => $amount * 100, // Convert to cents
            'Ecom_ConsumerOrderID' => $orderId,
            'Lite_Website_Successful_Url' => route('payment.success'),
            'Lite_Website_Fail_Url' => route('payment.fail'),
            'Lite_Website_TryLater_Url' => route('payment.retry'),
            'Lite_Website_Error_Url' => route('payment.error'),
            'Lite_ConsumerOrderID_PreFix' => 'CONS',
            'Ecom_Payment_Card_Protocols' => 'iVeri',
            'Ecom_TransactionComplete' => 'false',
            'Lite_Currency_AlphaCode' => $currency,
            'Lite_Transaction_Token' => $token,
            'Ecom_BillTo_Online_Email' => $consultation->email,
            'Ecom_BillTo_Postal_Name_First' => $firstName,
            'Ecom_BillTo_Postal_Name_Last' => $lastName,
            'consultation_id' => $consultation->id,
        ];
    }

    private function generateIveriToken($amount, $email)
    {
        $secret = config('services.iveri.secret');
        $time = time();
        $resource = '/Lite/Authorise.aspx';
        $appId = config('services.iveri.app_id', '3a7f44fd-4bb4-432c-b483-32e5a19e100d');

        $tokenData = $secret . $time . $resource . $appId . $amount . $email;

        return 'x:' . $time . '-' . hash('sha256', $tokenData);
    }

    public function show(Consultation $consultation)
    {
        return view('admin.consultations.show', compact('consultation'));
    }

    public function edit(Consultation $consultation)
    {
        return view('admin.consultations.edit', compact('consultation'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'status' => 'required|in:'.implode(',', [
                Consultation::STATUS_PENDING,
                Consultation::STATUS_CONFIRMED,
                Consultation::STATUS_COMPLETED,
                Consultation::STATUS_CANCELLED
            ]),
            'payment_status' => 'required|in:'.implode(',', [
                Consultation::PAYMENT_UNPAID,
                Consultation::PAYMENT_PAID,
                Consultation::PAYMENT_REFUNDED
            ]),
            'notes' => 'nullable|string|max:1000'
        ]);

        $consultation->update($validated);

        return back()->with('success', 'Consultation updated successfully!');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
        return back()->with('success', 'Consultation deleted successfully!');
    }
}
