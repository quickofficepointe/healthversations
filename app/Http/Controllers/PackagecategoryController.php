<?php

namespace App\Http\Controllers;

use App\Models\packagecategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PackagecategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $packagecategory = packagecategory::all();
       return view('healthversations.admin.packages.packagecategory.index',compact('packagecategory'));
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


    /**
     * Display the specified resource.
     */
    public function show(packagecategory $packagecategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(packagecategory $packagecategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // validate image type and size
            'category_tags' => 'nullable|string',
        ]);

        // Generate the slug from category_name
        $slug = Str::slug($request->category_name);

        // Handle the image upload
        $imagePath = null;
        if ($request->hasFile('category_image')) {
            $imagePath = $request->file('category_image')->store('category_image', 'public');
        }

        // Create and store the new category
        $category = PackageCategory::create([
            'category_name' => $request->category_name,
            'slug' => $slug,
            'category_description' => $request->category_description,
            'category_image' => $imagePath,
            'category_tags' => $request->category_tags,
        ]);

          // Redirect back with success message
    return redirect()->back()->with('success', 'Package category created successfully!');
}

    // Update an existing package category
    public function update(Request $request, $id)
    {
        // Find the category by its ID
        $category = PackageCategory::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // validate image type and size
            'category_tags' => 'nullable|string',
        ]);

        // Generate the slug from category_name
        $slug = Str::slug($request->category_name);

        // Handle the image upload
        if ($request->hasFile('category_image')) {
            // Delete old image if exists
            if ($category->category_image) {
                Storage::disk('public')->delete($category->category_image);
            }
            // Store the new image
            $imagePath = $request->file('category_image')->store('category_images', 'public');
            $category->category_image = $imagePath;
        }

        // Update the category data
        $category->update([
            'category_name' => $request->category_name,
            'slug' => $slug,
            'category_description' => $request->category_description,
            'category_tags' => $request->category_tags,
        ]);

         // Redirect back with success message
    return redirect()->back()->with('success', 'Package Category updated created successfully!');
}


    // Destroy a package category
    public function destroy($id)
    {
        // Find the category by its ID
        $category = PackageCategory::findOrFail($id);

        // Delete the category image if exists
        if ($category->category_image) {
            Storage::disk('public')->delete($category->category_image);
        }

        // Delete the category
        $category->delete();

          // Redirect back with success message
    return redirect()->back()->with('success', 'Package category ddeleted created successfully!');
}


}
