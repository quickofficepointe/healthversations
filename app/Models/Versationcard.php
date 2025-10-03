<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Versationcard extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'tags',
        'cover_image',
        'slug',
    ];
}
