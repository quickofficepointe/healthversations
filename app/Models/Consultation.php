<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    // Consultation Types - ADDED PHYSICAL
    const TYPE_INITIAL = 'initial';
    const TYPE_FOLLOWUP = 'followup';
    const TYPE_NUTRITION_REVIEW = 'nutrition_review';
    const TYPE_SPECIALIZED = 'specialized';
    const TYPE_PHYSICAL = 'physical'; // NEW: Physical consultation

    // Status Constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';  // Changed from 'confirmed' to match your admin
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

    // Fee Structure
    const FEE_KENYA = 3000; // KSH for online
    const FEE_INTERNATIONAL = 31; // USD for online
    const FEE_PHYSICAL = 5000; // KSH for physical consultation (2 hours)

    // Get consultation types with labels
    public static function getTypes()
    {
        return [
            self::TYPE_INITIAL => 'Online Initial Consultation',
            self::TYPE_FOLLOWUP => 'Online Follow-up Session',
            self::TYPE_NUTRITION_REVIEW => 'Online Nutrition Plan Review',
            self::TYPE_SPECIALIZED => 'Online Specialized Consultation',
            self::TYPE_PHYSICAL => 'Physical Consultation (2 hours)',
        ];
    }

    // Get consultation durations
    public function getDuration()
    {
        return match($this->type) {
            self::TYPE_PHYSICAL => '2 hours',
            self::TYPE_INITIAL => '60 minutes',
            self::TYPE_SPECIALIZED => '60 minutes',
            self::TYPE_NUTRITION_REVIEW => '45 minutes',
            self::TYPE_FOLLOWUP => '30 minutes',
            default => '60 minutes'
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calculateFee()
    {
        if ($this->type === self::TYPE_PHYSICAL) {
            $this->fee = self::FEE_PHYSICAL;
            $this->usd_equivalent = null;
        } elseif ($this->location === self::LOCATION_KENYA) {
            $this->fee = self::FEE_KENYA;
            $this->usd_equivalent = null;
        } else {
            $this->fee = self::FEE_INTERNATIONAL * 150; // Convert to KSH for storage
            $this->usd_equivalent = self::FEE_INTERNATIONAL;
        }
    }

    public function getDisplayAmountAttribute()
    {
        if ($this->type === self::TYPE_PHYSICAL) {
            return [
                'amount' => self::FEE_PHYSICAL,
                'currency' => 'KES',
                'formatted' => 'Ksh ' . number_format(self::FEE_PHYSICAL)
            ];
        } elseif ($this->location === self::LOCATION_KENYA) {
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
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled'
        ][$this->status] ?? 'Unknown Status';
    }

    public function getStatusColorAttribute()
    {
        return [
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_APPROVED => 'bg-green-100 text-green-800',
            self::STATUS_CONFIRMED => 'bg-blue-100 text-blue-800',
            self::STATUS_COMPLETED => 'bg-purple-100 text-purple-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800'
        ][$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    // Check if a time slot is available
    public static function isTimeSlotAvailable($date, $time, $type)
    {
        $duration = $type === self::TYPE_PHYSICAL ? 120 : 60; // 2 hours for physical, 1 hour for online

        // Check if there's any blocked slot for this time
        $blockedSlot = BlockedSlot::where('blocked_date', $date)
            ->where(function($query) use ($time, $duration) {
                $startTime = Carbon::parse($time);
                $endTime = (clone $startTime)->addMinutes($duration);

                $query->where(function($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<=', $startTime)
                      ->where('end_time', '>', $startTime);
                })->orWhere(function($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                      ->where('end_time', '>=', $endTime);
                });
            })
            ->exists();

        if ($blockedSlot) {
            return false;
        }

        // Check if there's already a booking at this time
        $existingBooking = self::where('consultation_date', $date)
            ->where('consultation_time', $time)
            ->whereIn('status', [self::STATUS_PENDING, self::STATUS_APPROVED])
            ->exists();

        return !$existingBooking;
    }

    // Get available time slots for a date
    public static function getAvailableTimeSlots($date)
    {
        $allTimeSlots = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'];
        $availableSlots = [];

        foreach ($allTimeSlots as $time) {
            $isBlocked = BlockedSlot::where('blocked_date', $date)
                ->where(function($query) use ($time) {
                    $startTime = Carbon::parse($time);
                    $query->where('start_time', '<=', $startTime)
                          ->where('end_time', '>', $startTime);
                })->exists();

            $isBooked = self::where('consultation_date', $date)
                ->where('consultation_time', $time)
                ->whereIn('status', [self::STATUS_PENDING, self::STATUS_APPROVED])
                ->exists();

            if (!$isBlocked && !$isBooked) {
                $availableSlots[] = $time;
            }
        }

        return $availableSlots;
    }
}
