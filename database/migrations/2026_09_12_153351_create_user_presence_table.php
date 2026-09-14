<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_user_presence_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPresenceTable extends Migration
{
    public function up()
    {
        Schema::create('user_presence', function (Blueprint $table) {
            $table->id();

            // ============================================
            // نوع و شناسه کاربر
            // ============================================
            $table->enum('user_type', ['manager', 'seller', 'company', 'admin']);
            $table->unsignedBigInteger('user_id');

            // ============================================
            // وضعیت آنلاین
            // ============================================
            $table->timestamp('last_seen')->useCurrent();
            $table->boolean('is_online')->default(false);

            // ============================================
            // Indexes
            // ============================================
            $table->unique(['user_type', 'user_id'], 'user_type_user_id_unique');
            $table->index('is_online');
            $table->index('last_seen');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_presence');
    }
}
