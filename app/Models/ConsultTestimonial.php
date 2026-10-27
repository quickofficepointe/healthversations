<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ConsultTestimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'consult_testmonials';

    protected $fillable = [
        'client_name',
        'slug', // Add slug to fillable
        'client_location',
        'client_age',
        'client_occupation',
        'program_type',
        'program_duration_weeks',
        'weight_loss_kg',
        'weight_gain_kg',
        'inches_lost',
        'measurements',
        'before_image',
        'after_image',
        'images_approved',
        'testimonial_text',
        'challenges_overcome',
        'key_achievements',
        'rating',
        'rating_breakdown',
        'social_media_handle',
        'featured',
        'sort_order',
        'is_verified',
        'is_public',
        'verification_token',
    ];

    protected $casts = [
        'measurements' => 'array',
        'rating_breakdown' => 'array',
        'images_approved' => 'boolean',
        'featured' => 'boolean',
        'is_verified' => 'boolean',
        'is_public' => 'boolean',
        'client_age' => 'integer',
        'program_duration_weeks' => 'integer',
        'rating' => 'integer',
        'sort_order' => 'integer',
        'weight_loss_kg' => 'decimal:2',
        'weight_gain_kg' => 'decimal:2',
        'inches_lost' => 'decimal:2',
    ];

    /**
     * Boot function for automatic slug generation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($testimonial) {
            $testimonial->slug = $testimonial->generateUniqueSlug();
        });

        static::updating(function ($testimonial) {
            // Regenerate slug if client name changed
            if ($testimonial->isDirty('client_name')) {
                $testimonial->slug = $testimonial->generateUniqueSlug();
            }
        });
    }

    /**
     * Generate unique slug from client name
     */
    public function generateUniqueSlug()
    {
        $slug = Str::slug($this->client_name);
        $originalSlug = $slug;
        $count = 1;

        // Check if slug already exists
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Get the route key for the model (for route model binding)
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relationship with measurements
     */
    public function measurements()
    {
        return $this->hasMany(TestimonialMeasurement::class, 'testimonial_id');
    }

    /**
     * Scope for public testimonials
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for verified testimonials
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope for featured testimonials
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope for approved images
     */
    public function scopeImagesApproved($query)
    {
        return $query->where('images_approved', true);
    }

    /**
     * Scope for specific program type
     */
    public function scopeProgramType($query, $type)
    {
        return $query->where('program_type', $type);
    }

    /**
     * Scope for testimonials with minimum rating
     */
    public function scopeMinRating($query, $rating)
    {
        return $query->where('rating', '>=', $rating);
    }

    /**
     * Get total weight change (positive for gain, negative for loss)
     */
    public function getTotalWeightChangeAttribute()
    {
        if ($this->weight_loss_kg) {
            return -$this->weight_loss_kg;
        }

        if ($this->weight_gain_kg) {
            return $this->weight_gain_kg;
        }

        return 0;
    }

    /**
     * Get display name with location
     */
    public function getClientDisplayNameAttribute()
    {
        if ($this->client_location) {
            return $this->client_name . ' from ' . $this->client_location;
        }

        return $this->client_name;
    }

    /**
     * Get program duration in months
     */
    public function getProgramDurationMonthsAttribute()
    {
        if ($this->program_duration_weeks) {
            return round($this->program_duration_weeks / 4, 1);
        }

        return null;
    }

    /**
     * Check if testimonial is eligible for display
     */
    public function getIsEligibleForDisplayAttribute()
    {
        return $this->is_public
            && $this->is_verified
            && $this->images_approved;
    }

    /**
     * Get URL for individual testimonial page
     */
    public function getUrlAttribute()
    {
        return route('testimonials.show', $this->slug);
    }
}
