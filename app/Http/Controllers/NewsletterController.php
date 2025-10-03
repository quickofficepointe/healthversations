<?php

namespace App\Http\Controllers;

use App\Models\newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscribers = Newsletter::all();
        return view('healthversations.admin.subscribers.index', compact('subscribers'));
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
   public function subscribe(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:newsletters,email',
        'consent' => 'required|accepted',
    ]);

    Newsletter::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'consent' => true, // Since it's required and checked
    ]);

    return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
}
    /**
     * Display the specified resource.
     */
    public function show(newsletter $newsletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(newsletter $newsletter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:newsletters,email,' . $id,
        'consent' => 'required|accepted',
    ]);

    $newsletter = Newsletter::findOrFail($id);
    $newsletter->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'consent' => true,
    ]);

    return redirect()->back()->with('success', 'Subscriber updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Find the subscriber by ID
    $newsletter = Newsletter::findOrFail($id);

    // Delete the subscriber
    $newsletter->delete();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Subscriber removed successfully!');
}

}