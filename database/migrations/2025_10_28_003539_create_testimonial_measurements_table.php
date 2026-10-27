<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonial_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('testimonial_id')
                  ->constrained('consult_testmonials')
                  ->onDelete('cascade');
            $table->string('measurement_type'); // chest, waist, arms, etc.
            $table->decimal('before_value', 5, 2);
            $table->decimal('after_value', 5, 2);
            $table->string('unit')->default('inches');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonial_measurements');
    }
};
