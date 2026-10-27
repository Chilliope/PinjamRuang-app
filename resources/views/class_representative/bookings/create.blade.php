@extends('layouts.class_representative')

@section('title', 'Ajukan Peminjaman - PinjamRuang')

@section('content')
<div class="space-y-7">

    {{-- Page Header --}}
    <section class="relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
        <div class="pointer-events-none absolute -right-12 -top-16 h-56 w-56 rounded-full bg-indigo-100/70 blur-3xl"></div>
        <div class="pointer-events-none absolute right-32 top-20 h-28 w-28 rounded-full bg-violet-100/60 blur-2xl"></div>

        <div class="relative">
            <a href="{{ route('class-representative.bookings.index') }}"
               class="inline-flex items-center gap-2 rounded-lg text-sm font-medium text-slate-500 transition hover:text-indigo-600">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Kembali ke Pengajuan
            </a>

            <div class="mt-6 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div class="max-w-xl">
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700">
                        <i data-lucide="calendar-plus" class="h-3.5 w-3.5"></i>
                        FORM PEMINJAMAN
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">
                        Ajukan Peminjaman
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-500 sm:text-base">
                        Lengkapi informasi ruangan, tanggal, dan waktu penggunaan sebelum mengirim pengajuan.
                    </p>
                </div>

                <div class="hidden h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 sm:flex">
                    <i data-lucide="clipboard-pen-line" class="h-8 w-8"></i>
                </div>
            </div>
        </div>
    </section>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 sm:p-5">
            <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-rose-600 shadow-sm">
                    <i data-lucide="alert-circle" class="h-5 w-5"></i>
                </div>

                <div class="min-w-0">
                    <h2 class="font-semibold text-rose-800">
                        Periksa kembali data pengajuan
                    </h2>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm leading-5 text-rose-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Booking Form --}}
    <form action="{{ route('class-representative.bookings.store') }}"
          method="POST"
          class="space-y-5">
        @csrf

        {{-- Room and Purpose --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
            <div class="flex items-start gap-3 border-b border-slate-100 px-5 py-5 sm:px-7">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <i data-lucide="door-open" class="h-5 w-5"></i>
                </div>

                <div>
                    <h2 class="font-bold text-slate-900">Informasi Peminjaman</h2>
                    <p class="mt-1 text-sm leading-5 text-slate-500">
                        Tentukan ruangan dan tujuan penggunaannya.
                    </p>
                </div>
            </div>

            <div class="space-y-6 p-5 sm:p-7">

                {{-- Room --}}
                <div>
                    <label for="room_id" class="mb-2 block text-sm font-semibold text-slate-700">
                        Pilih Ruangan <span class="text-rose-500">*</span>
                    </label>

                    <select id="room_id"
                            name="room_id"
                            required
                            class="block min-h-12 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                        <option value="">Pilih ruangan yang ingin digunakan</option>

                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}"
                                @selected((string) old('room_id') === (string) $room->id)>
                                {{ $room->room_name }} — {{ $room->building->building_name ?? 'Gedung tidak tersedia' }}
                            </option>
                        @endforeach
                    </select>

                    @error('room_id')
                        <p class="mt-2 flex items-center gap-1.5 text-sm text-rose-600">
                            <i data-lucide="alert-circle" class="h-4 w-4"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Purpose --}}
                <div>
                    <div class="mb-2 flex items-center justify-between gap-3">
                        <label for="purpose" class="block text-sm font-semibold text-slate-700">
                            Keperluan Peminjaman <span class="text-rose-500">*</span>
                        </label>

                        <span class="text-xs text-slate-400">Maks. 2000 karakter</span>
                    </div>

                    <textarea id="purpose"
                              name="purpose"
                              rows="4"
                              required
                              maxlength="2000"
                              placeholder="Contoh: Diskusi kelompok, rapat organisasi, atau kegiatan belajar bersama..."
                              class="block w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">{{ old('purpose') }}</textarea>

                    @error('purpose')
                        <p class="mt-2 flex items-center gap-1.5 text-sm text-rose-600">
                            <i data-lucide="alert-circle" class="h-4 w-4"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </section>

        {{-- Schedule --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
            <div class="flex items-start gap-3 border-b border-slate-100 px-5 py-5 sm:px-7">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <i data-lucide="calendar-clock" class="h-5 w-5"></i>
                </div>

                <div>
                    <h2 class="font-bold text-slate-900">Jadwal Penggunaan</h2>
                    <p class="mt-1 text-sm leading-5 text-slate-500">
                        Tentukan tanggal serta rentang waktu peminjaman.
                    </p>
                </div>
            </div>

            <div class="space-y-6 p-5 sm:p-7">

                {{-- Date --}}
                <div>
                    <label for="booking_date" class="mb-2 block text-sm font-semibold text-slate-700">
                        Tanggal Peminjaman <span class="text-rose-500">*</span>
                    </label>

                    <div class="relative">
                        <input type="date"
                               id="booking_date"
                               name="booking_date"
                               min="{{ now()->toDateString() }}"
                               value="{{ old('booking_date') }}"
                               required
                               class="block min-h-12 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                    </div>

                    @error('booking_date')
                        <p class="mt-2 flex items-center gap-1.5 text-sm text-rose-600">
                            <i data-lucide="alert-circle" class="h-4 w-4"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Time --}}
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label for="start_time" class="mb-2 block text-sm font-semibold text-slate-700">
                            Waktu Mulai <span class="text-rose-500">*</span>
                        </label>

                        <input type="time"
                               id="start_time"
                               name="start_time"
                               value="{{ old('start_time') }}"
                               required
                               class="block min-h-12 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">

                        @error('start_time')
                            <p class="mt-2 flex items-center gap-1.5 text-sm text-rose-600">
                                <i data-lucide="alert-circle" class="h-4 w-4"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_time" class="mb-2 block text-sm font-semibold text-slate-700">
                            Waktu Selesai <span class="text-rose-500">*</span>
                        </label>

                        <input type="time"
                               id="end_time"
                               name="end_time"
                               value="{{ old('end_time') }}"
                               required
                               class="block min-h-12 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">

                        @error('end_time')
                            <p class="mt-2 flex items-center gap-1.5 text-sm text-rose-600">
                                <i data-lucide="alert-circle" class="h-4 w-4"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Timezone Hint --}}
                <div class="flex items-start gap-3 rounded-xl border border-slate-100 bg-slate-50 p-4">
                    <i data-lucide="clock-3" class="mt-0.5 h-4 w-4 shrink-0 text-slate-500"></i>
                    <p class="text-sm leading-5 text-slate-600">
                        Pastikan waktu mulai lebih awal daripada waktu selesai. Jadwal yang dikirim akan diperiksa oleh Staff.
                    </p>
                </div>
            </div>
        </section>

        {{-- Submission Information --}}
        <section class="rounded-2xl border border-indigo-100 bg-indigo-50/70 p-4 sm:p-5">
            <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-indigo-600 shadow-sm">
                    <i data-lucide="info" class="h-5 w-5"></i>
                </div>

                <div>
                    <h2 class="text-sm font-bold text-indigo-950">Sebelum Mengirim</h2>
                    <p class="mt-1 text-sm leading-6 text-indigo-900/80">
                        Pengajuan akan berstatus <span class="font-semibold">Menunggu</span> sampai diperiksa Staff. Pastikan ruangan, keperluan, tanggal, dan waktu yang dipilih sudah benar.
                    </p>
                </div>
            </div>
        </section>

        {{-- Actions --}}
        <div class="flex flex-col-reverse gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <p class="hidden text-xs text-slate-400 sm:block">
                <span class="text-rose-500">*</span> Wajib diisi
            </p>

            <div class="flex flex-col-reverse gap-3 sm:flex-row">
                <a href="{{ route('class-representative.bookings.index') }}"
                   class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">
                    Batal
                </a>

                <button type="submit"
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-700 hover:shadow-indigo-600/30">
                    <i data-lucide="send" class="h-4 w-4"></i>
                    Kirim Pengajuan
                </button>
            </div>
        </div>

    </form>
</div>
@endsection

