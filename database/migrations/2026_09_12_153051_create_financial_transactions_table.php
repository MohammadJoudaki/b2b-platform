<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_financial_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();

            // ============================================
            // ارتباط‌ها
            // ============================================
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                  ->references('id')
                  ->on('company_orders')
                  ->onDelete('cascade');

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
            // مبلغ کل سفارش
            // ============================================
            $table->decimal('order_total', 15, 2);

            // ============================================
            // درصدهای کمیسیون
            // ============================================
            $table->decimal('company_commission_percent', 5, 2)->default(0);
            $table->decimal('seller_commission_percent', 5, 2)->default(0);
            $table->decimal('system_commission_percent', 5, 2)->default(0);

            // ============================================
            // درآمدها
            // ============================================
            $table->decimal('company_income', 15, 2)->default(0);
            $table->decimal('seller_income', 15, 2)->default(0);
            $table->decimal('system_income', 15, 2)->default(0);

            // ============================================
            // نوع و وضعیت
            // ============================================
            $table->enum('transaction_type', [
                'order', 'commission', 'refund'
            ])->default('order');

            $table->enum('status', [
                'pending', 'completed', 'cancelled'
            ])->default('completed');

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();

            // ============================================
            // Indexes
            // ============================================
            $table->index('order_id');
            $table->index('company_id');
            $table->index('seller_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_transactions');
    }
}
