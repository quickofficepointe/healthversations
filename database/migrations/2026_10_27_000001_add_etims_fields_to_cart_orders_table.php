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
        Schema::table('cart_orders', function (Blueprint $table) {
            // eTIMS invoice request captured at checkout
            if (!Schema::hasColumn('cart_orders', 'etims_requested')) {
                $table->boolean('etims_requested')->default(false)->after('delivery_cost');
            }
            if (!Schema::hasColumn('cart_orders', 'etims_kra_pin')) {
                $table->string('etims_kra_pin', 20)->nullable()->after('etims_requested');
            }
            if (!Schema::hasColumn('cart_orders', 'etims_business_name')) {
                $table->string('etims_business_name')->nullable()->after('etims_kra_pin');
            }
            // Invoice generated on KRA eTIMS and attached by admin
            if (!Schema::hasColumn('cart_orders', 'etims_invoice_number')) {
                $table->string('etims_invoice_number')->nullable()->after('etims_business_name');
            }
            if (!Schema::hasColumn('cart_orders', 'etims_invoice_path')) {
                $table->string('etims_invoice_path')->nullable()->after('etims_invoice_number');
            }
            if (!Schema::hasColumn('cart_orders', 'etims_invoice_sent_at')) {
                $table->timestamp('etims_invoice_sent_at')->nullable()->after('etims_invoice_path');
            }

            // Written by the KCB payment flow; make sure they exist
            if (!Schema::hasColumn('cart_orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('status');
            }
            if (!Schema::hasColumn('cart_orders', 'payment_status')) {
                $table->string('payment_status')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('cart_orders', 'kcb_payment_reference')) {
                $table->string('kcb_payment_reference')->nullable();
            }
            if (!Schema::hasColumn('cart_orders', 'kcb_invoice_number')) {
                $table->string('kcb_invoice_number')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_orders', function (Blueprint $table) {
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
