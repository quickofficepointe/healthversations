<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    //
    protected $fillable = [
        'name',
        'email',
        'reviewable_id',
        'reviewable_type',
        'review',
        'star',
        'approved',
    ];

    /**
     * Get the parent reviewable entity (e.g., Product or Service).
     */
    public function reviewable()
    {
        return $this->morphTo();
    }
}