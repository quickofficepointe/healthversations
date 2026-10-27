<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDailyHealthTracking;
use App\Models\UserDailyMealLog;
use App\Models\UserMealPlan;
use App\Models\UserWeeklyAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserMealPlanController extends Controller
{
    public function index(Request $request)
    {
        $query = UserMealPlan::with(['user', 'weeklyPlans'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $plans = $query->paginate(15)->withQueryString();

        return view('healthversations.admin.mealplans.index', compact('plans'));
    }

    public function create()
    {
        $users = User::where('role', 2)->orderBy('name')->get(['id', 'name', 'email']);
        $plan = new UserMealPlan(['total_weeks' => 4, 'status' => 'active', 'start_date' => today()]);

        return view('healthversations.admin.mealplans.form', compact('users', 'plan'));
    }

    public function store(Request $request)
    {
        $validated = $this->validatePlan($request);

        $hasActive = UserMealPlan::where('user_id', $validated['user_id'])->where('status', 'active')->exists();
        if ($hasActive && $validated['status'] === 'active') {
            return back()->withInput()->withErrors(['user_id' => 'This user already has an active meal plan. Complete or pause it first.']);
        }

        $plan = DB::transaction(function () use ($validated) {
            $plan = UserMealPlan::create(array_merge($validated, ['current_week' => 1]));
            $this->syncWeeks($plan);

            return $plan;
        });

        $this->notifyUser($plan, "A new meal plan \"{$plan->title}\" has been created for you.");

        return redirect()->route('admin.meal-plans.show', $plan)->with('success', 'Meal plan created. Add the content for each week below.');
    }

    public function show(UserMealPlan $userMealPlan)
    {
        $userMealPlan->load(['user', 'weeklyPlans', 'assessments']);

        $recentTracking = UserDailyHealthTracking::where('user_meal_plan_id', $userMealPlan->id)
            ->orderByDesc('tracking_date')
            ->take(7)
            ->get();

        return view('healthversations.admin.mealplans.show', ['plan' => $userMealPlan, 'recentTracking' => $recentTracking]);
    }

    public function edit(UserMealPlan $userMealPlan)
    {
        $users = User::where('role', 2)->orderBy('name')->get(['id', 'name', 'email']);

        return view('healthversations.admin.mealplans.form', ['users' => $users, 'plan' => $userMealPlan]);
    }

    public function update(Request $request, UserMealPlan $userMealPlan)
    {
        $validated = $this->validatePlan($request, $userMealPlan);

        if (empty($validated['current_week'])) {
            unset($validated['current_week']);
        } else {
            $validated['current_week'] = min($validated['current_week'], $validated['total_weeks']);
        }

        DB::transaction(function () use ($userMealPlan, $validated) {
            $userMealPlan->update($validated);
            $this->syncWeeks($userMealPlan);
        });

        return redirect()->route('admin.meal-plans.show', $userMealPlan)->with('success', 'Meal plan updated.');
    }

    public function destroy(UserMealPlan $userMealPlan)
    {
        foreach ($userMealPlan->weeklyPlans as $week) {
            if ($week->attachment_path) {
                Storage::disk('public')->delete($week->attachment_path);
            }
        }

        $userMealPlan->delete();

        return redirect()->route('admin.meal-plans.index')->with('success', 'Meal plan deleted.');
    }

    /**
     * Save the meal plan content (text and/or file) for one week.
     */
    public function uploadWeeklyContent(Request $request, UserMealPlan $userMealPlan, $weekNumber)
    {
        $week = $userMealPlan->weeklyPlans()->where('week_number', $weekNumber)->firstOrFail();

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'goals' => 'nullable|string',
            'content' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'remove_attachment' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'] ?? null,
            'goals' => $validated['goals'] ?? null,
            'content' => $validated['content'] ?? null,
        ];

        if ($request->hasFile('attachment') || $request->boolean('remove_attachment')) {
            if ($week->attachment_path) {
                Storage::disk('public')->delete($week->attachment_path);
            }
            $data['attachment_path'] = $request->hasFile('attachment')
                ? $request->file('attachment')->store('meal-plans/plan-' . $userMealPlan->id, 'public')
                : null;
        }

        $week->update($data);

        if ($week->wasChanged(['content', 'attachment_path']) && (int) $weekNumber === (int) $userMealPlan->current_week) {
            $this->notifyUser($userMealPlan, "Your meal plan for week {$weekNumber} is ready.");
        }

        return back()->with('success', "Week {$weekNumber} content saved.");
    }

    /**
     * Mark a week as completed and move the plan on to the next week.
     */
    public function completeWeek(UserMealPlan $userMealPlan, $weekNumber)
    {
        $week = $userMealPlan->weeklyPlans()->where('week_number', $weekNumber)->firstOrFail();
        $week->update(['is_completed' => true, 'completed_at' => now()]);

        if ((int) $weekNumber >= $userMealPlan->total_weeks) {
            $userMealPlan->update(['status' => 'completed', 'end_date' => $userMealPlan->end_date ?? today()]);
            $message = 'Final week completed. The meal plan is now marked as completed.';
        } else {
            $userMealPlan->update(['current_week' => max($userMealPlan->current_week, (int) $weekNumber + 1)]);
            $message = "Week {$weekNumber} completed. The user is now on week {$userMealPlan->current_week}.";
        }

        return back()->with('success', $message);
    }

    public function viewTracking(Request $request, UserMealPlan $userMealPlan)
    {
        $userMealPlan->load('user');

        $tracking = UserDailyHealthTracking::where('user_meal_plan_id', $userMealPlan->id)
            ->orderByDesc('tracking_date')
            ->paginate(31);

        $mealLogs = UserDailyMealLog::where('user_meal_plan_id', $userMealPlan->id)
            ->whereIn('log_date', $tracking->pluck('tracking_date')->map->toDateString())
            ->get()
            ->groupBy(fn ($log) => $log->log_date->toDateString());

        return view('healthversations.admin.mealplans.tracking', [
            'plan' => $userMealPlan,
            'tracking' => $tracking,
            'mealLogs' => $mealLogs,
        ]);
    }

    public function viewAssessments(UserMealPlan $userMealPlan)
    {
        $userMealPlan->load(['user', 'assessments']);

        return view('healthversations.admin.mealplans.assessments', ['plan' => $userMealPlan]);
    }

    public function addAssessmentFeedback(Request $request, UserMealPlan $userMealPlan, $weekNumber)
    {
        $validated = $request->validate([
            'admin_feedback' => 'required|string|max:5000',
        ]);

        $assessment = UserWeeklyAssessment::where('user_meal_plan_id', $userMealPlan->id)
            ->where('week_number', $weekNumber)
            ->firstOrFail();

        $assessment->update([
            'admin_feedback' => $validated['admin_feedback'],
            'feedback_at' => now(),
        ]);

        $this->notifyUser($userMealPlan, "Your coach left feedback on your week {$weekNumber} assessment.");

        return back()->with('success', "Feedback for week {$weekNumber} saved.");
    }

    public function updateStatus(Request $request, UserMealPlan $userMealPlan)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(UserMealPlan::STATUSES)],
        ]);

        if ($validated['status'] === 'active') {
            $otherActive = UserMealPlan::where('user_id', $userMealPlan->user_id)
                ->where('status', 'active')
                ->where('id', '!=', $userMealPlan->id)
                ->exists();
            if ($otherActive) {
                return back()->with('error', 'This user already has another active meal plan.');
            }
        }

        $userMealPlan->update($validated);

        return back()->with('success', 'Meal plan status updated.');
    }

    protected function validatePlan(Request $request, ?UserMealPlan $plan = null): array
    {
        return $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal' => 'nullable|string|max:255',
            'total_weeks' => 'required|integer|min:1|max:52',
            'current_week' => $plan ? 'nullable|integer|min:1|max:52' : 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => ['required', Rule::in(UserMealPlan::STATUSES)],
            'admin_notes' => 'nullable|string',
        ]);
    }

    /**
     * Make sure there is exactly one weekly plan row per week.
     */
    protected function syncWeeks(UserMealPlan $plan): void
    {
        for ($week = 1; $week <= $plan->total_weeks; $week++) {
            $plan->weeklyPlans()->firstOrCreate(['week_number' => $week]);
        }

        // Drop empty weeks beyond a reduced total; keep any week that already has content
        $plan->weeklyPlans()
            ->where('week_number', '>', $plan->total_weeks)
            ->whereNull('content')
            ->whereNull('attachment_path')
            ->delete();
    }

    protected function notifyUser(UserMealPlan $plan, string $message): void
    {
        $user = $plan->user ?? User::find($plan->user_id);
        if (!$user) {
            return;
        }

        try {
            Mail::raw("Hi {$user->name},\n\n{$message}\n\nLog in to your dashboard to view it: " . route('user.meal-plan.dashboard') . "\n\nHealthversation",
                function ($mail) use ($user, $plan) {
                    $mail->to($user->email)->subject("Meal Plan Update: {$plan->title}");
                });
        } catch (\Exception $e) {
            Log::error("Meal plan email failed for user {$user->id}: " . $e->getMessage());
        }
    }
}
