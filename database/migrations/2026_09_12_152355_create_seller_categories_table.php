<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_seller_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('seller_categories', function (Blueprint $table) {
            $table->id();

            // ============================================
            // ارتباط با فروشنده
            // ============================================
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')
                  ->references('id')
                  ->on('sellers')
                  ->onDelete('cascade');

            // ============================================
            // دسته‌بندی والد (برای زیردسته‌ها)
            // ============================================
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('seller_categories')
                  ->onDelete('cascade');

            // ============================================
            // اطلاعات دسته‌بندی
            // ============================================
            $table->string('name', 100);
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('order_num')->default(0)
                  ->comment('ترتیب نمایش');

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();

            // ============================================
            // Indexes
            // ============================================
            $table->index('seller_id');
            $table->index('parent_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seller_categories');
    }
}
