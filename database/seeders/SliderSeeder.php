<?php
// database/seeders/SliderSeeder.php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sliders = [
            [
                'title' => 'به بازار ساز خوش آمدید',
                'subtitle' => 'بهترین سازها با بهترین قیمت',
                'image' => 'slider-1.jpg',
                'link' => '/products',
                'button_text' => 'مشاهده محصولات',
                'order_num' => 1,
                'status' => 'active',
            ],
            [
                'title' => 'تجارت B2B ساز',
                'subtitle' => 'اتصال مستقیم شرکت‌ها و فروشندگان',
                'image' => 'slider-2.jpg',
                'link' => '/about',
                'button_text' => 'بیشتر بدانید',
                'order_num' => 2,
                'status' => 'active',
            ],
            [
                'title' => 'پرداخت امن',
                'subtitle' => 'با سیستم Escrow امن خرید کنید',
                'image' => 'slider-3.jpg',
                'link' => '/services',
                'button_text' => 'خدمات ما',
                'order_num' => 3,
                'status' => 'active',
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::updateOrCreate(
                ['title' => $slider['title']],
                $slider
            );
        }

        $this->command->info('✅ Sliders created: ' . count($sliders));
    }
}
