<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // ============================================
            // اطلاعات اصلی کاربر
            // ============================================
            $table->string('unique_code', 20)->unique()->nullable()
                  ->comment('کد یکتا مثل HSC-7YUQ0P06');
            $table->string('username', 100)->unique();
            $table->string('password');
            $table->string('full_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('logo')->nullable();

            // ============================================
            // نقش‌ها (ادغام company.role + manager.role + seller)
            // ============================================
            $table->enum('role', [
                'super_admin',      // از manager
                'admin',            // از manager
                'editor',           // از manager
                'company_manager',  // از company
                'company_admin',    // از company
                'company_user',     // از company
                'seller'            // از seller
            ])->default('seller');

            $table->enum('status', ['active', 'inactive', 'pending'])
                  ->default('active');

            // ============================================
            // احراز هویت و ورود
            // ============================================
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();

            // ============================================
            // اطلاعات قرارداد (از company)
            // ============================================
            $table->date('contract_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->text('manager_note')->nullable();

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();
            $table->softDeletes();

            // ============================================
            // Indexes
            // ============================================
            $table->index('role');
            $table->index('status');
            $table->index('last_login');
            $table->index('unique_code');
        });

        // ============================================
        // جداول سیستمی Laravel
        // ============================================

        // Password Reset
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('users');
    }
}
