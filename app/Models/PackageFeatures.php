<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageFeatures extends Model
{
    protected $fillable = ['coachingpackage_id', 'feature', 'sort_order'];

    public function package(): BelongsTo
    {
        return $this->belongsTo(CoachingPackages::class, 'coachingpackage_id');
    }
}
