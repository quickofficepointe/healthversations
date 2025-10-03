<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eorder extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'customer_name', 'customer_email',
        'customer_phone', 'shipping_address', 'type', 'status',
        'amount', 'payment_method', 'transaction_reference'
    ];

    public function ebooks()
    {
        return $this->belongsToMany(Ebook::class)
            ->withPivot('quantity', 'price');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}