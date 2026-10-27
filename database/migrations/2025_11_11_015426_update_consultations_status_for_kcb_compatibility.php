<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Expand status enum to include KCB values
            $table->enum('status', [
                'pending',
                'confirmed',
                'completed',
                'cancelled',
                'failed',
                'approved'
            ])->default('pending')->change();

            // Expand payment_status enum to include KCB values
            $table->enum('payment_status', [
                'unpaid',
                'paid',
                'refunded',
                'failed'
            ])->default('unpaid')->change();
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Revert back to original enums if needed
            $table->enum('status', [
                'pending',
                'confirmed',
                'completed',
                'cancelled'
            ])->default('pending')->change();

            $table->enum('payment_status', [
                'unpaid',
                'paid',
                'refunded'
            ])->default('unpaid')->change();
        });
    }
};
