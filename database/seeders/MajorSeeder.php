<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $majors = [
            [
                "major" => "Teknik Sipil dan Kebumian"
            ],
            [
                "major" => "Teknik Mesin"
            ],
            [
                "major" => "Teknik Elektro"
            ],
            [
                "major" => "Akutansi"
            ],
            [
                "major" => "Administrasi Bisnis"
            ]
        ];

        foreach($majors as $major) {
            Major::create([
                "major" => $major['major']
            ]);
        }
    }
}
