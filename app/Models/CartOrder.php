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
        'delivery_cost',
        'payment_method',
        'payment_status',
        'kcb_payment_reference',
        'kcb_invoice_number',
        'etims_requested',
        'etims_kra_pin',
        'etims_business_name',
        'etims_invoice_number',
        'etims_invoice_path',
        'etims_invoice_sent_at',
    ];

    protected $casts = [
        'items' => 'array',
        'amount' => 'decimal:2',
        'delivery_cost' => 'decimal:2',
        'etims_requested' => 'boolean',
        'etims_invoice_sent_at' => 'datetime',
    ];

    /**
     * Delivery zone rates in KES. Must match the zones shown at checkout.
     */
    public const DELIVERY_ZONE_RATES = [
        'A' => 150, 'J' => 450, 'D' => 450, 'F' => 450,
        'K' => 400, 'N' => 450, 'G' => 450, 'M' => 450,
        'H' => 600, 'O' => 650, 'P' => 800, 'R' => 900, 'Q' => 1350,
    ];

    public const STATUSES = ['pending', 'confirmed', 'processing', 'completed', 'failed', 'cancelled'];

    /**
     * eTIMS requested but no invoice attached yet.
     */
    public function scopeEtimsPending($query)
    {
        return $query->where('etims_requested', true)->whereNull('etims_invoice_path');
    }

    public function hasEtimsInvoice(): bool
    {
        return $this->etims_requested && !empty($this->etims_invoice_path);
    }
}
