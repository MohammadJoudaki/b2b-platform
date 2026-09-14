<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_site_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // ============================================
            // اطلاعات اصلی
            // ============================================
            $table->string('setting_key', 100)->unique();
            $table->text('setting_value')->nullable();

            $table->enum('setting_type', [
                'text', 'textarea', 'image', 'json'
            ])->default('text');

            $table->string('description')->nullable();

            // ============================================
            // Timestamps
            // ============================================
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_settings');
    }
}
