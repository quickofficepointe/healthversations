<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageCategory extends Model
{
    protected $fillable = [
        'category_name',
        'slug',
        'category_description',
        'category_image',
        'category_tags',
    ];//

}
