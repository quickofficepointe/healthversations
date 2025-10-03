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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->constrained('packagecategories')->onDelete('cascade');  // Foreign key from packagecategories
            $table->string('package_name');
            $table->string('slug')->unique();  // Slug for package
            $table->text('package_description');
            $table->string('package_tags')->nullable();  // Tags for package
            $table->string('package_image')->nullable();  // Image for package
            $table->timestamps();

            // Add indexes for performance
            $table->index('package_name');  // Index for package_name
            $table->index('slug');  // Index for slug
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
