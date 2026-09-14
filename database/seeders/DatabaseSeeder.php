<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('');
        $this->command->info('🌱 شروع seed کردن دیتابیس...');
        $this->command->info('');

        // ترتیب مهم است!
        $this->call([
            PermissionSeeder::class,   // اول نقش‌ها
            AdminSeeder::class,        // بعد کاربر مدیر
            SiteSettingSeeder::class,  // تنظیمات سایت
            SitePageSeeder::class,     // صفحات سایت
            SliderSeeder::class,       // اسلایدر
        ]);

        $this->command->info('');
        $this->command->info('🎉 تمام Seeder ها با موفقیت اجرا شدند!');
        $this->command->info('');
    }
}
