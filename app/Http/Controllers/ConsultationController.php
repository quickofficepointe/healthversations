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
        ]);
    }

    public function getAvailableSlots(Request $request)
    {
        $date = $request->get('date');
        $type = $request->get('type');

        if ($type === Consultation::TYPE_PHYSICAL) {
            $availableSlots = Consultation::getAvailablePhysicalTimeSlots($date);
        } else {
            $availableSlots = Consultation::getAvailableTimeSlots($date);
        }

        return response()->json([
            'available_slots' => $availableSlots
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:20',
            'type' => 'required|in:initial,followup,nutrition_review,specialized,physical',
            'consultation_date' => 'required|date|after_or_equal:today',
            'consultation_time' => 'required|date_format:H:i',
            'health_concerns' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:iveri,kcb'
        ];

        // Only require location and timezone for non-physical consultations
        if ($request->type !== Consultation::TYPE_PHYSICAL) {
            $rules['location'] = 'required|in:' . Consultation::LOCATION_KENYA . ',' . Consultation::LOCATION_INTERNATIONAL;
            $rules['timezone'] = 'required_if:location,' . Consultation::LOCATION_INTERNATIONAL . '|timezone';
        }

        $validated = $request->validate($rules);

        $consultation = new Consultation();
        $consultation->fill($validated);

        // Force physical consultations to use Kenya location
        if ($consultation->type === Consultation::TYPE_PHYSICAL) {
            $consultation->location = Consultation::LOCATION_KENYA;
            $consultation->timezone = null;
        }

        // Check time slot availability
        $isAvailable = Consultation::isTimeSlotAvailable(
            $consultation->consultation_date,
            $consultation->consultation_time,
            $consultation->type
        );

        if (!$isAvailable) {
            return response()->json([
                'success' => false,
                'message' => 'This time slot is not available. Please select another time.'
            ], 422);
        }

        // Calculate and set fees
        $consultation->calculateFee();

        // Set default statuses
        $consultation->status = Consultation::STATUS_PENDING;
        $consultation->payment_status = Consultation::PAYMENT_UNPAID;
        $consultation->payment_method = $request->payment_method;
        $consultation->user_id = auth()->id();

        $consultation->save();

        // Type labels
        $typeLabels = [
            'initial' => 'Initial Consultation',
            'followup' => 'Follow-up Consultation',
            'nutrition_review' => 'Nutrition Review',
            'specialized' => 'Specialized Consultation',
            'physical' => 'Physical Consultation (2 hours)'
        ];

        $typeLabel = $typeLabels[$consultation->type];

        // Set amount for response
        if ($consultation->type === Consultation::TYPE_PHYSICAL) {
            $displayAmount = Consultation::FEE_PHYSICAL;
            $displayCurrency = 'KES';
            $amountDisplay = 'KES ' . number_format(Consultation::FEE_PHYSICAL);
        } elseif ($consultation->location === Consultation::LOCATION_KENYA) {
            $displayAmount = Consultation::FEE_KENYA;
            $displayCurrency = 'KES';
            $amountDisplay = 'KES ' . number_format(Consultation::FEE_KENYA);
        } else {
            $displayAmount = Consultation::FEE_INTERNATIONAL;
            $displayCurrency = 'USD';
            $amountDisplay = '$' . number_format(Consultation::FEE_INTERNATIONAL, 2);
        }

        // Physical consultation location info
        $physicalLocationInfo = $consultation->type === Consultation::TYPE_PHYSICAL
            ? "\n\nLocation: Trio Complex, Behind Garden City, Nairobi, Kenya\nPlease arrive 10 minutes before your appointment."
            : '';

        // Send email to customer
        Mail::raw("Dear {$consultation->name},

Thank you for booking your consultation with Health Versations.

Your consultation has been successfully booked. Here are the details:

CONSULTATION DETAILS
Type: {$typeLabel}
Date: " . date('F j, Y', strtotime($consultation->consultation_date)) . "
Time: " . date('g:i A', strtotime($consultation->consultation_time)) . "
Duration: " . $consultation->getDuration() . "
Amount: {$amountDisplay}
Payment Method: " . strtoupper($request->payment_method) . $physicalLocationInfo . "

HEALTH CONCERNS
{$consultation->health_concerns}

NEXT STEPS
1. Proceed with payment to confirm your booking
2. Our team will contact you within 24 hours
3. " . ($consultation->type === Consultation::TYPE_PHYSICAL
    ? "Physical consultations are held at Trio Complex, Behind Garden City"
    : "You will receive a calendar invite with meeting details") . "

If you have any questions, please contact us at support@healthversations.com

Best regards,
Health Versations Team
www.healthversations.com", function ($message) use ($consultation) {
            $message->to($consultation->email)
                    ->subject('Your Consultation Booking Confirmation - Health Versations');
        });

        // Send email to sales team
        Mail::raw("NEW CONSULTATION BOOKING
==========================================

CUSTOMER DETAILS:
Name: {$consultation->name}
Email: {$consultation->email}
Phone: {$consultation->phone}
Location: " . ($consultation->type === Consultation::TYPE_PHYSICAL ? "Physical (Trio Complex, Nairobi)" : ucfirst($consultation->location)) . "

CONSULTATION DETAILS:
Type: {$typeLabel}
Date: " . date('F j, Y', strtotime($consultation->consultation_date)) . "
Time: " . date('g:i A', strtotime($consultation->consultation_time)) . "
Duration: " . $consultation->getDuration() . "
Amount: {$amountDisplay}
Payment Method: " . strtoupper($request->payment_method) . "

HEALTH CONCERNS:
{$consultation->health_concerns}

" . ($consultation->notes ? "ADDITIONAL NOTES:\n{$consultation->notes}\n\n" : "") . ($consultation->type === Consultation::TYPE_PHYSICAL ? "
PHYSICAL CONSULTATION LOCATION:
Trio Complex, Behind Garden City
Nairobi, Kenya

ACTION REQUIRED:
1. Contact customer to confirm appointment
2. Prepare consultation room
3. Have physical assessment tools ready
" : "
ACTION REQUIRED:
1. Contact customer to confirm appointment
2. Send calendar invite with meeting link
3. Prepare digital consultation materials
") . "
Consultation ID: {$consultation->id}
Created: " . $consultation->created_at->format('F j, Y g:i A') . "

-- Health Versations Notification", function ($message) use ($consultation) {
            $message->to('sales@healthversations.com')
                    ->subject('New Consultation Booking - ' . $consultation->name);
        });

        return response()->json([
            'success' => true,
            'consultation_id' => $consultation->id,
            'amount' => $displayAmount,
            'currency' => $displayCurrency,
            'name' => $consultation->name,
            'email' => $consultation->email,
            'type' => $consultation->type,
            'consultation_date' => $consultation->consultation_date,
            'consultation_time' => $consultation->consultation_time,
            'is_physical' => $consultation->type === Consultation::TYPE_PHYSICAL
        ]);
    }

    public function processPayment(Consultation $consultation)
    {
        if (auth()->check() && $consultation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($consultation->payment_status !== Consultation::PAYMENT_UNPAID) {
            return redirect()->back()->with('error', 'This consultation has already been paid for.');
        }

        $iveriData = $this->prepareIveriData($consultation);

        return view('payment.redirect-to-iveri', [
            'iveriUrl' => config('services.iveri.url', 'https://portal.host.iveri.com/Lite/Authorise.aspx'),
            'iveriData' => $iveriData
        ]);
    }

    private function prepareIveriData(Consultation $consultation)
    {
        if ($consultation->type === Consultation::TYPE_PHYSICAL) {
            $amount = Consultation::FEE_PHYSICAL;
            $currency = 'KES';
        } elseif ($consultation->location === Consultation::LOCATION_KENYA) {
            $amount = Consultation::FEE_KENYA;
            $currency = 'KES';
        } else {
            $amount = Consultation::FEE_INTERNATIONAL;
            $currency = 'USD';
        }

        $orderId = 'CONS-' . $consultation->id . '-' . Str::random(6);
        $time = time();
        $token = $this->generateIveriToken($amount * 100, $consultation->email);

        $nameParts = explode(' ', $consultation->name, 2);
        $firstName = $nameParts[0];
        $lastName = count($nameParts) > 1 ? $nameParts[1] : '';

        return [
            'Lite_Version' => '4.0',
            'Lite_Merchant_ApplicationId' => config('services.iveri.app_id', '3a7f44fd-4bb4-432c-b483-32e5a19e100d'),
            'Lite_Order_Amount' => $amount * 100,
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

    public function show(Request $request)
    {
        $status = $request->get('status');
        $payment = $request->get('payment');

        $query = Consultation::query()->latest();

        if ($status) {
            $query->where('status', $status);
        }

        if ($payment) {
            $query->where('payment_status', $payment);
        }

        $consultations = $query->paginate(10);

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
            'status' => 'required|in:' . implode(',', [
                Consultation::STATUS_PENDING,
                Consultation::STATUS_CONFIRMED,
                Consultation::STATUS_COMPLETED,
                Consultation::STATUS_CANCELLED
            ]),
            'payment_status' => 'required|in:' . implode(',', [
                Consultation::PAYMENT_UNPAID,
                Consultation::PAYMENT_PAID,
                Consultation::PAYMENT_REFUNDED
            ]),
            'notes' => 'nullable|string|max:1000'
        ]);

        $consultation->update($validated);

        return back()->with('success', 'Consultation updated successfully');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
        return back()->with('success', 'Consultation deleted successfully');
    }
}
