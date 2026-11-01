@extends('layouts.class_representative')

@section('title', 'Perubahan Jadwal - PinjamRuang')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            Perubahan Jadwal
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Kelola perubahan penggunaan ruangan untuk kelas yang kamu tangani.
        </p>
    </div>

    {{-- Jadwal Rutin --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 p-5">
            <h2 class="font-bold text-slate-900">Jadwal Kelas Saya</h2>
            <p class="mt-1 text-xs text-slate-500">
                Jadwal rutin yang terhubung dengan kelas kamu.
            </p>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($schedules as $schedule)
                <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="font-semibold text-slate-900">
                                {{ $schedule->schedule_name }}
                            </h3>

                            <span class="rounded-full bg-indigo-50 px-2.5 py-1 text-[10px] font-semibold text-indigo-700">
                                {{ $schedule->classRoom->class_name ?? 'Kelas belum ditentukan' }}
                            </span>
                        </div>

                        <div class="mt-2 flex flex-wrap gap-x-4 gap-y-2 text-sm text-slate-500">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="calendar" class="h-4 w-4"></i>
                                {{ [
                                    'monday' => 'Senin',
                                    'tuesday' => 'Selasa',
                                    'wednesday' => 'Rabu',
                                    'thursday' => 'Kamis',
                                    'friday' => 'Jumat',
                                    'saturday' => 'Sabtu',
                                    'sunday' => 'Minggu'
                                ][$schedule->day_of_week] ?? $schedule->day_of_week }}
                            </span>

                            <span class="flex items-center gap-1.5">
                                <i data-lucide="door-open" class="h-4 w-4"></i>
                                {{ $schedule->room->room_name }}
                            </span>

                            <span class="flex items-center gap-1.5">
                                <i data-lucide="clock" class="h-4 w-4"></i>
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                –
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('class-representative.schedule-changes.create', $schedule) }}"
                       class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl border border-indigo-200 px-4 py-2.5 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-50">
                        <i data-lucide="calendar-clock" class="h-4 w-4"></i>
                        Ajukan Perubahan
                    </a>
                </div>
            @empty
                <div class="p-10 text-center">
                    <i data-lucide="calendar-x" class="mx-auto h-9 w-9 text-slate-300"></i>
                    <p class="mt-3 font-semibold text-slate-700">
                        Belum Ada Jadwal
                    </p>
                    <p class="mt-1 text-sm text-slate-500">
                        Belum ada jadwal yang terhubung dengan kelas kamu.
                    </p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Riwayat Pengajuan --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 p-5">
            <h2 class="font-bold text-slate-900">Riwayat Pengajuan</h2>
            <p class="mt-1 text-xs text-slate-500">
                Pantau status perubahan jadwal yang sudah diajukan.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[750px] text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Jadwal</th>
                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4">Perubahan</th>
                        <th class="px-5 py-4">Pengganti</th>
                        <th class="px-5 py-4">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($changes as $change)
                        <tr>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-800">
                                    {{ $change->schedule->schedule_name }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $change->schedule->room->room_name }}
                                </p>
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $change->exception_date->format('d M Y') }}
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ [
                                    'online' => 'Online',
                                    'postponed' => 'Ditunda',
                                    'cancelled' => 'Dibatalkan',
                                    'rescheduled' => 'Dipindahkan'
                                ][$change->type] ?? $change->type }}
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                @if($change->replacementRoom)
                                    <p>{{ $change->replacementRoom->room_name }}</p>
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $change->replacement_date?->format('d M Y') }}
                                    </p>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                @if($change->status === 'approved')
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                        Disetujui
                                    </span>
                                @elseif($change->status === 'rejected')
                                    <span class="rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                        Menunggu
                                    </span>
                                @endif

                                @if($change->reviewer)
                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $change->reviewer->fullname }}
                                    </p>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-slate-500">
                                Belum ada pengajuan perubahan jadwal.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($changes->hasPages())
            <div class="border-t border-slate-100 p-4">
                {{ $changes->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
