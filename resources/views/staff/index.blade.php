@extends('layouts.staff')

@section('title', 'Dashboard Staff - PinjamRuang')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold text-indigo-600">
                Staff Workspace
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Dashboard Staff
            </h1>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Selamat datang, {{ auth()->user()->fullname ?? 'Staff' }}.
                Pantau kondisi ruangan dan kelola pengajuan peminjaman di sini.
            </p>
        </div>

        <a href="{{ route('staff.bookings.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100">
            <i data-lucide="clipboard-list" class="h-4 w-4"></i>
            Periksa Pengajuan
        </a>
    </div>

    {{-- Statistik Utama --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Ruangan --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <i data-lucide="door-open" class="h-5 w-5"></i>
                </div>
                <span class="rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700">
                    Ruangan
                </span>
            </div>

            <p class="mt-5 text-sm font-medium text-slate-500">
                Total Ruangan
            </p>
            <p class="mt-1 text-3xl font-bold tracking-tight text-slate-900">
                {{ $roomsCount ?? 0 }}
            </p>
            <p class="mt-2 text-xs text-slate-400">
                Pada gedung yang kamu kelola
            </p>
        </div>

        {{-- Pending --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <i data-lucide="clock-3" class="h-5 w-5"></i>
                </div>
                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">
                    Menunggu
                </span>
            </div>

            <p class="mt-5 text-sm font-medium text-slate-500">
                Pengajuan Pending
            </p>
            <p class="mt-1 text-3xl font-bold tracking-tight text-slate-900">
                {{ $pendingCount ?? 0 }}
            </p>
            <p class="mt-2 text-xs text-slate-400">
                Perlu ditinjau oleh Staff
            </p>
        </div>

        {{-- Approved --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="calendar-check" class="h-5 w-5"></i>
                </div>
                <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                    Disetujui
                </span>
            </div>

            <p class="mt-5 text-sm font-medium text-slate-500">
                Peminjaman Disetujui
            </p>
            <p class="mt-1 text-3xl font-bold tracking-tight text-slate-900">
                {{ $approvedCount ?? 0 }}
            </p>
            <p class="mt-2 text-xs text-slate-400">
                Pengajuan yang telah disetujui
            </p>
        </div>

        {{-- Rejected --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                    <i data-lucide="calendar-x" class="h-5 w-5"></i>
                </div>
                <span class="rounded-full bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700">
                    Ditolak
                </span>
            </div>

            <p class="mt-5 text-sm font-medium text-slate-500">
                Peminjaman Ditolak
            </p>
            <p class="mt-1 text-3xl font-bold tracking-tight text-slate-900">
                {{ $rejectedCount ?? 0 }}
            </p>
            <p class="mt-2 text-xs text-slate-400">
                Pengajuan yang telah ditolak
            </p>
        </div>

    </div>

    {{-- Pengajuan Terbaru --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900">
                    Pengajuan Terbaru
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Lima pengajuan terakhir dari gedung yang kamu kelola.
                </p>
            </div>

            <a href="{{ route('staff.bookings.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 transition hover:text-indigo-700">
                Lihat semua
                <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
            </a>
        </div>

        @forelse ($latestBookings ?? [] as $booking)
            <a href="{{ route('staff.bookings.show', $booking) }}"
               class="flex flex-col gap-4 border-b border-slate-100 px-5 py-5 transition last:border-b-0 hover:bg-slate-50 sm:flex-row sm:items-center sm:justify-between sm:px-6">

                <div class="flex min-w-0 items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                        <i data-lucide="calendar-days" class="h-5 w-5"></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-slate-900">
                            {{ $booking->purpose }}
                        </p>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ $booking->user->fullname ?? 'Pengguna' }}
                            <span class="mx-1 text-slate-300">•</span>
                            {{ $booking->room->room_name ?? 'Ruangan' }}
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            {{ $booking->room->building->building_name ?? 'Gedung' }}
                            <span class="mx-1">•</span>
                            {{ $booking->booking_date
                                ? \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d M Y')
                                : '-' }}
                            <span class="mx-1">•</span>
                            {{ \Illuminate\Support\Str::substr($booking->start_time, 0, 5) }}
                            –
                            {{ \Illuminate\Support\Str::substr($booking->end_time, 0, 5) }}
                        </p>
                    </div>
                </div>

                <div class="flex shrink-0 items-center justify-between gap-3 sm:justify-end">
                    @php
                        $statusStyles = [
                            'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                            'approved' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                            'rejected' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
                            'cancelled' => 'bg-slate-100 text-slate-600 ring-slate-500/20',
                        ];

                        $statusLabels = [
                            'pending' => 'Menunggu',
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                            'cancelled' => 'Dibatalkan',
                        ];
                    @endphp

                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusStyles[$booking->status] ?? 'bg-slate-100 text-slate-600 ring-slate-500/20' }}">
                        {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
                    </span>

                    <i data-lucide="chevron-right" class="h-4 w-4 text-slate-400"></i>
                </div>
            </a>
        @empty
            <div class="px-5 py-12 text-center sm:px-6">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <i data-lucide="inbox" class="h-6 w-6"></i>
                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-900">
                    Belum ada pengajuan
                </h3>
                <p class="mt-1 text-sm text-slate-500">
                    Pengajuan peminjaman dari gedung yang kamu kelola akan muncul di sini.
                </p>
            </div>
        @endforelse
    </section>

    {{-- Menu Utama --}}
    <section>
        <div class="mb-4">
            <h2 class="text-lg font-bold text-slate-900">
                Menu Utama
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Pilih fitur yang ingin kamu gunakan.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

            {{-- Manajemen Ruangan --}}
            <a href="{{ url('/staff/rooms') }}"
               class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md sm:p-6">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-600 group-hover:text-white">
                    <i data-lucide="building-2" class="h-6 w-6"></i>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-slate-900">
                        Manajemen Ruangan
                    </h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Lihat dan kelola data ruangan pada gedung yang menjadi tanggung jawabmu.
                    </p>
                    <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600">
                        Kelola Ruangan
                        <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>

            {{-- Peminjaman --}}
            <a href="{{ route('staff.bookings.index') }}"
               class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-200 hover:shadow-md sm:p-6">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 transition group-hover:bg-amber-500 group-hover:text-white">
                    <i data-lucide="clipboard-list" class="h-6 w-6"></i>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-slate-900">
                        Peminjaman Ruangan
                    </h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Periksa detail pengajuan dan proses persetujuan peminjaman ruangan.
                    </p>
                    <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600">
                        Lihat Pengajuan
                        <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>

            {{-- Jadwal Ruangan --}}
            <a href="{{ url('/staff/schedules') }}"
               class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-sky-200 hover:shadow-md sm:p-6">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600 transition group-hover:bg-sky-600 group-hover:text-white">
                    <i data-lucide="calendar-days" class="h-6 w-6"></i>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-slate-900">
                        Jadwal Ruangan
                    </h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Periksa jadwal penggunaan ruangan untuk membantu menghindari bentrok peminjaman.
                    </p>
                    <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600">
                        Lihat Jadwal
                        <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>

            {{-- Riwayat Peminjaman --}}
            <a href="{{ url('/staff/history') }}"
               class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-violet-200 hover:shadow-md sm:p-6">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 transition group-hover:bg-violet-600 group-hover:text-white">
                    <i data-lucide="history" class="h-6 w-6"></i>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-slate-900">
                        Riwayat Peminjaman
                    </h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Telusuri pengajuan dan keputusan peminjaman ruangan sebelumnya.
                    </p>
                    <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600">
                        Lihat Riwayat
                        <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>

        </div>
    </section>

</div>
@endsection

