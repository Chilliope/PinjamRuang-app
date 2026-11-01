@extends('layouts.staff')

@section('title', 'Jadwal Ruangan - PinjamRuang')

@section('content')
    <div class="space-y-5">

        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    Jadwal Ruangan
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Atur jadwal penggunaan ruangan setiap minggu.
                </p>
            </div>

            <a href="{{ route('staff.schedules.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Tambah Jadwal
            </a>
        </div>

        @if (session('success'))
            <div
                class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                <i data-lucide="check-circle-2" class="h-5 w-5 shrink-0"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Statistics --}}
        <div class="rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <i data-lucide="calendar-days" class="h-5 w-5"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Total Jadwal Mingguan</p>
                    <p class="text-xl font-bold text-slate-900">{{ $totalSchedules }}</p>
                </div>
            </div>
        </div>

        {{-- Main Container --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Filters --}}
            <div class="border-b border-slate-100 p-4 sm:p-5">
                <div class="mb-4">
                    <h2 class="font-bold text-slate-900">Daftar Jadwal</h2>
                    <p class="mt-1 text-xs text-slate-500">
                        Jadwal ini berlaku berulang setiap minggu.
                    </p>
                </div>

                <form method="GET" action="{{ route('staff.schedules.index') }}"
                    class="grid grid-cols-1 gap-2 sm:grid-cols-2 xl:grid-cols-4">

                    <div class="relative">
                        <i data-lucide="search"
                            class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari jadwal atau ruangan..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-50">
                    </div>

                    <select name="building_id"
                        class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-600 outline-none focus:border-indigo-500">
                        <option value="">Semua Gedung</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}"
                                {{ request('building_id') == $building->id ? 'selected' : '' }}>
                                {{ $building->building_name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="room_id"
                        class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-600 outline-none focus:border-indigo-500">
                        <option value="">Semua Ruangan</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->room_name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="flex gap-2">
                        <select name="day_of_week"
                            class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-600 outline-none focus:border-indigo-500">
                            <option value="">Semua Hari</option>
                            @foreach ([
            'monday' => 'Senin',
            'tuesday' => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday' => 'Kamis',
            'friday' => 'Jumat',
            'saturday' => 'Sabtu',
            'sunday' => 'Minggu',
        ] as $key => $day)
                                <option value="{{ $key }}"
                                    {{ request('day_of_week') === $key ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                            Filter
                        </button>

                        <a href="{{ route('staff.schedules.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-3 text-slate-500 hover:bg-slate-50">
                            <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                        </a>
                    </div>
                </form>
            </div>

            {{-- Schedule Cards --}}
            <div class="bg-slate-50/50 p-3 sm:p-5">
                @forelse($schedules as $schedule)
                    @if ($loop->first)
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
                    @endif

                    <div
                        class="group rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                                <i data-lucide="calendar-clock" class="h-5 w-5"></i>
                            </div>

                            <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-semibold text-amber-700">
                                Berulang Mingguan
                            </span>
                        </div>

                        <div class="mt-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">
                                {{ [
                                    'monday' => 'Senin',
                                    'tuesday' => 'Selasa',
                                    'wednesday' => 'Rabu',
                                    'thursday' => 'Kamis',
                                    'friday' => 'Jumat',
                                    'saturday' => 'Sabtu',
                                    'sunday' => 'Minggu',
                                ][$schedule->day_of_week] ?? $schedule->day_of_week }}
                            </p>

                            <h3 class="mt-1 text-base font-bold text-slate-900">
                                {{ $schedule->schedule_name }}
                            </h3>

                            <div class="mt-3 flex items-center gap-2 text-sm text-slate-500">
                                <i data-lucide="door-open" class="h-4 w-4 text-indigo-500"></i>
                                {{ $schedule->room->room_name }}
                            </div>

                            <div class="mt-1 flex items-center gap-2 text-sm text-slate-500">
                                <i data-lucide="building-2" class="h-4 w-4 text-indigo-500"></i>
                                {{ $schedule->room->building->building_name ?? '-' }}
                            </div>

                            <div class="mt-1 flex items-center gap-2 text-sm text-slate-500">
                                <i data-lucide="graduation-cap" class="h-4 w-4 text-indigo-500"></i>
                                {{ $schedule->classRoom->class_name ?? 'Kelas belum ditentukan' }}
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between rounded-xl bg-slate-50 px-3 py-3">
                            <div>
                                <p class="text-[10px] font-medium uppercase tracking-wider text-slate-400">
                                    Jam Penggunaan
                                </p>
                                <p class="mt-1 text-sm font-bold tabular-nums text-slate-800">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                    –
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                </p>
                            </div>

                            <i data-lucide="clock" class="h-5 w-5 text-slate-400"></i>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-2 border-t border-slate-100 pt-3">
                            <a href="{{ route('staff.schedules.edit', $schedule) }}"
                                class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-slate-200 py-2.5 text-xs font-semibold text-slate-600 hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                                <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                Edit
                            </a>

                            <form action="{{ route('staff.schedules.destroy', $schedule) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg border border-rose-100 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                    <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    @if ($loop->last)
            </div>
            @endif

        @empty
            <div class="rounded-xl border border-dashed border-slate-300 bg-white px-5 py-12 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <i data-lucide="calendar-x" class="h-7 w-7"></i>
                </div>

                <h3 class="mt-4 font-bold text-slate-800">
                    Belum Ada Jadwal
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Belum ada jadwal yang sesuai dengan filter atau belum dibuat.
                </p>

                <a href="{{ route('staff.schedules.create') }}"
                    class="mt-4 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Tambah Jadwal
                </a>
            </div>
            @endforelse
        </div>

        @if ($schedules->hasPages())
            <div class="border-t border-slate-100 bg-white px-4 py-4">
                {{ $schedules->links() }}
            </div>
        @endif
    </div>
    </div>
@endsection
