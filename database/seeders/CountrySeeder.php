<?php

namespace Database\Seeders;

use App\Models\CountryModel;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = require __DIR__.'/data/countries.php';

        foreach ($countries as $country) {
            CountryModel::withTrashed()->updateOrCreate(
                ['id' => $country['id']],
                [
                    'country_name' => $country['country_name'],
                    'country_code' => $country['country_code'],
                    'is_active' => 1,
                    'created_at' => $country['created_at'],
                    'updated_at' => $country['updated_at'],
                    'deleted_at' => $country['deleted_at'],
                ]
            );
        }
    }
}
