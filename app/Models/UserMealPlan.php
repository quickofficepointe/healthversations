<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMealPlan extends Model
{
    use HasFactory;

    public const STATUSES = ['active', 'paused', 'completed', 'cancelled'];

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'goal',
        'total_weeks',
        'current_week',
        'start_date',
        'end_date',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function weeklyPlans()
    {
        return $this->hasMany(UserWeeklyPlan::class)->orderBy('week_number');
    }

    public function dailyTrackings()
    {
        return $this->hasMany(UserDailyHealthTracking::class);
    }

    public function mealLogs()
    {
        return $this->hasMany(UserDailyMealLog::class);
    }

    public function assessments()
    {
        return $this->hasMany(UserWeeklyAssessment::class)->orderBy('week_number');
    }

    public function progressPercent(): int
    {
        if ($this->total_weeks < 1) {
            return 0;
        }

        $done = $this->weeklyPlans->where('is_completed', true)->count();

        return (int) round(($done / $this->total_weeks) * 100);
    }
}
