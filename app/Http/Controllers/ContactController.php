<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function aboutus()
     {
        return view('frontendviews.aboutus.index');
     }
    public function index()
    {
        //
        return view('frontendviews.aboutus.contact');
    }

    public function refundndreturn()
    {
        return view ('frontendviews.privacy.returnsandrefunds');
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
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',  // Assuming the phone number is optional
            'email' => 'required|email|max:255',  // Email is unique to prevent duplicates
            'message' => 'required|string',  // Message is required and should be a string
        ]);

        // Create a new contact record in the database
        Contact::create([
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'message' => $validated['message'],
        ]);

        // Return a success response or redirect
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        $contacts = Contact::latest()->get(); // Fetch all messages, latest first

        return view('healthversations.admin.messages.index', compact('contacts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(contact $contact)
    {
        //
    }
}
