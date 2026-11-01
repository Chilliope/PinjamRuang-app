@extends('layouts.staff')

@section('title', 'Edit Jadwal - PinjamRuang')

@section('content')
    <div class="mx-auto max-w-3xl space-y-5">

        <div>
            <a href="{{ route('staff.schedules.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-indigo-600">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Kembali ke Jadwal Ruangan
            </a>

            <h1 class="mt-4 text-2xl font-bold text-slate-900">
                Edit Jadwal Ruangan
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Perbarui informasi jadwal penggunaan ruangan.
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
            <form action="{{ route('staff.schedules.update', $schedule) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Nama Jadwal / Mata Kuliah
                    </label>
                    <input type="text" name="schedule_name" value="{{ old('schedule_name', $schedule->schedule_name) }}"
                        required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-50">
                    @error('schedule_name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Kelas
                    </label>

                    <select name="class_id" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-50">

                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" @selected(old('class_id', $schedule->class_id) == $class->id)>
                                {{ $class->class_name }}
                                — Semester {{ $class->semester }}
                                ({{ $class->major->major_name ?? '-' }})
                            </option>
                        @endforeach

                    </select>

                    @error('class_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Ruangan
                    </label>
                    <select name="room_id" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-50">
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}"
                                {{ old('room_id', $schedule->room_id) == $room->id ? 'selected' : '' }}>
                                {{ $room->room_name }} — {{ $room->building->building_name ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Hari
                    </label>
                    <select name="day_of_week" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-50">
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
                                {{ old('day_of_week', $schedule->day_of_week) === $key ? 'selected' : '' }}>
                                {{ $day }}
                            </option>
                        @endforeach
                    </select>
                    @error('day_of_week')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Jam Mulai
                        </label>
                        <input type="time" name="start_time"
                            value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}"
                            required
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-50">
                        @error('start_time')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Jam Selesai
                        </label>
                        <input type="time" name="end_time"
                            value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}"
                            required
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-50">
                        @error('end_time')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="rounded-xl border border-indigo-100 bg-indigo-50 p-4">
                    <div class="flex gap-3">
                        <i data-lucide="info" class="h-5 w-5 shrink-0 text-indigo-600"></i>
                        <p class="text-xs leading-relaxed text-indigo-700">
                            Perubahan jadwal akan berlaku setiap minggu setelah disimpan.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('staff.schedules.index') }}"
                        class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700">
                        <i data-lucide="save" class="h-4 w-4"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
