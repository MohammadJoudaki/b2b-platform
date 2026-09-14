<?php
// database/seeders/SitePageSeeder.php

namespace Database\Seeders;

use App\Models\SitePage;
use Illuminate\Database\Seeder;

class SitePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'page_key' => 'home',
                'title' => 'صفحه اصلی',
                'content' => 'محتوای صفحه اصلی',
                'meta_title' => 'هامسان ساز بازار | صفحه اصلی',
                'meta_description' => 'بازار تخصصی خرید و فروش ساز و آلات موسیقی',
                'status' => 'active',
            ],
            [
                'page_key' => 'about',
                'title' => 'درباره ما',
                'content' => 'محتوای درباره ما',
                'meta_title' => 'درباره ما | هامسان ساز بازار',
                'meta_description' => 'درباره پلتفرم هامسان ساز بازار',
                'status' => 'active',
            ],
            [
                'page_key' => 'services',
                'title' => 'خدمات',
                'content' => 'محتوای خدمات',
                'meta_title' => 'خدمات | هامسان ساز بازار',
                'meta_description' => 'خدمات پلتفرم هامسان ساز بازار',
                'status' => 'active',
            ],
            [
                'page_key' => 'projects',
                'title' => 'پروژه‌ها',
                'content' => 'محتوای پروژه‌ها',
                'meta_title' => 'پروژه‌ها | هامسان ساز بازار',
                'meta_description' => 'پروژه‌های انجام شده',
                'status' => 'active',
            ],
            [
                'page_key' => 'blog',
                'title' => 'وبلاگ',
                'content' => 'محتوای وبلاگ',
                'meta_title' => 'وبلاگ | هامسان ساز بازار',
                'meta_description' => 'مقالات و اخبار موسیقی',
                'status' => 'active',
            ],
            [
                'page_key' => 'contact',
                'title' => 'تماس با ما',
                'content' => 'محتوای تماس با ما',
                'meta_title' => 'تماس با ما | هامسان ساز بازار',
                'meta_description' => 'راه‌های ارتباطی با ما',
                'status' => 'active',
            ],
        ];

        foreach ($pages as $page) {
            SitePage::updateOrCreate(
                ['page_key' => $page['page_key']],
                $page
            );
        }

        $this->command->info('✅ Site pages created: ' . count($pages));
    }
}
