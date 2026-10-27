<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWeeklyAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_meal_plan_id',
        'user_weekly_plan_id',
        'week_number',
        'weight_kg',
        'body_fat_percentage',
        'chest_cm',
        'waist_cm',
        'hips_cm',
        'what_went_well',
        'challenges_faced',
        'next_week_goals',
        'front_photo',
        'side_photo',
        'back_photo',
        'is_completed',
        'admin_feedback',
        'feedback_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'feedback_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mealPlan()
    {
        return $this->belongsTo(UserMealPlan::class, 'user_meal_plan_id');
    }

    public function weeklyPlan()
    {
        return $this->belongsTo(UserWeeklyPlan::class, 'user_weekly_plan_id');
    }
}
