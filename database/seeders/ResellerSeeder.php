<?php

namespace Database\Seeders;

use App\Models\ResellerModel;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResellerSeeder extends Seeder
{
    /**
     * Seed default reseller account.
     * Email: reseller@j4e.com | Password: 12345678
     */
    public function run(): void
    {
        User::unguarded(function () {
            $user = User::updateOrCreate(
                ['email' => 'reseller@j4e.com'],
                [
                    'name' => 'Reseller',
                    'password' => '12345678',
                    'user_type' => 'reseller',
                    'email_verified_at' => now(),
                    'email_added_at' => now(),
                    'is_active' => 1,
                ]
            );

            ResellerModel::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'is_admin_approved' => 1,
                    'is_trusted' => 0,
                ]
            );
        });
    }
}
