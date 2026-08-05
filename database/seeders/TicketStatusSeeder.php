<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'id' => 1,
                'status_name' => 'Active',
                'is_active' => 1,
            ],
            [
                'id' => 2,
                'status_name' => 'Posted',
                'is_active' => 1,
            ],
            [
                'id' => 3,
                'status_name' => 'Unapproved',
                'is_active' => 1,
            ],
            [
                'id' => 4,
                'status_name' => 'Sold',
                'is_active' => 1,
            ],
            [
                'id' => 5,
                'status_name' => 'Pending',
                'is_active' => 1,
            ],
        ];

        foreach ($statuses as $status) {
            TicketStatus::updateOrCreate(
                ['id' => $status['id']],
                [
                    'status_name' => $status['status_name'],
                    'is_active' => $status['is_active'],
                ]
            );
        }
    }
}
