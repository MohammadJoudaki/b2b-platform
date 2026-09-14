<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_admins_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            // ============================================
            // ارتباط با کاربر
            // ============================================
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // ============================================
            // اطلاعات مدیر
            // ============================================
            $table->enum('admin_level', ['super_admin', 'admin', 'editor'])
                  ->default('admin')
                  ->comment('سطح دسترسی مدیر');

            $table->json('permissions')->nullable()
                  ->comment('دسترسی‌های اختصاصی (JSON)');

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
