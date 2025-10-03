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
        'payment_reference'
    ];

    // Consultation Types - must match database enum
    const TYPE_INITIAL = 'initial';
    const TYPE_FOLLOWUP = 'followup';
    const TYPE_NUTRITION_REVIEW = 'nutrition_review';
    const TYPE_SPECIALIZED = 'specialized';



    // Status Constants
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Payment Status
    const PAYMENT_UNPAID = 'unpaid';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_REFUNDED = 'refunded';

    // Location Constants
    const LOCATION_KENYA = 'kenya';
    const LOCATION_INTERNATIONAL = 'international';

    // Fee Structure (KSH)
    const FEE_KENYA = 2500;
    const FEE_INTERNATIONAL = 24; // USD

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
        $this->fee = $this->location === self::LOCATION_KENYA
            ? self::FEE_KENYA
            : self::FEE_INTERNATIONAL;

        if ($this->location === self::LOCATION_INTERNATIONAL) {
            $this->usd_equivalent = $this->fee;
            $this->fee = $this->fee * 150; // Convert to KSH
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
