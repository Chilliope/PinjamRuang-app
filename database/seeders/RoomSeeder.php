<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            'H-101',
            'H-102',
            'H-103',
            'Lab RPL',
            'Lab Komdas',
            'Lab Jaringan Komputer',
            'H-201',
            'H-202',
            'H-203',
            'H-204',
            'H-205',
            'H-206',
        ];

        foreach ($rooms as $room) {
            Room::firstOrCreate([
                'building_id' => 8,
                'room_name' => $room,
            ]);
        }
    }
}
