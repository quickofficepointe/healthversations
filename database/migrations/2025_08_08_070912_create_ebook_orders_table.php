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
        Schema::create('ebook_orders', function (Blueprint $table) {
            $table->id();
             $table->foreignId('ebook_id')->constrained();
                     $table->string('order_id');
    $table->decimal('amount', 10, 2);
    $table->string('customer_name');
    $table->string('customer_email');
    $table->string('customer_phone');
    $table->string('status')->default('pending');
    $table->string('iveri_reference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebook_orders');
    }
};