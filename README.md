# ?? åÇãÓÇä ÓÇÒ ÈÇÒÇÑ (Hamsan Saz Bazar)

áÊİÑã ÊÎÕÕí ÊÌÇÑÊ B2B 

---

## ?? ÏÑÈÇÑå Ñæå

áÊİÑã åÇãÓÇä ÓÇÒ ÈÇÒÇÑ í˜ ÓíÓÊã ÌÇãÚ ÈÑÇí ÇÊÕÇá ÔÑ˜ÊåÇ¡ İÑæÔäÏÇä æ ãÔÊÑíÇä ÏÑ ÍæÒå ÊÌÇÑÊ B2B 
### ? æííåÇí ÇÕáí

- ?? **äá ÔÑ˜Ê**: ãÏíÑíÊ ÓİÇÑÔÇÊ¡ ãÍÕæáÇÊ¡ ŞÑÇÑÏÇÏåÇ
- ?? **äá İÑæÔäÏå**: ãÏíÑíÊ ãÍÕæáÇÊ¡ ãÔÊÑíÇä¡ ÓİÇÑÔÇÊ
- ???? **äá ãÏíÑíÊ**: äÙÇÑÊ ˜Çãá ÈÑ ÓíÓÊã
- ?? **ÓíÓÊã ÑÏÇÎÊ Escrow**: ÑÏÇÎÊ Çãä Èíä ØÑİíä
- ?? **ÓíÓÊã Ê**: ÇÑÊÈÇØ Èíä ãÏíÑÇä æ İÑæÔäÏÇä
- ?? **ÓíÓÊã ÇÚáÇäåÇ**: ÇØáÇÚÑÓÇäí áÍÙåÇí
- ?? **ÏÇÔÈæÑÏ ÊÍáíáí**: ÒÇÑÔåÇí ÏŞíŞ
- ?? **Ïæ ÒÈÇäå**: İÇÑÓí æ ÇäáíÓí

---

## ??? Ê˜äæáæíåÇ

- **Backend**: Laravel 8.83, PHP 7.4+
- **Database**: MySQL 8.0
- **Frontend**: Blade, Bootstrap, Tailwind CDN
- **Authentication**: Breeze
- **Permissions**: Spatie Laravel Permission
- **Realtime**: Pusher (ÇÎÊíÇÑí)

---

## ?? äÕÈ æ ÑÇåÇäÏÇÒí

### íÔäíÇÒåÇ

- PHP >= 7.4
- Composer
- MySQL >= 5.7
- Node.js >= 14 (ÇÎÊíÇÑí)

### ãÑÇÍá äÕÈ

```bash
# 1. Clone Ñæå
git clone https://github.com/mohammadjoudaki/b2b-platform.git
cd b2b-platform

# 2. äÕÈ æÇÈÓÊíåÇí Composer
composer install

# 3. ˜í İÇíá ãÍíØí
cp .env.example .env

# 4. ÊæáíÏ APP_KEY
php artisan key:generate

# 5. ÊäÙíã ÇØáÇÚÇÊ ÏíÊÇÈíÓ ÏÑ .env
# DB_DATABASE=hamsansanat_laravel
# DB_USERNAME=root
# DB_PASSWORD=

# 6. ÓÇÎÊ ÏíÊÇÈíÓ ÏÑ MySQL
# CREATE DATABASE hamsansanat_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# 7. ÇÌÑÇí Migration åÇ
php artisan migrate

# 8. ÇÌÑÇí Seeder åÇ
php artisan db:seed

# 9. ÓÇÎÊ áíä˜ Storage
php artisan storage:link

# 10. ÇÌÑÇí ÓÑæÑ
php artisan serve