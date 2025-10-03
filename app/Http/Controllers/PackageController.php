<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Support\Str;
use App\Models\packagecategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $package = package::all();
        $packagecategory = packagecategory::all();
        return view('healthversations.admin.packages.package.index',compact('package','packagecategory'));
    }

    public function premiumpackages()
    {
        $packages = package::all();
        return view('frontendviews.packages.index',compact('packages'));
    }

    public function allpackages()
{
    $packages = Package::all();
    return view('frontendviews.packages.index', compact('packages'));
}
    public function healthyliving()
    {
        return view('frontendviews.healthyliving.index');
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
        'category_id' => 'required|exists:packagecategories,id',
        'package_name' => 'required|string|max:255',
        'package_description' => 'nullable|string',
        'package_tags' => 'nullable|string',
        'package_image' => 'nullable|image|mimes:jpg,jpeg,png',
    ]);

    // Generate the slug from the package_name
    $slug = Str::slug($request->package_name);

    // Handle image upload if present
    if ($request->hasFile('package_image')) {
        $imagePath = $request->file('package_image')->store('package_images', 'public');
    } else {
        $imagePath = null;
    }

    // Create the package record with the generated slug
    $package = Package::create([
        'category_id' => $request->category_id,
        'package_name' => $request->package_name,
        'slug' => $slug,
        'package_description' => $request->package_description,
        'package_tags' => $request->package_tags,
        'package_image' => $imagePath,
    ]);

    // Redirect back with success message
    return redirect()->back()->with('success', 'Package created successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show($slug)
{
    $package = Package::where('slug', $slug)->firstOrFail();
    return view('frontendviews.packages.show', compact('package'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Remove the empty edit method since we're using modal
// public function edit(package $package)
// {
//     //
// }

// Update method should handle both AJAX and regular requests
public function update(Request $request, Package $package)
{
    $validated = $request->validate([
        'category_id' => 'required|exists:packagecategories,id',
        'package_name' => 'required|string|max:255',
        'package_description' => 'nullable|string',
        'package_tags' => 'nullable|string',
        'package_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Handle image upload
    if ($request->hasFile('package_image')) {
        // Delete old image if exists
        if ($package->package_image) {
            Storage::disk('public')->delete($package->package_image);
        }
        $validated['package_image'] = $request->file('package_image')->store('package_images', 'public');
    }

    // Update slug if name changed
    if ($package->package_name !== $request->package_name) {
        $validated['slug'] = Str::slug($request->package_name);
    }

    $package->update($validated);

    // Return JSON for AJAX requests or redirect for normal form submission
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Package updated successfully',
            'package' => $package
        ]);
    }

    return redirect()->route('packages.index')
        ->with('success', 'Package updated successfully');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $package = Package::findOrFail($id);

        // Delete the image if exists
        if ($package->package_image) {
            Storage::disk('public')->delete($package->package_image);
        }

        $package->delete();

        // For web requests (like form submissions)
        if (request()->expectsJson()) {
            return response()->json(['message' => 'Package deleted successfully']);
        }

        return redirect()->route('packages.index')
            ->with('success', 'Package deleted successfully');
    }

}