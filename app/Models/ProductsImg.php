<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsImg extends Model
{
    protected $table = 'productsimgs'; // Explicitly set table name

    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text' // Make sure this matches your migration
    ];

    public function product()
    {
        return $this->belongsTo(product::class);
    }
}