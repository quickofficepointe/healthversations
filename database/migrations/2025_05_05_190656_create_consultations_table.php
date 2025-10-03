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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('phone', 20)->nullable();
            $table->enum('type', [
                'initial',
                'followup',
                'nutrition_review',
                'specialized'
            ])->default('initial');
            $table->date('consultation_date');
            $table->time('consultation_time');
            $table->enum('location', ['kenya', 'international'])->default('kenya');
            $table->string('timezone', 50)->nullable();
            $table->text('health_concerns');
            $table->text('notes')->nullable();
            $table->decimal('fee', 10, 2);
            $table->decimal('usd_equivalent', 10, 2)->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid');
            $table->string('payment_reference')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();

            $table->index(['consultation_date', 'consultation_time']);
            $table->index('email');
            $table->index('status');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};