<?php

namespace App\Http\Controllers;

use App\Models\subscribe;
use Illuminate\Http\Request;

class SubscribeController extends Controller
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
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email|unique:subscribes,email',
        ]);

        // Create the subscription
        Subscribe::create([
            'email' => $request->email,
            'status' => 'active', // Default to active when the user subscribes
        ]);

        return back()->with('success', 'You have successfully subscribed!');
    }

    /**
     * Display the specified resource.
     */
    public function show(subscribe $subscribe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(subscribe $subscribe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, subscribe $subscribe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(subscribe $subscribe)
    {
        //
    }
}