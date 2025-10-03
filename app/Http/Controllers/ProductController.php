<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\productVariant;
use App\Models\ProductsImg;
use App\Models\productcategory;
use App\Models\VariationAttribute;
use App\Models\VariationAttributeValue;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; // Add this import
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index ()
    {
        $products = product::with(['category', 'variants', 'images'])->get();
        $productcategory = productcategory::all();
        return view('healthversations.admin.products.product.index', compact('products', 'productcategory'));
    }public function getVariants(Product $product)
{
    try {
        $variants = $product->variants()->with('product')->get();

        return response()->json([
            'success' => true,
            'product' => $product,
            'variants' => $variants
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Failed to load variants'
        ], 500);
    }
}

public function deleteVariant(ProductVariant $variant)
{
    try {
        $variant->delete();
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Failed to delete variant'
        ], 500);
    }
}

public function deleteImage(ProductImage $image)
{
    try {
        // Remove the '/storage/' prefix to get the correct path
        $imagePath = str_replace('/storage/', '', $image->image_path);
        Storage::disk('public')->delete($imagePath);

        $image->delete();
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Failed to delete image'
        ], 500);
    }
}

    public function allproducts()
    {
        // Get products with eager loading
        $products = product::with(['category', 'variants'])
            ->withCount('variants')
            ->latest()
            ->paginate(12);

        // Get all categories with product counts
        $categories = productcategory::withCount('products')->get();

        // Prepare meta tags
        $metaDescription = "Discover our premium health & wellness products. " .
            ($products->isNotEmpty() ? $products->first()->product_name : 'Natural, organic solutions for your wellbeing');

        $metaKeywords = "health products, wellness, organic supplements, natural remedies";
        if ($products->isNotEmpty()) {
            $metaKeywords .= ", " . $products->pluck('product_name')->join(', ');
        }

        // Prepare structured data for SEO
        $structuredData = [
            "@context" => "https://schema.org",
            "@type" => "ItemList",
            "itemListElement" => []
        ];

        foreach ($products as $index => $product) {
            $structuredData['itemListElement'][] = [
                "@type" => "ListItem",
                "position" => $index + 1,
                "item" => [
                    "@type" => "Product",
                    "name" => $product->product_name,
                    "image" => asset('storage/' . $product->cover_image),
                    "description" => Str::limit($product->description, 100),
                    "offers" => [
                        "@type" => "Offer",
                        "priceCurrency" => "KES",
                        "price" => $product->price_kes,
                        "availability" => "https://schema.org/InStock"
                    ]
                ]
            ];
        }

        return view('frontendviews.products.index', [
            'products' => $products,
            'categories' => $categories,
            'meta_description' => $metaDescription,
            'meta_keywords' => $metaKeywords,
            'structured_data' => json_encode($structuredData, JSON_UNESCAPED_SLASHES)
        ]);
    }
// Add this method to handle variant details
public function getVariantDetails($variantId)
{
    try {
        $variant = ProductVariant::with('product')->findOrFail($variantId);

        return response()->json([
            'success' => true,
            'variant' => $variant,
            'specifications' => [
                'price_kes' => $variant->price_kes,
                'price_usd' => $variant->price_usd,
                'stock' => $variant->stock,
                'measurement' => $variant->product->measurement_unit,
                'display_name' => $variant->display_name
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Variant not found'], 404);
    }
}
    public function show($slug)
{
    // Eager load relationships with counts
    $product = Product::with(['category', 'images', 'reviews', 'variants'])
        ->withCount(['reviews', 'variants'])
        ->where('slug', $slug)
        ->firstOrFail();

    // Calculate average rating
    $averageRating = $product->reviews->avg('rating') ?? 0;
    $reviewCount = $product->reviews->count();

    // Prepare order URL and disabled status
    $orderUrl = route('order.page', ['slug' => $product->slug]) . '?quantity=1';
    $orderDisabled = false;

    if ($product->has_variations && $product->variants->count()) {
        $variant = $product->variants->first();
        $orderUrl .= "&variant_id={$variant->id}";
        $orderUrl .= "&variant_name=" . urlencode($variant->display_name);
        $orderUrl .= "&price_kes={$variant->price_kes}";
        $orderUrl .= "&price_usd={$variant->price_usd}";
        $orderDisabled = $variant->stock <= 0;
    } else {
        $orderDisabled = $product->stock <= 0;
    }

    // Prepare meta tags for SEO
    $metaDescription = "Discover {$product->product_name} - {$product->product_description}";
    $metaKeywords = "{$product->product_name}, health products, wellness, " .
                   ($product->category ? $product->category->category_name : '');

    // Structured data for product (JSON-LD)
    $structuredData = [
        "@context" => "https://schema.org",
        "@type" => "Product",
        "name" => $product->product_name,
        "description" => $product->product_description,
        "brand" => [
            "@type" => "Brand",
            "name" => "Health Versations"
        ],
        "offers" => [
            "@type" => "Offer",
            "priceCurrency" => "KES",
            "price" => $product->price_kes,
            "availability" => "https://schema.org/InStock",
            "url" => url()->current()
        ],
        "aggregateRating" => [
            "@type" => "AggregateRating",
            "ratingValue" => number_format($averageRating, 1),
            "reviewCount" => $reviewCount
        ]
    ];

    // Add images to structured data if available
    if ($product->cover_image) {
        $structuredData['image'] = asset('storage/' . $product->cover_image);
    }

    if ($product->images->isNotEmpty()) {
        $structuredData['image'] = array_merge(
            [$structuredData['image'] ?? ''],
            $product->images->map(function($image) {
                return asset('storage/' . $image->image_path);
            })->toArray()
        );
    }

    // Related products (from same category)
    $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->withCount('reviews')
        ->limit(4)
        ->get();

    return view('frontendviews.products.show', [
        'product' => $product,
        'averageRating' => $averageRating,
        'reviewCount' => $reviewCount,
        'relatedProducts' => $relatedProducts,
        'meta_description' => $metaDescription,
        'meta_keywords' => $metaKeywords,
        'structured_data' => json_encode($structuredData, JSON_UNESCAPED_SLASHES),
        'orderUrl' => $orderUrl,
        'orderDisabled' => $orderDisabled
    ]);
}
    public function store(Request $request)
    {
        $validated = $this->validateProductRequest($request);

        // Handle file upload
        $imagePath = $request->file('cover_image')->store('products', 'public');
        $validated['cover_image'] = Storage::url($imagePath);

        // Create the product
        $product = Product::create([
            'product_name' => $validated['product_name'],
            'slug' => Str::slug($validated['product_name']),
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'cover_image' => $validated['cover_image'],
            'tags' => $validated['tags'],
            'meta_keywords' => $validated['meta_keywords'],
            'has_variations' => $validated['has_variations'],
            'measurement_unit' => $validated['measurement_unit'] ?? null,
            'price_kes' => $validated['has_variations'] ? null : $validated['price_kes'],
            'price_usd' => $validated['has_variations'] ? null : $validated['price_usd'],
            'stock' => $validated['has_variations'] ? 0 : $validated['stock'],
        ]);

        // Handle variants if product has variations
        if ($validated['has_variations'] && !empty($validated['variants'])) {
            foreach ($validated['variants'] as $variant) {
                $product->variants()->create([
                    'name' => $variant['quantity'],
                    'display_name' => $variant['quantity'] . $validated['measurement_unit'],
                    'price_kes' => $variant['price_kes'],
                    'price_usd' => $variant['price_usd'],
                    'stock' => $variant['stock'],
                ]);
            }
        }

        // Handle additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => Storage::url($path),
                    'alt_text' => $validated['product_name']
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function update(Request $request, Product $product)
    {
        Log::info('Update request received', [
            'product_id' => $product->id,
            'request_data' => $request->all(),
            'files' => $request->hasFile('cover_image') ? 'Has file' : 'No file'
        ]);

        try {
            $validated = $this->validateProductRequest($request, $product->id);

            Log::info('Validation passed', ['validated_data' => $validated]);

            // Handle file upload
            if ($request->hasFile('cover_image')) {
                // Delete old image
                if ($product->cover_image) {
                    $oldImagePath = str_replace('/storage/', '', $product->cover_image);
                    Storage::disk('public')->delete($oldImagePath);
                }

                $imagePath = $request->file('cover_image')->store('products', 'public');
                $validated['cover_image'] = Storage::url($imagePath);
            }

            // Prepare update data
            $updateData = [
                'product_name' => $validated['product_name'],
                'slug' => Str::slug($validated['product_name']),
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'tags' => $validated['tags'],
                'meta_keywords' => $validated['meta_keywords'],
                'has_variations' => $validated['has_variations'],
                'measurement_unit' => $validated['measurement_unit'] ?? $product->measurement_unit,
            ];

            // Add cover image if updated
            if (isset($validated['cover_image'])) {
                $updateData['cover_image'] = $validated['cover_image'];
            }

            // Handle pricing and stock based on product type
            if ($validated['has_variations']) {
                $updateData['price_kes'] = null;
                $updateData['price_usd'] = null;
                $updateData['stock'] = 0;

                // Handle variants updates
                if (!empty($validated['variants'])) {
                    $existingVariantIds = $product->variants->pluck('id')->toArray();
                    $updatedVariantIds = [];

                    foreach ($validated['variants'] as $variantData) {
                        if (isset($variantData['id'])) {
                            // Update existing variant
                            $variant = $product->variants()->find($variantData['id']);
                            if ($variant) {
                                $variant->update([
                                    'name' => $variantData['quantity'],
                                    'display_name' => $variantData['quantity'] . $validated['measurement_unit'],
                                    'price_kes' => $variantData['price_kes'],
                                    'price_usd' => $variantData['price_usd'],
                                    'stock' => $variantData['stock'],
                                ]);
                                $updatedVariantIds[] = $variantData['id'];
                            }
                        } else {
                            // Create new variant
                            $newVariant = $product->variants()->create([
                                'name' => $variantData['quantity'],
                                'display_name' => $variantData['quantity'] . $validated['measurement_unit'],
                                'price_kes' => $variantData['price_kes'],
                                'price_usd' => $variantData['price_usd'],
                                'stock' => $variantData['stock'],
                            ]);
                            $updatedVariantIds[] = $newVariant->id;
                        }
                    }

                    // Delete variants that were removed
                    $variantsToDelete = array_diff($existingVariantIds, $updatedVariantIds);
                    if (!empty($variantsToDelete)) {
                        $product->variants()->whereIn('id', $variantsToDelete)->delete();
                    }
                }
            } else {
                $updateData['price_kes'] = $validated['price_kes'];
                $updateData['price_usd'] = $validated['price_usd'];
                $updateData['stock'] = $validated['stock'];

                // Delete all variants if switching from variant to simple product
                if ($product->variants()->exists()) {
                    $product->variants()->delete();
                }
            }

            // Update the product
            $product->update($updateData);

            Log::info('Product updated successfully', ['product_id' => $product->id]);

            return redirect()->route('products.index')->with('success', 'Product updated successfully!');

        } catch (\Exception $e) {
            Log::error('Product update failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to update product: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function edit(Product $product)
{
    // Load relationships
    $product->load(['category', 'variants', 'images']);

    return response()->json([
        'success' => true,
        'product' => $product
    ]);
}
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete cover image
        if ($product->cover_image) {
            Storage::disk('public')->delete($product->cover_image);
        }

        // Delete additional images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Delete variants
        $product->variants()->delete();

        // Delete product
        $product->delete();

        return response()->json(['success' => 'Product deleted successfully']);
    }

     private function validateProductRequest(Request $request, $productId = null)
    {
        $rules = [
            'product_name' => 'required|string|max:255|unique:products,product_name' . ($productId ? ",$productId" : ''),
            'description' => 'required|string',
            'category_id' => 'required|exists:productcategories,id',
            'cover_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'has_variations' => 'required|boolean', // Changed from 'sometimes' to 'required'
        ];

        // Only require these fields for simple products
        if (!$request->has_variations || $request->has_variations == '0') {
            $rules['price_kes'] = 'required|numeric|min:0';
            $rules['price_usd'] = 'required|numeric|min:0';
            $rules['stock'] = 'required|integer|min:0';
        } else {
            $rules['measurement_unit'] = 'required|in:kg,g,L,ml,pcs';
            $rules['variants'] = 'required|array|min:1';
            $rules['variants.*.quantity'] = 'required|numeric|min:0';
            $rules['variants.*.price_kes'] = 'required|numeric|min:0';
            $rules['variants.*.price_usd'] = 'required|numeric|min:0';
            $rules['variants.*.stock'] = 'required|integer|min:0';
        }

        return $request->validate($rules);
    }
}
