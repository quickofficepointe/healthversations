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
        Schema::create('consult_testmonials', function (Blueprint $table) {
            $table->id();

            // Client information
            $table->string('client_name');
            $table->string('slug')->unique(); // Add this line for slug
            $table->string('client_location')->nullable();
            $table->integer('client_age')->nullable();
            $table->string('client_occupation')->nullable();

            // ... rest of your existing fields remain the same
            // Program/Service details
            $table->string('program_type');
            $table->integer('program_duration_weeks')->nullable();

            // Results achieved
            $table->decimal('weight_loss_kg', 5, 2)->nullable();
            $table->decimal('weight_gain_kg', 5, 2)->nullable();
            $table->decimal('inches_lost', 5, 2)->nullable();
            $table->json('measurements')->nullable();

            // Images
            $table->string('before_image');
            $table->string('after_image');
            $table->boolean('images_approved')->default(false);

            // Testimonial content
            $table->longText('testimonial_text');
            $table->text('challenges_overcome')->nullable();
            $table->text('key_achievements')->nullable();

            // Ratings
            $table->integer('rating')->default(5);
            $table->json('rating_breakdown')->nullable();

            // Social proof
            $table->string('social_media_handle')->nullable();
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);

            // Status and verification
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_public')->default(true);
            $table->string('verification_token')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index(['featured', 'is_public', 'is_verified']);
            $table->index('program_type');
            $table->index('rating');
            $table->index('slug'); // Add index for slug
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_testmonials');
    }
};
