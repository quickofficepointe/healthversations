<?php

namespace App\Http\Controllers;

use App\Models\privacypolicy;
use Illuminate\Http\Request;

class PrivacypolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $privacypolicy = privacypolicy::all();
        return view('healthversations.admin.privacypolicy.index', compact('privacypolicy'));
    }

public function privacy()
{
    $privacypolicy = privacypolicy::all();

    return view('frontendviews.privacy.index',compact('privacypolicy'));
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
        $request->validate([
            'privacy' => 'required',  // Ensure privacy content is provided
        ]);

        // Create a new privacy policy entry
        PrivacyPolicy::create([
            'privacy' => $request->privacy,
        ]);

        return redirect()->route('privacy.index')->with('success', 'Privacy policy created successfully.');
    }

    /**
     * Update the existing privacy policy.
     */
    public function update(Request $request)
    {
        $request->validate([
            'privacy' => 'required',  // Ensure privacy content is provided
        ]);

        $privacyPolicy = PrivacyPolicy::first();  // Assuming only one policy exists
        $privacyPolicy->update([
            'privacy' => $request->privacy,
        ]);

        return redirect()->route('privacy.index')->with('success', 'Privacy policy updated successfully.');
    }

    /**
     * Delete the privacy policy.
     */
    public function destroy()
    {
        $privacyPolicy = PrivacyPolicy::first();  // Assuming only one policy exists
        $privacyPolicy->delete();

        return redirect()->route('privacy.index')->with('success', 'Privacy policy deleted successfully.');
    }
}
