<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testmony extends Model
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
