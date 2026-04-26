<?php

namespace App\Http\Controllers;

use App\Models\CoachingEnrollment;
use App\Models\CoachingPackage;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class CoachingEnrollmentController extends Controller
{
    public function process(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:coaching_packages,id',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'country' => 'required',
            'package_price' => 'required|numeric',
            'package_currency' => 'required|in:KES'
        ]);

        $package = Package::findOrFail($request->package_id);

        // Create enrollment record
        $enrollment = CoachingEnrollment::create([
            'order_id' => 'COACH-' . Str::random(10),
            'package_id' => $package->id,
            'amount' => $request->package_price,
            'original_amount' => $request->package_price,
            'original_currency' => 'KES',
            'conversion_rate' => 1,
            'customer_name' => $request->name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'country' => $request->country,
            'status' => 'pending'
        ]);

        // Send email to user
        Mail::raw(
            "Dear {$request->name},

Your consultation has been successfully booked! We have received your booking for the following package:

Package: {$package->name}
Order ID: {$enrollment->order_id}
Amount: KES {$request->package_price}

Our team will contact you shortly to schedule your consultation session.

Thank you for choosing our services!

Best regards,
Healthveration Team",
            function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Your Consultation Has Been Booked Successfully!');
            }
        );
        
        // Send email to sales@healthveration.com
        Mail::raw(
            "NEW CONSULTATION BOOKING NOTIFICATION

Order ID: {$enrollment->order_id}
Customer Name: {$request->name}
Customer Email: {$request->email}
Customer Phone: {$request->phone}
Country: {$request->country}
Package: {$package->name}
Amount: KES {$request->package_price}

Please contact the customer to schedule their consultation session.",
            function ($message) use ($enrollment) {
                $message->to('sales@healthveration.com')
                        ->subject('New Consultation Booking - ' . $enrollment->order_id);
            }
        );

        // Generate the transaction token
        $token = $this->generateTransactionToken(
            config('services.iveri.secret'),
            $request->package_price * 100, // in cents
            $request->email
        );

        // Prepare iVeri data
        $iveriData = [
            'Lite_Version' => '4.0',
            'Lite_Merchant_ApplicationId' => config('services.iveri.app_id'),
            'Lite_Order_Amount' => $request->package_price * 100,
            'Ecom_ConsumerOrderID' => $enrollment->order_id,
            'Ecom_BillTo_Online_Email' => $request->email,
            'Ecom_BillTo_Postal_Name_First' => $request->name,
            'Ecom_BillTo_Telecom_Phone_Number' => $request->phone,
            'Lite_Website_Successful_Url' => route('payment.success'),
            'Lite_Website_Fail_Url' => route('payment.fail'),
            'Lite_Website_TryLater_Url' => route('payment.retry'),
            'Lite_Website_Error_Url' => route('payment.error'),
            'Lite_ConsumerOrderID_PreFix' => 'COACHING',
            'Ecom_Payment_Card_Protocols' => 'iVeri',
            'Ecom_TransactionComplete' => 'false',
            'Lite_Currency_AlphaCode' => 'KES',
            'Lite_Transaction_Token' => $token,
            'Lite_Order_LineItems_Product_1' => $package->name,
            'Lite_Order_LineItems_Quantity_1' => 1,
            'Lite_Order_LineItems_Amount_1' => $request->package_price * 100
        ];

        return view('payment.redirect-to-iveri', [
            'iveriUrl' => 'https://portal.host.iveri.com/Lite/Authorise.aspx',
            'iveriData' => $iveriData
        ]);
    }

    protected function generateTransactionToken($secretKey, $amount, $email)
    {
        $time = time();
        $resource = '/Lite/Authorise.aspx';
        $applicationId = config('services.iveri.app_id');
        $tokenData = $secretKey . $time . $resource . $applicationId . $amount . $email;
        
        return 'x:' . $time . '-' . hash('sha256', $tokenData);
    }
}