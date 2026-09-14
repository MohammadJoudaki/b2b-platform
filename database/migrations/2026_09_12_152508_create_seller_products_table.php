<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_seller_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerProductsTable extends Migration
{
    public function up()
    {
        Schema::create('seller_products', function (Blueprint $table) {
            $table->id();

            // ============================================
            // ارتباط‌ها
            // ============================================
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')
                  ->references('id')
                  ->on('sellers')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')
                  ->references('id')
                  ->on('seller_categories')
                  ->onDelete('set null');

            // ============================================
            // اطلاعات محصول
            // ============================================
            $table->string('company_name')->nullable()
                  ->comment('نام شرکت سازنده');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // ============================================
            // قیمت‌گذاری
            // ============================================
            $table->decimal('price', 15, 2);
            $table->decimal('price_usd', 15, 2)->default(0);
            $table->decimal('price_thousand_toman', 15, 2)->default(0);

            // ============================================
            // واحد اندازه‌گیری
            // ============================================
            $table->enum('unit_type', [
                'عدد', 'کیلوگرم', 'متر', 'لیتر',
                'گرم', 'بسته', 'جعبه', 'تن',
                'مترمربع', 'مترمکعب', 'سایر'
            ])->default('عدد');

            $table->decimal('unit_quantity', 10, 2)->default(1);

            // ============================================
            // موجودی و کمیسیون
            // ============================================
            $table->integer('stock')->default(0);
            $table->decimal('commission_percent', 5, 2)->default(30);

            // ============================================
            // فایل‌ها و تصاویر
            // ============================================
            $table->string('catalog_file')->nullable()
                  ->comment('فایل کاتالوگ');
            $table->string('brochure_file')->nullable()
                  ->comment('فایل بروشور');
            $table->text('images')->nullable()
                  ->comment('تصاویر به صورت JSON');
            $table->string('image')->nullable()
                  ->comment('تصویر اصلی');

            // ============================================
            // SEO
            // ============================================
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('tags', 500)->nullable();

            // ============================================
            // وضعیت
            // ============================================
            $table->enum('status', ['active', 'inactive', 'pending', 'rejected'])
                  ->default('active');

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();
            $table->softDeletes();

            // ============================================
            // Indexes
            // ============================================
            $table->index('seller_id');
            $table->index('category_id');
            $table->index('status');
            $table->index('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seller_products');
    }
}
