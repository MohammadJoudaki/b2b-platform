<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_companies_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            // ============================================
            // ارتباط با کاربر اصلی
            // ============================================
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // ============================================
            // اطلاعات شرکت
            // ============================================
            $table->string('company_name');
            $table->string('slug')->unique()->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();

            // ============================================
            // اطلاعات ثبتی و قانونی
            // ============================================
            $table->string('economic_code', 50)->nullable()
                  ->comment('کد اقتصادی');
            $table->string('national_id', 20)->nullable()
                  ->comment('شناسه ملی');
            $table->string('registration_number', 50)->nullable()
                  ->comment('شماره ثبت');

            // ============================================
            // تنظیمات تجاری
            // ============================================
            $table->decimal('commission_rate', 5, 2)->default(0)
                  ->comment('درصد کمیسیون اختصاصی شرکت');

            $table->enum('company_type', ['buyer', 'seller', 'both'])
                  ->default('buyer')
                  ->comment('نوع شرکت: خریدار، فروشنده یا هر دو');

            // ============================================
            // Timestamps و Soft Delete
            // ============================================
            $table->timestamps();
            $table->softDeletes();

            // ============================================
            // Indexes
            // ============================================
            $table->index('company_name');
            $table->index('company_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
