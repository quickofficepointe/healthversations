<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomPackage extends Model
{
    //
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'service',
        'message',
        'package_details',
        'status',
    ];

}
