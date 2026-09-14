<?php
// config/b2b.php

return [
    'app_name' => env('B2B_APP_NAME', 'هامسان ساز بازار'),

    // کمیسیون پیش‌فرض
    'default_commission' => 30.0, // درصد

    // کدهای یکتا
    'unique_code_prefix' => 'HSC',
    'unique_code_length' => 10,

    // انواع قرارداد
    'contract_types' => [
        'sales' => 'فروش',
        'distribution' => 'توزیع',
        'agency' => 'نمایندگی',
        'partnership' => 'مشارکت',
        'custom' => 'سفارشی',
    ],

    // واحدهای اندازه‌گیری
    'unit_types' => [
        'عدد', 'کیلوگرم', 'متر', 'لیتر',
        'گرم', 'بسته', 'جعبه', 'تن',
        'مترمربع', 'مترمکعب', 'سایر'
    ],

    // تنظیمات چت
    'chat' => [
        'presence_timeout' => 60, // ثانیه
        'messages_per_page' => 50,
        'typing_timeout' => 3, // ثانیه
    ],

    // تنظیمات مالی
    'finance' => [
        'currency' => 'IRR',
        'currency_symbol' => 'تومان',
        'escrow_enabled' => true,
        'tax_rate' => 9, // درصد
    ],

    // آپلود
    'uploads' => [
        'product_image_max_size' => 2048, // KB
        'catalog_max_size' => 10240, // KB
        'allowed_image_types' => ['jpg', 'jpeg', 'png', 'webp'],
        'allowed_doc_types' => ['pdf', 'doc', 'docx'],
    ],
];
