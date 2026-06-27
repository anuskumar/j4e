<?php

namespace Database\Seeders;

use App\Models\VenueType;
use Illuminate\Database\Seeder;

class VenueTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Stadium',
            'Arena',
            'Theater',
            'Concert Hall',
            'Nightclub',
            'Outdoor Park',
            'Convention Center',
            'Auditorium',
            'Ballroom',
            'Festival Ground',
        ];

        foreach ($types as $typeName) {
            VenueType::updateOrCreate(
                ['venue_type_name' => $typeName],
                ['is_active' => 1]
            );
        }
    }
}
