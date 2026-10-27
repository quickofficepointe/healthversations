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
        if (Schema::hasTable('blocked_slots')) {
            return;
        }

        Schema::create('blocked_slots', function (Blueprint $table) {
            $table->id();
            $table->date('blocked_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('reason')->nullable();
            $table->timestamps();

            $table->index('blocked_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocked_slots');
    }
};
