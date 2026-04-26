<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'type',
        'consultation_date',
        'consultation_time',
        'location',
        'timezone',
        'health_concerns',
        'notes',
        'fee',
        'usd_equivalent',
        'status',
        'payment_status',
        'payment_reference',
        'payment_method'
    ];

    // Consultation Types
    const TYPE_INITIAL = 'initial';
    const TYPE_FOLLOWUP = 'followup';
    const TYPE_NUTRITION_REVIEW = 'nutrition_review';
    const TYPE_SPECIALIZED = 'specialized';

    // Status Constants
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Payment Status Constants
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_UNPAID = 'unpaid';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_FAILED = 'failed';
    const PAYMENT_REFUNDED = 'refunded';
    const PAYMENT_PROCESSING = 'processing';

    // All valid payment statuses
    const PAYMENT_STATUSES = [
        self::PAYMENT_PENDING,
        self::PAYMENT_UNPAID, 
        self::PAYMENT_PAID,
        self::PAYMENT_FAILED,
        self::PAYMENT_REFUNDED,
        self::PAYMENT_PROCESSING
    ];

    // Location Constants
    const LOCATION_KENYA = 'kenya';
    const LOCATION_INTERNATIONAL = 'international';

    // Fee Structure - Flat rates for all types2500
    const FEE_KENYA = 3000; // KSH
    const FEE_INTERNATIONAL = 31; // USD

    // Add validation mutator
    public function setPaymentStatusAttribute($value)
    {
        if (!in_array($value, self::PAYMENT_STATUSES)) {
            throw new \InvalidArgumentException("Invalid payment status: {$value}");
        }
        $this->attributes['payment_status'] = $value;
    }

    public static function getTypes()
    {
        return [
            self::TYPE_INITIAL => 'Initial Consultation',
            self::TYPE_FOLLOWUP => 'Follow-up Session',
            self::TYPE_NUTRITION_REVIEW => 'Nutrition Plan Review',
            self::TYPE_SPECIALIZED => 'Specialized Consultation',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateFee()
    {
        if ($this->location === self::LOCATION_KENYA) {
            $this->fee = self::FEE_KENYA;
            $this->usd_equivalent = null;
        } else {
            $this->fee = self::FEE_INTERNATIONAL * 150; // Convert to KSH for storage
            $this->usd_equivalent = self::FEE_INTERNATIONAL;
        }
    }

    public function getDisplayAmountAttribute()
    {
        if ($this->location === self::LOCATION_KENYA) {
            return [
                'amount' => self::FEE_KENYA,
                'currency' => 'KES',
                'formatted' => 'Ksh ' . number_format(self::FEE_KENYA)
            ];
        } else {
            return [
                'amount' => self::FEE_INTERNATIONAL,
                'currency' => 'USD',
                'formatted' => '$' . number_format(self::FEE_INTERNATIONAL, 2)
            ];
        }
    }

    public function getTypeLabelAttribute()
    {
        return self::getTypes()[$this->type] ?? 'Unknown Type';
    }

    public function getStatusLabelAttribute()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled'
        ][$this->status] ?? 'Unknown Status';
    }

    public function getStatusColorAttribute()
    {
        return [
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_CONFIRMED => 'bg-blue-100 text-blue-800',
            self::STATUS_COMPLETED => 'bg-green-100 text-green-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800'
        ][$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}