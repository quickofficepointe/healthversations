<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

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
            'defaultLocation' => 'international'
        ]);
    }
public function getAvailableSlots(Request $request)
{
    $date = $request->get('date');
    $type = $request->get('type');

    $availableSlots = Consultation::getAvailableTimeSlots($date);

    return response()->json([
        'available_slots' => $availableSlots
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
            'payment_method' => 'required|in:iveri,kcb'
        ]);

        $consultation = new Consultation($validated);

        // Calculate and set fees
        $consultation->calculateFee();

        // Set default statuses
        $consultation->status = Consultation::STATUS_PENDING;
        $consultation->payment_status = Consultation::PAYMENT_UNPAID;
        $consultation->payment_method = $request->payment_method;

        // Associate user if authenticated
        $consultation->user_id = auth()->id();

        $consultation->save();

        // Get type label for email
        $typeLabels = [
            'initial' => 'Initial Consultation',
            'followup' => 'Follow-up Consultation',
            'nutrition_review' => 'Nutrition Review',
            'specialized' => 'Specialized Consultation'
        ];

        $typeLabel = $typeLabels[$consultation->type] ?? $consultation->type;
        $amount = $consultation->location === Consultation::LOCATION_KENYA ? 'KES 3,000' : '$31 USD';

        // Send email to customer
        Mail::raw("Dear {$consultation->name},

Thank you for booking your consultation with Healthveration!

Your consultation has been successfully booked. Here are the details:

CONSULTATION DETAILS
Type: {$typeLabel}
Date: {$consultation->consultation_date}
Time: {$consultation->consultation_time}
Amount: {$amount}

HEALTH CONCERNS
{$consultation->health_concerns}

NEXT STEPS:
1. Please proceed to payment to confirm your booking
2. Our team will contact you shortly to schedule the consultation
3. You will receive a calendar invite with Zoom/meeting details

If you have any questions, please contact us at support@healthveration.com

Best regards,
Healthveration Team
www.healthveration.com", function ($message) use ($consultation) {
            $message->to($consultation->email)
                    ->subject('Your Consultation Has Been Booked Successfully!');
        });

        // Send email to sales team
        Mail::raw("NEW CONSULTATION BOOKING NOTIFICATION
==========================================

CUSTOMER DETAILS:
Name: {$consultation->name}
Email: {$consultation->email}
Phone: {$consultation->phone}
Location: " . ucfirst($consultation->location) . "

CONSULTATION DETAILS:
Type: {$typeLabel}
Date: {$consultation->consultation_date}
Time: {$consultation->consultation_time}
Amount: {$amount}
Payment Method: {$consultation->payment_method}

HEALTH CONCERNS:
{$consultation->health_concerns}

" . ($consultation->notes ? "ADDITIONAL NOTES:\n{$consultation->notes}\n\n" : "") . "
ACTION REQUIRED:
1. Contact the customer to schedule their consultation
2. Send calendar invite with meeting details
3. Follow up after payment confirmation

Consultation ID: {$consultation->id}
Created at: {$consultation->created_at}", function ($message) use ($consultation) {
            $message->to('sales@healthveration.com')
                    ->subject('New Consultation Booking - ' . $consultation->name);
        });

        // Return JSON response for AJAX handling
        return response()->json([
            'success' => true,
            'consultation_id' => $consultation->id,
            'amount' => $consultation->location === Consultation::LOCATION_KENYA ? 3000 : 31,
            'currency' => $consultation->location === Consultation::LOCATION_KENYA ? 'KES' : 'USD',
            'name' => $consultation->name,
            'email' => $consultation->email,
            'type' => $consultation->type,
            'consultation_date' => $consultation->consultation_date,
            'consultation_time' => $consultation->consultation_time,
            'location' => $consultation->location
        ]);
    }

    public function processPayment(Consultation $consultation)
    {
        // Verify the consultation belongs to the authenticated user
        if (auth()->check() && $consultation->user_id !== auth()->id()) {
            abort(403);
        }

        // Verify payment status is still unpaid
        if ($consultation->payment_status !== Consultation::PAYMENT_UNPAID) {
            return redirect()->back()->with('error', 'This consultation has already been paid for.');
        }

        // Prepare iVeri data
        $iveriData = $this->prepareIveriData($consultation);

        return view('payment.redirect-to-iveri', [
            'iveriUrl' => config('services.iveri.url', 'https://portal.host.iveri.com/Lite/Authorise.aspx'),
            'iveriData' => $iveriData
        ]);
    }

    private function prepareIveriData(Consultation $consultation)
    {
        $amount = $consultation->location === Consultation::LOCATION_KENYA ? 3000 : 31;
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


    // Show list of all consultations (INDEX)
    public function show(Request $request)
    {
        // Get filter parameters
        $status = $request->get('status');
        $payment = $request->get('payment');

        // Start query
        $query = Consultation::query()->latest();

        // Apply filters
        if ($status) {
            $query->where('status', $status);
        }

        if ($payment) {
            $query->where('payment_status', $payment);
        }

        // Get paginated results
        $consultations = $query->paginate(10);

        // Get counts for stats
        $totalCount = Consultation::count();
        $pendingCount = Consultation::where('status', 'pending')->count();
        $approvedCount = Consultation::where('status', 'approved')->count();
        $unpaidCount = Consultation::where('payment_status', 'unpaid')->count();

        return view('healthversations.admin.consultation.show', compact(
            'consultations',
            'totalCount',
            'pendingCount',
            'approvedCount',
            'unpaidCount'
        ));
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
