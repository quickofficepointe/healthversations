<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'slug',
        'description',
        'tags',
        'cover_image',
        'meta_keywords',
        'category_id',
        'has_variations',
        'measurement_unit',
        'price_kes',
        'price_usd',
        'stock',
        'discount_percent',
        'has_discount'
    ];

    protected $casts = [
        'discount_percent' => 'decimal:2',
        'has_discount' => 'boolean',
    ];

    // Default discount percentage (20%)
    const DEFAULT_DISCOUNT_PERCENT = 20;

    public function category()
    {
        return $this->belongsTo(productcategory::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(productsimg::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function scopeHasVariants($query)
    {
        return $query->where('has_variations', true);
    }

    public function reviews()
    {
        return $this->morphMany(review::class, 'reviewable');
    }

    /**
     * Get the effective discount percentage
     * Returns the stored discount_percent if has_discount is true,
     * otherwise returns the default 20% discount
     */
    public function getEffectiveDiscountPercentAttribute()
    {
        // If product has specific discount set, use that
        if ($this->has_discount && $this->discount_percent > 0) {
            return $this->discount_percent;
        }
        // Default 20% discount for all products
        return self::DEFAULT_DISCOUNT_PERCENT;
    }

    /**
     * Check if product has any discount (either specific or default)
     */
    public function getHasAnyDiscountAttribute()
    {
        return true; // Always true since we have default 20% discount
    }

    /**
     * Get the discounted price in KES (applies default 20% if no specific discount)
     */
    public function getDiscountedPriceKesAttribute()
    {
        $discountPercent = $this->effective_discount_percent;
        return $this->price_kes * (1 - $discountPercent / 100);
    }

    /**
     * Get the discounted price in USD (applies default 20% if no specific discount)
     */
    public function getDiscountedPriceUsdAttribute()
    {
        $discountPercent = $this->effective_discount_percent;
        return $this->price_usd * (1 - $discountPercent / 100);
    }

    /**
     * Get the original price (for strikethrough display)
     */
    public function getOriginalPriceKesAttribute()
    {
        // Always return original price for strikethrough
        return $this->price_kes;
    }

    /**
     * Get the original price in USD (for strikethrough display)
     */
    public function getOriginalPriceUsdAttribute()
    {
        return $this->price_usd;
    }

    /**
     * Get the savings amount in KES
     */
    public function getSavingsKesAttribute()
    {
        $discountPercent = $this->effective_discount_percent;
        return $this->price_kes * ($discountPercent / 100);
    }

    /**
     * Get the savings amount in USD
     */
    public function getSavingsUsdAttribute()
    {
        $discountPercent = $this->effective_discount_percent;
        return $this->price_usd * ($discountPercent / 100);
    }

    /**
     * Get the discount percentage for display
     */
    public function getDisplayDiscountPercentAttribute()
    {
        return round($this->effective_discount_percent);
    }
}
