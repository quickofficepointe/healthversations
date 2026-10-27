<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonialMeasurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'testimonial_id',
        'measurement_type',
        'before_value',
        'after_value',
        'unit',
    ];

    protected $casts = [
        'before_value' => 'decimal:2',
        'after_value' => 'decimal:2',
    ];

    /**
     * Relationship with testimonial
     */
    public function testimonial()
    {
        return $this->belongsTo(ConsultTestimonial::class, 'testimonial_id');
    }

    /**
     * Get the difference between after and before values
     */
    public function getDifferenceAttribute()
    {
        return $this->after_value - $this->before_value;
    }

    /**
     * Get the percentage change
     */
    public function getPercentageChangeAttribute()
    {
        if ($this->before_value == 0) return 0;

        return (($this->after_value - $this->before_value) / $this->before_value) * 100;
    }

    /**
     * Check if measurement improved (for weight loss, lower is better)
     */
    public function getIsImprovedAttribute()
    {
        // For most measurements, lower is better (weight, waist, etc.)
        // You might want to customize this based on measurement type
        return $this->after_value < $this->before_value;
    }
}
