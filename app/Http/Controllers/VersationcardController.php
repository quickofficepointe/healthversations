<?php

namespace App\Http\Controllers;

use App\Models\versationcard;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class VersationcardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $versationscard = versationcard::all();
        return view('healthversations.admin.versationcards.index', compact('versationscard'));
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        // Handle image upload if present
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('versationcards', 'public');
        } else {
            $imagePath = null;
        }

        // Create the new VersationCard
        $versationCard = VersationCard::create([
            'name' => $request->name,
            'description' => $request->description,
            'tags' => $request->tags,
            'cover_image' => $imagePath,
            'slug' => Str::slug($request->name),  // Auto-generate slug from the name
        ]);

       // Redirect back with a success message
    return redirect()->back()->with('success', 'Versation Card created successfully!');
    }

    // Show a single Versation Card
    public function show($id)
    {
        $versationCard = VersationCard::findOrFail($id);
        return response()->json($versationCard);
    }

    // Update an existing Versation Card
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        // Find the VersationCard by ID
        $versationCard = VersationCard::findOrFail($id);

        // Handle image upload if present
        if ($request->hasFile('cover_image')) {
            // Delete old image from storage if it exists
            if ($versationCard->cover_image) {
                Storage::disk('public')->delete($versationCard->cover_image);
            }
            // Store the new image
            $imagePath = $request->file('cover_image')->store('versationcards', 'public');
        } else {
            $imagePath = $versationCard->cover_image; // Retain old image if not updated
        }

        // Update the VersationCard with new values
        $versationCard->update([
            'name' => $request->name,
            'description' => $request->description,
            'tags' => $request->tags,
            'cover_image' => $imagePath,
            'slug' => Str::slug($request->name),  // Auto-generate slug from the name
        ]);

        return redirect()->back()->with('success', 'Versation Card updated successfully!');
    }


    // Destroy a Versation Card
    public function destroy($id)
    {
        $versationCard = VersationCard::findOrFail($id);

        // Delete cover image if it exists
        if ($versationCard->cover_image) {
            Storage::disk('public')->delete($versationCard->cover_image);
        }

        // Delete the VersationCard
        $versationCard->delete();

        return redirect()->back()->with('success', 'Versation Card deleted successfully!');
    }

}