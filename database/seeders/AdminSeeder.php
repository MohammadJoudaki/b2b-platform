<?php
// database/seeders/AdminSeeder.php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ============================================
        // ایجاد کاربر مدیر کل
        // ============================================
        $user = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'unique_code' => 'HSC-ADMIN0001',
                'full_name' => 'مدیر اصلی سیستم',
                'email' => 'admin@hamsansaz.com',
                'phone' => '09120000000',
                'password' => Hash::make('admin123'),
                'role' => 'super_admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // ============================================
        // ایجاد رکورد Admin
        // ============================================
        $admin = Admin::firstOrCreate(
            ['user_id' => $user->id],
            [
                'admin_level' => 'super_admin',
                'permissions' => json_encode(['*']),
            ]
        );

        // ============================================
        // اختصاص نقش Spatie
        // ============================================
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole && !$user->hasRole('super_admin')) {
            $user->assignRole($superAdminRole);
        }

        // ============================================
        // نمایش اطلاعات
        // ============================================
        $this->command->info('');
        $this->command->info('✅ Admin user created:');
        $this->command->info('   Username: admin');
        $this->command->info('   Password: admin123');
        $this->command->info('   Email:    admin@hamsansaz.com');
        $this->command->info('');
        $this->command->warn('⚠️  لطفاً در اولین ورود رمز را تغییر دهید!');
    }
}
