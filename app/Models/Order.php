<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'name',
        'email',
        'phone',
        'order_type',
        'quantity',
        'total_price',
        'payment_code',
        'pickup_date',
        'pickup_time',
        'county',
        'subcounty',
        'location',
        'address',
        'latitude',
        'longitude',
        'variant_id',
        'tracking_id',
        'status',
        'payment_status'
    ];

    public function product()
{
    return $this->belongsTo(Product::class);
}

public function variant()
{
    return $this->belongsTo(ProductVariant::class);
}
}