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
        Schema::create('coaching_enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('package_id')->constrained('coaching_packages');
            $table->decimal('amount', 10, 2); // in KES
            $table->decimal('original_amount', 10, 2);
            $table->string('original_currency', 3)->default('KES');
            $table->decimal('conversion_rate', 10, 6)->default(1);
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('country');
            $table->string('status')->default('pending');
            $table->text('iveri_response')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('order_id');
            $table->index('customer_email');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaching_enrollments');
    }
};