<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Major;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $major = Major::find(1);

        if (!$major) {
            $this->command->error('Program studi dengan ID 1 tidak ditemukan.');
            return;
        }

        $classes = [
            ['class_name' => 'SI-2A', 'semester' => 2],
            ['class_name' => 'SI-2B', 'semester' => 2],
            ['class_name' => 'SI-3A', 'semester' => 3],
            ['class_name' => 'SI-3B', 'semester' => 3],
            ['class_name' => 'SI-4A', 'semester' => 4],
            ['class_name' => 'SI-4B', 'semester' => 4],
        ];

        foreach ($classes as $class) {
            ClassRoom::firstOrCreate(
                [
                    'major_id' => $major->id,
                    'class_name' => $class['class_name'],
                ],
                [
                    'semester' => $class['semester'],
                ]
            );
        }

        $this->command->info('Data kelas berhasil dibuat.');
    }
}
