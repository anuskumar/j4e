<?php

namespace Database\Seeders;

use App\Models\CustomerModel;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Seed default customer account.
     * Email: customer@j4e.com | Password: 12345678
     */
    public function run(): void
    {
        User::unguarded(function () {
            $user = User::updateOrCreate(
                ['email' => 'customer@j4e.com'],
                [
                    'name' => 'Customer',
                    'password' => '12345678',
                    'user_type' => 'customer',
                    'email_verified_at' => now(),
                    'email_added_at' => now(),
                    'is_active' => 1,
                ]
            );

            CustomerModel::updateOrCreate(
                ['user_id' => $user->id]
            );
        });
    }
}
