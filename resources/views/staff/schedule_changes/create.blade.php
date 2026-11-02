@extends('layouts.staff')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Header --}}
        <div>
            <a href="{{ route('staff.schedule-changes.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Kembali ke Pengajuan Perubahan Jadwal
            </a>

            <div class="mt-4">
                <h1 class="text-2xl font-bold text-gray-800">
                    Buat Perubahan Jadwal
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Staff dapat mengubah jadwal secara langsung tanpa menunggu pengajuan Class Representative.
                </p>
            </div>
        </div>

        {{-- Error validation --}}
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                <div class="flex items-start gap-3">
                    <i data-lucide="alert-circle" class="mt-0.5 h-5 w-5 text-red-600"></i>
                    <div>
                        <p class="text-sm font-semibold text-red-700">
                            Terdapat kesalahan pada pengisian form
                        </p>
                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('staff.schedule-changes.direct.store') }}" method="POST"
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            @csrf

            <div class="space-y-6 p-6">

                {{-- Jadwal --}}
                <div>
                    <label for="room_schedule_id" class="mb-2 block text-sm font-semibold text-gray-700">
                        Jadwal Perkuliahan
                        <span class="text-red-500">*</span>
                    </label>

                    <select name="room_schedule_id" id="room_schedule_id" required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">

                        <option value="">Pilih jadwal perkuliahan</option>

                        @foreach ($schedules as $schedule)
                            <option value="{{ $schedule->id }}" @selected(old('room_schedule_id') == $schedule->id)>
                                {{ $schedule->schedule_name }}
                                - {{ $schedule->classRoom?->class_name ?? 'Tanpa kelas' }}
                                - {{ $schedule->room->room_name }}
                                ({{ $schedule->day_of_week }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="exception_date" class="mb-2 block text-sm font-semibold text-gray-700">
                        Tanggal Perubahan
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="date" name="exception_date" id="exception_date" value="{{ old('exception_date') }}"
                        min="{{ date('Y-m-d') }}" required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">

                    <p class="mt-1 text-xs text-gray-400">
                        Tanggal harus sesuai dengan hari jadwal perkuliahan rutin.
                    </p>
                </div>

                {{-- Jenis perubahan --}}
                <div>
                    <label for="type" class="mb-2 block text-sm font-semibold text-gray-700">
                        Jenis Perubahan
                        <span class="text-red-500">*</span>
                    </label>

                    <select name="type" id="type" required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">

                        <option value="">Pilih jenis perubahan</option>
                        <option value="online" @selected(old('type') === 'online')>
                            Perkuliahan Online
                        </option>
                        <option value="postponed" @selected(old('type') === 'postponed')>
                            Ditunda
                        </option>
                        <option value="cancelled" @selected(old('type') === 'cancelled')>
                            Dibatalkan
                        </option>
                        <option value="rescheduled" @selected(old('type') === 'rescheduled')>
                            Dijadwalkan Ulang
                        </option>
                    </select>
                </div>

                {{-- Jadwal pengganti --}}
                <div id="replacement-fields"
                    class="{{ old('type') === 'rescheduled' ? '' : 'hidden' }} space-y-5 rounded-xl border border-blue-100 bg-blue-50 p-5">

                    <div>
                        <h3 class="font-semibold text-gray-800">
                            Jadwal Pengganti
                        </h3>
                        <p class="mt-1 text-xs text-gray-500">
                            Lengkapi informasi berikut jika jadwal dipindahkan.
                        </p>
                    </div>

                    {{-- Ruangan --}}
                    <div>
                        <label for="replacement_room_id" class="mb-2 block text-sm font-medium text-gray-700">
                            Ruangan Pengganti
                            <span class="text-red-500">*</span>
                        </label>

                        <select name="replacement_room_id" id="replacement_room_id"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm">

                            <option value="">Pilih ruangan pengganti</option>

                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" @selected(old('replacement_room_id') == $room->id)>
                                    {{ $room->room_name }}
                                    - {{ $room->building->building_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal pengganti --}}
                    <div>
                        <label for="replacement_date" class="mb-2 block text-sm font-medium text-gray-700">
                            Tanggal Pengganti
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="date" name="replacement_date" id="replacement_date"
                            value="{{ old('replacement_date') }}" min="{{ date('Y-m-d') }}"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm">
                    </div>

                    {{-- Waktu --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="replacement_start_time" class="mb-2 block text-sm font-medium text-gray-700">
                                Waktu Mulai
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="time" name="replacement_start_time" id="replacement_start_time"
                                value="{{ old('replacement_start_time') }}"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm">
                        </div>

                        <div>
                            <label for="replacement_end_time" class="mb-2 block text-sm font-medium text-gray-700">
                                Waktu Selesai
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="time" name="replacement_end_time" id="replacement_end_time"
                                value="{{ old('replacement_end_time') }}"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm">
                        </div>
                    </div>
                </div>

                {{-- Alasan --}}
                <div>
                    <label for="reason" class="mb-2 block text-sm font-semibold text-gray-700">
                        Alasan Perubahan
                        <span class="text-red-500">*</span>
                    </label>

                    <textarea name="reason" id="reason" rows="4" maxlength="2000" required
                        placeholder="Tuliskan alasan perubahan jadwal..."
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('reason') }}</textarea>
                </div>

                {{-- Informasi --}}
                <div class="flex gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4">
                    <i data-lucide="info" class="h-5 w-5 shrink-0 text-amber-600"></i>
                    <p class="text-sm leading-relaxed text-amber-800">
                        Perubahan yang dibuat melalui halaman ini akan langsung disetujui.
                        Pastikan seluruh informasi sudah benar sebelum menyimpan.
                    </p>
                </div>
            </div>

            {{-- Footer --}}
            <div
                class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end">

                <a href="{{ route('staff.schedule-changes.index') }}"
                    class="rounded-xl border border-gray-300 bg-white px-5 py-3 text-center text-sm font-semibold text-gray-600 hover:bg-gray-100">
                    Batal
                </a>

                <button type="submit" onclick="return confirm('Apakah kamu yakin ingin menyimpan perubahan jadwal ini?')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">

                    <i data-lucide="save" class="h-4 w-4"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const replacementFields = document.getElementById('replacement-fields');

            const replacementInputs = [
                document.getElementById('replacement_room_id'),
                document.getElementById('replacement_date'),
                document.getElementById('replacement_start_time'),
                document.getElementById('replacement_end_time'),
            ];

            function toggleReplacementFields() {
                const isRescheduled = typeSelect.value === 'rescheduled';

                replacementFields.classList.toggle('hidden', !isRescheduled);

                replacementInputs.forEach(input => {
                    input.required = isRescheduled;
                });
            }

            typeSelect.addEventListener('change', toggleReplacementFields);

            toggleReplacementFields();
        });
    </script>
@endsection
