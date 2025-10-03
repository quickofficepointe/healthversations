<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'package_id',
        'amount',
        'customer_name',
        'customer_email',
        'customer_phone',
        'country',
        'status',
        'iveri_reference'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    public function package()
    {
        return $this->belongsTo(package::class);
    }
}