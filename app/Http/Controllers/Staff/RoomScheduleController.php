<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Room;
use App\Models\RoomSchedule;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RoomScheduleController extends Controller
{
    private function buildingIds()
    {
        return Building::whereHas('staff', function ($query) {
            $query->where('users.id', Auth::id());
        })->pluck('id');
    }

    private function roomIds()
    {
        return Room::whereIn('building_id', $this->buildingIds())
            ->pluck('id');
    }

    private function authorizeSchedule(RoomSchedule $schedule): void
    {
        abort_unless(
            $this->roomIds()->contains($schedule->room_id),
            403
        );
    }


    private function validateSchedule(Request $request, ?RoomSchedule $schedule = null): array
    {
        $validated = $request->validate([
            'room_id' => [
                'required',
                'integer',
                Rule::in($this->roomIds()->all()),
            ],
            'class_id' => [
                'required',
                'integer',
                'exists:classes,id',
            ],
            'schedule_name' => [
                'required',
                'string',
                'max:255',
            ],
            'day_of_week' => [
                'required',
                Rule::in([
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                ]),
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
        ]);

        $overlap = RoomSchedule::where('room_id', $validated['room_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('start_time', '<', $validated['end_time'])
            ->where('end_time', '>', $validated['start_time']);

        if ($schedule) {
            $overlap->where('id', '!=', $schedule->id);
        }

        if ($overlap->exists()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'start_time' => 'Jadwal ruangan bertabrakan dengan jadwal lain pada hari dan jam tersebut.',
            ]);
        }

        return $validated;
    }


    public function index(Request $request)
    {
        $buildingIds = $this->buildingIds();

        $buildings = Building::whereIn('id', $buildingIds)
            ->orderBy('building_name')
            ->get();

        $rooms = Room::whereIn('building_id', $buildingIds)
            ->orderBy('room_name')
            ->get();

        $query = RoomSchedule::with(['room.building', 'classRoom'])
            ->whereIn('room_id', $this->roomIds());

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('schedule_name', 'like', "%{$search}%")
                    ->orWhereHas('room', function ($roomQuery) use ($search) {
                        $roomQuery->where('room_name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('building_id')) {
            $query->whereHas('room', function ($q) use ($request) {
                $q->where('building_id', $request->building_id);
            });
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        if ($request->filled('day_of_week')) {
            $query->where('day_of_week', $request->day_of_week);
        }

        $dayOrder = [
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday',
        ];

        $schedules = $query
            ->orderByRaw("FIELD(day_of_week, '" . implode("','", $dayOrder) . "')")
            ->orderBy('start_time')
            ->paginate(12)
            ->withQueryString();

        $totalSchedules = RoomSchedule::whereIn('room_id', $this->roomIds())
            ->count();

        return view('staff.schedule.index', compact(
            'schedules',
            'buildings',
            'rooms',
            'totalSchedules'
        ));
    }

    public function create()
    {
        $rooms = Room::with('building')
            ->whereIn('building_id', $this->buildingIds())
            ->orderBy('room_name')
            ->get();

        $classes = ClassRoom::with('major')
            ->orderBy('class_name')
            ->get();

        return view('staff.schedule.create', compact(
            'rooms',
            'classes'
        ));
    }

    public function store(Request $request)
    {
        $validated = $this->validateSchedule($request);

        RoomSchedule::create($validated);

        return redirect()
            ->route('staff.schedules.index')
            ->with('success', 'Jadwal ruangan berhasil ditambahkan.');
    }

    public function edit(RoomSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $rooms = Room::with('building')
            ->whereIn('building_id', $this->buildingIds())
            ->orderBy('room_name')
            ->get();

        $classes = ClassRoom::with('major')
            ->orderBy('class_name')
            ->get();

        return view('staff.schedule.edit', compact(
            'schedule',
            'rooms',
            'classes'
        ));
    }

    public function update(Request $request, RoomSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $validated = $this->validateSchedule($request, $schedule);

        $schedule->update($validated);

        return redirect()
            ->route('staff.schedules.index')
            ->with('success', 'Jadwal ruangan berhasil diperbarui.');
    }

    public function destroy(RoomSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $schedule->delete();

        return redirect()
            ->route('staff.schedules.index')
            ->with('success', 'Jadwal ruangan berhasil dihapus.');
    }
}
