@extends('layouts.staff')

@section('title', 'Manajemen Ruangan - PinjamRuang')

@section('content')
<div class="space-y-5">

    {{-- PAGE HEADER --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Manajemen Ruangan
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola ruangan dari gedung yang menjadi tanggung jawabmu.
            </p>
        </div>

        <a href="{{ route('staff.rooms.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-200 transition duration-200 hover:bg-indigo-700 active:scale-[0.98]">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Tambah Ruangan
        </a>
    </div>

    {{-- MAIN ROOM CONTAINER --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- SEARCH & FILTER HEADER --}}
        <div class="border-b border-slate-100 p-4 sm:p-5">

            <div class="mb-4 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900">
                        Daftar Ruangan
                    </h2>
                    <p class="mt-1 text-xs text-slate-500">
                        Cari dan kelola ruangan yang berada dalam tanggung jawabmu.
                    </p>
                </div>

                <div>
                    <span class="mt-2 inline-flex w-fit items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-600 sm:mt-0">
                        <i data-lucide="layers" class="h-3.5 w-3.5"></i>
                        {{ $rooms->total() }} Ruangan
                    </span>
                    <span class="mt-2 inline-flex w-fit items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-600 sm:mt-0">
                        <i data-lucide="building" class="h-3.5 w-3.5"></i>
                        {{ $buildings->count() }} Gedung
                    </span>
                </div>
            </div>

            {{-- SEARCH FORM --}}
            <form action="{{ route('staff.rooms.index') }}" method="GET"
                  class="flex flex-col gap-2 sm:flex-row">

                {{-- Search --}}
                <div class="relative min-w-0 flex-1">
                    <i data-lucide="search"
                       class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama ruangan..."
                           class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-50">
                </div>

                {{-- Building Filter --}}
                <div class="relative sm:w-52">
                    <select name="building_id"
                            class="w-full appearance-none rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 pr-9 text-sm text-slate-600 outline-none transition hover:border-slate-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-50">
                        <option value="">Semua Gedung</option>

                        @foreach($buildings as $building)
                            <option value="{{ $building->id }}"
                                {{ request('building_id') == $building->id ? 'selected' : '' }}>
                                {{ $building->building_name }}
                            </option>
                        @endforeach
                    </select>

                    <i data-lucide="chevron-down"
                       class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2">
                    <button type="submit"
                            class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700 active:scale-[0.98] sm:flex-none">
                        <i data-lucide="filter" class="h-4 w-4"></i>
                        Filter
                    </button>

                    <a href="{{ route('staff.rooms.index') }}"
                       title="Reset pencarian"
                       class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-slate-500 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-700">
                        <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                    </a>
                </div>
            </form>
        </div>

        {{-- ROOM CARDS --}}
        <div class="bg-slate-50/50 p-3 sm:p-5">

            @forelse($rooms as $room)
                @if($loop->first)
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
                @endif

                <div class="group flex flex-col rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md">

                    {{-- Card Top --}}
                    <div class="flex items-start justify-between">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-100">
                            <i data-lucide="door-open" class="h-5 w-5"></i>
                        </div>

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            Terdaftar
                        </span>
                    </div>

                    {{-- Card Content --}}
                    <div class="mt-4 flex-1">
                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                            Ruangan #{{ $rooms->firstItem() + $loop->index }}
                        </p>

                        <h3 class="mt-1 break-words text-base font-bold text-slate-900">
                            {{ $room->room_name }}
                        </h3>

                        <div class="mt-3 flex items-center gap-2 text-sm text-slate-500">
                            <i data-lucide="building-2" class="h-4 w-4 shrink-0 text-indigo-500"></i>
                            <span class="truncate">
                                {{ $room->building->building_name ?? 'Gedung tidak ditemukan' }}
                            </span>
                        </div>
                    </div>

                    {{-- Card Actions --}}
                    <div class="mt-4 grid grid-cols-2 gap-2 border-t border-slate-100 pt-3">

                        <a href="{{ route('staff.rooms.edit', $room) }}"
                           class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-slate-200 px-2 py-2.5 text-xs font-semibold text-slate-600 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                            <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                            Edit
                        </a>

                        <form action="{{ route('staff.rooms.destroy', $room) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg border border-rose-100 px-2 py-2.5 text-xs font-semibold text-rose-600 transition hover:border-rose-200 hover:bg-rose-50">
                                <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                Hapus
                            </button>
                        </form>

                    </div>
                </div>

                @if($loop->last)
                    </div>
                @endif

            @empty

                {{-- EMPTY STATE --}}
                <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-slate-300 bg-white px-5 py-12 text-center">

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                        <i data-lucide="door-closed" class="h-7 w-7"></i>
                    </div>

                    <h3 class="mt-4 text-base font-bold text-slate-800">
                        Tidak Ada Ruangan
                    </h3>

                    <p class="mt-1 max-w-sm text-sm leading-relaxed text-slate-500">
                        Belum ada ruangan yang sesuai dengan pencarianmu atau belum ada ruangan yang terdaftar.
                    </p>

                    @if(request()->filled('search') || request()->filled('building_id'))
                        <a href="{{ route('staff.rooms.index') }}"
                           class="mt-4 text-sm font-semibold text-indigo-600 transition hover:text-indigo-700">
                            Reset pencarian
                        </a>
                    @else
                        <a href="{{ route('staff.rooms.create') }}"
                           class="mt-4 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            <i data-lucide="plus" class="h-4 w-4"></i>
                            Tambah Ruangan
                        </a>
                    @endif
                </div>

            @endforelse

        </div>

        {{-- PAGINATION --}}
        @if($rooms->hasPages())
            <div class="border-t border-slate-100 bg-white px-4 py-4 sm:px-5">
                {{ $rooms->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
