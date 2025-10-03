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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Name of the person contacting
            $table->string('phone_number')->nullable();  // Nullable phone number
            $table->string('email');  // Unique email to prevent duplicates
            $table->text('message');  // Using text for longer message storage
            $table->timestamps();

            // Adding indexes to improve search performance
            $table->index('name');  // Indexing the name for quicker search
            $table->index('email'); // Indexing the email
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};