@extends('layouts.admin')

@section('title', 'Manajemen Kelas - PinjamRuang')

@section('content')
<div class="space-y-5">

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manajemen Kelas</h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola kelas dan Class Representative.
            </p>
        </div>

        <a href="{{ route('classes.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Tambah Kelas
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                <i data-lucide="graduation-cap" class="h-5 w-5"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500">Total Kelas</p>
                <p class="text-xl font-bold text-slate-900">{{ $totalClasses }}</p>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 p-4 sm:p-5">
            <h2 class="font-bold text-slate-900">Daftar Kelas</h2>
            <p class="mt-1 text-xs text-slate-500">
                Informasi kelas dan perwakilan yang ditugaskan.
            </p>

            <form method="GET" class="mt-4 grid grid-cols-1 gap-2 sm:grid-cols-2 xl:grid-cols-4">
                <input type="text" name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama kelas atau prodi..."
                       class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none focus:border-indigo-500">

                <select name="major_id"
                        class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm outline-none focus:border-indigo-500">
                    <option value="">Semua Program Studi</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}"
                            @selected(request('major_id') == $major->id)>
                            {{ $major->major_name }}
                        </option>
                    @endforeach
                </select>

                <select name="semester"
                        class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm outline-none focus:border-indigo-500">
                    <option value="">Semua Semester</option>
                    @foreach(range(1, 8) as $semester)
                        <option value="{{ $semester }}"
                            @selected(request('semester') == $semester)>
                            Semester {{ $semester }}
                        </option>
                    @endforeach
                </select>

                <div class="flex gap-2">
                    <button type="submit"
                            class="flex-1 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                        Filter
                    </button>

                    <a href="{{ route('classes.index') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-3 text-slate-500 hover:bg-slate-50">
                        <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Kelas</th>
                        <th class="px-5 py-4">Program Studi</th>
                        <th class="px-5 py-4">Semester</th>
                        <th class="px-5 py-4">Class Representative</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($classes as $class)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-5 py-4">
                                <span class="font-semibold text-slate-900">
                                    {{ $class->class_name }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $class->major->major_name ?? '-' }}
                            </td>

                            <td class="px-5 py-4">
                                <span class="rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700">
                                    Semester {{ $class->semester }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                @forelse($class->classRepresentatives as $representative)
                                    <div class="mb-1 flex items-center gap-2 text-slate-700">
                                        <i data-lucide="user-round" class="h-3.5 w-3.5 text-slate-400"></i>
                                        <span>{{ $representative->fullname }}</span>
                                    </div>
                                @empty
                                    <span class="text-xs text-slate-400">
                                        Belum ditugaskan
                                    </span>
                                @endforelse
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('classes.edit', $class) }}"
                                       class="rounded-lg border border-slate-200 p-2 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600">
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>

                                    <form action="{{ route('classes.destroy', $class) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="rounded-lg border border-rose-100 p-2 text-rose-500 hover:bg-rose-50">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-500">
                                Belum ada data kelas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($classes->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">
                {{ $classes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
