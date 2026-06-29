<?php

namespace Database\Seeders;

use App\Models\SplitTypeModel;
use Illuminate\Database\Seeder;

class SplitTypeSeeder extends Seeder
{
    public function run(): void
    {
        $splitTypes = [
            [
                'id' => 1,
                'split_name' => 'Any',
                'is_active' => 1,
            ],
            [
                'id' => 2,
                'split_name' => 'None',
                'is_active' => 1,
            ],
            [
                'id' => 3,
                'split_name' => 'Avoid leaving one ticket',
                'is_active' => 1,
            ],
            [
                'id' => 4,
                'split_name' => 'Avoid leaving one or three tickets',
                'is_active' => 1,
            ],
            [
                'id' => 5,
                'split_name' => 'Avoid leaving odd numbers',
                'is_active' => 1,
            ],
        ];

        foreach ($splitTypes as $type) {
            SplitTypeModel::withTrashed()->updateOrCreate(
                ['id' => $type['id']],
                [
                    'split_name' => $type['split_name'],
                    'is_active' => $type['is_active'],
                    'deleted_at' => null,
                ]
            );
        }
    }
}
