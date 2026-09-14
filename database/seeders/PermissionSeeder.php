<?php
// database/seeders/PermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // پاک کردن کش نقش‌ها
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ============================================
        // ایجاد دسترسی‌ها (Permissions)
        // ============================================
        $permissions = [
            // مدیریت کاربران
            'users.view', 'users.create', 'users.edit', 'users.delete',

            // مدیریت شرکت‌ها
            'companies.view', 'companies.create', 'companies.edit', 'companies.delete',

            // مدیریت فروشندگان
            'sellers.view', 'sellers.create', 'sellers.edit', 'sellers.delete',

            // مدیریت محصولات
            'products.view', 'products.create', 'products.edit', 'products.delete',

            // مدیریت سفارشات
            'orders.view', 'orders.create', 'orders.edit', 'orders.delete',
            'orders.confirm', 'orders.cancel',

            // مدیریت قراردادها
            'contracts.view', 'contracts.create', 'contracts.edit', 'contracts.delete',
            'contracts.confirm',

            // مدیریت مالی
            'finance.view', 'finance.manage', 'finance.settle',

            // چت
            'chat.use',

            // محتوای سایت
            'content.view', 'content.manage',

            // تنظیمات
            'settings.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // ============================================
        // ایجاد نقش‌ها (Roles)
        // ============================================

        // ۱. مدیر کل - همه دسترسی‌ها
        $superAdmin = Role::firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'web']
        );
        $superAdmin->givePermissionTo(Permission::all());

        // ۲. مدیر
        $admin = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web']
        );
        $admin->givePermissionTo([
            'users.view', 'users.create', 'users.edit',
            'companies.view', 'companies.edit',
            'sellers.view', 'sellers.edit',
            'products.view',
            'orders.view', 'orders.confirm', 'orders.cancel',
            'contracts.view', 'contracts.confirm',
            'finance.view',
            'chat.use',
            'content.view', 'content.manage',
        ]);

        // ۳. ویرایشگر
        $editor = Role::firstOrCreate(
            ['name' => 'editor', 'guard_name' => 'web']
        );
        $editor->givePermissionTo([
            'content.view', 'content.manage',
            'products.view',
            'orders.view',
        ]);

        // ۴. مدیر شرکت
        $companyManager = Role::firstOrCreate(
            ['name' => 'company_manager', 'guard_name' => 'web']
        );
        $companyManager->givePermissionTo([
            'products.view', 'products.create', 'products.edit',
            'orders.view', 'orders.create', 'orders.edit', 'orders.confirm', 'orders.cancel',
            'contracts.view',
            'finance.view',
            'chat.use',
        ]);

        // ۵. ادمین شرکت
        $companyAdmin = Role::firstOrCreate(
            ['name' => 'company_admin', 'guard_name' => 'web']
        );
        $companyAdmin->givePermissionTo([
            'products.view',
            'orders.view', 'orders.create',
            'contracts.view',
            'finance.view',
            'chat.use',
        ]);

        // ۶. کاربر شرکت
        $companyUser = Role::firstOrCreate(
            ['name' => 'company_user', 'guard_name' => 'web']
        );
        $companyUser->givePermissionTo([
            'products.view',
            'orders.view',
        ]);

        // ۷. فروشنده
        $seller = Role::firstOrCreate(
            ['name' => 'seller', 'guard_name' => 'web']
        );
        $seller->givePermissionTo([
            'products.view', 'products.create', 'products.edit', 'products.delete',
            'orders.view', 'orders.create', 'orders.edit',
            'finance.view',
            'chat.use',
        ]);

        // ============================================
        // نمایش نتیجه
        // ============================================
        $this->command->info('✅ Roles created:');
        $this->command->info('  - super_admin (' . $superAdmin->permissions->count() . ' permissions)');
        $this->command->info('  - admin (' . $admin->permissions->count() . ' permissions)');
        $this->command->info('  - editor (' . $editor->permissions->count() . ' permissions)');
        $this->command->info('  - company_manager (' . $companyManager->permissions->count() . ' permissions)');
        $this->command->info('  - company_admin (' . $companyAdmin->permissions->count() . ' permissions)');
        $this->command->info('  - company_user (' . $companyUser->permissions->count() . ' permissions)');
        $this->command->info('  - seller (' . $seller->permissions->count() . ' permissions)');
        $this->command->info('');
        $this->command->info('✅ Total permissions: ' . Permission::count());
    }
}
