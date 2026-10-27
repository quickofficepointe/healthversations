<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWeeklyPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_meal_plan_id',
        'week_number',
        'title',
        'goals',
        'content',
        'attachment_path',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function mealPlan()
    {
        return $this->belongsTo(UserMealPlan::class, 'user_meal_plan_id');
    }

    public function hasContent(): bool
    {
        return !empty($this->content) || !empty($this->attachment_path);
    }
}
