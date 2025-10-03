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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image'); // Path to stored image
            $table->string('button_text')->default('Learn More');
            $table->string('button_url')->nullable(); // URL or route name
            $table->string('text_color')->default('#ffffff');
            $table->string('background_color')->nullable();
            $table->integer('order')->default(0); // For sorting banners
            $table->boolean('is_active')->default(true);
            $table->dateTime('start_at')->nullable(); // Schedule banner display
            $table->dateTime('end_at')->nullable();   // Schedule banner display
            $table->string('target_audience')->nullable()->comment('Optional targeting: all, new_users, returning_users, etc.');
            $table->json('display_rules')->nullable()->comment('Additional display rules in JSON format');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};