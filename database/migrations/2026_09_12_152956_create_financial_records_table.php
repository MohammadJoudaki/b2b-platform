<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_financial_records_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('financial_records', function (Blueprint $table) {
            $table->id();

            // ============================================
            // ارتباط‌ها
            // ============================================
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')
                  ->references('id')
                  ->on('company_orders')
                  ->onDelete('set null');

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('seller_customers')
                  ->onDelete('set null');

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')
                  ->references('id')
                  ->on('sellers')
                  ->onDelete('cascade');

            // ============================================
            // مبالغ
            // ============================================
            $table->decimal('order_total', 15, 2);
            $table->decimal('customer_paid_amount', 15, 2)->default(0);
            $table->decimal('customer_remaining', 15, 2)->default(0);

            // ============================================
            // درآمدها
            // ============================================
            $table->decimal('company_income', 15, 2)->default(0);
            $table->decimal('seller_income', 15, 2)->default(0);
            $table->decimal('system_income', 15, 2)->default(0);

            // ============================================
            // پرداخت‌ها
            // ============================================
            $table->decimal('company_paid', 15, 2)->default(0);
            $table->decimal('company_remaining', 15, 2)->default(0);
            $table->decimal('seller_paid', 15, 2)->default(0);
            $table->decimal('seller_remaining', 15, 2)->default(0);

            // ============================================
            // نوع و وضعیت
            // ============================================
            $table->enum('transaction_type', [
                'order', 'payment_in', 'payment_out', 'settlement'
            ])->default('order');

            $table->enum('status', [
                'pending', 'partial', 'completed', 'cancelled'
            ])->default('pending');

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();

            // ============================================
            // Indexes
            // ============================================
            $table->index('order_id');
            $table->index('customer_id');
            $table->index('company_id');
            $table->index('seller_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_records');
    }
}
