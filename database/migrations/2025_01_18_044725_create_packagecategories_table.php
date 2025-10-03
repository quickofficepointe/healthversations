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
        Schema::create('packagecategories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->string('slug')->unique();
            $table->text('category_description');
            $table->string('category_image')->nullable();
            $table->string('category_tags')->nullable();
            $table->timestamps();

            // Add indexes for better performance
            $table->index('category_name'); // Index for 'category_name'
            $table->index('category_tags'); // Index for 'category_tags'

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packagecategories');
    }
};