<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('blog_title');
            $table->text('blog_description');  // For storing content (e.g., Summernote)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assuming `users` table exists
            $table->foreignId('blogcategory_id')->constrained('blogcategories')->onDelete('cascade'); // Foreign key to `blogcategories` table
            $table->boolean('approved')->default(false); // Approval status with default value `false`
            $table->string('cover_image')->nullable();  // Cover image for the blog
            $table->string('tags')->nullable();
            $table->string('slug')->unique();// Tags, stored as a string (can be separated by commas)
            $table->timestamps();// Indexes for optimization
            $table->index('blog_title');  // Index on blog title
            $table->index('tags');  // Index on tags
            $table->index('user_id');  // Index on user_id (for faster retrieval of user's blogs)
            $table->index('blogcategory_id');  // Index on blogcategory_id (for faster retrieval of category-specific blogs)

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};