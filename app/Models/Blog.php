<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    //
    // Fillable attributes for mass assignment
    protected $fillable = [
        'blog_title',
        'blog_description',
        'user_id',
        'blogcategory_id',
        'approved',
        'cover_image',
        'tags',
        'slug',
    ];

    /**
     * Get the user that owns the blog.
     */
    public function user()
    {
        return $this->belongsTo(User::class);  // A blog belongs to a user
    }

    /**
     * Get the category that the blog belongs to.
     */
    public function category()
    {
        return $this->belongsTo(blogcategory::class, 'blogcategory_id');  // A blog belongs to a blog category
    }


}
