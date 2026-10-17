@extends('layouts.admin')

@section('title', 'User - PinjamRuang')

@section('content')
    <div class="space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">
                    Manajemen Pengguna
                </p>

                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    User Management
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Kelola akun dan hak akses pengguna PinjamRuang.
                </p>
            </div>

            <a href="{{ url('/admin/users/create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                <i data-lucide="user-plus" class="h-4 w-4"></i>
                Tambah User
            </a>
        </div>

        {{-- Summary --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Pengguna</p>
                        <h2 class="mt-2 text-3xl font-bold text-slate-900">
                            {{ $users->total() }}
                        </h2>
                    </div>

                    <div class="rounded-xl bg-indigo-50 p-3 text-indigo-600">
                        <i data-lucide="users" class="h-6 w-6"></i>
                    </div>
                </div>
                <p class="mt-3 text-xs text-slate-500">
                    Seluruh akun yang terdaftar
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Data Ditampilkan</p>
                        <h2 class="mt-2 text-3xl font-bold text-slate-900">
                            {{ $users->count() }}
                        </h2>
                    </div>

                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <i data-lucide="contact-round" class="h-6 w-6"></i>
                    </div>
                </div>
                <p class="mt-3 text-xs text-slate-500">
                    Pengguna pada halaman ini
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:col-span-2 xl:col-span-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Sistem Akses</p>
                        <h2 class="mt-2 text-xl font-bold text-slate-900">
                            3 Peran
                        </h2>
                    </div>

                    <div class="rounded-xl bg-amber-50 p-3 text-amber-600">
                        <i data-lucide="shield-check" class="h-6 w-6"></i>
                    </div>
                </div>
                <p class="mt-3 text-xs text-slate-500">
                    Admin, Staff, dan Class Representative
                </p>
            </div>
        </div>


        {{-- User Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex flex-col gap-5 border-b border-slate-200 px-6 py-5 xl:flex-row xl:items-center xl:justify-between">
                <div>
                    <h2 class="font-semibold text-slate-900">
                        Daftar Pengguna
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Cari pengguna dan filter berdasarkan role.
                    </p>
                </div>

                <form action="{{ url('/admin/users') }}" method="GET"
                    class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:flex xl:items-center">

                    {{-- Search Bar --}}
                    <div class="relative">
                        <i data-lucide="search"
                            class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                        <input type="search" name="search" value="{{ $search }}"
                            placeholder="Cari nama atau email..."
                            class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 xl:w-64">
                    </div>

                    {{-- Role Filter --}}
                    <div class="relative">
                        <i data-lucide="shield-check"
                            class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                        <select name="role"
                            class="w-full appearance-none rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-9 text-sm text-slate-700 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 xl:w-56">

                            @foreach ($roles as $value => $label)
                                <option value="{{ $value }}" @selected($selectedRole === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        <i data-lucide="chevron-down"
                            class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    </div>

                    {{-- Search Button --}}
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        <i data-lucide="filter" class="h-4 w-4"></i>
                        Terapkan
                    </button>

                    {{-- Reset --}}
                    @if ($search !== '' || $selectedRole !== 'admin')
                        <a href="{{ url('/admin/users') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                            <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-3">
                <p class="text-sm text-slate-500">
                    Hasil pencarian:
                    <span class="font-semibold text-slate-800">
                        {{ $users->total() }} pengguna
                    </span>
                </p>

                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                    {{ $roles[$selectedRole] }}
                </span>
            </div>

            @if (session('success'))
                <div
                    class="mx-6 mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($users->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Pengguna</th>
                                <th class="px-6 py-4 font-semibold">Email</th>
                                <th class="px-6 py-4 font-semibold">Peran</th>
                                <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @foreach ($users as $user)
                                <tr class="transition hover:bg-slate-50/70">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 font-semibold uppercase text-indigo-600">
                                                {{ substr($user->fullname ?? 'U', 0, 1) }}
                                            </div>

                                            <div>
                                                <p class="font-semibold text-slate-800">
                                                    {{ $user->fullname }}
                                                </p>
                                                <p class="mt-1 text-xs text-slate-400">
                                                    ID: {{ $user->id }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-slate-600">
                                        {{ $user->email }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        @php
                                            $role = strtolower($user->role ?? '');
                                            $roleStyle = match ($role) {
                                                'admin' => 'bg-violet-50 text-violet-700 ring-violet-600/20',
                                                'staff' => 'bg-sky-50 text-sky-700 ring-sky-600/20',
                                                'class_representative'
                                                    => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                                default => 'bg-slate-100 text-slate-600 ring-slate-500/20',
                                            };

                                            $roleLabel = match ($role) {
                                                'admin' => 'Admin',
                                                'staff' => 'Staff',
                                                'class_representative' => 'Class Representative',
                                                '' => 'Belum ditentukan',
                                                default => ucwords(str_replace('_', ' ', $role)),
                                            };
                                        @endphp

                                        <span
                                            class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $roleStyle }}">
                                            {{ $roleLabel }}
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ url('/admin/users/' . $user->id . '/edit') }}"
                                                title="Edit pengguna"
                                                class="inline-flex items-center justify-center rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600">
                                                <i data-lucide="pencil" class="h-4 w-4"></i>
                                            </a>

                                            <form action="{{ url('/admin/users/' . $user->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" title="Hapus pengguna"
                                                    class="inline-flex items-center justify-center rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600">
                                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $users->links() }}
                </div>
            @else
                <div class="px-6 py-16 text-center">
                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                        <i data-lucide="users" class="h-7 w-7"></i>
                    </div>

                    <h3 class="mt-4 font-semibold text-slate-900">
                        Belum ada pengguna
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        Data pengguna akan muncul di sini setelah tersedia.
                    </p>

                    <a href="{{ url('/admin/users/create') }}"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        <i data-lucide="user-plus" class="h-4 w-4"></i>
                        Tambah Pengguna
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        if (window.lucide) {
            window.lucide.createIcons();
        }
    </script>
@endsection
