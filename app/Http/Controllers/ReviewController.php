<?php

namespace App\Http\Controllers;

use App\Models\package;
use App\Models\Product;
use App\Models\review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
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
    public function store(Request $request, $productId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'review' => 'required|string|max:1000',
            'star' => 'required|integer|min:1|max:5',
        ]);

        $product = Product::findOrFail($productId);

        // Create the review
        $product->reviews()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'review' => $validated['review'],
            'star' => $validated['star'],
            'approved' => false, // Default to false for moderation
        ]);

        return back()->with('success', 'Your review has been submitted for approval!');
    }


    /**
     * Display the specified resource.
     */
    public function show(review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(review $review)
    {
        //
    }
}