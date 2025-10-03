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
        Schema::create('custom_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // User's name
            $table->string('email'); // User's email
            $table->string('phone_number'); // User's phone number
            $table->string('service'); // Type of service requested
            $table->text('message')->nullable(); // Additional notes or message from the user
            $table->string('package_details')->nullable(); // Details about the custom package
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_packages');
    }
};
