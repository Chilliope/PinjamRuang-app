@extends('layouts.class_representative')

@section('title', 'Ajukan Perubahan Jadwal - PinjamRuang')

@section('content')
<div class="mx-auto max-w-3xl space-y-5">

    <div>
        <a href="{{ route('class-representative.schedule-changes.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-indigo-600">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali ke Jadwal
        </a>

        <h1 class="mt-4 text-2xl font-bold text-slate-900">
            Ajukan Perubahan Jadwal
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Ajukan perubahan penggunaan ruangan untuk jadwal kelas.
        </p>
    </div>

    @if($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <p class="mb-2 font-semibold">Pengajuan belum dapat dikirim:</p>
            <ul class="list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Informasi Jadwal --}}
    <div class="rounded-2xl border border-indigo-100 bg-indigo-50 p-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">
            Jadwal yang akan diubah
        </p>

        <h2 class="mt-2 text-lg font-bold text-slate-900">
            {{ $schedule->schedule_name }}
        </h2>

        <div class="mt-3 grid grid-cols-2 gap-3 text-sm text-slate-600">
            <div>
                <p class="text-xs text-slate-400">Kelas</p>
                <p class="mt-1 font-semibold">
                    {{ $schedule->classRoom->class_name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-400">Ruangan</p>
                <p class="mt-1 font-semibold">
                    {{ $schedule->room->room_name }}
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-400">Hari</p>
                <p class="mt-1 font-semibold">
                    {{ ucfirst($schedule->day_of_week) }}
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-400">Waktu</p>
                <p class="mt-1 font-semibold">
                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                    –
                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        <form action="{{ route('class-representative.schedule-changes.store', $schedule) }}"
              method="POST"
              class="space-y-5">

            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Tanggal Perubahan
                </label>

                <input type="date"
                       name="exception_date"
                       value="{{ old('exception_date') }}"
                       min="{{ now()->toDateString() }}"
                       required
                       class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-50">

                <p class="mt-1 text-xs text-slate-500">
                    Pilih tanggal yang sesuai dengan hari jadwal rutin.
                </p>

                @error('exception_date')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Jenis Perubahan
                </label>

                <select name="type" id="change-type" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-50">

                    <option value="">Pilih Jenis Perubahan</option>
                    <option value="online" @selected(old('type') === 'online')>
                        Perkuliahan Online
                    </option>
                    <option value="postponed" @selected(old('type') === 'postponed')>
                        Perkuliahan Ditunda
                    </option>
                    <option value="cancelled" @selected(old('type') === 'cancelled')>
                        Perkuliahan Dibatalkan
                    </option>
                    <option value="rescheduled" @selected(old('type') === 'rescheduled')>
                        Jadwal Dipindahkan
                    </option>
                </select>

                @error('type')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Informasi Jadwal Pengganti --}}
            <div id="replacement-fields"
                 class="hidden space-y-4 rounded-xl border border-indigo-100 bg-indigo-50/50 p-4">

                <div>
                    <h3 class="font-semibold text-slate-800">
                        Jadwal Pengganti
                    </h3>
                    <p class="mt-1 text-xs text-slate-500">
                        Tentukan ruangan, tanggal, dan waktu perkuliahan pengganti.
                    </p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Ruangan Pengganti
                    </label>

                    <select name="replacement_room_id"
                            id="replacement-room"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-indigo-500">

                        <option value="">Pilih Ruangan</option>

                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}"
                                @selected(old('replacement_room_id') == $room->id)>
                                {{ $room->room_name }}
                                — {{ $room->building->building_name ?? '-' }}
                            </option>
                        @endforeach
                    </select>

                    @error('replacement_room_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Tanggal Pengganti
                    </label>

                    <input type="date"
                           name="replacement_date"
                           id="replacement-date"
                           value="{{ old('replacement_date') }}"
                           min="{{ now()->toDateString() }}"
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-indigo-500">

                    @error('replacement_date')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Jam Mulai
                        </label>

                        <input type="time"
                               name="replacement_start_time"
                               id="replacement-start"
                               value="{{ old('replacement_start_time') }}"
                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-indigo-500">

                        @error('replacement_start_time')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Jam Selesai
                        </label>

                        <input type="time"
                               name="replacement_end_time"
                               id="replacement-end"
                               value="{{ old('replacement_end_time') }}"
                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-indigo-500">

                        @error('replacement_end_time')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Alasan Perubahan
                </label>

                <textarea name="reason"
                          rows="4"
                          required
                          maxlength="2000"
                          placeholder="Jelaskan alasan perubahan jadwal..."
                          class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-50">{{ old('reason') }}</textarea>

                @error('reason')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                <div class="flex gap-3">
                    <i data-lucide="info" class="h-5 w-5 shrink-0 text-amber-600"></i>
                    <p class="text-xs leading-relaxed text-amber-800">
                        Ruangan tidak langsung dilepas setelah pengajuan dikirim.
                        Pengajuan harus disetujui Staff terlebih dahulu.
                        Jika ditolak, jadwal rutin tetap berlaku.
                    </p>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('class-representative.schedule-changes.index') }}"
                   class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Batal
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700">
                    <i data-lucide="send" class="h-4 w-4"></i>
                    Kirim Pengajuan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('change-type');
    const replacementFields = document.getElementById('replacement-fields');

    const replacementInputs = [
        document.getElementById('replacement-room'),
        document.getElementById('replacement-date'),
        document.getElementById('replacement-start'),
        document.getElementById('replacement-end'),
    ];

    function updateReplacementFields() {
        const isRescheduled = typeSelect.value === 'rescheduled';

        replacementFields.classList.toggle('hidden', !isRescheduled);

        replacementInputs.forEach(input => {
            input.required = isRescheduled;
        });
    }

    typeSelect.addEventListener('change', updateReplacementFields);

    updateReplacementFields();
});
</script>
@endsection
