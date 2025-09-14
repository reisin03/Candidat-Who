<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create a super admin if one doesn't exist
        $superAdmin = Admin::where('email', 'superadmin@candidatwho.com')->first();

        if (!$superAdmin) {
            Admin::create([
                'name' => 'Super Administrator',
                'email' => 'superadmin@candidatwho.com',
                'password' => Hash::make('SuperAdmin123!'),
                'verification_status' => 'approved',
                'verification_notes' => 'Auto-created super admin account',
                'is_super_admin' => true,
                'verified_at' => now(),
                'verified_by' => null, // Self-verified as the first super admin
                'profile_picture' => null,
                'id_document' => null,
            ]);

            $this->command->info('🎉 Super Admin created successfully!');
            $this->command->info('📧 Email: superadmin@candidatwho.com');
            $this->command->info('🔒 Password: SuperAdmin123!');
            $this->command->info('⭐ This account has full super admin privileges');
            $this->command->warn('⚠️  Please change the default password after first login!');
        } else {
            $this->command->info('ℹ️  Super Admin already exists.');
            $this->command->info('📧 Email: superadmin@candidatwho.com');
        }
    }
}
