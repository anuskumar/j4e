<?php

namespace Database\Seeders;

use App\Models\CountryModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    /**
     * Seed all ISO 3166-1 alpha-2 countries from bundled JSON (official slim list).
     */
    public function run(): void
    {
        $path = database_path('data/iso3166_slim2.json');
        if (! File::exists($path)) {
            throw new \RuntimeException("Missing {$path}. Add database/data/iso3166_slim2.json (ISO 3166 slim-2 export).");
        }

        $rows = json_decode(File::get($path), true);
        if (! is_array($rows)) {
            throw new \RuntimeException("Invalid JSON in {$path}.");
        }

        foreach ($rows as $row) {
            $code = $row['alpha-2'] ?? null;
            $name = $row['name'] ?? null;
            if (! $code || ! $name) {
                continue;
            }

            CountryModel::updateOrCreate(
                ['country_code' => $code],
                [
                    'country_name' => $name,
                    'is_active' => 1,
                ]
            );
        }
    }
}
