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
        Schema::create('versationcards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('tags')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();

            // Adding indexes
            $table->index('name'); // Index for faster search by name
            $table->index('tags'); // Index for faster search by tags
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versationcards');
    }
};