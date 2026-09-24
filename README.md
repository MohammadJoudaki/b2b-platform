# 🎵 هامسان ساز بازار (Hamsan Saz Bazar)

پلتفرم تخصصی تجارت B2B 

---

## 📖 درباره پروژه

پلتفرم هامسان ساز بازار یک سیستم جامع برای اتصال شرکت‌ها، فروشندگان و مشتریان در حوزه تجارت B2B ساز و آلات موسیقی است.

### ✨ ویژگی‌های اصلی

- 🏢 **پنل شرکت**: مدیریت سفارشات، محصولات، قراردادها
- 🏪 **پنل فروشنده**: مدیریت محصولات، مشتریان، سفارشات
- 👨‍💼 **پنل مدیریت**: نظارت کامل بر سیستم
- 💰 **سیستم پرداخت Escrow**: پرداخت امن بین طرفین
- 💬 **سیستم چت**: ارتباط بین مدیران و فروشندگان
- 🔔 **سیستم اعلان‌ها**: اطلاع‌رسانی لحظه‌ای
- 📊 **داشبورد تحلیلی**: گزارش‌های دقیق
- 🌐 **دو زبانه**: فارسی و انگلیسی

---

## 🛠️ تکنولوژی‌ها

- **Backend**: Laravel 8.83, PHP 7.4+
- **Database**: MySQL 8.0
- **Frontend**: Blade, Bootstrap 5, Tailwind CDN
- **Authentication**: Laravel Breeze
- **Permissions**: Spatie Laravel Permission
- **Realtime**: Pusher (اختیاری)
- **Font**: Vazirmatn (محلی)

---

## 📦 نصب و راه‌اندازی

### پیش‌نیازها

- PHP >= 7.4
- Composer
- MySQL >= 5.7
- Node.js >= 14 (اختیاری)

### مراحل نصب

```bash
# 1. Clone پروژه
git clone https://github.com/mohammadjoudaki/b2b-platform.git
cd b2b-platform

# 2. نصب وابستگی‌های Composer
composer install

# 3. کپی فایل محیطی
cp .env.example .env

# 4. تولید APP_KEY
php artisan key:generate

# 5. تنظیم اطلاعات دیتابیس در .env
# DB_DATABASE=hamsansanat_laravel
# DB_USERNAME=root
# DB_PASSWORD=

# 6. ساخت دیتابیس در MySQL
# CREATE DATABASE hamsansanat_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# 7. اجرای Migration ها
php artisan migrate

# 8. اجرای Seeder ها
php artisan db:seed

# 9. ساخت لینک Storage
php artisan storage:link

# 10. اجرای سرور
php artisan serve
