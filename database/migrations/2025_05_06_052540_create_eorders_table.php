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
        Schema::create('eorders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
    $table->string('order_number')->unique();
    $table->string('customer_name');
    $table->string('customer_email');
    $table->string('customer_phone');
    $table->text('shipping_address')->nullable();
    $table->enum('type', ['ebook', 'hardcopy']);
    $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
    $table->decimal('amount', 8, 2);
    $table->string('payment_method');
    $table->string('transaction_reference')->nullable();
    $table->timestamps();
});

Schema::create('ebook_order', function (Blueprint $table) {
    $table->foreignId('ebook_id')->constrained();
    $table->foreignId('eorder_id')->constrained();
    $table->integer('quantity')->default(1);
    $table->decimal('price', 8, 2);
    $table->primary(['ebook_id', 'eorder_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eorders');
    }
};