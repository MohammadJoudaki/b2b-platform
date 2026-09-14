<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_seller_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('seller_orders', function (Blueprint $table) {
            $table->id();

            // ============================================
            // شماره سفارش
            // ============================================
            $table->string('order_number', 50)->unique();

            // ============================================
            // ارتباط‌ها
            // ============================================
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')
                  ->references('id')
                  ->on('sellers')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                  ->references('id')
                  ->on('seller_products')
                  ->onDelete('restrict');

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('seller_customers')
                  ->onDelete('set null');

            // ============================================
            // اطلاعات مشتری (ذخیره در زمان سفارش)
            // ============================================
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->string('customer_email')->nullable();
            $table->text('address')->nullable();

            // ============================================
            // مالی
            // ============================================
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 15, 2);
            $table->decimal('total_price', 15, 2);
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);

            // ============================================
            // وضعیت سفارش
            // ============================================
            $table->enum('status', [
                'pending', 'processing', 'shipped', 'completed', 'cancelled'
            ])->default('pending');

            $table->enum('payment_status', [
                'pending', 'paid', 'failed', 'refunded'
            ])->default('pending');

            // ============================================
            // روش‌های پرداخت و ارسال
            // ============================================
            $table->string('payment_method', 50)->nullable();
            $table->string('shipping_method', 50)->nullable();

            $table->text('notes')->nullable();

            // ============================================
            // تاریخ‌ها
            // ============================================
            $table->date('order_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();
            $table->softDeletes();

            // ============================================
            // Indexes
            // ============================================
            $table->index('seller_id');
            $table->index('product_id');
            $table->index('customer_id');
            $table->index('status');
            $table->index('payment_status');
            $table->index('order_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seller_orders');
    }
}
