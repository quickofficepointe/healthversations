<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDailyHealthTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_meal_plan_id',
        'tracking_date',
        'water_intake_liters',
        'water_intake_glasses',
        'sleep_hours',
        'walked_today',
        'steps_count',
        'exercised_today',
        'did_cardio',
        'cardio_minutes',
        'lifted_weights',
        'weightlifting_minutes',
        'exercise_notes',
        'ate_breakfast',
        'ate_lunch',
        'ate_dinner',
        'meal_notes',
        'mood_rating',
        'energy_rating',
    ];

    protected $casts = [
        'tracking_date' => 'date',
        'walked_today' => 'boolean',
        'exercised_today' => 'boolean',
        'did_cardio' => 'boolean',
        'lifted_weights' => 'boolean',
        'ate_breakfast' => 'boolean',
        'ate_lunch' => 'boolean',
        'ate_dinner' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function (self $tracking) {
            $tracking->daily_score = $tracking->calculateScore();
        });
    }

    /**
     * Score out of 100: water 20, sleep 20, movement 15, exercise 15, meals 10 each.
     */
    public function calculateScore(): int
    {
        $score = 0;

        if ($this->water_intake_liters >= 2 || $this->water_intake_glasses >= 8) {
            $score += 20;
        }
        if ($this->sleep_hours >= 7) {
            $score += 20;
        }
        if ($this->walked_today || $this->steps_count >= 8000) {
            $score += 15;
        }
        if ($this->exercised_today || $this->did_cardio || $this->lifted_weights) {
            $score += 15;
        }
        foreach (['ate_breakfast', 'ate_lunch', 'ate_dinner'] as $meal) {
            if ($this->$meal) {
                $score += 10;
            }
        }

        return $score;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mealPlan()
    {
        return $this->belongsTo(UserMealPlan::class, 'user_meal_plan_id');
    }
}
