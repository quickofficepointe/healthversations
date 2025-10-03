<?php

namespace App\Http\Controllers;

use App\Models\faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::all();

        return view('healthversations.admin.faqs.index', compact('faqs'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function versation()
    {
        $faqs = Faq::all();
        return view('frontendviews.faqs.index',compact('faqs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:1000',
        ]);

        // Create a new FAQ entry
        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        // Redirect back with a success message
        return redirect()->route('faqs.index')->with('success', 'FAQ added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(faq $faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:1000',
        ]);

        // Find the FAQ by ID
        $faq = Faq::findOrFail($id);

        // Update the FAQ
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        // Redirect back with a success message
        return redirect()->route('faqs.index')->with('success', 'FAQ updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the FAQ by ID
        $faq = Faq::findOrFail($id);

        // Delete the FAQ
        $faq->delete();

        // Redirect back with a success message
        return redirect()->route('faqs.index')->with('success', 'FAQ deleted successfully!');
    }
}
