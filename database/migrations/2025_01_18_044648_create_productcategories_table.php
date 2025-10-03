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
        Schema::create('productcategories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name')->unique(); // Unique category name
            $table->text('category_description')->nullable(); // Optional description
            $table->string('slug')->unique(); // Unique slug for SEO
            $table->string('category_tag')->nullable(); // Comma-separated tags
            $table->string('image')->nullable(); // Path to the cover image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productcategories');
    }
};
