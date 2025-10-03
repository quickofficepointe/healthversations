<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{

 protected $table = 'productcategories'; // Explicitly set the table name
    protected $fillable = [
        'category_name',
        'category_description',
        'category_tag',
        'image',
        'slug',
    ];

     // Relationship to products
     public function products()
     {
         return $this->hasMany(product::class, 'category_id');
     }

     // Accessors for consistent attribute naming
     public function getNameAttribute()
     {
         return $this->category_name;
     }

     public function getDescriptionAttribute()
     {
         return $this->category_description;
     }
}
