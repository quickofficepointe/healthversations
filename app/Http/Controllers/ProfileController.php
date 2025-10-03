<?php

namespace App\Http\Controllers;

use App\Models\profile;
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
    public function show(profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(profile $profile)
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
        $profile = $user->profile ?? new Profile(); // Create a new Profile if none exists

        // Validate input data
        $request->validate([
            'country' => 'string|max:255',
            'city' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'description' => 'nullable|string',
            'health_goals' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            // If a new profile picture is uploaded, delete the old one if it exists
            if ($profile->profile_picture) {
                Storage::delete($profile->profile_picture);
            }

            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profile->profile_picture = $path;  // Update the profile with the new picture path
        }

        // Update other profile fields or create a new profile if it didn't exist
        $profile->user_id = $user->id; // Ensure the profile is associated with the logged-in user
        $profile->country = $request->input('country');
        $profile->city = $request->input('city');
        $profile->phone_number = $request->input('phone_number');
        $profile->description = $request->input('description');
        $profile->health_goals = $request->input('health_goals');
        $profile->save(); // Save the profile

        // Redirect with success message
        return redirect()->route('home')->with('success', 'Profile updated successfully.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(profile $profile)
    {
        //
    }
}