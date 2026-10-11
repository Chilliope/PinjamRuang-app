<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\BuildingMajor;
use App\Models\Major;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $buildings = Building::query()
            ->when($search, function ($query, $search) {
                $query->where('building_name', 'like', "%{$search}%");
            })
            ->with('majors')->get();

        if ($request->ajax()) {
            return view('admin.buildings.partials.table', [
                'buildings' => $buildings,
            ]);
        }

        return view('admin.buildings.index', [
            'buildings' => $buildings
        ]);
    }

    public function create()
    {
        $majors = Major::get();
        return view('admin.buildings.create', [
            'majors' => $majors
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'building_name' => 'required|unique:buildings,building_name',
            'major_id' => 'nullable|integer|exists:majors,id'
        ]);

        $major = Major::where('id', $request->major_id)->first();

        $building = Building::create([
            'building_name' => $validatedData['building_name'],
        ]);

        BuildingMajor::create([
            'building_id' => $building->id,
            'major_id' => $major->id
        ]);

        return redirect('/admin/buildings')->with('success', 'Building Created Successfully');
    }

    public function edit(Building $building)
    {
        $buildingMajor = BuildingMajor::where('building_id', $building->id)->first();

        $major = $buildingMajor ? Major::find($buildingMajor->major_id) : null;

        $majors = Major::all();

        return view('admin.buildings.edit', [
            'major' => $major,
            'majors' => $majors,
            'building' => $building,
        ]);
    }

    public function update(Request $request, Building $building)
    {
        $validatedData = $request->validate([
            'building_name' => [
                'required',
                'string',
                'max:255',
                'unique:buildings,building_name,' . $building->id,
            ],
            'major_id' => [
                'nullable',
                'integer',
                'exists:majors,id',
            ],
        ]);

        // Update nama gedung
        $building->update([
            'building_name' => $validatedData['building_name'],
        ]);

        // Hapus relasi jurusan sebelumnya
        BuildingMajor::where('building_id', $building->id)->delete();

        // Tambahkan relasi baru jika bukan universal
        if (!empty($validatedData['major_id'])) {
            BuildingMajor::create([
                'building_id' => $building->id,
                'major_id' => $validatedData['major_id'],
            ]);
        }

        return redirect('/admin/buildings')->with('success', 'Building Updated Successfully');
    }


    public function destroy(Building $building)
    {
        $building->delete();

        return redirect('/admin/buildings')->with('success', 'Building Deleted Successfully');
    }
}
