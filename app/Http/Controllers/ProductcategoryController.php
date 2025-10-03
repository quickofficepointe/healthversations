<?php

namespace App\Http\Controllers;

use App\Models\productcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $productcategory = productcategory::all();
        return view('healthversations.admin.products.productcategory.index', compact('productcategory'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function edit(ProductCategory $productCategory)
{
    return response()->json([
        'success' => true,
        'category' => $productCategory
    ]);
}
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'required|string',
            'category_tag' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('productcategories', 'public');
        }

        $data['slug'] = Str::slug($data['category_name']);

        productcategory::create($data);

        return redirect()->back()->with('success', 'Package category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(productcategory $productcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $data = $request->validate([
            'category_name' => 'sometimes|required|string|max:255',
            'category_description' => 'sometimes|required|string',
            'category_tag' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('productcategories', 'public');
        }

        if (isset($data['category_name'])) {
            $data['slug'] = Str::slug($data['category_name']);
        }

        $productCategory->update($data);

        return redirect()->back()->with('success', 'Product category updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();

        return redirect()->back()->with('success', 'Product category deleted successfully.');
    }
}
