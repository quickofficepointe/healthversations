<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'blocked_date',
        'start_time',
        'end_time',
        'reason',
    ];

    protected $casts = [
        'blocked_date' => 'date',
    ];

    public function scopeUpcoming($query)
    {
        return $query->whereDate('blocked_date', '>=', now()->toDateString());
    }

    public function isFullDay(): bool
    {
        return substr($this->start_time, 0, 5) === '00:00' && substr($this->end_time, 0, 5) === '23:59';
    }
}
