<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_company_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyProductsTable extends Migration
{
    public function up()
    {
        Schema::create('company_products', function (Blueprint $table) {
            $table->id();

            // ============================================
            // ارتباط‌ها
            // ============================================
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('seller_product_id');
            $table->foreign('seller_product_id')
                  ->references('id')
                  ->on('seller_products')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')
                  ->references('id')
                  ->on('sellers')
                  ->onDelete('cascade');

            // ============================================
            // قیمت اختصاصی برای این شرکت
            // ============================================
            $table->decimal('price', 15, 2);
            $table->decimal('price_usd', 15, 2)->default(0);
            $table->decimal('price_thousand_toman', 15, 2)->default(0);

            // ============================================
            // موجودی و کمیسیون
            // ============================================
            $table->integer('stock')->default(0);
            $table->decimal('custom_commission', 5, 2)->nullable()
                  ->comment('کمیسیون اختصاصی');

            // ============================================
            // وضعیت
            // ============================================
            $table->enum('status', ['active', 'inactive'])->default('active');

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();

            // ============================================
            // Indexes
            // ============================================
            $table->unique(['company_id', 'seller_product_id'], 'company_product_unique');
            $table->index('company_id');
            $table->index('seller_product_id');
            $table->index('seller_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_products');
    }
}
