<?php

namespace App\Http\Controllers;

use App\Models\testmony;
use Illuminate\Http\Request;

class TestmonyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all testimonials
        $testimonies = Testmony::orderBy('created_at', 'desc')->get();

        // Pass testimonials to the view
        return view('healthversations.admin.feedback.index', compact('testimonies'));
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
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        // Create and store the testimony
        testmony::create([
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
            'rating' => $request->input('rating'),
            'is_enabled' => false, // Default to disabled
        ]);

        // Redirect or return a response
        $message = 'Thank you for your feedback! ';

        // Check if the request expects a JSON response
        if ($request->wantsJson()) {
            return response()->json([
                'message' => $message,
            ], 201);
        }

        // Otherwise, redirect with a success message
        return redirect()->back()->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(testmony $testmony)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(testmony $testmony)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the testimony by ID
        $testimony = testmony::findOrFail($id);

        // Toggle the `is_enabled` status
        $testimony->is_enabled = !$testimony->is_enabled;

        // Save the changes
        $testimony->save();


         // Redirect or return a response
         $message = 'Testimony status updated successfully ';

         // Check if the request expects a JSON response
         if ($request->wantsJson()) {
             return response()->json([
                 'message' => $message,
             ], 201);
         }

          // Otherwise, redirect with a success message
          return redirect()->back()->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $request)
    {
        // Find the testimony by ID
        $testimony = testmony::findOrFail($id);

        // Delete the testimony
        $testimony->delete();

        // Return a response


         // Redirect or return a response
         $message = 'Testimony deleted successfully. ';

         // Check if the request expects a JSON response
         if ($request->wantsJson()) {
             return response()->json([
                 'message' => $message,
             ], 201);
         }

          // Otherwise, redirect with a success message
          return redirect()->back()->with('success', $message);
    }

}