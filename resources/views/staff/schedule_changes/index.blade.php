@extends('layouts.staff')

@section('content')
    <div class="space-y-7">

        {{-- Header --}}
        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-sm text-gray-400">
                    <i data-lucide="calendar-days" class="h-4 w-4"></i>
                    <span>Manajemen Jadwal</span>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-blue-600">Perubahan Jadwal</span>
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                    Pengajuan Perubahan Jadwal
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Kelola dan tinjau perubahan jadwal perkuliahan dari Class Representative.
                </p>
            </div>

            <a href="{{ route('staff.schedule-changes.direct.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-200 transition hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-md">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Buat Perubahan Langsung
            </a>
        </div>

        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 p-4">
                <div class="flex items-center gap-2 text-sm font-semibold text-red-800">
                    <i data-lucide="alert-triangle" class="h-4 w-4"></i>
                    Perubahan belum dapat diproses
                </div>
                <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Overview --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pengajuan</p>
                        <h3 class="mt-2 text-2xl font-bold text-gray-900">
                            {{ $changes->total() }}
                        </h3>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <i data-lucide="calendar-range" class="h-5 w-5"></i>
                    </div>
                </div>
                <p class="mt-3 text-xs text-gray-400">Seluruh pengajuan perubahan jadwal</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Menunggu Tinjauan</p>
                        <h3 class="mt-2 text-2xl font-bold text-amber-600">
                            {{ $changes->getCollection()->where('status', 'pending')->count() }}
                        </h3>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                        <i data-lucide="clock-3" class="h-5 w-5"></i>
                    </div>
                </div>
                <p class="mt-3 text-xs text-gray-400">Pengajuan pada halaman ini</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Telah Disetujui</p>
                        <h3 class="mt-2 text-2xl font-bold text-emerald-600">
                            {{ $changes->getCollection()->where('status', 'approved')->count() }}
                        </h3>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i data-lucide="calendar-check" class="h-5 w-5"></i>
                    </div>
                </div>
                <p class="mt-3 text-xs text-gray-400">Pengajuan pada halaman ini</p>
            </div>
        </div>

        {{-- Main Table --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            {{-- Table Header --}}
            <div
                class="flex flex-col gap-3 border-b border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="text-base font-bold text-gray-900">
                        Daftar Perubahan Jadwal
                    </h2>
                    <p class="mt-1 text-xs text-gray-500">
                        Informasi pengajuan dan tindakan yang dapat dilakukan.
                    </p>
                </div>

                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                    Menunggu persetujuan Staff
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1050px] text-left">
                    <thead>
                        <tr
                            class="border-b border-gray-100 bg-gray-50/80 text-[11px] font-semibold uppercase tracking-wider text-gray-400">
                            <th class="px-6 py-4">Informasi Jadwal</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Jenis Perubahan</th>
                            <th class="px-6 py-4">Pengaju</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Tindakan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($changes as $change)
                            <tr class="group transition hover:bg-gray-50/80">

                                {{-- Schedule --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                            <i data-lucide="book-open" class="h-5 w-5"></i>
                                        </div>

                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-800">
                                                {{ $change->schedule->schedule_name }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $change->schedule->classRoom?->class_name ?? 'Tanpa kelas' }}
                                            </p>

                                            <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-gray-400">
                                                <span class="inline-flex items-center gap-1">
                                                    <i data-lucide="map-pin" class="h-3 w-3"></i>
                                                    {{ $change->schedule->room->room_name }}
                                                </span>
                                                <span>·</span>
                                                <span>
                                                    {{ $change->schedule->room->building->building_name }}
                                                </span>
                                            </div>

                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ $change->schedule->start_time }}
                                                – {{ $change->schedule->end_time }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Date --}}
                                <td class="px-6 py-5">
                                    <div class="font-medium text-gray-700">
                                        {{ $change->exception_date->format('d M Y') }}
                                    </div>
                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $change->exception_date->format('l') }}
                                    </p>
                                </td>

                                {{-- Type --}}
                                <td class="px-6 py-5">
                                    @php
                                        $types = [
                                            'online' => [
                                                'label' => 'Online',
                                                'icon' => 'monitor',
                                                'class' => 'bg-violet-50 text-violet-700',
                                            ],
                                            'postponed' => [
                                                'label' => 'Ditunda',
                                                'icon' => 'calendar-clock',
                                                'class' => 'bg-amber-50 text-amber-700',
                                            ],
                                            'cancelled' => [
                                                'label' => 'Dibatalkan',
                                                'icon' => 'calendar-x',
                                                'class' => 'bg-red-50 text-red-700',
                                            ],
                                            'rescheduled' => [
                                                'label' => 'Dijadwalkan Ulang',
                                                'icon' => 'calendar-sync',
                                                'class' => 'bg-blue-50 text-blue-700',
                                            ],
                                        ];

                                        $type = $types[$change->type] ?? [
                                            'label' => ucfirst($change->type),
                                            'icon' => 'calendar',
                                            'class' => 'bg-gray-100 text-gray-600',
                                        ];
                                    @endphp

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-semibold {{ $type['class'] }}">
                                        <i data-lucide="{{ $type['icon'] }}" class="h-3.5 w-3.5"></i>
                                        {{ $type['label'] }}
                                    </span>

                                    @if ($change->type === 'rescheduled')
                                        <div class="mt-2 space-y-1 text-xs text-gray-500">
                                            <p class="font-medium text-gray-700">
                                                {{ $change->replacementRoom?->room_name ?? '-' }}
                                            </p>
                                            <p>
                                                {{ $change->replacement_date?->format('d M Y') ?? '-' }}
                                            </p>
                                            <p>
                                                {{ $change->replacement_start_time ?? '-' }}
                                                – {{ $change->replacement_end_time ?? '-' }}
                                            </p>
                                        </div>
                                    @endif

                                    <p class="mt-2 max-w-[200px] text-xs leading-relaxed text-gray-400"
                                        title="{{ $change->reason }}">
                                        {{ \Illuminate\Support\Str::limit($change->reason, 75) }}
                                    </p>
                                </td>

                                {{-- Requester --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-100 text-xs font-bold text-gray-600">
                                            {{ strtoupper(substr($change->requester?->fullname ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">
                                                {{ $change->requester?->fullname ?? '-' }}
                                            </p>
                                            <p class="mt-0.5 text-xs text-gray-400">
                                                Pengaju
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-5">
                                    @if ($change->status === 'pending')
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Menunggu
                                        </span>
                                    @elseif ($change->status === 'approved')
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Disetujui
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                            Ditolak
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-5">
                                    @if ($change->status === 'pending')
                                        <div class="flex justify-end gap-2">
                                            <form action="{{ route('staff.schedule-changes.approve', $change) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah kamu yakin ingin menyetujui pengajuan ini?')">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" title="Setujui pengajuan"
                                                    class="inline-flex h-9 items-center gap-1.5 rounded-lg bg-emerald-600 px-3 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                                    <i data-lucide="check" class="h-3.5 w-3.5"></i>
                                                    Setujui
                                                </button>
                                            </form>

                                            <form action="{{ route('staff.schedule-changes.reject', $change) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah kamu yakin ingin menolak pengajuan ini?')">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" title="Tolak pengajuan"
                                                    class="inline-flex h-9 items-center gap-1.5 rounded-lg border border-red-200 bg-white px-3 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                                                    <i data-lucide="x" class="h-3.5 w-3.5"></i>
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="text-right">
                                            <p class="text-xs font-medium text-gray-600">
                                                {{ $change->reviewer?->fullname ?? '-' }}
                                            </p>
                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ $change->reviewed_at?->format('d M Y, H:i') ?? '-' }}
                                            </p>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-50 text-gray-400">
                                        <i data-lucide="calendar-search" class="h-8 w-8"></i>
                                    </div>

                                    <h3 class="mt-4 text-sm font-semibold text-gray-800">
                                        Belum ada pengajuan perubahan
                                    </h3>

                                    <p class="mx-auto mt-2 max-w-sm text-xs leading-relaxed text-gray-400">
                                        Pengajuan dari Class Representative akan muncul di halaman ini.
                                        Kamu juga dapat membuat perubahan jadwal secara langsung.
                                    </p>

                                    <a href="{{ route('staff.schedule-changes.direct.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-blue-700">
                                        <i data-lucide="plus" class="h-4 w-4"></i>
                                        Buat Perubahan Jadwal
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($changes->hasPages())
                <div
                    class="flex flex-col gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-gray-400">
                        Menampilkan
                        <span class="font-semibold text-gray-700">{{ $changes->firstItem() }}</span>
                        sampai
                        <span class="font-semibold text-gray-700">{{ $changes->lastItem() }}</span>
                        dari
                        <span class="font-semibold text-gray-700">{{ $changes->total() }}</span>
                        pengajuan
                    </p>

                    <div>
                        {{ $changes->links() }}
                    </div>
                </div>
            @endif
        </div>

        <div class="flex items-start gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 p-4">
            <i data-lucide="lightbulb" class="mt-0.5 h-5 w-5 shrink-0 text-blue-600"></i>
            <div>
                <p class="text-sm font-semibold text-blue-900">Informasi pengelolaan jadwal</p>
                <p class="mt-1 text-xs leading-relaxed text-blue-700">
                    Pengajuan yang disetujui hanya memengaruhi jadwal pada tanggal yang dipilih.
                    Jadwal rutin pada minggu berikutnya tetap berlaku seperti biasa.
                </p>
            </div>
        </div>

    </div>
@endsection
