@extends('layouts.staff')

@section('title', 'Dashboard Staff - PinjamRuang')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div>
        <p class="text-sm font-medium text-indigo-600">
            Staff Workspace
        </p>

        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            Dashboard Staff
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            Selamat datang, {{ auth()->user()->fullname ?? 'Staff' }}.
            Kelola ruangan dan pantau peminjaman melalui halaman ini.
        </p>
    </div>

    {{-- Informasi Utama --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <i data-lucide="door-open" class="h-5 w-5"></i>
                </div>
                <span class="text-xs font-medium text-slate-400">Ruangan</span>
            </div>

            <p class="mt-5 text-sm text-slate-500">Total Ruangan</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">—</p>
            <p class="mt-2 text-xs text-slate-400">
                Ruangan pada gedung yang dikelola
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <i data-lucide="clock-3" class="h-5 w-5"></i>
                </div>
                <span class="text-xs font-medium text-slate-400">Menunggu</span>
            </div>

            <p class="mt-5 text-sm text-slate-500">Pengajuan Pending</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">—</p>
            <p class="mt-2 text-xs text-slate-400">
                Menunggu keputusan Staff
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="calendar-check" class="h-5 w-5"></i>
                </div>
                <span class="text-xs font-medium text-slate-400">Disetujui</span>
            </div>

            <p class="mt-5 text-sm text-slate-500">Peminjaman Disetujui</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">—</p>
            <p class="mt-2 text-xs text-slate-400">
                Pengajuan yang telah disetujui
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                    <i data-lucide="calendar-x" class="h-5 w-5"></i>
                </div>
                <span class="text-xs font-medium text-slate-400">Ditolak</span>
            </div>

            <p class="mt-5 text-sm text-slate-500">Peminjaman Ditolak</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">—</p>
            <p class="mt-2 text-xs text-slate-400">
                Pengajuan yang telah ditolak
            </p>
        </div>

    </div>

    {{-- Menu Utama --}}
    <div>
        <div class="mb-4">
            <h2 class="text-lg font-bold text-slate-900">
                Menu Utama
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Pilih fitur untuk mulai bekerja.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

            <a href="{{ url('/staff/rooms') }}"
               class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-600 group-hover:text-white">
                    <i data-lucide="building-2" class="h-6 w-6"></i>
                </div>

                <div class="flex-1">
                    <h3 class="font-semibold text-slate-900">
                        Manajemen Ruangan
                    </h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Lihat, tambah, dan perbarui data ruangan pada gedung yang menjadi tanggung jawabmu.
                    </p>
                    <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600">
                        Kelola Ruangan
                        <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>

            <a href="{{ url('/staff/bookings') }}"
               class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 transition group-hover:bg-amber-500 group-hover:text-white">
                    <i data-lucide="clipboard-list" class="h-6 w-6"></i>
                </div>

                <div class="flex-1">
                    <h3 class="font-semibold text-slate-900">
                        Peminjaman Ruangan
                    </h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Periksa detail pengajuan peminjaman dan kelola keputusan sesuai kewenangan Staff.
                    </p>
                    <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600">
                        Lihat Pengajuan
                        <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>

            <a href="{{ url('/staff/schedules') }}"
               class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600 transition group-hover:bg-sky-600 group-hover:text-white">
                    <i data-lucide="calendar-days" class="h-6 w-6"></i>
                </div>

                <div class="flex-1">
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

            <a href="{{ url('/staff/history') }}"
               class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 transition group-hover:bg-violet-600 group-hover:text-white">
                    <i data-lucide="history" class="h-6 w-6"></i>
                </div>

                <div class="flex-1">
                    <h3 class="font-semibold text-slate-900">
                        Riwayat Peminjaman
                    </h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Telusuri riwayat pengajuan dan keputusan peminjaman ruangan.
                    </p>
                    <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600">
                        Lihat Riwayat
                        <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>

        </div>
    </div>

</div>
@endsection
