<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $fillable = [
        'user_id',
        'country',
        'city',
        'phone_number',
        'description',
        'profile_picture',
        'health_goals',
    ];


    public function user()
{
    return $this->belongsTo(User::class);
}

}
