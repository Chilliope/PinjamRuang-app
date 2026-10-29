@extends('layouts.class_representative')

@section('title', 'Peminjaman Ruangan - PinjamRuang')

@section('content')
<div class="min-h-full space-y-7">

    @php
        $statusStyles = [
            'pending' => [
                'label' => 'Menunggu',
                'class' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                'dot' => 'bg-amber-500',
            ],
            'approved' => [
                'label' => 'Disetujui',
                'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                'dot' => 'bg-emerald-500',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'class' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
                'dot' => 'bg-rose-500',
            ],
            'cancelled' => [
                'label' => 'Dibatalkan',
                'class' => 'bg-slate-100 text-slate-600 ring-slate-500/20',
                'dot' => 'bg-slate-400',
            ],
        ];
    @endphp

    {{-- Page Header --}}
    <section class="relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
        <div class="pointer-events-none absolute -right-12 -top-16 h-56 w-56 rounded-full bg-indigo-100/70 blur-3xl"></div>
        <div class="pointer-events-none absolute right-32 top-20 h-28 w-28 rounded-full bg-violet-100/60 blur-2xl"></div>

        <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="max-w-xl">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                    CLASS REPRESENTATIVE
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">
                    Pengajuan Peminjaman
                </h1>

                <p class="mt-2 max-w-lg text-sm leading-6 text-slate-500 sm:text-base">
                    Semua pengajuan ruanganmu ada di satu tempat. Pantau jadwal dan statusnya dengan mudah.
                </p>
            </div>

            <a href="{{ route('class-representative.bookings.create') }}"
               class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3.5 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition duration-200 hover:-translate-y-0.5 hover:bg-indigo-700 hover:shadow-indigo-600/30">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Ajukan Ruangan
                <i data-lucide="arrow-up-right" class="h-4 w-4 opacity-75"></i>
            </a>
        </div>
    </section>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm">
                <i data-lucide="check-circle-2" class="h-4 w-4"></i>
            </div>
            <div class="pt-1">
                <p class="font-semibold">Berhasil</p>
                <p class="mt-1 leading-5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Section Heading --}}
    <section>
        <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-lg font-bold tracking-tight text-slate-900">
                    Riwayat Pengajuan
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Lihat informasi dan perkembangan peminjaman ruanganmu.
                </p>
            </div>

            @if ($bookings->total() > 0)
                <p class="text-sm text-slate-500">
                    Total
                    <span class="font-semibold text-slate-800">{{ $bookings->total() }}</span>
                    pengajuan
                </p>
            @endif
        </div>

        @if ($bookings->isNotEmpty())

            {{-- Booking Cards --}}
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 2xl:grid-cols-3">
                @foreach ($bookings as $booking)
                    @php
                        $status = $statusStyles[$booking->status] ?? [
                            'label' => ucfirst($booking->status),
                            'class' => 'bg-slate-100 text-slate-600 ring-slate-500/20',
                            'dot' => 'bg-slate-400',
                        ];
                    @endphp

                    <article class="group relative flex min-w-0 flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-indigo-200 hover:shadow-xl hover:shadow-slate-200/60">

                        {{-- Accent --}}
                        <div class="h-1 w-full {{ $booking->status === 'approved' ? 'bg-emerald-400' : ($booking->status === 'rejected' ? 'bg-rose-400' : ($booking->status === 'pending' ? 'bg-amber-400' : 'bg-slate-300')) }}"></div>

                        <div class="flex flex-1 flex-col p-5 sm:p-6">

                            {{-- Card Top --}}
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-600 group-hover:text-white">
                                        <i data-lucide="door-open" class="h-5 w-5"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400">
                                            Ruangan
                                        </p>
                                        <h3 class="mt-1 break-words font-bold text-slate-900">
                                            {{ $booking->room->room_name ?? 'Ruangan tidak tersedia' }}
                                        </h3>
                                    </div>
                                </div>

                                <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $status['class'] }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                    {{ $status['label'] }}
                                </span>
                            </div>

                            {{-- Building --}}
                            <div class="mt-4 flex items-center gap-2 text-sm text-slate-500">
                                <i data-lucide="building-2" class="h-4 w-4 shrink-0 text-slate-400"></i>
                                <span class="break-words">
                                    {{ $booking->room->building->building_name ?? 'Gedung tidak tersedia' }}
                                </span>
                            </div>

                            {{-- Date and Time --}}
                            <div class="mt-5 grid grid-cols-2 gap-3">
                                <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5">
                                    <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                                        <i data-lucide="calendar-days" class="h-3.5 w-3.5"></i>
                                        Tanggal
                                    </div>

                                    <p class="mt-2 text-xl font-bold tracking-tight text-slate-900">
                                        {{ $booking->booking_date->format('d') }}
                                        <span class="text-sm font-semibold text-slate-500">
                                            {{ $booking->booking_date->format('M') }}
                                        </span>
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-500">
                                        {{ $booking->booking_date->format('Y') }}
                                    </p>
                                </div>

                                <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5">
                                    <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                                        <i data-lucide="clock-3" class="h-3.5 w-3.5"></i>
                                        Waktu
                                    </div>

                                    <p class="mt-2 text-base font-bold tracking-tight text-slate-900">
                                        {{ substr($booking->start_time, 0, 5) }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-500">
                                        sampai {{ substr($booking->end_time, 0, 5) }} WITA
                                    </p>
                                </div>
                            </div>

                            {{-- Purpose --}}
                            <div class="mt-4 flex-1 rounded-xl border border-slate-100 px-4 py-3.5">
                                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    <i data-lucide="clipboard-list" class="h-3.5 w-3.5"></i>
                                    Keperluan
                                </div>

                                <p class="mt-2 break-words text-sm leading-6 text-slate-700">
                                    {{ $booking->purpose }}
                                </p>
                            </div>

                            {{-- Footer --}}
                            <div class="mt-5 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                                <span class="text-xs text-slate-400">
                                    ID #{{ $booking->id }}
                                </span>

                                <a href="{{ route('class-representative.bookings.show', $booking) }}"
                                   class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-600">
                                    Lihat Detail
                                    <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                                </a>
                            </div>

                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($bookings->hasPages())
                <div class="mt-7 flex justify-center rounded-2xl border border-slate-200 bg-white px-4 py-4">
                    {{ $bookings->links() }}
                </div>
            @endif

        @else

            {{-- Empty State --}}
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white px-5 py-14 text-center shadow-sm sm:py-20">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                    <i data-lucide="calendar-plus" class="h-7 w-7"></i>
                </div>

                <h3 class="mt-5 text-lg font-bold text-slate-900">
                    Belum Ada Pengajuan
                </h3>

                <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">
                    Belum ada peminjaman yang tercatat. Buat pengajuan pertamamu untuk mulai memesan ruangan.
                </p>

                <a href="{{ route('class-representative.bookings.create') }}"
                   class="mt-6 inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-700">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Buat Pengajuan
                </a>
            </div>

        @endif
    </section>

</div>
@endsection
