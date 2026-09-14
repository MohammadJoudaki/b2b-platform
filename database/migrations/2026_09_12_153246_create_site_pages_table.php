<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_site_pages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitePagesTable extends Migration
{
    public function up()
    {
        Schema::create('site_pages', function (Blueprint $table) {
            $table->id();

            // ============================================
            // اطلاعات اصلی
            // ============================================
            $table->string('page_key', 100)->unique()
                  ->comment('کلید صفحه مثل home, about, services');
            $table->string('title');
            $table->longText('content')->nullable();

            // ============================================
            // SEO
            // ============================================
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();

            // ============================================
            // وضعیت
            // ============================================
            $table->enum('status', ['active', 'inactive'])->default('active');

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_pages');
    }
}
