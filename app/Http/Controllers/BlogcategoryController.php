<?php

namespace App\Http\Controllers;

use App\Models\blogcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = blogcategory::latest()->get();
        return view('healthversations.admin.articles.articlescategory.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoryname' => 'required|string|max:255|unique:blogcategories,categoryname',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
        ]);

        $category = blogcategory::create([
            'categoryname' => $validated['categoryname'],
            'slug' => $this->createUniqueSlug($validated['categoryname']),
            'description' => $validated['description'] ?? Str::slug($validated['categoryname']),
            'user_id' => auth()->id(),
            'cover_image' => $this->handleImageUpload($request->file('cover_image')),
        ]);

        return redirect()->back()
            ->with('success', 'Category created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, BlogCategory $category)
{
    $validated = $request->validate([
        'categoryname' => 'required|string|max:255|unique:blogcategories,categoryname,' . $category->id . ',id',
        'description' => 'nullable|string',
        'cover_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
    ]);

    if ($category->categoryname !== $validated['categoryname']) {
        $validated['slug'] = $this->createUniqueSlug($validated['categoryname']);
    }

    if ($request->hasFile('cover_image')) {
        $this->deleteImage($category->cover_image);
        $validated['cover_image'] = $this->handleImageUpload($request->file('cover_image'));
    }

    $category->update($validated);

    return redirect()->back()->with('success', 'Category updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)  // Change parameter to $id to match route
{
    $category = BlogCategory::findOrFail($id);

    // Delete associated image if exists
    if ($category->cover_image) {
        $this->deleteImage($category->cover_image);
    }

    // Delete the category
    $category->delete();

    return redirect()->back()
        ->with('success', 'Category deleted successfully!');
}

    /**
     * Handle image upload
     */
    private function handleImageUpload($file)
    {
        if (!$file) return null;
        return $file->store('blog-categories', 'public');
    }

    /**
     * Delete image from storage
     */
    private function deleteImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    /**
     * Create a unique slug
     */
    private function createUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = BlogCategory::where('slug', $slug)->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }
}
