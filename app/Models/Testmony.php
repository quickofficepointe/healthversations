<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class testmony extends Model
{
    //
    protected $fillable = [
        'full_name',
        'email',
        'message',
        'rating',
        'is_enabled',
    ];

}