<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->query('search');
        $selectedBuilding = $request->query('building_id');

        $buildings = Building::orderBy('building_name')->get();

        $query = Room::with('building');

        // Cari berdasarkan nama ruangan
        if ($search) {
            $query->where('room_name', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan gedung
        if ($selectedBuilding) {
            $query->where('building_id', $selectedBuilding);
        }

        $rooms = $query->latest()->paginate(10)->withQueryString();

        $totalRooms = Room::count();

        return view('admin.room.index', compact(
            'rooms',
            'buildings',
            'search',
            'selectedBuilding',
            'totalRooms'
        ));
    }

    public function create()
    {
        $buildings = Building::orderBy('building_name')->get();

        return view('admin.room.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_name' => ['required', 'string', 'max:255'],
            'building_id' => ['required', 'exists:buildings,id'],
        ]);

        Room::create($validated);

        return redirect('/admin/rooms')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        $buildings = Building::orderBy('building_name')->get();

        return view('admin.room.edit', compact('room', 'buildings'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_name' => ['required', 'string', 'max:255'],
            'building_id' => ['required', 'exists:buildings,id'],
        ]);

        $room->update($validated);

        return redirect('/admin/rooms')->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect('/admin/rooms')->with('success', 'Ruangan berhasil dihapus.');
    }
}
