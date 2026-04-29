<?php

namespace App\Http\Controllers;

use App\Models\package;
use App\Models\Product;
use App\Models\review;
use Illuminate\Http\Request;

class ReviewController extends Controller
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
     * Display all reviews for admin (with pending approval filter)
     */
    public function adminIndex(Request $request)
    {
        $status = $request->get('status', 'pending');

        $query = review::with('reviewable');

        if ($status === 'pending') {
            $query->where('approved', false);
        } elseif ($status === 'approved') {
            $query->where('approved', true);
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get counts for badges
        $pendingCount = review::where('approved', false)->count();
        $approvedCount = review::where('approved', true)->count();
        $totalCount = review::count();

        return view('healthversations.admin.reviews.index', compact('reviews', 'status', 'pendingCount', 'approvedCount', 'totalCount'));
    }

    /**
     * Approve a review
     */
  public function approve($id)
{
    try {
        $review = review::findOrFail($id);
        $review->approved = true;
        $review->save();

        return response()->json([
            'success' => true,
            'message' => 'Review approved successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

public function reject($id)
{
    try {
        $review = review::findOrFail($id);
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Bulk action for reviews
     */
    public function bulkAction(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;

        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'No reviews selected']);
        }

        if ($action === 'approve') {
            review::whereIn('id', $ids)->update(['approved' => true]);
            return response()->json(['success' => true, 'message' => 'Reviews approved successfully']);
        } elseif ($action === 'reject') {
            review::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Reviews deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid action']);
    }

    /**
     * Get pending reviews count (for AJAX badge update)
     */
    public function getPendingCount()
    {
        $count = review::where('approved', false)->count();
        return response()->json(['count' => $count]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $productId)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'review' => 'required|string|max:1000',
            'star' => 'required|integer|min:1|max:5',
        ]);

        // Find the product
        $product = Product::findOrFail($productId);

        // Create the review using the correct relationship
        $review = new review();
        $review->name = $validated['name'];
        $review->email = $validated['email'];
        $review->review = $validated['review'];
        $review->star = $validated['star'];
        $review->approved = false;
        $review->reviewable_id = $product->id;
        $review->reviewable_type = Product::class;
        $review->save();

        // Return JSON response for AJAX request
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Your review has been submitted for approval!',
                'review' => [
                    'name' => $review->name,
                    'star' => $review->star,
                    'review' => $review->review,
                    'created_at' => $review->created_at->format('M d, Y')
                ]
            ]);
        }

        // Return back with success message for non-AJAX requests
        return back()->with('success', 'Your review has been submitted for approval!');
    }

    /**
     * Display the specified resource.
     */
    public function show(review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(review $review)
    {
        //
    }
}
