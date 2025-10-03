<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value'];

    public function attribute()
    {
        return $this->belongsTo(VariationAttribute::class, 'attribute_id');
    }

    public function variations()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variation_attribute_values');
    }
}
