@extends('layouts.staff')

@section('title', 'Pengajuan Ruangan - PinjamRuang')

@section('content')
<div class="space-y-7">

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

    {{-- Header --}}
    <section class="relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
        <div class="pointer-events-none absolute -right-12 -top-16 h-56 w-56 rounded-full bg-indigo-100/70 blur-3xl"></div>

        <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700">
                    <i data-lucide="clipboard-check" class="h-3.5 w-3.5"></i>
                    STAFF WORKSPACE
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">
                    Pengajuan Ruangan
                </h1>

                <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500 sm:text-base">
                    Periksa permintaan peminjaman dan kelola pengajuan dari gedung yang menjadi tanggung jawabmu.
                </p>
            </div>

            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                <i data-lucide="calendar-check" class="h-7 w-7"></i>
            </div>
        </div>
    </section>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
            <i data-lucide="check-circle-2" class="mt-0.5 h-5 w-5 shrink-0"></i>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <p class="font-semibold">Pengajuan belum dapat diproses.</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- List Heading --}}
    <section>
        <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-lg font-bold tracking-tight text-slate-900">
                    Daftar Pengajuan
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Pengajuan yang perlu diperiksa dan riwayat pemrosesan.
                </p>
            </div>

            <p class="text-sm text-slate-500">
                Total <span class="font-semibold text-slate-800">{{ $bookings->total() }}</span> pengajuan
            </p>
        </div>

        @if ($bookings->isNotEmpty())
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 2xl:grid-cols-3">
                @foreach ($bookings as $booking)
                    @php
                        $status = $statusStyles[$booking->status] ?? [
                            'label' => ucfirst($booking->status),
                            'class' => 'bg-slate-100 text-slate-600 ring-slate-500/20',
                            'dot' => 'bg-slate-400',
                        ];
                    @endphp

                    <article class="group flex min-w-0 flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-indigo-200 hover:shadow-xl hover:shadow-slate-200/60">

                        <div class="h-1 {{ $booking->status === 'pending' ? 'bg-amber-400' : ($booking->status === 'approved' ? 'bg-emerald-400' : ($booking->status === 'rejected' ? 'bg-rose-400' : 'bg-slate-300')) }}"></div>

                        <div class="flex flex-1 flex-col p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-600 group-hover:text-white">
                                        <i data-lucide="door-open" class="h-5 w-5"></i>
                                    </div>

                                    <div class="min-w-0">
                                        <h3 class="break-words font-bold text-slate-900">
                                            {{ $booking->room->room_name ?? 'Ruangan tidak tersedia' }}
                                        </h3>
                                        <p class="mt-1 break-words text-sm text-slate-500">
                                            {{ $booking->room->building->building_name ?? 'Gedung tidak tersedia' }}
                                        </p>
                                    </div>
                                </div>

                                <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1.5 text-xs font-semibold ring-1 ring-inset {{ $status['class'] }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                    {{ $status['label'] }}
                                </span>
                            </div>

                            <div class="mt-5 rounded-xl border border-slate-100 bg-slate-50 p-3.5">
                                <p class="text-xs font-medium text-slate-500">Pemohon</p>
                                <p class="mt-1 break-words text-sm font-semibold text-slate-800">
                                    {{ $booking->user->fullname ?? 'Pengguna tidak tersedia' }}
                                </p>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-3">
                                <div class="rounded-xl border border-slate-100 p-3.5">
                                    <p class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                                        <i data-lucide="calendar-days" class="h-3.5 w-3.5"></i>
                                        Tanggal
                                    </p>
                                    <p class="mt-2 text-sm font-bold text-slate-900">
                                        {{ $booking->booking_date->format('d M Y') }}
                                    </p>
                                </div>

                                <div class="rounded-xl border border-slate-100 p-3.5">
                                    <p class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                                        <i data-lucide="clock-3" class="h-3.5 w-3.5"></i>
                                        Waktu
                                    </p>
                                    <p class="mt-2 text-sm font-bold text-slate-900">
                                        {{ substr($booking->start_time, 0, 5) }}
                                        – {{ substr($booking->end_time, 0, 5) }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4 flex-1 rounded-xl border border-slate-100 px-4 py-3.5">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    Keperluan
                                </p>
                                <p class="mt-2 break-words text-sm leading-6 text-slate-700">
                                    {{ \Illuminate\Support\Str::limit($booking->purpose, 120) }}
                                </p>
                            </div>

                            <div class="mt-5 border-t border-slate-100 pt-4">
                                <a href="{{ route('staff.bookings.show', $booking) }}"
                                   class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-600">
                                    Periksa Pengajuan
                                    <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($bookings->hasPages())
                <div class="mt-7 rounded-2xl border border-slate-200 bg-white px-4 py-4">
                    {{ $bookings->links() }}
                </div>
            @endif
        @else
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-5 py-14 text-center sm:py-20">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                    <i data-lucide="inbox" class="h-7 w-7"></i>
                </div>

                <h3 class="mt-5 text-lg font-bold text-slate-900">
                    Belum Ada Pengajuan
                </h3>

                <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">
                    Pengajuan dari gedung yang menjadi tanggung jawabmu akan muncul di sini.
                </p>
            </div>
        @endif
    </section>
</div>
@endsection
