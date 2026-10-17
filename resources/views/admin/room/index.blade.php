@extends('layouts.admin')

@section('title', 'Room Management - PinjamRuang')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">
                    Manajemen Fasilitas
                </p>

                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Room Management
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Kelola dan pantau data ruangan yang tersedia di PinjamRuang.
                </p>
            </div>

            <a href="{{ url('/admin/rooms/create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Tambah Ruangan
            </a>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Ruangan</p>
                        <h2 class="mt-2 text-3xl font-bold text-slate-900">
                            {{ $rooms->total() }}
                        </h2>
                    </div>

                    <div class="rounded-xl bg-indigo-50 p-3 text-indigo-600">
                        <i data-lucide="door-open" class="h-6 w-6"></i>
                    </div>
                </div>

                <p class="mt-3 text-xs text-slate-500">
                    Seluruh ruangan yang terdaftar
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Data Ditampilkan</p>
                        <h2 class="mt-2 text-3xl font-bold text-slate-900">
                            {{ $rooms->count() }}
                        </h2>
                    </div>

                    <div class="rounded-xl bg-sky-50 p-3 text-sky-600">
                        <i data-lucide="list" class="h-6 w-6"></i>
                    </div>
                </div>

                <p class="mt-3 text-xs text-slate-500">
                    Ruangan pada halaman ini
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:col-span-2 xl:col-span-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Pengelolaan</p>
                        <h2 class="mt-2 text-xl font-bold text-slate-900">
                            Terpusat
                        </h2>
                    </div>

                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <i data-lucide="building-2" class="h-6 w-6"></i>
                    </div>
                </div>

                <p class="mt-3 text-xs text-slate-500">
                    Data ruangan dalam satu dashboard
                </p>
            </div>
        </div>

        {{-- Room Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">


            <div class="border-b border-slate-200 px-6 py-5">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                    <div>
                        <h2 class="font-semibold text-slate-900">
                            Daftar Ruangan
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Cari ruangan dan filter berdasarkan gedung.
                        </p>
                    </div>

                    <form action="{{ url('/admin/rooms') }}" method="GET"
                        class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:flex xl:items-center">

                        {{-- Search Room --}}
                        <div class="relative">
                            <i data-lucide="search"
                                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                            <input type="search" name="search" value="{{ $search }}"
                                placeholder="Cari nama ruangan..."
                                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 xl:w-64">
                        </div>

                        {{-- Filter Building --}}
                        <div class="relative">
                            <i data-lucide="building-2"
                                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                            <select name="building_id"
                                class="w-full appearance-none rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-9 text-sm text-slate-700 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 xl:w-56">

                                <option value="">Semua Gedung</option>

                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}" @selected((string) $selectedBuilding === (string) $building->id)>
                                        {{ $building->building_name }}
                                    </option>
                                @endforeach
                            </select>

                            <i data-lucide="chevron-down"
                                class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                        </div>

                        {{-- Search Button --}}
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            <i data-lucide="filter" class="h-4 w-4"></i>
                            Terapkan
                        </button>

                        {{-- Reset Filter --}}
                        @if ($search || $selectedBuilding)
                            <a href="{{ url('/admin/rooms') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                                <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="mt-4 flex items-center justify-between gap-3">
                    <p class="text-sm text-slate-500">
                        Hasil pencarian:
                        <span class="font-semibold text-slate-800">
                            {{ $rooms->total() }} ruangan
                        </span>
                    </p>
                </div>
            </div>

            {{-- Notifications --}}
            @if (session('success'))
                <div
                    class="mx-6 mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mx-6 mt-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($rooms->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Ruangan</th>
                                <th class="px-6 py-4 font-semibold">Gedung</th>
                                <th class="px-6 py-4 font-semibold">Informasi</th>
                                <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @foreach ($rooms as $room)
                                <tr class="transition hover:bg-slate-50/70">

                                    {{-- Room --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                                                <i data-lucide="door-open" class="h-5 w-5"></i>
                                            </div>

                                            <div>
                                                <p class="font-semibold text-slate-800">
                                                    {{ $room->room_name ?? ($room->name ?? 'Tanpa Nama') }}
                                                </p>

                                                <p class="mt-1 text-xs text-slate-400">
                                                    ID: {{ $room->id }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Building --}}
                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $room->building->building_name ?? 'Belum terhubung' }}
                                    </td>

                                    {{-- Information --}}
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-slate-500">
                                            Data ruangan
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ url('/admin/rooms/' . $room->id . '/edit') }}" title="Edit ruangan"
                                                class="inline-flex items-center justify-center rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600">
                                                <i data-lucide="pencil" class="h-4 w-4"></i>
                                            </a>

                                            <form action="{{ url('/admin/rooms/' . $room->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" title="Hapus ruangan"
                                                    class="inline-flex items-center justify-center rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600">
                                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $rooms->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="px-6 py-16 text-center">
                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                        <i data-lucide="door-closed" class="h-7 w-7"></i>
                    </div>

                    <h3 class="mt-4 font-semibold text-slate-900">
                        Belum ada ruangan
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        Tambahkan ruangan agar datanya muncul di halaman ini.
                    </p>

                    <a href="{{ url('/admin/rooms/create') }}"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        <i data-lucide="plus" class="h-4 w-4"></i>
                        Tambah Ruangan
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        if (window.lucide) {
            window.lucide.createIcons();
        }
    </script>
@endsection
