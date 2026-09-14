<?php
// app/Helpers/constants.php

// نقش‌های کاربری
define('ROLE_SUPER_ADMIN', 'super_admin');
define('ROLE_ADMIN', 'admin');
define('ROLE_EDITOR', 'editor');
define('ROLE_COMPANY_MANAGER', 'company_manager');
define('ROLE_COMPANY_ADMIN', 'company_admin');
define('ROLE_COMPANY_USER', 'company_user');
define('ROLE_SELLER', 'seller');

// وضعیت‌ها
define('STATUS_ACTIVE', 'active');
define('STATUS_INACTIVE', 'inactive');
define('STATUS_PENDING', 'pending');

// وضعیت سفارش
define('ORDER_PENDING', 'pending');
define('ORDER_CONFIRMED', 'confirmed');
define('ORDER_PROCESSING', 'processing');
define('ORDER_READY', 'ready');
define('ORDER_DELIVERED', 'delivered');
define('ORDER_CANCELLED', 'cancelled');

// وضعیت مالی
define('PAYMENT_PENDING', 'pending');
define('PAYMENT_PAID', 'paid');
define('PAYMENT_FAILED', 'failed');
define('PAYMENT_REFUNDED', 'refunded');

// وضعیت قرارداد
define('CONTRACT_DRAFT', 'draft');
define('CONTRACT_PENDING', 'pending');
define('CONTRACT_ACTIVE', 'active');
define('CONTRACT_EXPIRED', 'expired');
define('CONTRACT_TERMINATED', 'terminated');
