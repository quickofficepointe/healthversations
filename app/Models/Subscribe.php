<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subscribe extends Model
{
    //
    protected $fillable = [
        'email',
        'status',
    ];
}