<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kcb_payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // Format: 8234000-PROD-1701234567-1234
            $table->string('checkout_request_id')->unique();
            $table->string('merchant_request_id');
            $table->string('phone_number');
            $table->decimal('amount', 10, 2);
            $table->string('payment_type'); // product, consultation, ebook, custom_package
            $table->unsignedBigInteger('reference_id'); // ID of the related order/consultation/etc
            $table->string('reference_type'); // App\Models\Order, App\Models\Consultation, etc

            // Payment status fields
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->string('result_code')->nullable();
            $table->string('result_description')->nullable();
            $table->string('mpesa_receipt_number')->nullable();
            $table->timestamp('transaction_date')->nullable();

            // KCB specific fields
            $table->string('org_short_code')->default('8234000');
            $table->text('callback_payload')->nullable();

            $table->timestamps();

            // Indexes for better performance
            $table->index(['invoice_number']);
            $table->index(['checkout_request_id']);
            $table->index(['status']);
            $table->index(['payment_type', 'reference_id', 'reference_type']);
            $table->index(['created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kcb_payments');
    }
};
