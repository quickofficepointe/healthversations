<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Consultation;
use App\Models\EbookOrder;
use App\Models\Review;
use App\Models\CoachingEnrollment;
use App\Models\CartOrder;
use App\Models\UserMealPlan;
use App\Models\UserDailyHealthTracking;
use App\Models\UserDailyMealLog;
use App\Models\UserWeeklyAssessment;
use App\Models\UserWeeklyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Admin: View all users
    public function index()
    {
        $users = User::all();
        return view('healthversations.admin.users.index', compact('users'));
    }

    // Admin: Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|integer|in:0,1,2'
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role
        ]);

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    // Admin: Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    // ==================== USER DASHBOARD METHODS ====================

    // User Dashboard Home
    public function dashboard()
    {
        $user = Auth::user();
        $userEmail = $user->email;

        $totalOrders = CartOrder::where('customer_email', $userEmail)->count();
        $totalConsultations = Consultation::where('email', $userEmail)->count();
        $totalEbooks = EbookOrder::where('customer_email', $userEmail)->count();
        $totalReviews = Review::where('email', $userEmail)->count();

        $recentOrders = CartOrder::where('customer_email', $userEmail)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentConsultations = Consultation::where('email', $userEmail)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentEbooks = EbookOrder::where('customer_email', $userEmail)
            ->with('ebook')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('healthversations.user.index', compact(
            'totalOrders',
            'totalConsultations',
            'totalEbooks',
            'totalReviews',
            'recentOrders',
            'recentConsultations',
            'recentEbooks'
        ));
    }

    // My Orders
    public function myOrders()
    {
        $userEmail = Auth::user()->email;
        $orders = CartOrder::where('customer_email', $userEmail)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('healthversations.user.orders', compact('orders'));
    }

    // Order Details
    public function orderDetails($id)
    {
        $userEmail = Auth::user()->email;
        $order = CartOrder::where('customer_email', $userEmail)->findOrFail($id);
        if (is_string($order->items)) {
            $order->items = json_decode($order->items, true);
        }
        return view('healthversations.user.order-details', compact('order'));
    }

    // My Consultations
    public function myConsultations()
    {
        $userEmail = Auth::user()->email;
        $consultations = Consultation::where('email', $userEmail)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('healthversations.user.consultations', compact('consultations'));
    }

    // My Ebooks
    public function myEbooks()
    {
        $userEmail = Auth::user()->email;
        $ebooks = EbookOrder::where('customer_email', $userEmail)
            ->with('ebook')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return view('healthversations.user.ebooks', compact('ebooks'));
    }

    // Download Ebook
    public function downloadEbook($id)
    {
        $userEmail = Auth::user()->email;
        $ebookOrder = EbookOrder::where('customer_email', $userEmail)
            ->with('ebook')
            ->findOrFail($id);

        if ($ebookOrder->status !== 'completed') {
            return back()->with('error', 'Payment not completed for this ebook.');
        }

        $filePath = storage_path('app/public/' . $ebookOrder->ebook->file_path);
        if (!file_exists($filePath)) {
            return back()->with('error', 'Ebook file not found.');
        }

        return response()->download($filePath, $ebookOrder->ebook->title . '.pdf');
    }

    // My Coaching Enrollments
    public function myCoaching()
    {
        $userEmail = Auth::user()->email;
        $enrollments = CoachingEnrollment::where('customer_email', $userEmail)
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('healthversations.user.coaching', compact('enrollments'));
    }

    // My Reviews
    public function myReviews()
    {
        $userEmail = Auth::user()->email;
        $reviews = Review::where('email', $userEmail)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('healthversations.user.reviews', compact('reviews'));
    }

    // Profile Settings
    public function profileSettings()
    {
        $user = Auth::user();
        return view('healthversations.user.profile', compact('user'));
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($user->profile) {
            $user->profile->update([
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        } else {
            $user->profile()->create([
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    // Change Password Form
    public function changePasswordForm()
    {
        return view('healthversations.user.change-password');
    }

    // Update Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password changed successfully!');
    }

    // ==================== USER MEAL PLAN METHODS ====================

    /**
     * User Meal Plan Dashboard
     */
    public function mealPlanDashboard()
    {
        $user = Auth::user();

        $activePlan = UserMealPlan::where('user_id', $user->id)
            ->where('status', 'active')
            ->with('weeklyPlans')
            ->first();

        $completedPlans = UserMealPlan::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->get();

        $todayTracking = UserDailyHealthTracking::where('user_id', $user->id)
            ->where('tracking_date', today())
            ->first();

        return view('healthversations.user.meal-plan.dashboard', compact('activePlan', 'completedPlans', 'todayTracking'));
    }

    /**
     * Show current week's meal plan
     */
    public function mealPlanCurrentWeek()
    {
        $user = Auth::user();

        $activePlan = UserMealPlan::where('user_id', $user->id)
            ->where('status', 'active')
            ->firstOrFail();

        $currentWeekPlan = $activePlan->weeklyPlans()
            ->where('week_number', $activePlan->current_week)
            ->first();

        $weeklyAssessment = UserWeeklyAssessment::where('user_meal_plan_id', $activePlan->id)
            ->where('week_number', $activePlan->current_week)
            ->first();

        return view('healthversations.user.meal-plan.current-week', compact('activePlan', 'currentWeekPlan', 'weeklyAssessment'));
    }

    /**
     * Save daily health tracking (AJAX)
     */
    public function saveDailyTracking(Request $request)
    {
        $validated = $request->validate([
            'water_intake_liters' => 'nullable|numeric|min:0|max:20',
            'water_intake_glasses' => 'nullable|integer|min:0|max:30',
            'sleep_hours' => 'nullable|numeric|min:0|max:24',
            'walked_today' => 'boolean',
            'steps_count' => 'nullable|integer|min:0',
            'exercised_today' => 'boolean',
            'did_cardio' => 'boolean',
            'cardio_minutes' => 'nullable|integer|min:0',
            'lifted_weights' => 'boolean',
            'weightlifting_minutes' => 'nullable|integer|min:0',
            'exercise_notes' => 'nullable|string',
            'ate_breakfast' => 'boolean',
            'ate_lunch' => 'boolean',
            'ate_dinner' => 'boolean',
            'meal_notes' => 'nullable|string',
            'mood_rating' => 'nullable|integer|min:1|max:5',
            'energy_rating' => 'nullable|integer|min:1|max:5',
        ]);

        $user = Auth::user();
        $activePlan = UserMealPlan::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$activePlan) {
            return response()->json(['success' => false, 'message' => 'No active meal plan'], 400);
        }

        $tracking = UserDailyHealthTracking::updateOrCreate(
            [
                'user_id' => $user->id,
                'tracking_date' => today()
            ],
            array_merge($validated, ['user_meal_plan_id' => $activePlan->id])
        );

        return response()->json([
            'success' => true,
            'message' => 'Tracking saved successfully',
            'daily_score' => $tracking->daily_score ?? 0
        ]);
    }

    /**
     * Save meal log with photo (AJAX)
     */
    public function saveMealLog(Request $request)
    {
        $validated = $request->validate([
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            'food_items' => 'nullable|string',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:5120',
        ]);

        $user = Auth::user();
        $activePlan = UserMealPlan::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$activePlan) {
            return response()->json(['success' => false, 'message' => 'No active meal plan'], 400);
        }

        $currentWeekPlan = $activePlan->weeklyPlans()
            ->where('week_number', $activePlan->current_week)
            ->first();

        $data = [
            'user_id' => $user->id,
            'user_meal_plan_id' => $activePlan->id,
            'user_weekly_plan_id' => $currentWeekPlan->id,
            'log_date' => today(),
            'meal_type' => $validated['meal_type'],
            'food_items' => $validated['food_items'] ?? null,
            'description' => $validated['description'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('meal-logs/user-' . $user->id, 'public');
            $data['photo_path'] = $path;
        }

        $mealLog = UserDailyMealLog::updateOrCreate(
            [
                'user_id' => $user->id,
                'log_date' => today(),
                'meal_type' => $validated['meal_type']
            ],
            $data
        );

        // Update meal compliance
        $tracking = UserDailyHealthTracking::firstOrCreate(
            ['user_id' => $user->id, 'tracking_date' => today()],
            ['user_meal_plan_id' => $activePlan->id]
        );

        if ($validated['meal_type'] == 'breakfast') $tracking->ate_breakfast = true;
        if ($validated['meal_type'] == 'lunch') $tracking->ate_lunch = true;
        if ($validated['meal_type'] == 'dinner') $tracking->ate_dinner = true;
        $tracking->save();

        return response()->json([
            'success' => true,
            'message' => 'Meal logged successfully'
        ]);
    }

    /**
     * Submit weekly assessment
     */
    public function submitWeeklyAssessment(Request $request)
    {
        $validated = $request->validate([
            'weight_kg' => 'nullable|numeric|min:20|max:300',
            'body_fat_percentage' => 'nullable|numeric|min:5|max:60',
            'chest_cm' => 'nullable|numeric',
            'waist_cm' => 'nullable|numeric',
            'hips_cm' => 'nullable|numeric',
            'what_went_well' => 'nullable|string',
            'challenges_faced' => 'nullable|string',
            'next_week_goals' => 'nullable|string',
            'front_photo' => 'nullable|image|max:10240',
            'side_photo' => 'nullable|image|max:10240',
            'back_photo' => 'nullable|image|max:10240',
        ]);

        $user = Auth::user();
        $activePlan = UserMealPlan::where('user_id', $user->id)
            ->where('status', 'active')
            ->firstOrFail();

        $currentWeekPlan = $activePlan->weeklyPlans()
            ->where('week_number', $activePlan->current_week)
            ->firstOrFail();

        $data = [
            'user_id' => $user->id,
            'user_meal_plan_id' => $activePlan->id,
            'user_weekly_plan_id' => $currentWeekPlan->id,
            'week_number' => $activePlan->current_week,
            'weight_kg' => $validated['weight_kg'] ?? null,
            'body_fat_percentage' => $validated['body_fat_percentage'] ?? null,
            'chest_cm' => $validated['chest_cm'] ?? null,
            'waist_cm' => $validated['waist_cm'] ?? null,
            'hips_cm' => $validated['hips_cm'] ?? null,
            'what_went_well' => $validated['what_went_well'] ?? null,
            'challenges_faced' => $validated['challenges_faced'] ?? null,
            'next_week_goals' => $validated['next_week_goals'] ?? null,
            'is_completed' => true
        ];

        if ($request->hasFile('front_photo')) {
            $path = $request->file('front_photo')->store('assessments/user-' . $user->id, 'public');
            $data['front_photo'] = $path;
        }
        if ($request->hasFile('side_photo')) {
            $path = $request->file('side_photo')->store('assessments/user-' . $user->id, 'public');
            $data['side_photo'] = $path;
        }
        if ($request->hasFile('back_photo')) {
            $path = $request->file('back_photo')->store('assessments/user-' . $user->id, 'public');
            $data['back_photo'] = $path;
        }

        UserWeeklyAssessment::updateOrCreate(
            ['user_meal_plan_id' => $activePlan->id, 'week_number' => $activePlan->current_week],
            $data
        );

        return redirect()->route('user.meal-plan.dashboard')
            ->with('success', 'Weekly assessment submitted successfully!');
    }

    /**
     * Weekly summary with charts
     */
    public function mealPlanWeeklySummary()
    {
        $user = Auth::user();
        $activePlan = UserMealPlan::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$activePlan) {
            return view('healthversations.user.meal-plan.weekly-summary', ['hasActivePlan' => false]);
        }

        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        $dailyTracking = UserDailyHealthTracking::where('user_id', $user->id)
            ->whereBetween('tracking_date', [$weekStart, $weekEnd])
            ->orderBy('tracking_date')
            ->get();

        $weeklyAssessment = UserWeeklyAssessment::where('user_meal_plan_id', $activePlan->id)
            ->where('week_number', $activePlan->current_week)
            ->first();

        $chartData = [];
        for ($date = clone $weekStart; $date <= $weekEnd; $date->modify('+1 day')) {
            $tracking = $dailyTracking->firstWhere('tracking_date', $date->format('Y-m-d'));
            $chartData[] = [
                'date' => $date->format('D'),
                'water' => $tracking ? $tracking->water_intake_liters : 0,
                'steps' => $tracking ? $tracking->steps_count : 0,
                'sleep' => $tracking ? $tracking->sleep_hours : 0,
            ];
        }

        return view('healthversations.user.meal-plan.weekly-summary', compact('activePlan', 'dailyTracking', 'weeklyAssessment', 'chartData'));
    }
}
