<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MajorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $majors = Major::query()
            ->when($search, function ($query, $search) {
                $query->where('major', 'like', "%{$search}%");
            })
            ->get();

        if ($request->ajax()) {
            return view('admin.majors.partials.table', [
                'majors' => $majors,
            ]);
        }

        return view('admin.majors.index', [
            'majors' => $majors,
        ]);
    }

    public function create()
    {
        return view('admin.majors.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'major' => 'required|unique:majors,major'
        ]);

        Major::create($validatedData);

        return redirect('/admin/majors')->with('success', 'Major Created');
    }

    public function edit(Major $major)
    {
        return view('admin.majors.edit', [
            'major' => $major
        ]);
    }

    public function update(Request $request, Major $major)
    {
        $validatedData = $request->validate(
            [
                'major' => [
                    'required',
                    Rule::unique('majors', 'major')->ignore($major->id),
                ],
            ],
            [
                'major.required' => 'Nama jurusan wajib diisi.',
                'major.unique' => 'Jurusan tersebut sudah terdaftar.',
            ]
        );

        $major->update($validatedData);

        return redirect('/admin/majors')->with('success', 'Major Updated');
    }

    public function destroy(Major $major)
    {
        $major->delete();

        return redirect('/admin/majors')->with('success', 'Major Deleted');
    }
}
