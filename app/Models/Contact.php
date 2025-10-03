<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    // Fillable attributes to allow mass assignment
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'message',
    ];
}
