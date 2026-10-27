<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Cari akun Class Representative yang sudah tersedia.
        $representative = User::where(
            'role',
            'class_representative'
        )->first();

        // Ambil salah satu ruangan yang tersedia.
        $room = Room::query()->first();

        if (! $representative || ! $room) {
            $this->command->warn(
                'Seeder dibatalkan: akun Class Representative atau ruangan belum tersedia.'
            );

            return;
        }

        // Cari Staff yang ditugaskan pada gedung ruangan tersebut.
        $staffId = User::where('role', 'staff')
            ->whereHas('buildings', function ($query) use ($room) {
                $query->where('buildings.id', $room->building_id);
            })
            ->value('id');

        $today = Carbon::today();

        $samples = [
            [
                'days' => 1,
                'start' => '08:00:00',
                'end' => '10:00:00',
                'purpose' => 'Diskusi kelompok mahasiswa',
                'status' => 'pending',
            ],
            [
                'days' => 2,
                'start' => '10:00:00',
                'end' => '12:00:00',
                'purpose' => 'Kegiatan belajar bersama',
                'status' => 'approved',
            ],
            [
                'days' => 3,
                'start' => '13:00:00',
                'end' => '15:00:00',
                'purpose' => 'Kegiatan organisasi kelas',
                'status' => 'rejected',
            ],
            [
                'days' => 4,
                'start' => '08:00:00',
                'end' => '09:00:00',
                'purpose' => 'Contoh pengajuan yang dibatalkan',
                'status' => 'cancelled',
            ],
        ];

        foreach ($samples as $sample) {
            $date = $today->copy()
                ->addDays($sample['days'])
                ->toDateString();

            $processed = in_array(
                $sample['status'],
                ['approved', 'rejected']
            );

            Booking::firstOrCreate(
                [
                    'user_id' => $representative->id,
                    'room_id' => $room->id,
                    'booking_date' => $date,
                    'start_time' => $sample['start'],
                    'end_time' => $sample['end'],
                ],
                [
                    'purpose' => $sample['purpose'],
                    'status' => $sample['status'],
                    'reviewed_by' => $processed ? $staffId : null,
                    'reviewed_at' => $processed ? now() : null,
                    'rejection_reason' => $sample['status'] === 'rejected'
                        ? 'Ruangan tidak dapat digunakan pada jadwal tersebut.'
                        : null,
                ]
            );
        }

        $this->command->info(
            'Seeder peminjaman selesai diproses.'
        );
    }
}
