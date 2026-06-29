<?php

namespace Database\Seeders;

use App\Models\TicketType;
use Illuminate\Database\Seeder;

class TicketTypeSeeder extends Seeder
{
    public function run(): void
    {
        $ticketTypes = [
            [
                'id' => 1,
                'ticket_type_name' => 'Paper Tickets',
                'description' => 'Printed tickets, not in electronic format',
                'is_active' => 1,
            ],
            [
                'id' => 2,
                'ticket_type_name' => 'E-Tickets',
                'description' => 'Electronic tickets in PDF format',
                'is_active' => 1,
            ],
            [
                'id' => 3,
                'ticket_type_name' => 'Mobile QR Code',
                'description' => 'Your ticket is a QR Code on your mobile phone.',
                'is_active' => 1,
            ],
            [
                'id' => 4,
                'ticket_type_name' => 'Mobile Ticket Transfer',
                'description' => 'You will need to transfer the tickets via the ticket provider.',
                'is_active' => 1,
            ],
        ];

        foreach ($ticketTypes as $type) {
            TicketType::withTrashed()->updateOrCreate(
                ['id' => $type['id']],
                [
                    'ticket_type_name' => $type['ticket_type_name'],
                    'description' => $type['description'],
                    'is_active' => $type['is_active'],
                    'deleted_at' => null,
                ]
            );
        }
    }
}
