@extends('layouts.class_representative')

@section('title', 'Detail Pengajuan - PinjamRuang')

@section('content')
<div class="space-y-6">

    <div>
        <a href="{{ route('class-representative.bookings.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-indigo-600">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali ke Pengajuan
        </a>

        <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900">
            Detail Pengajuan
        </h1>
        <p class="mt-2 text-sm text-slate-500">
            Periksa informasi dan status pengajuan peminjaman.
        </p>
    </div>

    @php
        $statusLabels = [
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
        ];

        $statusStyles = [
            'pending' => 'bg-amber-50 text-amber-700',
            'approved' => 'bg-emerald-50 text-emerald-700',
            'rejected' => 'bg-rose-50 text-rose-700',
            'cancelled' => 'bg-slate-100 text-slate-600',
        ];
    @endphp

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col justify-between gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center">
            <div>
                <p class="text-sm text-slate-500">Nomor Pengajuan</p>
                <h2 class="mt-1 text-lg font-bold text-slate-900">
                    #{{ $booking->id }}
                </h2>
            </div>

            <span class="inline-flex w-fit rounded-full px-3 py-1.5 text-sm font-semibold {{ $statusStyles[$booking->status] ?? 'bg-slate-100 text-slate-600' }}">
                {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">

            <div>
                <p class="text-sm text-slate-500">Nama Ruangan</p>
                <p class="mt-1 font-semibold text-slate-900">
                    {{ $booking->room->room_name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Gedung</p>
                <p class="mt-1 font-semibold text-slate-900">
                    {{ $booking->room->building->building_name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Tanggal Peminjaman</p>
                <p class="mt-1 font-semibold text-slate-900">
                    {{ $booking->booking_date->format('d F Y') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Waktu Peminjaman</p>
                <p class="mt-1 font-semibold text-slate-900">
                    {{ substr($booking->start_time, 0, 5) }}
                    – {{ substr($booking->end_time, 0, 5) }}
                </p>
            </div>

            <div class="sm:col-span-2">
                <p class="text-sm text-slate-500">Keperluan</p>
                <p class="mt-2 whitespace-pre-line leading-7 text-slate-700">
                    {{ $booking->purpose }}
                </p>
            </div>

            @if ($booking->reviewer)
                <div>
                    <p class="text-sm text-slate-500">Diproses oleh</p>
                    <p class="mt-1 font-semibold text-slate-900">
                        {{ $booking->reviewer->fullname }}
                    </p>
                </div>
            @endif

            @if ($booking->reviewed_at)
                <div>
                    <p class="text-sm text-slate-500">Waktu Keputusan</p>
                    <p class="mt-1 font-semibold text-slate-900">
                        {{ $booking->reviewed_at->format('d F Y, H:i') }}
                    </p>
                </div>
            @endif

            @if ($booking->status === 'rejected' && $booking->rejection_reason)
                <div class="sm:col-span-2 rounded-xl border border-rose-200 bg-rose-50 p-4">
                    <p class="font-semibold text-rose-800">Alasan Penolakan</p>
                    <p class="mt-2 text-sm leading-6 text-rose-700">
                        {{ $booking->rejection_reason }}
                    </p>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
