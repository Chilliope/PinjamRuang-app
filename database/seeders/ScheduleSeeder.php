<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomSchedule;
use App\Models\ClassRoom;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $class = ClassRoom::where('class_name', 'SI-2A')->first();

        if (!$class) {
            $this->command->warn('Kelas SI-2A belum tersedia.');
            return;
        }

        $schedules = [
            'H-101' => [
                ['Pemrograman Web', 'monday', '08:00', '10:00'],
                ['Basis Data', 'wednesday', '10:00', '12:00'],
                ['Sistem Informasi', 'friday', '13:00', '15:00'],
            ],

            'H-102' => [
                ['Algoritma dan Pemrograman', 'monday', '10:00', '12:00'],
                ['Matematika Diskrit', 'tuesday', '08:00', '10:00'],
            ],

            'H-103' => [
                ['Pengantar Sistem Informasi', 'tuesday', '10:00', '12:00'],
                ['Statistika', 'wednesday', '08:00', '10:00'],
            ],

            'Lab RPL' => [
                ['Praktikum Pemrograman Web', 'monday', '13:00', '15:00'],
                ['Praktikum Pemrograman Mobile', 'friday', '10:00', '12:00'],
            ],

            'Lab Komdas' => [
                ['Praktikum Sistem Komputer', 'tuesday', '13:00', '15:00'],
            ],

            'Lab Jaringan Komputer' => [
                ['Praktikum Administrasi Jaringan', 'monday', '08:00', '10:00'],
                ['Praktikum Jaringan Komputer', 'wednesday', '10:00', '12:00'],
            ],

            'H-201' => [
                ['Pemrograman Berorientasi Objek', 'monday', '10:00', '12:00'],
                ['Analisis dan Perancangan Sistem', 'tuesday', '08:00', '10:00'],
            ],

            'H-202' => [
                ['Interaksi Manusia dan Komputer', 'tuesday', '10:00', '12:00'],
            ],

            'H-203' => [
                ['Sistem Basis Data', 'wednesday', '08:00', '10:00'],
            ],

            'H-204' => [
                ['Sistem Operasi', 'monday', '13:00', '15:00'],
            ],

            'H-205' => [
                ['Jaringan Komputer', 'tuesday', '13:00', '15:00'],
            ],

            'H-206' => [
                ['Manajemen Data', 'thursday', '08:00', '10:00'],
            ],
        ];

        foreach ($schedules as $roomName => $roomSchedules) {
            $room = Room::where('building_id', 8)
                ->where('room_name', $roomName)
                ->first();

            if (!$room) {
                $this->command->warn("Ruangan {$roomName} tidak ditemukan.");
                continue;
            }

            foreach ($roomSchedules as [$name, $day, $start, $end]) {
                RoomSchedule::updateOrCreate(
                    [
                        'room_id' => $room->id,
                        'day_of_week' => $day,
                        'start_time' => $start,
                        'end_time' => $end,
                    ],
                    [
                        'class_id' => $class->id,
                        'schedule_name' => $name,
                    ]
                );
            }
        }

        $this->command->info('ScheduleSeeder berhasil dijalankan.');
    }
}
