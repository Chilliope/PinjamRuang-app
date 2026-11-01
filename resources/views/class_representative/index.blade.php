
@extends('layouts.class_representative')

@section('title', 'Dashboard - PinjamRuang')

@section('content')
<div class="space-y-8">

    {{-- Welcome Section --}}
    <section class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
        <div>
            <p class="text-sm font-medium text-indigo-600">
                Class Representative
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Dashboard
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Selamat datang, {{ auth()->user()->fullname ?? 'Pengguna' }}!
                Kelola pengajuan peminjaman ruanganmu di sini.
            </p>
        </div>

        <a href="{{ route('class-representative.bookings.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
            <i data-lucide="plus" class="h-5 w-5"></i>
            Ajukan Peminjaman
        </a>
    </section>

    {{-- Statistics --}}
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Pengajuan</p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">
                        {{ $totalBookings ?? 0 }}
                    </h2>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <i data-lucide="file-text" class="h-6 w-6"></i>
                </div>
            </div>
            <p class="mt-4 text-xs text-slate-400">Seluruh pengajuan peminjaman</p>
        </div>

        {{-- Pending --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Menunggu Persetujuan</p>
                    <h2 class="mt-3 text-3xl font-bold text-amber-600">
                        {{ $pendingBookings ?? 0 }}
                    </h2>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <i data-lucide="clock" class="h-6 w-6"></i>
                </div>
            </div>
            <p class="mt-4 text-xs text-slate-400">Sedang menunggu pemeriksaan</p>
        </div>

        {{-- Approved --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Disetujui</p>
                    <h2 class="mt-3 text-3xl font-bold text-emerald-600">
                        {{ $approvedBookings ?? 0 }}
                    </h2>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="check-circle" class="h-6 w-6"></i>
                </div>
            </div>
            <p class="mt-4 text-xs text-slate-400">Pengajuan berhasil disetujui</p>
        </div>

        {{-- Rejected --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Ditolak</p>
                    <h2 class="mt-3 text-3xl font-bold text-rose-600">
                        {{ $rejectedBookings ?? 0 }}
                    </h2>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                    <i data-lucide="x-circle" class="h-6 w-6"></i>
                </div>
            </div>
            <p class="mt-4 text-xs text-slate-400">Pengajuan tidak disetujui</p>
        </div>

    </section>

    {{-- Recent Bookings --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col justify-between gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center">
            <div>
                <h2 class="text-lg font-bold text-slate-900">
                    Pengajuan Terbaru
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Pantau perkembangan peminjaman ruanganmu.
                </p>
            </div>

            <a href="{{ route('class-representative.bookings.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                Lihat Semua
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>

        @if(isset($recentBookings) && $recentBookings->count() > 0)

            <div class="overflow-x-auto">
                <table class="w-full min-w-[650px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Ruangan</th>
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold">Waktu</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentBookings as $booking)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $booking->room->room_name ?? 'Ruangan' }}
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    {{ $booking->booking_date->format('l, d/m/Y') ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    {{ date('H:i', strtotime($booking->start_time)) ?? '-' }}
                                    -
                                    {{ date('H:i', strtotime($booking->end_time)) ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $status = strtolower($booking->status ?? 'pending');

                                        $statusStyle = match($status) {
                                            'approved', 'disetujui' => 'bg-emerald-50 text-emerald-700',
                                            'rejected', 'ditolak' => 'bg-rose-50 text-rose-700',
                                            default => 'bg-amber-50 text-amber-700',
                                        };
                                    @endphp

                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusStyle }}">
                                        {{ ucfirst($booking->status ?? 'Pending') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else

            <div class="flex flex-col items-center justify-center px-6 py-16 text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <i data-lucide="calendar-days" class="h-8 w-8"></i>
                </div>

                <h3 class="mt-5 text-base font-bold text-slate-900">
                    Belum Ada Pengajuan
                </h3>

                <p class="mt-2 max-w-sm text-sm text-slate-500">
                    Kamu belum memiliki pengajuan peminjaman ruangan.
                    Mulai ajukan peminjaman untuk kebutuhan kelasmu.
                </p>

                <a href="{{ route('class-representative.bookings.create') }}"
                   class="mt-5 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Buat Pengajuan
                </a>
            </div>

        @endif

    </section>

</div>
@endsection
