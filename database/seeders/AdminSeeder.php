<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed default admin account.
     * Email: admin@j4e.com | Password: 12345678
     */
    public function run(): void
    {
        User::unguarded(function () {
            User::updateOrCreate(
                ['email' => 'admin@j4e.com'],
                [
                    'name' => 'Admin',
                    'password' => '12345678',
                    'user_type' => 'superadmin',
                    'email_verified_at' => now(),
                    'email_added_at' => now(),
                    'is_active' => 1,
                ]
            );
        });
    }
}
