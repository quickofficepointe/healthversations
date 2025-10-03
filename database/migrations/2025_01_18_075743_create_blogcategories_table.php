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
        Schema::create('blogcategories', function (Blueprint $table) {
                $table->id();  // Primary key column
                $table->string('categoryname');
                $table->text('description')->nullable();
                $table->string('cover_image')->nullable();
                $table->string('slug')->unique();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->timestamps();

                // Adding indexes for optimization
                $table->index('slug');
                $table->index('description');
                $table->index('categoryname');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogcategories');
    }
};