<?php

namespace Database\Seeders;

use App\Models\MasterStandardEngineering;
use Illuminate\Database\Seeder;

class MasterStandardEngineeringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'engineering_code' => 'C001',
                'engineering_name' => 'gramasi glass',
                'engineering_unit' => 'percent',
            ],
            [
                'engineering_code' => 'C002',
                'engineering_name' => 'glass content',
                'engineering_unit' => 'percent',
            ],
            [
                'engineering_code' => 'C003',
                'engineering_name' => 'resin content',
                'engineering_unit' => 'mm',
            ],
            [
                'engineering_code' => 'C004',
                'engineering_name' => 'bj glass',
                'engineering_unit' => 'mm',
            ],
            [
                'engineering_code' => 'C005',
                'engineering_name' => 'Thickness Structure',
                'engineering_unit' => 'mm',
            ],
            [
                'engineering_code' => 'C006',
                'engineering_name' => 'Thickness liner',
                'engineering_unit' => 'mm',
            ],
            [
                'engineering_code' => 'C007',
                'engineering_name' => 'Top coat',
                'engineering_unit' => 'mm',
            ],
        ];

        foreach ($data as $item) {
            MasterStandardEngineering::updateOrCreate(
                ['engineering_code' => $item['engineering_code']], 
                $item
            );
        }
    }
}