<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_messages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // ============================================
            // ارتباط با مکالمه
            // ============================================
            $table->unsignedBigInteger('conversation_id')->nullable();
            $table->foreign('conversation_id')
                  ->references('id')
                  ->on('conversations')
                  ->onDelete('cascade');

            // ============================================
            // فرستنده و گیرنده
            // ============================================
            $table->enum('sender_type', ['manager', 'seller', 'company']);
            $table->unsignedBigInteger('sender_id');
            $table->enum('receiver_type', ['manager', 'seller', 'company']);
            $table->unsignedBigInteger('receiver_id');

            // ============================================
            // محتوای پیام
            // ============================================
            $table->text('message');
            $table->json('attachments')->nullable()
                  ->comment('فایل‌های پیوست');

            // ============================================
            // وضعیت خواندن
            // ============================================
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();
            $table->softDeletes();

            // ============================================
            // Indexes
            // ============================================
            $table->index(['sender_type', 'sender_id'], 'sender_idx');
            $table->index(['receiver_type', 'receiver_id'], 'receiver_idx');
            $table->index('conversation_id');
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
