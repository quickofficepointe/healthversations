<?php

namespace App\Http\Controllers;

use App\Models\custompackage;
use Illuminate\Http\Request;

class CustompackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $customPackages = custompackage::all();
        return view('healthversations.admin.customqoutes.index', compact('customPackages'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('frontendviews.custompackage.index');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'service' => 'required|string|max:255',
            'message' => 'nullable|string',
            'package_details' => 'nullable|string',
        ]);

        // Create a new CustomPackage record
        $package = CustomPackage::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'service' => $validatedData['service'],
            'message' => $validatedData['message'],
            'package_details' => $validatedData['package_details'],
            'status' => 'pending', // Default status
        ]);

        // Redirect with a success message
        return redirect()->back()->with('success', 'Your custom package request has been submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(custompackage $custompackage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(custompackage $custompackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, custompackage $custompackage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(custompackage $custompackage)
    {
        //
    }
}