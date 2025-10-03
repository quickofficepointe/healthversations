<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualOrder extends Model
{
    protected $fillable = [
        'tracking_id',
        'product_id',
        'quantity',
        'total_price',
        'payment_code',
        'name',
        'email',
        'phone',
        'order_type', // 'pickup' or 'delivery'
        'pickup_date',
        'pickup_time',
        'county',
        'subcounty',
        'location',
        'address',
        'latitude',
        'longitude',
        'status', // 'pending', 'processing', 'completed', 'cancelled'
    ];

    /**
     * Relationship with Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
