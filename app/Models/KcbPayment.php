<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KcbPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'checkout_request_id',
        'merchant_request_id',
        'phone_number',
        'amount',
        'payment_type',
        'reference_id',
        'reference_type',
        'status',
        'result_code',
        'result_description',
        'mpesa_receipt_number',
        'transaction_date',
        'org_short_code',
        'callback_payload'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'datetime',
        'callback_payload' => 'array'
    ];

    /**
     * Get the related model (Order, Consultation, etc)
     */
    public function reference()
    {
        return $this->morphTo();
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for completed payments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for failed payments
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Get payment type label
     */
    public function getPaymentTypeLabelAttribute()
    {
        return match($this->payment_type) {
            'product' => 'Product Purchase',
            'consultation' => 'Consultation',
            'ebook' => 'Ebook Purchase',
            'custom_package' => 'Custom Package',
            default => ucfirst($this->payment_type)
        };
    }

    /**
     * Check if payment is successful
     */
    public function getIsSuccessfulAttribute()
    {
        return $this->status === 'completed';
    }

    /**
     * Format amount with currency
     */
    public function getFormattedAmountAttribute()
    {
        return 'KSh ' . number_format($this->amount, 2);
    }
}
