@extends('layouts.staff')

@section('title', 'Detail Pengajuan - PinjamRuang')

@section('content')
<div class="space-y-7">

    @php
        $statusStyles = [
            'pending' => [
                'label' => 'Menunggu Persetujuan',
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

        $status = $statusStyles[$booking->status] ?? [
            'label' => ucfirst($booking->status),
            'class' => 'bg-slate-100 text-slate-600 ring-slate-500/20',
            'dot' => 'bg-slate-400',
        ];
    @endphp

    {{-- Header --}}
    <section class="relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8">
        <div class="pointer-events-none absolute -right-12 -top-16 h-56 w-56 rounded-full bg-indigo-100/70 blur-3xl"></div>

        <div class="relative">
            <a href="{{ route('staff.bookings.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-indigo-600">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Kembali ke Pengajuan
            </a>

            <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">
                        Detail Pengajuan #{{ $booking->id }}
                    </p>

                    <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">
                        {{ $booking->room->room_name ?? 'Ruangan tidak tersedia' }}
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        {{ $booking->room->building->building_name ?? 'Gedung tidak tersedia' }}
                    </p>
                </div>

                <span class="inline-flex w-fit items-center gap-2 rounded-full px-3.5 py-2 text-sm font-semibold ring-1 ring-inset {{ $status['class'] }}">
                    <span class="h-2 w-2 rounded-full {{ $status['dot'] }}"></span>
                    {{ $status['label'] }}
                </span>
            </div>
        </div>
    </section>

    {{-- Flash Messages --}}
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

    <div class="grid grid-cols-1 items-start gap-5 xl:grid-cols-3">

        {{-- Booking Information --}}
        <section class="space-y-5 xl:col-span-2">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-5 sm:px-6">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                        <i data-lucide="calendar-clock" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900">Informasi Peminjaman</h2>
                        <p class="mt-1 text-sm text-slate-500">Detail jadwal dan keperluan.</p>
                    </div>
                </div>

                <div class="space-y-5 p-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                            <p class="text-xs font-medium text-slate-500">Tanggal Peminjaman</p>
                            <p class="mt-2 font-bold text-slate-900">
                                {{ $booking->booking_date->format('d M Y') }}
                            </p>
                        </div>

                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                            <p class="text-xs font-medium text-slate-500">Waktu Peminjaman</p>
                            <p class="mt-2 font-bold text-slate-900">
                                {{ substr($booking->start_time, 0, 5) }}
                                – {{ substr($booking->end_time, 0, 5) }} WITA
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-slate-700">Keperluan</p>
                        <p class="mt-2 whitespace-pre-line break-words text-sm leading-7 text-slate-600">{{ $booking->purpose }}</p>
                    </div>

                    @if ($booking->status === 'rejected' && $booking->rejection_reason)
                        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4">
                            <p class="flex items-center gap-2 text-sm font-bold text-rose-800">
                                <i data-lucide="message-square-warning" class="h-4 w-4"></i>
                                Alasan Penolakan
                            </p>
                            <p class="mt-2 whitespace-pre-line break-words text-sm leading-6 text-rose-700">
                                {{ $booking->rejection_reason }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Applicant --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-5 sm:px-6">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                        <i data-lucide="user-round" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900">Informasi Pemohon</h2>
                        <p class="mt-1 text-sm text-slate-500">Pengguna yang mengajukan peminjaman.</p>
                    </div>
                </div>

                <div class="p-5 sm:p-6">
                    <p class="text-xs font-medium text-slate-500">Nama Pemohon</p>
                    <p class="mt-1 font-semibold text-slate-900">
                        {{ $booking->user->fullname ?? 'Pengguna tidak tersedia' }}
                    </p>

                    @if ($booking->reviewer)
                        <div class="mt-5 border-t border-slate-100 pt-5">
                            <p class="text-xs font-medium text-slate-500">Diproses oleh</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $booking->reviewer->fullname }}
                            </p>
                            @if ($booking->reviewed_at)
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $booking->reviewed_at->format('d M Y, H:i') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Review Actions --}}
        <aside class="space-y-5">
            @if ($booking->status === 'pending')
                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-5 py-5">
                        <h2 class="font-bold text-slate-900">Tindakan Staff</h2>
                        <p class="mt-1 text-sm leading-5 text-slate-500">
                            Periksa jadwal dan keperluan sebelum mengambil keputusan.
                        </p>
                    </div>

                    <div class="space-y-4 p-5">
                        {{-- Approve --}}
                        <form action="{{ route('staff.bookings.approve', $booking) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menyetujui pengajuan ini?')">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-600/15 transition hover:bg-emerald-700">
                                <i data-lucide="check-circle-2" class="h-4 w-4"></i>
                                Setujui Pengajuan
                            </button>
                        </form>

                        <div class="border-t border-slate-100 pt-4">
                            <p class="mb-3 text-sm font-semibold text-slate-800">
                                Tolak Pengajuan
                            </p>

                            <form action="{{ route('staff.bookings.reject', $booking) }}"
                                  method="POST"
                                  class="space-y-3">
                                @csrf
                                @method('PATCH')

                                <label for="rejection_reason" class="block text-sm font-medium text-slate-700">
                                    Alasan Penolakan <span class="text-rose-500">*</span>
                                </label>

                                <textarea id="rejection_reason"
                                          name="rejection_reason"
                                          rows="4"
                                          maxlength="2000"
                                          required
                                          placeholder="Jelaskan alasan pengajuan ditolak..."
                                          class="block w-full rounded-xl border border-slate-200 px-3.5 py-3 text-sm leading-6 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-rose-400 focus:ring-4 focus:ring-rose-500/10">{{ old('rejection_reason') }}</textarea>

                                @error('rejection_reason')
                                    <p class="text-sm text-rose-600">{{ $message }}</p>
                                @enderror

                                <button type="submit"
                                        onclick="return confirm('Yakin ingin menolak pengajuan ini?')"
                                        class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-xl border border-rose-200 bg-white px-4 py-3 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">
                                    <i data-lucide="x-circle" class="h-4 w-4"></i>
                                    Tolak Pengajuan
                                </button>
                            </form>
                        </div>
                    </div>
                </section>
            @else
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl {{ $booking->status === 'approved' ? 'bg-emerald-50 text-emerald-600' : ($booking->status === 'rejected' ? 'bg-rose-50 text-rose-600' : 'bg-slate-100 text-slate-500') }}">
                        <i data-lucide="{{ $booking->status === 'approved' ? 'check-circle-2' : ($booking->status === 'rejected' ? 'x-circle' : 'info') }}" class="h-5 w-5"></i>
                    </div>

                    <h2 class="mt-4 font-bold text-slate-900">
                        Pengajuan Telah Diproses
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Pengajuan ini berstatus {{ strtolower($status['label']) }} dan tidak dapat diproses kembali melalui halaman ini.
                    </p>
                </section>
            @endif

            <a href="{{ route('staff.bookings.index') }}"
               class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Kembali ke Daftar
            </a>
        </aside>
    </div>
</div>
@endsection
