<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_seller_customers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('seller_customers', function (Blueprint $table) {
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
            // اطلاعات مشتری
            // ============================================
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            // ============================================
            // اطلاعات شغلی
            // ============================================
            $table->string('job_title')->nullable();
            $table->string('company')->nullable();
            $table->text('description')->nullable();

            // ============================================
            // اطلاعات تماس
            // ============================================
            $table->string('contact_time', 100)->nullable();
            $table->date('contact_date')->nullable();

            // ============================================
            // وضعیت
            // ============================================
            $table->enum('status', ['active', 'inactive', 'lead', 'customer'])
                  ->default('lead');

            $table->string('source', 100)->nullable()
                  ->comment('منبع آشنایی');
            $table->text('notes')->nullable();

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();
            $table->softDeletes();

            // ============================================
            // Indexes
            // ============================================
            $table->index('seller_id');
            $table->index('phone');
            $table->index('status');
            $table->index(['first_name', 'last_name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seller_customers');
    }
}
