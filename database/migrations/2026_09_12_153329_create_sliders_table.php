<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_sliders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();

            // ============================================
            // اطلاعات اسلاید
            // ============================================
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('image');
            $table->string('link')->nullable();
            $table->string('button_text', 100)->nullable();

            // ============================================
            // ترتیب و وضعیت
            // ============================================
            $table->integer('order_num')->default(0)
                  ->comment('ترتیب نمایش');
            $table->enum('status', ['active', 'inactive'])->default('active');

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();

            // ============================================
            // Indexes
            // ============================================
            $table->index('status');
            $table->index('order_num');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}
