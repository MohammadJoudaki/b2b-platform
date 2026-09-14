#!/bin/bash
# setup.sh - اسکریپت راه‌اندازی ساختار پروژه B2B

echo "🚀 ایجاد ساختار پروژه B2B..."

# ═══ App ═══
mkdir -p app/{Console/Commands,Events,Exceptions,Helpers,Policies,Providers,Services,Traits,Models}
mkdir -p app/Http/Controllers/{Auth,Frontend,Management,Company,Seller,Api}
mkdir -p app/Http/Middleware
mkdir -p app/Http/Requests/{Auth,Frontend,Management,Company,Seller}
mkdir -p app/Http/Resources
mkdir -p app/View/Components/{Frontend,Management,Company,Seller}

# ═══ Database ═══
mkdir -p database/{factories,migrations,seeders}

# ═══ Resources ═══
mkdir -p resources/views/layouts
mkdir -p resources/views/components/{frontend,management,company,seller,partials}
mkdir -p resources/views/frontend
mkdir -p resources/views/auth
mkdir -p resources/views/management/{dashboard,companies,sellers,contracts,orders,finance,chat,notifications,site-pages,site-settings,sliders,users}
mkdir -p resources/views/company/{dashboard,orders,products,sellers,contracts,finance,chat,notifications,profile}
mkdir -p resources/views/seller/{dashboard,products,categories,customers,orders,finance,chat,notifications,messages,profile}
mkdir -p resources/views/emails
mkdir -p resources/{css,js}

# ═══ Routes ═══
touch routes/frontend.php
touch routes/management.php
touch routes/company.php
touch routes/seller.php
touch routes/auth.php

# ═══ Lang ═══
mkdir -p lang/{fa,en}

# ═══ Public ═══
mkdir -p public/assets/{css,js,images}
mkdir -p public/assets/fonts/{Manrope,SpaceMono,Vazirmatn}
mkdir -p public/uploads/{products,companies,sellers,contracts,avatars,catalogs}

# ═══ Storage ═══
mkdir -p storage/app/public/{products,logos,contracts,avatars,catalogs}

# ═══ Tests ═══
mkdir -p tests/Feature/{Auth,Frontend,Management,Company,Seller,Api}
mkdir -p tests/Unit/{Services,Models,Helpers}

# ═══ Config ═══
touch config/b2b.php
touch config/roles.php

# ═══ Helpers ═══
touch app/Helpers/helpers.php
touch app/Helpers/constants.php

echo "✅ ساختار پروژه با موفقیت ایجاد شد!"
echo ""
echo "📋 مراحل بعدی:"
echo "1. composer dump-autoload"
echo "2. php artisan storage:link"
echo "3. محتوای فایل‌های Migration را اضافه کنید"
echo "4. php artisan migrate"
