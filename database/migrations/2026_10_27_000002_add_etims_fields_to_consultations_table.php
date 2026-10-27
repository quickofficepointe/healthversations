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
        Schema::table('consultations', function (Blueprint $table) {
            // eTIMS invoice request captured at booking
            if (!Schema::hasColumn('consultations', 'etims_requested')) {
                $table->boolean('etims_requested')->default(false)->after('payment_reference');
            }
            if (!Schema::hasColumn('consultations', 'etims_kra_pin')) {
                $table->string('etims_kra_pin', 20)->nullable()->after('etims_requested');
            }
            if (!Schema::hasColumn('consultations', 'etims_business_name')) {
                $table->string('etims_business_name')->nullable()->after('etims_kra_pin');
            }
            // Invoice generated on KRA eTIMS and attached by admin
            if (!Schema::hasColumn('consultations', 'etims_invoice_number')) {
                $table->string('etims_invoice_number')->nullable()->after('etims_business_name');
            }
            if (!Schema::hasColumn('consultations', 'etims_invoice_path')) {
                $table->string('etims_invoice_path')->nullable()->after('etims_invoice_number');
            }
            if (!Schema::hasColumn('consultations', 'etims_invoice_sent_at')) {
                $table->timestamp('etims_invoice_sent_at')->nullable()->after('etims_invoice_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn([
                'etims_requested',
                'etims_kra_pin',
                'etims_business_name',
                'etims_invoice_number',
                'etims_invoice_path',
                'etims_invoice_sent_at',
            ]);
        });
    }
};
