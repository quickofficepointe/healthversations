<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookOrder extends Model
{
    use HasFactory;

    protected $table = 'ebook_orders';

    protected $fillable = [
        'order_id',
        'ebook_id',
        'amount',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'iveri_reference'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }
}