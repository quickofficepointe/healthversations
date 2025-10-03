<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coaching_packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->string('duration');
            $table->decimal('price_usd', 10, 2);
            $table->decimal('price_kes', 10, 2);
            $table->string('bg_color');
            $table->string('button_text')->default('Enroll Now');
            $table->string('button_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coaching_packages');
    }
};
