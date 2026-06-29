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
                'status_name' => 'Available',
                'is_active' => 1,
            ],
            [
                'id' => 2,
                'status_name' => 'Not Available',
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
