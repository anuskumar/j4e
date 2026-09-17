<?php

namespace Database\Seeders;

use App\Models\CityModel;
use App\Models\CountryModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Map our country names to names used in cities_by_country.json.
     */
    private array $nameAliases = [
        "cote d'ivoire (ivory coast)" => 'ivory coast',
        'east timor' => 'timor-leste',
        'gambia the' => 'the gambia',
        'guernsey and alderney' => 'guernsey',
        'macedonia' => 'north macedonia',
        'swaziland' => 'eswatini',
        'suricountry_name' => 'suriname',
    ];

    public function run(): void
    {
        $path = __DIR__.'/data/cities_by_country.json';

        if (! is_file($path)) {
            $this->command?->error('Missing cities data file: '.$path);

            return;
        }

        $countriesData = json_decode(file_get_contents($path), true);

        if (! is_array($countriesData)) {
            $this->command?->error('Invalid cities data file.');

            return;
        }

        $citiesByCountryName = [];
        foreach ($countriesData as $country) {
            $key = mb_strtolower(trim((string) ($country['name'] ?? '')));
            if ($key === '') {
                continue;
            }
            $citiesByCountryName[$key] = array_values(array_unique(array_filter(
                $country['cities'] ?? [],
                fn ($city) => is_string($city) && trim($city) !== ''
            )));
        }

        $countries = CountryModel::withTrashed()->get(['id', 'country_name']);
        $now = now();
        $inserted = 0;
        $skippedCountries = [];

        foreach ($countries as $country) {
            $lookup = mb_strtolower(trim((string) $country->country_name));
            $lookup = $this->nameAliases[$lookup] ?? $lookup;
            $cities = $citiesByCountryName[$lookup] ?? null;

            if ($cities === null) {
                $skippedCountries[] = $country->country_name;
                continue;
            }

            if ($cities === []) {
                continue;
            }

            $existing = CityModel::withTrashed()
                ->where('country_id', $country->id)
                ->pluck('name')
                ->map(fn ($name) => mb_strtolower(trim($name)))
                ->flip();

            $rows = [];
            foreach ($cities as $cityName) {
                $cityName = trim($cityName);
                $key = mb_strtolower($cityName);

                if (isset($existing[$key])) {
                    continue;
                }

                $existing[$key] = true;
                $rows[] = [
                    'name' => $cityName,
                    'country_id' => $country->id,
                    'is_active' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                if (count($rows) >= 500) {
                    DB::table('cities')->insert($rows);
                    $inserted += count($rows);
                    $rows = [];
                }
            }

            if ($rows !== []) {
                DB::table('cities')->insert($rows);
                $inserted += count($rows);
            }
        }

        $this->command?->info("Cities seeded: {$inserted} inserted.");

        if ($skippedCountries !== []) {
            $this->command?->warn('No city list matched for: '.implode(', ', $skippedCountries));
        }
    }
}
