<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Seed the default superadmin account (safe to re-run).
     */
    public function run(): void
    {
        $email = 'superadmin@j4e.local';
        $password = 'SuperAdmin#2026';

        $user = User::firstOrNew(['email' => $email]);
        $user->name = 'Super Admin';
        $user->password = $password;
        $user->user_type = 'superadmin';
        $user->email_verified_at = now();
        $user->is_active = 1;
        $user->save();
    }
}
