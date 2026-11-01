<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Mengambil ID gedung yang ditugaskan kepada Staff.
     */
    private function buildingIds()
    {
        return Building::whereHas('staff', function ($query) {
            $query->where('users.id', Auth::id());
        })->pluck('id');
    }

    public function index(Request $request)
    {
        $buildingIds = $this->buildingIds();

        $buildings = Building::whereIn('id', $buildingIds)
            ->orderBy('building_name')
            ->get();

        $query = Room::with('building')
            ->whereIn('building_id', $buildingIds);

        if ($request->filled('search')) {
            $query->where(
                'room_name',
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->filled('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        $rooms = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $totalRooms = Room::whereIn('building_id', $buildingIds)
            ->count();

        return view('staff.room.index', compact(
            'rooms',
            'buildings',
            'totalRooms'
        ));
    }

    public function create()
    {
        $buildings = Building::whereIn('id', $this->buildingIds())
            ->orderBy('building_name')
            ->get();

        return view('staff.room.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $buildingIds = $this->buildingIds();

        $validated = $request->validate([
            'room_name' => ['required', 'string', 'max:255'],
            'building_id' => [
                'required',
                'integer',
                Rule::in($buildingIds->all()),
            ],
        ]);

        Room::create($validated);

        return redirect()
            ->route('staff.rooms.index')
            ->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        abort_unless(
            $this->buildingIds()->contains($room->building_id),
            403
        );

        $buildings = Building::whereIn('id', $this->buildingIds())
            ->orderBy('building_name')
            ->get();

        return view('staff.room.edit', compact('room', 'buildings'));
    }

    public function update(Request $request, Room $room)
    {
        abort_unless(
            $this->buildingIds()->contains($room->building_id),
            403
        );

        $buildingIds = $this->buildingIds();

        $validated = $request->validate([
            'room_name' => ['required', 'string', 'max:255'],
            'building_id' => [
                'required',
                'integer',
                Rule::in($buildingIds->all()),
            ],
        ]);

        $room->update($validated);

        return redirect()
            ->route('staff.rooms.index')
            ->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        abort_unless(
            $this->buildingIds()->contains($room->building_id),
            403
        );

        $room->delete();

        return redirect()
            ->route('staff.rooms.index')
            ->with('success', 'Ruangan berhasil dihapus.');
    }
}
