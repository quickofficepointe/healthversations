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
        'stock'
    ];

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

}
