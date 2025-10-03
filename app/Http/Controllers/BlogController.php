<?php

namespace App\Http\Controllers;

use App\Models\blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\blogcategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $blog= blog::all();
        $blogcategory = blogcategory::all();
        return view('healthversations.admin.articles.article.index', compact('blog','blogcategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
public function blogs()
{
    $blogs = Blog::with('category')->latest()->paginate(10); // 10 blogs per page
    return view('frontendviews.blogs.index', compact('blogs'));
}

public function show($slug)
{
    // Fetch the blog post by slug instead of ID
    $blog = Blog::with('category')
                ->where('slug', $slug)
                ->firstOrFail();

    // Return the blog details to a frontend view
    return view('frontendviews.blogs.show', compact('blog'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'blog_title' => 'required|string|max:255',
            'blog_description' => 'required|string',
            'blogcategory_id' => 'required|exists:blogcategories,id',
            'approved' => 'nullable|boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'nullable|string',
        ]);

        // Generate a slug from the blog title
        $slug = Str::slug($validated['blog_title']);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image')->store('cover_images', 'public');
        }

        // Create the blog post
        $blog = Blog::create([
            'blog_title' => $validated['blog_title'],
            'blog_description' => $validated['blog_description'],
            'user_id' => auth()->id(),  // Get the current logged-in user's ID
            'blogcategory_id' => $validated['blogcategory_id'],
            'approved' => $validated['approved'] ?? false,
            'cover_image' => $cover_image ? Storage::url($cover_image) : null,
            'tags' => $validated['tags'],
            'slug' => $slug,
        ]);

        // Return response (you can redirect or return a JSON response)
        return redirect()->route('blogs.index')->with('success', 'Blog created successfully!');
    }



    /**
     * Update the specified blog in storage.
     */
   public function update(Request $request, Blog $blog)
{
    // Validate the incoming data
    $validated = $request->validate([
        'blog_title' => 'required|string|max:255',
        'blog_description' => 'required|string',
        'user_id' => 'required|exists:users,id',
        'blogcategory_id' => 'required|exists:blogcategories,id',
        'approved' => 'nullable|boolean',
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'tags' => 'nullable|string',
    ]);

    // Generate slug from the blog title
    $slug = Str::slug($validated['blog_title']);

    // Handle cover image
    $cover_image = $blog->cover_image;

    if ($request->hasFile('cover_image')) {
        // Delete old image if it exists in storage
        if ($cover_image) {
            $oldImagePath = str_replace('/storage/', '', $cover_image);
            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        // Store new image in same way as in store()
        $storedPath = $request->file('cover_image')->store('cover_images', 'public');
        $cover_image = Storage::url($storedPath);
    }

    // Update the blog post
    $blog->update([
        'blog_title' => $validated['blog_title'],
        'blog_description' => $validated['blog_description'],
        'user_id' => $validated['user_id'],
        'blogcategory_id' => $validated['blogcategory_id'],
        'approved' => $validated['approved'] ?? false,
        'cover_image' => $cover_image,
        'tags' => $validated['tags'],
        'slug' => $slug,
    ]);

    return redirect()->route('blogs.index')->with('success', 'Blog updated successfully!');
}

    public function destroy($id)
{
    $blog = Blog::findOrFail($id);

    if ($blog->cover_image) {
        Storage::delete($blog->cover_image);
    }

    $blog->delete();

    return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
}

}
