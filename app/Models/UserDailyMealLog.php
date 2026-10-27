<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDailyMealLog extends Model
{
    use HasFactory;

    public const MEAL_TYPES = ['breakfast', 'lunch', 'dinner', 'snack'];

    protected $fillable = [
        'user_id',
        'user_meal_plan_id',
        'user_weekly_plan_id',
        'log_date',
        'meal_type',
        'food_items',
        'description',
        'notes',
        'photo_path',
    ];

    protected $casts = [
        'log_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mealPlan()
    {
        return $this->belongsTo(UserMealPlan::class, 'user_meal_plan_id');
    }
}
