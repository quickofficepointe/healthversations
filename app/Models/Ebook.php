<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    protected $fillable = [
        'title', 'description', 'cover_image', 'file_path',
        'preview_content', 'ebook_price', 'hardcopy_price',
        'is_hardcopy_available', 'is_featured'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function getFormattedEbookPriceAttribute()
    {
        return 'Ksh ' . number_format($this->ebook_price, 2);
    }

    public function getFormattedHardcopyPriceAttribute()
    {
        return $this->hardcopy_price ? 'Ksh ' . number_format($this->hardcopy_price, 2) : null;
    }
}