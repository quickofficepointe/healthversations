<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Blog;
use App\Models\CartOrder;
use App\Models\Consultation;
use App\Models\Contact;
use App\Models\EbookOrder;
use App\Models\Product;
use App\Models\Review;
use App\Models\Subscribe;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('healthversations.user.index');

    }


    public function dashboard()
    {
        $paidStatuses = ['confirmed', 'processing', 'completed'];

        $stats = [
            'orderCount' => CartOrder::count(),
            'pendingOrders' => CartOrder::where('status', 'pending')->count(),
            'revenue' => CartOrder::whereIn('status', $paidStatuses)->sum('amount'),
            'etimsPending' => CartOrder::etimsPending()->count(),
            'consultationCount' => Consultation::count(),
            'pendingConsultations' => Consultation::where('status', 'pending')->count(),
            'ebookOrderCount' => EbookOrder::count(),
            'contactCount' => Contact::count(),
            'newContacts' => Contact::where('created_at', '>=', now()->subMonth())->count(),
            'subscriberCount' => Subscribe::count(),
            'productCount' => Product::count(),
            'inStockCount' => Product::where('stock', '>', 0)->count(),
            'reviewCount' => Review::count(),
            'pendingReviews' => Review::where('approved', false)->count(),
            'avgRating' => (float) Review::avg('star'),
            'blogCount' => Blog::count(),
        ];

        // Last 6 months, grouped in PHP so it works with MySQL ONLY_FULL_GROUP_BY
        $months = collect(range(5, 0))->map(fn ($i) => now()->startOfMonth()->subMonths($i));
        $since = $months->first();

        $orders = CartOrder::where('created_at', '>=', $since)->get(['created_at', 'amount', 'status']);
        $subscribers = Subscribe::where('created_at', '>=', $since)->pluck('created_at');

        $stats['chartLabels'] = $months->map(fn ($m) => $m->format('M Y'));
        $stats['ordersByMonth'] = $months->map(fn ($m) => $orders->filter(fn ($o) => $o->created_at->isSameMonth($m))->count());
        $stats['revenueByMonth'] = $months->map(fn ($m) => (float) $orders
            ->filter(fn ($o) => $o->created_at->isSameMonth($m) && in_array($o->status, $paidStatuses))
            ->sum('amount'));
        $stats['subscribersByMonth'] = $months->map(fn ($m) => $subscribers->filter(fn ($d) => $d->isSameMonth($m))->count());

        $stats['recentOrders'] = CartOrder::latest()->take(6)->get();
        $stats['recentActivities'] = $this->getRecentActivities();

        return view('healthversations.admin.index', $stats);
    }

    protected function getRecentActivities()
    {
        $activities = collect();

        foreach (Consultation::latest()->take(3)->get() as $consultation) {
            $activities->push([
                'icon' => 'calendar-check',
                'color' => 'green',
                'title' => 'Consultation booked by ' . $consultation->name,
                'description' => 'For ' . ($consultation->consultation_date ? Carbon::parse($consultation->consultation_date)->format('M d, Y') : 'TBD'),
                'at' => $consultation->created_at,
            ]);
        }

        foreach (Subscribe::latest()->take(3)->get() as $subscriber) {
            $parts = explode('@', $subscriber->email);
            $activities->push([
                'icon' => 'user-plus',
                'color' => 'blue',
                'title' => 'New Subscriber',
                'description' => substr($parts[0], 0, 3) . '****@' . ($parts[1] ?? ''),
                'at' => $subscriber->created_at,
            ]);
        }

        foreach (Review::latest()->take(3)->get() as $review) {
            $activities->push([
                'icon' => 'star',
                'color' => 'yellow',
                'title' => 'New Review by ' . $review->name,
                'description' => 'Rating: ' . $review->star . '/5' . ($review->approved ? '' : ' (awaiting approval)'),
                'at' => $review->created_at,
            ]);
        }

        return $activities->sortByDesc('at')->take(6)->values();
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
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
