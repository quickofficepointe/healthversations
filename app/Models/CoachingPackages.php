<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoachingPackages extends Model
{
    protected $fillable = [
        'package_name',
        'duration',
        'price_usd',
        'price_kes',
        'bg_color',
        'button_text',
        'button_link',
        'is_active',
        'image',
        'sort_order'
    ];

    public function features(): HasMany
    {
        return $this->hasMany(Packagefeatures::class, 'coachingpackage_id');
    }

    // Method to format price based on currency
    public function formattedPrice($currency = 'usd'): string
    {
        if ($currency === 'kes') {
            return 'KSh ' . number_format($this->price_kes, 2);
        }

        return '$' . number_format($this->price_usd, 2);
    }
      public function enrollments()
    {
        return $this->hasMany(CoachingEnrollment::class);
    }
}
