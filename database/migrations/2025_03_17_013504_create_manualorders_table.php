<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up()
{
Schema::create('manual_orders', function (Blueprint $table) {
$table->id();
$table->string('tracking_id')->unique();
$table->foreignId('product_id')->constrained()->onDelete('cascade');
$table->integer('quantity');
$table->decimal('total_price', 10, 2);
$table->string('payment_code');
$table->string('name');
$table->string('email');
$table->string('phone');
$table->enum('order_type', ['pickup', 'delivery']);

// Pickup details
$table->date('pickup_date')->nullable();
$table->time('pickup_time')->nullable();

// Delivery details
$table->string('county')->nullable();
$table->string('subcounty')->nullable();
$table->string('location')->nullable();
$table->string('address')->nullable();
$table->decimal('latitude', 10, 7)->nullable();
$table->decimal('longitude', 10, 7)->nullable();

$table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');

$table->timestamps();
});
}

public function down()
{
Schema::dropIfExists('manual_orders');
}
};