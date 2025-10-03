<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Product information
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants');
            $table->string('product_name');

            // Customer information
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('phone');

            // Order details
            $table->string('order_type')->default('delivery'); // 'delivery' or 'pickup'
            $table->integer('quantity');
            $table->decimal('total_price_kes', 10, 2);
            $table->decimal('total_price_usd', 10, 2);
            $table->string('payment_code');

            // Delivery information
            $table->string('county')->nullable();
            $table->string('subcounty')->nullable();
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Pickup information
            $table->date('pickup_date')->nullable();
            $table->string('pickup_time')->nullable();

            // Order tracking
            $table->string('tracking_id')->unique();
            $table->string('status')->default('pending'); // 'pending', 'processing', 'shipped', 'delivered', 'cancelled'

            // Payment status
            $table->string('payment_status')->default('pending'); // 'pending', 'paid', 'failed', 'refunded'

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
