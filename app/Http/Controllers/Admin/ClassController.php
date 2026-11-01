<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Major;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassRoom::with(['major', 'classRepresentatives']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('class_name', 'like', "%{$search}%")
                    ->orWhereHas('major', function ($majorQuery) use ($search) {
                        $majorQuery->where(
                            'major',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        if ($request->filled('major_id')) {
            $query->where('major_id', $request->major_id);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $classes = $query
            ->orderBy('class_name')
            ->paginate(10)
            ->withQueryString();

        $majors = Major::orderBy('major')->get();

        $totalClasses = ClassRoom::count();

        return view('admin.classes.index', compact(
            'classes',
            'majors',
            'totalClasses'
        ));
    }

    public function create()
    {
        $majors = Major::orderBy('major')->get();

        $classRepresentatives = User::where(
            'role',
            'class_representative'
        )->orderBy('fullname')->get();

        return view('admin.classes.create', compact(
            'majors',
            'classRepresentatives'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'major_id' => [
                'required',
                'exists:majors,id',
            ],
            'class_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('classes')->where(
                    fn($query) => $query->where(
                        'major_id',
                        $request->major_id
                    )
                ),
            ],
            'semester' => [
                'required',
                'integer',
                'min:1',
                'max:14',
            ],
            'class_representatives' => [
                'nullable',
                'array',
            ],
            'class_representatives.*' => [
                'integer',
                Rule::exists('users', 'id')->where(
                    fn($query) => $query->where(
                        'role',
                        'class_representative'
                    )
                ),
            ],
        ]);

        $class = ClassRoom::create([
            'major_id' => $validated['major_id'],
            'class_name' => $validated['class_name'],
            'semester' => $validated['semester'],
        ]);

        $class->classRepresentatives()->sync(
            $validated['class_representatives'] ?? []
        );

        return redirect()
            ->route('classes.index')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(ClassRoom $class)
    {
        $class->load('classRepresentatives');

        $majors = Major::orderBy('major')->get();

        $classRepresentatives = User::where(
            'role',
            'class_representative'
        )->orderBy('fullname')->get();

        return view('admin.classes.edit', compact(
            'class',
            'majors',
            'classRepresentatives'
        ));
    }

    public function update(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'major_id' => [
                'required',
                'exists:majors,id',
            ],
            'class_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('classes')
                    ->where(fn($query) => $query->where(
                        'major_id',
                        $request->major_id
                    ))
                    ->ignore($class->id),
            ],
            'semester' => [
                'required',
                'integer',
                'min:1',
                'max:14',
            ],
            'class_representatives' => [
                'nullable',
                'array',
            ],
            'class_representatives.*' => [
                'integer',
                Rule::exists('users', 'id')->where(
                    fn($query) => $query->where(
                        'role',
                        'class_representative'
                    )
                ),
            ],
        ]);

        $class->update([
            'major_id' => $validated['major_id'],
            'class_name' => $validated['class_name'],
            'semester' => $validated['semester'],
        ]);

        $class->classRepresentatives()->sync(
            $validated['class_representatives'] ?? []
        );

        return redirect()
            ->route('classes.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(ClassRoom $class)
    {
        $class->delete();

        return redirect()
            ->route('classes.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }
}
