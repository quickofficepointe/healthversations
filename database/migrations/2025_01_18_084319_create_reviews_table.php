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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the person writing the review
            $table->string('email'); // Email of the person writing the review
            $table->morphs('reviewable'); // Polymorphic relationship (can be product, service, etc.)
            $table->text('review'); // Review content
            $table->integer('star')->default(5); // Rating (1-5 stars)
            $table->boolean('approved')->default(false); // Default approval status is false (for moderation)
            $table->timestamps();

            // Indexes for optimization
            $table->index('email');
            $table->index('reviewable_id');
            $table->index('reviewable_type');
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};