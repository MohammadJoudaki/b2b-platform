<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_company_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('company_orders', function (Blueprint $table) {
            $table->id();

            // ============================================
            // شماره سفارش
            // ============================================
            $table->string('order_number', 50)->unique();

            // ============================================
            // ارتباط‌ها
            // ============================================
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('seller_order_id')->nullable();
            $table->foreign('seller_order_id')
                  ->references('id')
                  ->on('seller_orders')
                  ->onDelete('set null');

            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')
                  ->references('id')
                  ->on('sellers')
                  ->onDelete('restrict');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                  ->references('id')
                  ->on('seller_products')
                  ->onDelete('restrict');

            // ============================================
            // اطلاعات مشتری نهایی
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
            // وضعیت
            // ============================================
            $table->enum('status', [
                'pending', 'confirmed', 'processing', 'ready',
                'delivered', 'cancelled'
            ])->default('pending');

            // ============================================
            // روش‌ها
            // ============================================
            $table->string('payment_method', 50)->nullable();
            $table->string('shipping_method', 50)->nullable();

            $table->text('notes')->nullable();
            $table->text('company_note')->nullable();

            // ============================================
            // تاریخ‌ها
            // ============================================
            $table->date('order_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('processing_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();
            $table->softDeletes();

            // ============================================
            // Indexes
            // ============================================
            $table->index('company_id');
            $table->index('seller_order_id');
            $table->index('seller_id');
            $table->index('product_id');
            $table->index('status');
            $table->index('order_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_orders');
    }
}
