<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_financial_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('financial_payments', function (Blueprint $table) {
            $table->id();

            // ============================================
            // ارتباط با سابقه مالی
            // ============================================
            $table->unsignedBigInteger('financial_record_id');
            $table->foreign('financial_record_id')
                  ->references('id')
                  ->on('financial_records')
                  ->onDelete('cascade');

            // ============================================
            // نوع پرداخت‌کننده
            // ============================================
            $table->enum('payer_type', [
                'customer',
                'management_to_company',
                'management_to_seller'
            ]);

            // ============================================
            // اطلاعات پرداخت
            // ============================================
            $table->decimal('amount', 15, 2);
            $table->string('payment_method', 50)->default('cash');
            $table->string('reference_number', 100)->nullable();
            $table->text('description')->nullable();

            $table->timestamp('paid_at')->nullable();

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();

            // ============================================
            // Indexes
            // ============================================
            $table->index('financial_record_id');
            $table->index('payer_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_payments');
    }
}
