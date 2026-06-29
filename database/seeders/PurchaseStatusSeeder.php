<?php

namespace Database\Seeders;

use App\Models\PurchaseStatus;
use Illuminate\Database\Seeder;

class PurchaseStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['id' => 1, 'status_name' => 'New Order', 'description' => 'Payment received, awaiting processing', 'is_active' => 1],
            ['id' => 2, 'status_name' => 'Processing', 'description' => 'Order is being processed', 'is_active' => 1],
            ['id' => 3, 'status_name' => 'Cancelled', 'description' => 'Order was cancelled', 'is_active' => 1],
            ['id' => 4, 'status_name' => 'On Hold', 'description' => 'Order is on hold', 'is_active' => 1],
            ['id' => 5, 'status_name' => 'Shipped', 'description' => 'Tickets have been shipped', 'is_active' => 1],
            ['id' => 6, 'status_name' => 'Completed', 'description' => 'Order completed', 'is_active' => 1],
        ];

        foreach ($statuses as $status) {
            PurchaseStatus::updateOrCreate(
                ['id' => $status['id']],
                [
                    'status_name' => $status['status_name'],
                    'description' => $status['description'],
                    'is_active' => $status['is_active'],
                ]
            );
        }
    }
}
