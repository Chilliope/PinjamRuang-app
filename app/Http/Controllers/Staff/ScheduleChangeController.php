<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Room;
use App\Models\RoomSchedule;
use App\Models\RoomScheduleException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ScheduleChangeController extends Controller
{
    /**
     * ID gedung yang menjadi tanggung jawab Staff.
     */
    private function buildingIds()
    {
        return Building::whereHas('staff', function ($query) {
            $query->where('users.id', Auth::id());
        })->pluck('id');
    }

    /**
     * Memastikan jadwal berasal dari gedung yang ditangani Staff.
     */
    private function authorizeException(RoomScheduleException $exception)
    {
        $buildingIds = $this->buildingIds();

        abort_unless(
            $buildingIds->contains($exception->schedule->room->building_id),
            403,
            'Kamu tidak memiliki akses ke jadwal ini.'
        );
    }

    /**
     * Daftar pengajuan perubahan jadwal.
     */
    public function index()
    {
        $buildingIds = $this->buildingIds();

        $changes = RoomScheduleException::with([
            'schedule.room.building',
            'schedule.classRoom',
            'replacementRoom',
            'requester',
            'reviewer',
        ])
            ->whereHas('schedule.room', function ($query) use ($buildingIds) {
                $query->whereIn('building_id', $buildingIds);
            })
            ->latest()
            ->paginate(10);

        return view('staff.schedule_changes.index', compact('changes'));
    }

    /**
     * Memeriksa ketersediaan ruangan pengganti.
     */
    private function checkReplacementAvailability(
        RoomScheduleException $exception,
        int $roomId,
        string $date,
        string $startTime,
        string $endTime
    ) {
        $weekday = Carbon::parse($date)->format('l');

        // Periksa jadwal rutin pada ruangan dan hari yang sama.
        // Jadwal yang sudah memiliki pengecualian approved pada tanggal
        // tersebut tidak lagi dianggap menggunakan ruangan.
        $scheduleConflict = RoomSchedule::where('room_id', $roomId)
            ->where('day_of_week', $weekday)
            ->where('id', '!=', $exception->room_schedule_id)
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->whereDoesntHave('exceptions', function ($query) use ($date) {
                $query->whereDate('exception_date', $date)
                    ->where('status', 'approved');
            })
            ->exists();

        if ($scheduleConflict) {
            throw ValidationException::withMessages([
                'replacement_room_id' =>
                'Ruangan pengganti sudah digunakan oleh jadwal rutin pada waktu tersebut.',
            ]);
        }

        // Periksa pengajuan lain yang sudah disetujui dan menggunakan
        // ruangan tersebut sebagai ruangan pengganti.
        $exceptionConflict = RoomScheduleException::where(
            'replacement_room_id',
            $roomId
        )
            ->whereDate('replacement_date', $date)
            ->where('status', 'approved')
            ->where('id', '!=', $exception->id)
            ->where('replacement_start_time', '<', $endTime)
            ->where('replacement_end_time', '>', $startTime)
            ->exists();

        if ($exceptionConflict) {
            throw ValidationException::withMessages([
                'replacement_room_id' =>
                'Ruangan sudah digunakan sebagai ruangan pengganti pada waktu tersebut.',
            ]);
        }

        // Periksa peminjaman ruangan yang sudah disetujui.
        $bookingConflict = DB::table('bookings')
            ->where('room_id', $roomId)
            ->whereDate('booking_date', $date)
            ->where('status', 'approved')
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->exists();

        if ($bookingConflict) {
            throw ValidationException::withMessages([
                'replacement_room_id' =>
                'Ruangan sudah memiliki peminjaman yang disetujui pada waktu tersebut.',
            ]);
        }
    }

    /**
     * Menyetujui pengajuan perubahan jadwal.
     */
    public function approve(RoomScheduleException $scheduleChange)
    {
        DB::transaction(function () use ($scheduleChange) {
            $exception = RoomScheduleException::with([
                'schedule.room',
            ])
                ->lockForUpdate()
                ->findOrFail($scheduleChange->id);

            $this->authorizeException($exception);

            if ($exception->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Pengajuan ini sudah pernah ditinjau.',
                ]);
            }

            if ($exception->type === 'rescheduled') {
                if (
                    !$exception->replacement_room_id ||
                    !$exception->replacement_date ||
                    !$exception->replacement_start_time ||
                    !$exception->replacement_end_time
                ) {
                    throw ValidationException::withMessages([
                        'replacement_room_id' =>
                        'Data ruangan atau waktu pengganti belum lengkap.',
                    ]);
                }

                $replacementRoom = Room::whereKey(
                    $exception->replacement_room_id
                )->lockForUpdate()->first();

                if (!$replacementRoom) {
                    throw ValidationException::withMessages([
                        'replacement_room_id' =>
                        'Ruangan pengganti tidak ditemukan atau sudah tidak aktif.',
                    ]);
                }

                $this->checkReplacementAvailability(
                    $exception,
                    $replacementRoom->id,
                    $exception->replacement_date->format('Y-m-d'),
                    $exception->replacement_start_time,
                    $exception->replacement_end_time
                );
            }

            $exception->update([
                'status' => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);
        });

        return redirect()
            ->route('staff.schedule-changes.index')
            ->with('success', 'Pengajuan perubahan jadwal berhasil disetujui.');
    }

    /**
     * Menolak pengajuan perubahan jadwal.
     */
    public function reject(RoomScheduleException $scheduleChange)
    {
        $exception = RoomScheduleException::with([
            'schedule.room',
        ])->findOrFail($scheduleChange->id);

        $this->authorizeException($exception);

        if ($exception->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah pernah ditinjau.');
        }

        $exception->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->route('staff.schedule-changes.index')
            ->with('success', 'Pengajuan perubahan jadwal berhasil ditolak.');
    }


    public function directCreate()
    {
        $buildingIds = $this->buildingIds();

        $schedules = RoomSchedule::with([
            'room.building',
            'classRoom',
        ])
            ->whereHas('room', function ($query) use ($buildingIds) {
                $query->whereIn('building_id', $buildingIds);
            })
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        $rooms = Room::with('building')
            ->whereIn('building_id', $buildingIds)
            ->orderBy('room_name')
            ->get();

        return view('staff.schedule_changes.create', compact(
            'schedules',
            'rooms'
        ));
    }


    public function directStore(Request $request)
    {
        $buildingIds = $this->buildingIds();

        $data = $request->validate([
            'room_schedule_id' => [
                'required',
                'integer',
                'exists:room_schedules,id',
            ],
            'exception_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'type' => [
                'required',
                Rule::in([
                    'online',
                    'postponed',
                    'cancelled',
                    'rescheduled',
                ]),
            ],
            'reason' => [
                'required',
                'string',
                'max:2000',
            ],
            'replacement_room_id' => [
                'nullable',
                'required_if:type,rescheduled',
                'integer',
                'exists:rooms,id',
            ],
            'replacement_date' => [
                'nullable',
                'required_if:type,rescheduled',
                'date',
                'after_or_equal:today',
            ],
            'replacement_start_time' => [
                'nullable',
                'required_if:type,rescheduled',
                'date_format:H:i',
            ],
            'replacement_end_time' => [
                'nullable',
                'required_if:type,rescheduled',
                'date_format:H:i',
                'after:replacement_start_time',
            ],
        ]);

        DB::transaction(function () use ($data, $buildingIds) {

            $schedule = RoomSchedule::with('room')
                ->whereHas('room', function ($query) use ($buildingIds) {
                    $query->whereIn('building_id', $buildingIds);
                })
                ->lockForUpdate()
                ->findOrFail($data['room_schedule_id']);

            // Pastikan tanggal sesuai hari jadwal rutin.
            $exceptionDate = Carbon::parse($data['exception_date']);

            if ($exceptionDate->format('l') !== $schedule->day_of_week) {
                throw ValidationException::withMessages([
                    'exception_date' =>
                    'Tanggal yang dipilih tidak sesuai dengan hari jadwal rutin.',
                ]);
            }

            // Cegah perubahan ganda pada tanggal yang sama.
            $duplicate = RoomScheduleException::where(
                'room_schedule_id',
                $schedule->id
            )
                ->whereDate('exception_date', $data['exception_date'])
                ->whereIn('status', ['pending', 'approved'])
                ->exists();

            if ($duplicate) {
                throw ValidationException::withMessages([
                    'exception_date' =>
                    'Sudah ada pengajuan atau perubahan untuk tanggal tersebut.',
                ]);
            }

            $replacementRoomId = null;
            $replacementDate = null;
            $replacementStart = null;
            $replacementEnd = null;

            if ($data['type'] === 'rescheduled') {

                $replacementRoom = Room::whereIn('building_id', $buildingIds)
                    ->find($data['replacement_room_id']);

                if (!$replacementRoom) {
                    throw ValidationException::withMessages([
                        'replacement_room_id' =>
                        'Ruangan pengganti tidak tersedia pada gedung yang kamu kelola.',
                    ]);
                }

                $replacementStart = $data['replacement_start_time'];
                $replacementEnd = $data['replacement_end_time'];
                $replacementDate = $data['replacement_date'];
                $replacementRoomId = $replacementRoom->id;

                // Periksa bentrok jadwal pengganti.
                $temporaryException = new RoomScheduleException([
                    'room_schedule_id' => $schedule->id,
                ]);

                $this->checkReplacementAvailability(
                    $temporaryException,
                    $replacementRoomId,
                    $replacementDate,
                    $replacementStart,
                    $replacementEnd
                );
            }

            // Simpan sebagai perubahan yang langsung disetujui.
            RoomScheduleException::create([
                'room_schedule_id' => $schedule->id,
                'exception_date' => $data['exception_date'],
                'type' => $data['type'],
                'reason' => $data['reason'],

                'replacement_room_id' => $replacementRoomId,
                'replacement_date' => $replacementDate,
                'replacement_start_time' => $replacementStart,
                'replacement_end_time' => $replacementEnd,

                'status' => 'approved',
                'requested_by' => Auth::id(),
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);
        });

        return redirect()
            ->route('staff.schedule-changes.index')
            ->with('success', 'Perubahan jadwal berhasil dibuat dan langsung disetujui.');
    }
}
