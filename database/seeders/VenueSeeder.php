<?php

namespace Database\Seeders;

use App\Models\CityModel;
use App\Models\CountryModel;
use App\Models\LocationModel;
use App\Models\VenueModel;
use App\Models\VenueType;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        $country = CountryModel::firstOrCreate(
            ['country_name' => 'United Kingdom'],
            [
                'country_code' => 'GB',
                'is_active' => 1,
            ]
        );

        $city = CityModel::firstOrCreate(
            [
                'name' => 'London',
                'country_id' => $country->id,
            ],
            ['is_active' => 1]
        );

        $venues = [
            ['name' => 'Wembley Stadium', 'location' => 'Wembley, London', 'type' => 'Stadium'],
            ['name' => 'O2 Arena', 'location' => 'Greenwich, London', 'type' => 'Arena'],
            ['name' => 'Royal Albert Hall', 'location' => 'South Kensington, London', 'type' => 'Concert Hall'],
            ['name' => 'Apollo Theater', 'location' => 'Hammersmith, London', 'type' => 'Theater'],
            ['name' => 'Fabric Nightclub', 'location' => 'Farringdon, London', 'type' => 'Nightclub'],
            ['name' => 'Hyde Park', 'location' => 'Westminster, London', 'type' => 'Outdoor Park'],
            ['name' => 'ExCeL London', 'location' => 'Royal Docks, London', 'type' => 'Convention Center'],
            ['name' => 'Barbican Centre', 'location' => 'City of London', 'type' => 'Auditorium'],
            ['name' => 'Grosvenor House Ballroom', 'location' => 'Mayfair, London', 'type' => 'Ballroom'],
            ['name' => 'Victoria Park', 'location' => 'Tower Hamlets, London', 'type' => 'Festival Ground'],
        ];

        foreach ($venues as $venueData) {
            $venueType = VenueType::where('venue_type_name', $venueData['type'])->first();

            if (!$venueType) {
                continue;
            }

            $location = LocationModel::updateOrCreate(
                ['location_name' => $venueData['location']],
                [
                    'country' => $country->id,
                    'city' => $city->id,
                    'address' => $venueData['location'],
                    'is_active' => 1,
                ]
            );

            VenueModel::updateOrCreate(
                ['name' => $venueData['name']],
                [
                    'location' => $location->id,
                    'venue_type' => $venueType->id,
                    'is_active' => 1,
                ]
            );
        }
    }
}
