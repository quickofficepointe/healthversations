<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add KCB payment fields to ALL order tables
        Schema::table('cart_orders', function (Blueprint $table) {
            $table->string('kcb_payment_reference')->nullable()->after('iveri_reference');
            $table->string('kcb_invoice_number')->nullable()->after('kcb_payment_reference');
            $table->string('payment_method')->default('iveri')->change();
        });

        Schema::table('consultations', function (Blueprint $table) {
            $table->string('kcb_payment_reference')->nullable()->after('payment_reference');
            $table->string('kcb_invoice_number')->nullable()->after('kcb_payment_reference');
            $table->string('payment_method')->default('iveri')->change();
        });

        Schema::table('ebook_orders', function (Blueprint $table) {
            $table->string('kcb_payment_reference')->nullable()->after('iveri_reference');
            $table->string('kcb_invoice_number')->nullable()->after('kcb_payment_reference');
            $table->string('payment_method')->default('iveri')->change();
        });

        Schema::table('eorders', function (Blueprint $table) {
            $table->string('kcb_payment_reference')->nullable()->after('transaction_reference');
            $table->string('kcb_invoice_number')->nullable()->after('kcb_payment_reference');
            $table->string('payment_method')->default('iveri')->change();
        });

        Schema::table('coaching_enrollments', function (Blueprint $table) {
            $table->string('kcb_payment_reference')->nullable()->after('transaction_reference');
            $table->string('kcb_invoice_number')->nullable()->after('kcb_payment_reference');
            $table->string('payment_method')->default('iveri')->change();
        });

        // Add custom_packages table if it doesn't exist
        if (!Schema::hasTable('custom_packages')) {
            Schema::create('custom_packages', function (Blueprint $table) {
                $table->id();
                $table->string('package_name');
                $table->text('description');
                $table->decimal('amount', 10, 2);
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('customer_phone');
                $table->string('status')->default('pending');
                $table->string('payment_method')->default('iveri');
                $table->string('kcb_payment_reference')->nullable();
                $table->string('kcb_invoice_number')->nullable();
                $table->text('requirements')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::table('cart_orders', function (Blueprint $table) {
            $table->dropColumn(['kcb_payment_reference', 'kcb_invoice_number']);
        });

        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn(['kcb_payment_reference', 'kcb_invoice_number']);
        });

        Schema::table('ebook_orders', function (Blueprint $table) {
            $table->dropColumn(['kcb_payment_reference', 'kcb_invoice_number']);
        });

        Schema::table('eorders', function (Blueprint $table) {
            $table->dropColumn(['kcb_payment_reference', 'kcb_invoice_number']);
        });

        Schema::table('coaching_enrollments', function (Blueprint $table) {
            $table->dropColumn(['kcb_payment_reference', 'kcb_invoice_number']);
        });
    }
};
