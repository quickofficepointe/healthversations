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
        Schema::create('cart_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->json('items'); // Stores cart items as JSON
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('county')->nullable();
            $table->string('subcounty')->nullable();
            $table->string('location')->nullable();
            $table->text('address')->nullable();
            $table->string('delivery_method')->default('pickup'); // Added: pickup or delivery
            $table->string('delivery_zone')->nullable(); // Added: delivery zone code (A, B, C, etc.)
            $table->decimal('delivery_cost', 10, 2)->default(0); // Added: delivery cost amount
            $table->string('status')->default('pending');
            $table->string('iveri_reference')->nullable();
            $table->text('response_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_orders');
    }
};
