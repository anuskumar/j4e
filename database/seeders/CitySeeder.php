<?php

namespace Database\Seeders;

use App\Models\CityModel;
use App\Models\CountryModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    /**
     * Seed cities per country: capitals from bundled RestCountries export, plus extra major cities.
     */
    public function run(): void
    {
        $path = database_path('data/restcountries_capitals.json');
        if (! File::exists($path)) {
            throw new \RuntimeException("Missing {$path}. Add database/data/restcountries_capitals.json.");
        }

        $rows = json_decode(File::get($path), true);
        if (! is_array($rows)) {
            throw new \RuntimeException("Invalid JSON in {$path}.");
        }

        $byCode = [];

        foreach ($rows as $row) {
            $code = $row['cca2'] ?? null;
            if (! $code) {
                continue;
            }

            $cities = [];
            if (! empty($row['capital']) && is_array($row['capital'])) {
                foreach ($row['capital'] as $c) {
                    if (is_string($c) && $c !== '') {
                        $cities[] = $c;
                    }
                }
            }
            if ($cities === []) {
                $common = $row['name']['common'] ?? null;
                if (is_string($common) && $common !== '') {
                    $cities[] = $common;
                }
            }

            $extras = self::additionalCities()[$code] ?? [];
            $byCode[$code] = array_values(array_unique(array_merge($cities, $extras)));
        }

        foreach (self::additionalCities() as $code => $extras) {
            if (! isset($byCode[$code])) {
                $byCode[$code] = array_values(array_unique($extras));
            }
        }

        foreach ($byCode as $countryCode => $cities) {
            $country = CountryModel::where('country_code', $countryCode)->first();
            if (! $country) {
                continue;
            }

            foreach ($cities as $cityName) {
                if (! is_string($cityName) || $cityName === '') {
                    continue;
                }

                CityModel::updateOrCreate(
                    [
                        'name' => $cityName,
                        'country_id' => $country->id,
                    ],
                    ['is_active' => 1]
                );
            }
        }
    }

    /**
     * Extra notable cities by ISO alpha-2 (merged after capitals; capitals stay first when unique).
     *
     * @return array<string, list<string>>
     */
    private static function additionalCities(): array
    {
        return [
            'US' => [
                'New York',
                'Los Angeles',
                'Chicago',
                'Houston',
                'Phoenix',
                'Miami',
                'Dallas',
                'San Francisco',
                'Seattle',
                'Boston',
            ],
            'GB' => [
                'Manchester',
                'Birmingham',
                'Leeds',
                'Liverpool',
                'Bristol',
                'Glasgow',
                'Edinburgh',
            ],
            'IN' => [
                'Mumbai',
                'Delhi',
                'Bangalore',
                'Hyderabad',
                'Chennai',
                'Kochi',
                'Kolkata',
                'Pune',
                'Ahmedabad',
                'Trivandrum',
            ],
            'CA' => [
                'Toronto',
                'Vancouver',
                'Montreal',
                'Calgary',
                'Ottawa',
                'Edmonton',
                'Winnipeg',
            ],
            'AU' => [
                'Sydney',
                'Melbourne',
                'Brisbane',
                'Perth',
                'Adelaide',
                'Canberra',
            ],
            'AE' => [
                'Dubai',
                'Abu Dhabi',
                'Sharjah',
                'Ajman',
                'Fujairah',
            ],
            'DE' => [
                'Berlin',
                'Munich',
                'Hamburg',
                'Frankfurt',
                'Cologne',
            ],
            'FR' => [
                'Paris',
                'Lyon',
                'Marseille',
                'Toulouse',
                'Nice',
            ],
            'IT' => [
                'Rome',
                'Milan',
                'Naples',
                'Turin',
                'Venice',
            ],
            'ES' => [
                'Madrid',
                'Barcelona',
                'Valencia',
                'Seville',
                'Bilbao',
            ],
            'SA' => [
                'Riyadh',
                'Jeddah',
                'Mecca',
                'Medina',
                'Dammam',
            ],
            'QA' => [
                'Doha',
                'Al Rayyan',
                'Umm Salal',
            ],
            'SG' => [
                'Singapore',
            ],
            'MY' => [
                'Kuala Lumpur',
                'George Town',
                'Johor Bahru',
                'Ipoh',
            ],
            'CN' => [
                'Beijing',
                'Shanghai',
                'Shenzhen',
                'Guangzhou',
                'Chengdu',
            ],
            'JP' => [
                'Tokyo',
                'Osaka',
                'Kyoto',
                'Nagoya',
                'Sapporo',
            ],
            'KR' => [
                'Seoul',
                'Busan',
                'Incheon',
                'Daegu',
            ],
            'RU' => [
                'Moscow',
                'Saint Petersburg',
                'Kazan',
                'Sochi',
            ],
            'BR' => [
                'Sao Paulo',
                'Rio de Janeiro',
                'Brasilia',
                'Salvador',
            ],
            'MX' => [
                'Mexico City',
                'Guadalajara',
                'Monterrey',
                'Cancun',
            ],
            'ZA' => [
                'Cape Town',
                'Johannesburg',
                'Durban',
                'Pretoria',
            ],
            'EG' => [
                'Cairo',
                'Alexandria',
                'Giza',
            ],
            'TH' => [
                'Bangkok',
                'Chiang Mai',
                'Pattaya',
                'Phuket',
            ],
            'TR' => [
                'Istanbul',
                'Ankara',
                'Izmir',
                'Bursa',
            ],
            'NP' => [
                'Kathmandu',
                'Pokhara',
                'Lalitpur',
            ],
            'LK' => [
                'Colombo',
                'Kandy',
                'Galle',
                'Jaffna',
            ],
            'PK' => [
                'Karachi',
                'Lahore',
                'Islamabad',
                'Peshawar',
            ],
            'BD' => [
                'Dhaka',
                'Chittagong',
                'Khulna',
            ],
        ];
    }
}
