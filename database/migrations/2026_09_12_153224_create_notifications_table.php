<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_notifications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // ============================================
            // گیرنده
            // ============================================
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // ============================================
            // فرستنده
            // ============================================
            $table->enum('sender_type', [
                'system', 'seller', 'company', 'admin'
            ])->default('system');
            $table->unsignedBigInteger('sender_id')->nullable();

            // ============================================
            // محتوا
            // ============================================
            $table->string('title');
            $table->text('message');
            $table->string('link')->nullable();
            $table->string('icon', 50)->nullable();
            $table->string('color', 20)->nullable();

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
            $table->index('user_id');
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
