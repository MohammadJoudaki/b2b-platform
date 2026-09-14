<?php
// database/seeders/SiteSettingSeeder.php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            // ============================================
            // اطلاعات سایت
            // ============================================
            [
                'setting_key' => 'site_title',
                'setting_value' => 'هامسان ساز بازار',
                'setting_type' => 'text',
                'description' => 'عنوان سایت',
            ],
            [
                'setting_key' => 'site_description',
                'setting_value' => 'بازار تخصصی ساز و آلات موسیقی',
                'setting_type' => 'textarea',
                'description' => 'توضیحات سایت',
            ],
            [
                'setting_key' => 'site_logo',
                'setting_value' => 'logo.png',
                'setting_type' => 'image',
                'description' => 'لوگوی سایت',
            ],

            // ============================================
            // اطلاعات تماس
            // ============================================
            [
                'setting_key' => 'contact_email',
                'setting_value' => 'info@hamsansaz.com',
                'setting_type' => 'text',
                'description' => 'ایمیل تماس',
            ],
            [
                'setting_key' => 'contact_phone',
                'setting_value' => '021-12345678',
                'setting_type' => 'text',
                'description' => 'شماره تماس',
            ],
            [
                'setting_key' => 'contact_address',
                'setting_value' => 'تهران، خیابان ...',
                'setting_type' => 'textarea',
                'description' => 'آدرس',
            ],

            // ============================================
            // شبکه‌های اجتماعی
            // ============================================
            [
                'setting_key' => 'social_instagram',
                'setting_value' => 'hamsansaz',
                'setting_type' => 'text',
                'description' => 'آیدی اینستاگرام',
            ],
            [
                'setting_key' => 'social_telegram',
                'setting_value' => 'hamsansaz',
                'setting_type' => 'text',
                'description' => 'آیدی تلگرام',
            ],
            [
                'setting_key' => 'social_whatsapp',
                'setting_value' => '09123456789',
                'setting_type' => 'text',
                'description' => 'شماره واتساپ',
            ],

            // ============================================
            // Hero
            // ============================================
            [
                'setting_key' => 'hero_title',
                'setting_value' => 'به بازار ساز خوش آمدید',
                'setting_type' => 'text',
                'description' => 'عنوان هیرو',
            ],
            [
                'setting_key' => 'hero_subtitle',
                'setting_value' => 'بهترین سازها با بهترین قیمت',
                'setting_type' => 'text',
                'description' => 'زیرعنوان هیرو',
            ],
            [
                'setting_key' => 'hero_image',
                'setting_value' => 'hero-banner.jpg',
                'setting_type' => 'image',
                'description' => 'تصویر هیرو',
            ],

            // ============================================
            // درباره ما
            // ============================================
            [
                'setting_key' => 'about_title',
                'setting_value' => 'درباره ما',
                'setting_type' => 'text',
                'description' => 'عنوان درباره ما',
            ],
            [
                'setting_key' => 'about_content',
                'setting_value' => 'هامسان ساز بازار یک پلتفرم تخصصی برای خرید و فروش ساز و آلات موسیقی است.',
                'setting_type' => 'textarea',
                'description' => 'محتوای درباره ما',
            ],

            // ============================================
            // تنظیمات مالی
            // ============================================
            [
                'setting_key' => 'default_commission',
                'setting_value' => '30',
                'setting_type' => 'text',
                'description' => 'درصد کمیسیون پیش‌فرض',
            ],
            [
                'setting_key' => 'tax_rate',
                'setting_value' => '9',
                'setting_type' => 'text',
                'description' => 'نرخ مالیات (درصد)',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['setting_key' => $setting['setting_key']],
                $setting
            );
        }

        $this->command->info('✅ Site settings created: ' . count($settings));
    }
}
