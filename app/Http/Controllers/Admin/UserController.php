<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = [
            'admin' => 'Admin',
            'staff' => 'Staff',
            'class_representative' => 'Class Representative',
        ];

        // Default role adalah Admin
        $selectedRole = $request->query('role', 'admin');

        if (! array_key_exists($selectedRole, $roles)) {
            $selectedRole = 'admin';
        }

        $search = $request->query('search', '');

        $query = User::query()
            ->where('role', $selectedRole);

        // Cari berdasarkan fullname atau email
        if (trim($search) !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('fullname', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        $totalUsers = User::count();

        return view('admin.user.index', compact(
            'users',
            'roles',
            'selectedRole',
            'search',
            'totalUsers'
        ));
    }

    public function create()
    {
        $roles = [
            'admin' => 'Admin',
            'staff' => 'Staff',
            'class_representative' => 'Class Representative',
        ];

        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'staff', 'class_representative',])],
        ]);

        $user = new User();
        $user->fullname = $validated['fullname'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role = $validated['role'];
        $user->save();

        return redirect('/admin/users?role=' . $user->role)->with('success', 'Pengguna berhasil ditambahkan.');
    }



    public function edit(User $user)
    {
        $roles = [
            'admin' => 'Admin',
            'staff' => 'Staff',
            'class_representative' => 'Class Representative',
        ];

        $buildings = Building::orderBy('building_name')->get();

        $selectedBuildingIds = $user->buildings()->pluck('buildings.id')->all();

        return view('admin.user.edit', compact(
            'user',
            'roles',
            'buildings',
            'selectedBuildingIds'
        ));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'staff',
                    'class_representative',
                ]),
            ],
            'building_ids' => [
                'required_if:role,staff',
                'array',
                'min:1',
            ],
            'building_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:buildings,id',
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'building_ids.required_if' => 'Pilih minimal satu gedung untuk Staff.',
            'building_ids.min' => 'Pilih minimal satu gedung untuk Staff.',
            'building_ids.*.exists' => 'Gedung yang dipilih tidak valid.',
        ]);

        $user->fullname = $validated['fullname'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Sinkronisasi penugasan gedung berdasarkan role.
        if ($user->role === 'staff') {
            $user->buildings()->sync($validated['building_ids']);
        } else {
            // Role selain Staff tidak memiliki penugasan gedung.
            $user->buildings()->sync([]);
        }

        return redirect('/admin/users?role=' . $user->role)->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Cegah admin menghapus akun sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Kamu tidak dapat menghapus akun sendiri.');
        }

        $role = $user->role;

        $user->delete();

        return redirect('/admin/users?role=' . $role)->with('success', 'Pengguna berhasil dihapus.');
    }
}
