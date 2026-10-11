<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        $buildings = [
            // Teknik Sipil dan Kebumian
            [
                'building_name' => 'Gedung G',
                'major_ids' => [1],
            ],
            [
                'building_name' => 'Gedung I',
                'major_ids' => [1],
            ],
            [
                'building_name' => 'Gedung M',
                'major_ids' => [1],
            ],
            [
                'building_name' => 'Gedung N',
                'major_ids' => [1],
            ],

            // Teknik Mesin
            [
                'building_name' => 'Gedung C',
                'major_ids' => [2],
            ],
            [
                'building_name' => 'Gedung J',
                'major_ids' => [2],
            ],
            [
                'building_name' => 'Gedung P',
                'major_ids' => [2],
            ],

            // Teknik Elektro
            [
                'building_name' => 'Gedung H',
                'major_ids' => [3],
            ],
            [
                'building_name' => 'Gedung L',
                'major_ids' => [3],
            ],
            [
                'building_name' => 'Gedung K',
                'major_ids' => [3],
            ],

            // Administrasi Bisnis
            [
                'building_name' => 'Gedung U',
                'major_ids' => [4],
            ],

            // Akuntansi
            [
                'building_name' => 'Gedung F',
                'major_ids' => [5],
            ],
            [
                'building_name' => 'Gedung E',
                'major_ids' => [5],
            ],

            // Universal
            [
                'building_name' => 'Gedung Akademik',
                'major_ids' => [],
            ],
            [
                'building_name' => 'Gedung Serba Guna',
                'major_ids' => [],
            ],
        ];

        foreach ($buildings as $data) {
            $building = Building::create([
                'building_name' => $data['building_name'],
                'deleted_at' => null
            ]);

            $building->majors()->sync($data['major_ids']);
        }
    }
}
