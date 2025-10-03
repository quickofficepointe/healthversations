<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\EbookOrder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EbookOrderController extends Controller
{
    public function index()
    {
        $ebookOrders = EbookOrder::with('ebook')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('healthversations.admin.ebooks.ebooksbook', compact('ebookOrders'));
    }

    public function update(Request $request, $id)
{
    $order = EbookOrder::findOrFail($id);
    $currentStatus = $order->status;

    $validated = $request->validate([
        'status' => 'required|in:pending,completed,failed'
    ]);

    $order->update($validated);

    // Send download link if status changed to completed
    if ($validated['status'] === 'completed' && $currentStatus !== 'completed') {
        $this->sendEbookDownloadLink($order);
    }

    return redirect()->route('admin.ebook-orders.index')
        ->with('success', 'Order status updated successfully');
}
// In your EbookOrderController
public function download($orderId, $token)
{
    $order = EbookOrder::where('order_id', $orderId)->firstOrFail();
    $ebook = $order->ebook;

    // Verify the token is valid and hasn't expired
    $expiresAt = now()->addDays(7); // Must match the expiration in sendEbookDownloadLink
    $expectedToken = $this->generateDownloadToken($order, $expiresAt);

    if (!hash_equals($expectedToken, $token)) {
        abort(403, 'Invalid download token');
    }

    if ($order->status !== 'completed') {
        abort(403, 'This order is not completed');
    }

    // Get the file path and ensure it exists
    $filePath = storage_path('app/public/' . $ebook->file_path);
    if (!file_exists($filePath)) {
        abort(404, 'Ebook file not found');
    }

    // Return the file download with additional security headers
    return response()->download(
        $filePath,
        Str::slug($ebook->title) . '.pdf',
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . Str::slug($ebook->title) . '.pdf"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]
    );
}
protected function sendEbookDownloadLink($order)
{
    $ebook = $order->ebook;
    $customerEmail = $order->customer_email;

    // Generate a secure, time-limited download link (valid for 7 days)
    $expiresAt = now()->addDays(7);
    $downloadUrl = route('ebook.download', [
        'order' => $order->order_id,
        'token' => $this->generateDownloadToken($order, $expiresAt)
    ]);

    Mail::raw("Your ebook purchase is complete!\n\n" .
               "Ebook: {$ebook->title}\n" .
               "Download Link: {$downloadUrl}\n\n" .
               "This link will expire on {$expiresAt->format('F j, Y')}.\n" .
               "Please download your ebook before this date.",
        function ($message) use ($customerEmail, $ebook) {
            $message->to($customerEmail)
                    ->subject("Your ebook download: {$ebook->title}");
        });
}

protected function generateDownloadToken($order, $expiresAt)
{
    // Create a signed token that includes order ID and expiration
    return hash_hmac('sha256', $order->order_id . $expiresAt->timestamp, config('app.key'));
}

    public function process(Request $request)
    {
        $validated = $request->validate([
            'ebook_id' => 'required|exists:ebooks,id',
            'Ecom_BillTo_Postal_Name_First' => 'required',
            'Ecom_BillTo_Online_Email' => 'required|email',
            'Ecom_BillTo_Telecom_Phone_Number' => 'required',
            'Lite_Order_Amount' => 'required',
            'Ecom_ConsumerOrderID' => 'required',
        ]);

        $ebook = Ebook::findOrFail($request->ebook_id);

        // Store the order
        $order = EbookOrder::create([
            'order_id' => $request->Ecom_ConsumerOrderID,
            'ebook_id' => $ebook->id,
            'amount' => $request->Lite_Order_Amount / 100, // Convert back to dollars
            'customer_name' => $request->Ecom_BillTo_Postal_Name_First,
            'customer_email' => $request->Ecom_BillTo_Online_Email,
            'customer_phone' => $request->Ecom_BillTo_Telecom_Phone_Number,
            'status' => 'pending'
        ]);

        // Send email notifications
        $this->sendEbookOrderNotifications($order, $ebook);

        // Generate the transaction token (same as your frontend)
        $token = $this->generateTransactionToken(
            config('services.iveri.secret'),
            $request->Lite_Order_Amount,
            $request->Ecom_BillTo_Online_Email
        );

        // Add token to request
        $request->merge(['Lite_Transaction_Token' => $token]);

        return view('payment.redirect-to-iveri', [
            'iveriUrl' => 'https://portal.host.iveri.com/Lite/Authorise.aspx',
            'iveriData' => $request->except('_token')
        ]);
    }

    protected function generateTransactionToken($secretKey, $amount, $email)
    {
        $time = time();
        $resource = '/Lite/Authorise.aspx';
        $applicationId = '3a7f44fd-4bb4-432c-b483-32e5a19e100d';
        $tokenData = $secretKey . $time . $resource . $applicationId . $amount . $email;

        return 'x:' . $time . '-' . hash('sha256', $tokenData);
    }

    protected function sendEbookOrderNotifications($order, $ebook)
    {
        $customerEmail = $order->customer_email;
        $salesEmail = 'sales@healthversation.com';

        // Customer email
        Mail::raw("Thank you for your ebook purchase #{$order->order_id}.\n\n" .
                   "Ebook Details:\n" .
                   "Title: {$ebook->title}\n" .
                   "Price: KES {$order->amount}\n\n" .
                   "We'll send you a download link once your payment is confirmed.",
            function ($message) use ($customerEmail, $order) {
                $message->to($customerEmail)
                        ->subject("Your Ebook Purchase #{$order->order_id}");
            });

        // Sales team email
        Mail::raw("New Ebook Purchase #{$order->order_id}\n\n" .
                   "Customer: {$order->customer_name}\n" .
                   "Email: {$order->customer_email}\n" .
                   "Phone: {$order->customer_phone}\n" .
                   "Amount: KES {$order->amount}\n\n" .
                   "Ebook Details:\n" .
                   "Title: {$ebook->title}\n" .
                   "ID: {$ebook->id}",
            function ($message) use ($salesEmail, $order) {
                $message->to($salesEmail)
                        ->subject("New Ebook Purchase #{$order->order_id} from {$order->customer_name}");
            });
    }
}
