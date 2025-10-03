<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class blogcategory extends Model
{
    //
    protected $fillable = [
        'categoryname',
        'description',
        'cover_image',
        'slug',
        'user_id',
    ];

    /**
     * Get the user that owns the blog category.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function blogs()
    {
        return $this->hasMany(blog::class, 'blogcategory_id');
    }
}
