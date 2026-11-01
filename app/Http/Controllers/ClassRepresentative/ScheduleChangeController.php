<?php

namespace App\Http\Controllers\ClassRepresentative;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomSchedule;
use App\Models\RoomScheduleException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ScheduleChangeController extends Controller
{
    /**
     * Menampilkan pengajuan perubahan jadwal milik Class Representative.
     */
    public function index()
    {
        $classIds = Auth::user()
            ->representedClasses()
            ->pluck('classes.id');

        $schedules = RoomSchedule::with([
            'room.building',
            'classRoom',
        ])
            ->whereIn('class_id', $classIds)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        $changes = RoomScheduleException::with([
            'schedule.room',
            'replacementRoom',
            'reviewer',
        ])
            ->whereHas('schedule', function ($query) use ($classIds) {
                $query->whereIn('class_id', $classIds);
            })
            ->latest()
            ->paginate(10);

        return view('class_representative.schedule_changes.index', compact(
            'schedules',
            'changes'
        ));
    }

    /**
     * Menampilkan form pengajuan perubahan.
     */
    public function create(RoomSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $rooms = Room::with('building')
            ->orderBy('room_name')
            ->get();

        return view('class_representative.schedule_changes.create', compact(
            'schedule',
            'rooms'
        ));
    }

    /**
     * Memastikan jadwal merupakan milik kelas yang ditangani user.
     */
    private function authorizeSchedule(RoomSchedule $schedule): void
    {
        $isAuthorized = Auth::user()
            ->representedClasses()
            ->where('classes.id', $schedule->class_id)
            ->exists();

        abort_unless($isAuthorized, 403);
    }

    /**
     * Menyimpan pengajuan perubahan jadwal.
     */
    public function store(Request $request, RoomSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $validated = $request->validate([
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

        // Tanggal perubahan harus sesuai dengan hari jadwal rutin.
        $requestedDay = strtolower(
            Carbon::parse($validated['exception_date'])->englishDayOfWeek
        );

        if ($requestedDay !== $schedule->day_of_week) {
            throw ValidationException::withMessages([
                'exception_date' => 'Tanggal perubahan harus sesuai dengan hari jadwal rutin kelas.',
            ]);
        }

        // Mencegah pengajuan ganda untuk jadwal dan tanggal yang sama.
        $alreadyRequested = RoomScheduleException::where(
            'room_schedule_id',
            $schedule->id
        )
            ->whereDate('exception_date', $validated['exception_date'])
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($alreadyRequested) {
            throw ValidationException::withMessages([
                'exception_date' => 'Sudah ada pengajuan perubahan untuk jadwal pada tanggal tersebut.',
            ]);
        }

        // Jika ada jadwal pengganti, pastikan waktu mulai dan selesai benar.
        if ($validated['type'] === 'rescheduled') {
            if ($validated['replacement_start_time'] >= $validated['replacement_end_time']) {
                throw ValidationException::withMessages([
                    'replacement_end_time' => 'Jam selesai harus setelah jam mulai.',
                ]);
            }
        }

        RoomScheduleException::create([
            'room_schedule_id' => $schedule->id,
            'exception_date' => $validated['exception_date'],
            'type' => $validated['type'],
            'reason' => $validated['reason'],
            'replacement_room_id' => $validated['replacement_room_id'] ?? null,
            'replacement_date' => $validated['replacement_date'] ?? null,
            'replacement_start_time' => $validated['replacement_start_time'] ?? null,
            'replacement_end_time' => $validated['replacement_end_time'] ?? null,
            'status' => 'pending',
            'requested_by' => Auth::id(),
        ]);

        return redirect()
            ->route('class-representative.schedule-changes.index')
            ->with('success', 'Pengajuan perubahan jadwal berhasil dikirim dan menunggu persetujuan Staff.');
    }
}
