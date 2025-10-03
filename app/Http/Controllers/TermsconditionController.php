<?php

namespace App\Http\Controllers;

use App\Models\termscondition;
use Illuminate\Http\Request;

class TermsconditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $termsandconditions = termscondition::all();
        return view('healthversations.admin.termsandcondition.index', compact('termsandconditions'));
    }

    /**
     * Show the form for creating a new resource.
      */

      public function terms()
      {
          $termsandconditions = TermsCondition::all(); // Fetch all terms
          return view('frontendviews.termsandconditions.index', compact('termsandconditions'));
      }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'terms' => 'required',  // Make sure terms content is not empty
        ]);

        // Create a new terms and conditions record
        TermsCondition::create([
            'terms' => $request->terms,
        ]);

        return redirect()->route('terms.index')->with('success', 'Terms and Conditions created successfully.');
    }

    /**
     * Update the existing terms and conditions.
     */
    public function update(Request $request)
    {
        $request->validate([
            'terms' => 'required',  // Ensure terms content is provided
        ]);

        $termsCondition = TermsCondition::first();  // Fetch the first (and only) record
        $termsCondition->update([
            'terms' => $request->terms,
        ]);

        return redirect()->route('terms.index')->with('success', 'Terms and Conditions updated successfully.');
    }

    /**
     * Delete the terms and conditions.
     */
    public function destroy($id)
    {
        $termsCondition = TermsCondition::findOrFail($id);  // Find the term by ID
        $termsCondition->delete();

        return redirect()->route('terms.index')->with('success', 'Terms and Conditions deleted successfully.');
    }



}
