<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_sellers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();

            // ============================================
            // ارتباط با کاربر و شرکت
            // ============================================
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('set null')
                  ->comment('شرکتی که فروشنده به آن متصل است');

            // ============================================
            // اطلاعات فروشگاه
            // ============================================
            $table->string('store_name')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->text('store_description')->nullable();
            $table->enum('store_status', ['active', 'inactive'])->default('active');

            // ============================================
            // شبکه‌های اجتماعی و اطلاعات تماس
            // ============================================
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('telegram')->nullable();
            $table->string('whatsapp', 20)->nullable();

            // ============================================
            // Timestamps و Soft Delete
            // ============================================
            $table->timestamps();
            $table->softDeletes();

            // ============================================
            // Indexes
            // ============================================
            $table->index('company_id');
            $table->index('store_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sellers');
    }
}
