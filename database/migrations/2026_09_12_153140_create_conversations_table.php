<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_conversations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();

            // ============================================
            // ارتباط با کاربران (مدیر و فروشنده)
            // ============================================
            $table->unsignedBigInteger('manager_id');
            $table->foreign('manager_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // ============================================
            // اطلاعات اضافی
            // ============================================
            $table->timestamp('last_message_at')->nullable();

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();

            // ============================================
            // Indexes
            // ============================================
            $table->unique(['manager_id', 'seller_id'], 'manager_seller_unique');
            $table->index('last_message_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('conversations');
    }
}
