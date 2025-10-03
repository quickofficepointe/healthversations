<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'category_id',
        'package_name',
        'slug',
        'package_description',
        'package_tags',
        'package_image',
    ];

    /**
     * Get the category that owns the package.
     */
    public function category()
    {
        return $this->belongsTo(PackageCategory::class, 'category_id');
    }
}
