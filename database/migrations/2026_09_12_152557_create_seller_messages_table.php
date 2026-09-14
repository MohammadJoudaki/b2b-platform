<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_seller_messages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('seller_messages', function (Blueprint $table) {
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
            // اطلاعات فرستنده
            // ============================================
            $table->string('sender_name');
            $table->string('sender_email')->nullable();
            $table->string('sender_phone', 20)->nullable();

            // ============================================
            // پیام
            // ============================================
            $table->string('subject')->nullable();
            $table->text('message');

            // ============================================
            // وضعیت خواندن
            // ============================================
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();

            // ============================================
            // Indexes
            // ============================================
            $table->index('seller_id');
            $table->index('is_read');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seller_messages');
    }
}
