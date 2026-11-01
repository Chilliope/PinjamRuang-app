<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClassClassrepSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar penugasan Class Representative
        $assignments = [
            'SI-2A' => [3],
        ];

        foreach ($assignments as $className => $userIds) {
            $class = ClassRoom::where('class_name', $className)->first();

            if (!$class) {
                $this->command->warn("Kelas {$className} tidak ditemukan.");
                continue;
            }

            foreach ($userIds as $userId) {
                $user = User::where('id', $userId)
                    ->where('role', 'class_representative')
                    ->first();

                if (!$user) {
                    $this->command->warn(
                        "User ID {$userId} bukan Class Representative atau tidak ditemukan."
                    );
                    continue;
                }

                $class->classRepresentatives()->syncWithoutDetaching([
                    $user->id,
                ]);
            }
        }

        $this->command->info('Penugasan Class Representative berhasil diproses.');
    }
}
