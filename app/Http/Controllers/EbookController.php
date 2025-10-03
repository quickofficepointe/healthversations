<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Eorder;
use Illuminate\Support\Str;
use Spatie\PdfToImage\Pdf as PdfToImage; // Renamed to avoid conflicts
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser; // For PDF page counting

class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ebooks = Ebook::latest()->paginate(10);
        return view('healthversations.admin.ebooks.index', compact('ebooks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'ebook_file' => 'required|mimes:pdf|max:5242880',
            'preview_content' => 'required|string',
            'ebook_price' => 'required|numeric|min:0',
            'hardcopy_price' => 'nullable|numeric|min:0',
            'is_hardcopy_available' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $coverPath = $request->file('cover_image')->store('ebook_covers', 'public');
        $filePath = $request->file('ebook_file')->store('ebook_files', 'public');

        // Get PDF page count
        $pageCount = $this->getPdfPageCount(storage_path('app/public/' . $filePath));

        Ebook::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'cover_image' => $coverPath,
            'file_path' => $filePath,
            'preview_content' => $validated['preview_content'],
            'ebook_price' => $validated['ebook_price'],
            'hardcopy_price' => $validated['hardcopy_price'] ?? null,
            'is_hardcopy_available' => $request->has('is_hardcopy_available'),
            'is_featured' => $request->has('is_featured'),
            'page_count' => $pageCount // Store page count for flipbook
        ]);

        return redirect()->back()->with('success', 'Ebook created successfully!');
    }

    public function update(Request $request, Ebook $ebook)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ebook_file' => 'nullable|mimes:pdf|max:5120',
            'preview_content' => 'required|string',
            'ebook_price' => 'required|numeric|min:0',
            'hardcopy_price' => 'nullable|numeric|min:0',
            'is_hardcopy_available' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'preview_content' => $validated['preview_content'],
            'ebook_price' => $validated['ebook_price'],
            'hardcopy_price' => $validated['hardcopy_price'] ?? null,
            'is_hardcopy_available' => $request->has('is_hardcopy_available'),
            'is_featured' => $request->has('is_featured')
        ];

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($ebook->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('ebook_covers', 'public');
        }

        if ($request->hasFile('ebook_file')) {
            Storage::disk('public')->delete($ebook->file_path);
            $filePath = $request->file('ebook_file')->store('ebook_files', 'public');
            $data['file_path'] = $filePath;
            $data['page_count'] = $this->getPdfPageCount(storage_path('app/public/' . $filePath));
        }

        $ebook->update($data);

        return redirect()->back()->with('success', 'Ebook updated successfully!');
    }

    public function destroy(Ebook $ebook)
    {
        Storage::disk('public')->delete([$ebook->cover_image, $ebook->file_path]);
        $ebook->delete();
        return redirect()->back()->with('success', 'Ebook deleted successfully!');
    }

    public function purchase(Request $request, Ebook $ebook)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'type' => 'required|in:ebook,hardcopy',
            'shipping_address' => 'required_if:type,hardcopy|nullable|string|max:500',
        ]);

        $price = $validated['type'] === 'ebook'
            ? $ebook->ebook_price
            : $ebook->hardcopy_price;

        if (is_null($price)) {
            return back()->with('error', 'Invalid price for selected purchase type');
        }

        $order = Eorder::create([
            'order_number' => 'ORD-' . Str::upper(Str::random(10)),
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'customer_phone' => $validated['phone'],
            'shipping_address' => $validated['shipping_address'] ?? null,
            'type' => $validated['type'],
            'status' => 'pending',
            'amount' => $price,
            'payment_method' => 'pending',
        ]);

        $order->ebooks()->attach($ebook->id, [
            'quantity' => 1,
            'price' => $price,
        ]);

        return redirect()->route('payment.process', $order->order_number)
            ->with('success', 'Order created successfully. Proceed to payment.');
    }

    public function show()
    {
        $ebooks = Ebook::all();
        return view('frontendviews.ebooks.index', compact('ebooks'));
    }

    /**
     * Get the number of pages in a PDF file
     */
    private function getPdfPageCount($filePath)
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            return count($pdf->getPages());
        } catch (\Exception $e) {
            // Fallback to default if parsing fails
            return 0;
        }
    }
}
