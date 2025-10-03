<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'items',
        'customer_name',
        'customer_email',
        'customer_phone',
        'county',
        'subcounty',
        'location',
        'address',
        'status',
        'iveri_reference',
        'delivery_method',
        'delivery_zone',
        'delivery_cost'
    ];

    protected $casts = [
        'items' => 'array',
        'amount' => 'decimal:2',
        'delivery_cost' => 'decimal:2'
    ];
}
