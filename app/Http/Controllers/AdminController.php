<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\blog;
use App\Models\contact;
use App\Models\custompackage;
use App\Models\order;
use App\Models\package;
use App\Models\product;
use App\Models\review;
use App\Models\subscribe;
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
    // Basic counts
    $stats = [
        'blogs' => blog::all(),
        'contacts' => contact::all(),
        'customPackages' => custompackage::all(),
        'orders' => order::all(),
        'packages' => package::all(),
        'products' => product::all(),
        'reviews' => Review::all(),
        'subscribers' => Subscribe::all(),
    ];

    // Chart data
    $stats['ordersByMonth'] = order::selectRaw('count(*) as count, DATE_FORMAT(created_at, "%b") as month')
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('created_at')
        ->get();

    $stats['subscribersByMonth'] = Subscribe::selectRaw('count(*) as count, DATE_FORMAT(created_at, "%b") as month')
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('created_at')
        ->get();

    $stats['maxOrders'] = max($stats['ordersByMonth']->max('count'), 1);
    $stats['maxSubscribers'] = max($stats['subscribersByMonth']->max('count'), 1);

    // Recent activity
    $stats['recentActivities'] = $this->getRecentActivities();

    return view('healthversations.admin.index', $stats);
}

protected function getRecentActivities()
{
    $activities = [];

    // Recent orders
    $recentOrders = Order::latest()->take(3)->get();
    foreach ($recentOrders as $order) {
        $activities[] = [
            'icon' => 'shopping-cart',
            'color' => 'purple',
            'title' => 'New Order #'.$order->id,
            'description' => 'Total: $'.number_format($order->total, 2),
            'time' => $order->created_at->diffForHumans()
        ];
    }

    // Recent subscribers
    $recentSubscribers = subscribe::latest()->take(2)->get();
    foreach ($recentSubscribers as $subscriber) {
        $activities[] = [
            'icon' => 'user-plus',
            'color' => 'blue',
            'title' => 'New Subscriber',
            'description' => substr($subscriber->email, 0, 3).'****@'.explode('@', $subscriber->email)[1],
            'time' => $subscriber->created_at->diffForHumans()
        ];
    }

    // Recent reviews
    $recentReviews = review::latest()->take(2)->get();
    foreach ($recentReviews as $review) {
        $activities[] = [
            'icon' => 'star',
            'color' => 'yellow',
            'title' => 'New Review',
            'description' => 'Rating: '.$review->rating.'/5',
            'time' => $review->created_at->diffForHumans()
        ];
    }

    // Sort by time
    usort($activities, function($a, $b) {
        return strtotime($b['time']) - strtotime($a['time']);
    });

    return array_slice($activities, 0, 5);
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
    public function show(admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(admin $admin)
    {
        //
    }
}
