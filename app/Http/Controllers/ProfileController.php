<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        $user = Auth::user();
        return view('healthversations.user.profiles.index', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Fetch the user's profile or create one if it doesn't exist
        $profile = $user->profile ?? new Profile();

        // Validate input data - ONLY city and phone_number are required
        $request->validate([
            'country' => 'nullable|string|max:255',           // Optional
            'city' => 'required|string|max:255',              // REQUIRED
            'phone_number' => 'required|string|max:20',       // REQUIRED
            'description' => 'nullable|string',               // Optional
            'health_goals' => 'nullable|string',              // Optional
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Optional
        ]);

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            // If a new profile picture is uploaded, delete the old one if it exists
            if ($profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }

            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profile->profile_picture = $path;
        }

        // Update profile fields
        $profile->user_id = $user->id;
        $profile->country = $request->input('country');           // Can be null
        $profile->city = $request->input('city');                 // REQUIRED
        $profile->phone_number = $request->input('phone_number'); // REQUIRED
        $profile->description = $request->input('description');   // Can be null
        $profile->health_goals = $request->input('health_goals'); // Can be null
        $profile->save();

        // Redirect with success message
        return redirect()->route('home')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
