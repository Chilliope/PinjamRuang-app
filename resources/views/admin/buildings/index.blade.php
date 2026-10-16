@extends('layouts.admin')

@section('title', 'Buildings - PinjamRuang')
@section('page-title', 'Buildings')
@section('breadcrumb', 'Buildings / Overview')

@section('heading')
    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-slate-400">
                <i data-lucide="building-2" class="h-4 w-4"></i>
                <span>Facility Management</span>
                <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
                <span>Buildings</span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Buildings
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Kelola data gedung dan fasilitas yang tersedia di PinjamRuang.
            </p>
        </div>

        <a href="{{ url('/admin/buildings/create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Add Building
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6">

        <form action="{{ route('buildings.index') }}" method="GET">
            <div class="relative max-w-md">
                <svg class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>

                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search buildings..."
                    autocomplete="off"
                    class="w-full rounded-xl border border-gray-200 bg-white py-3 pl-11 pr-4 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-400 focus:ring-4 focus:ring-gray-100">
            </div>
        </form>

        {{-- Building Cards --}}
        @if ($buildings->count())
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($buildings as $building)
                    <article
                        class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md">
                        {{-- Card Top --}}
                        <div class="flex items-start justify-between gap-4">
                            <div
                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-600 group-hover:text-white">
                                <i data-lucide="building-2" class="h-6 w-6"></i>
                            </div>

                            <span
                                class="rounded-full border border-slate-200 px-2.5 py-1 text-xs font-medium text-slate-500">
                                Building #{{ $building->id }}
                            </span>
                        </div>

                        {{-- Building Details --}}
                        <div class="mt-5">
                            <h3 class="text-base font-semibold text-slate-900">
                                {{ $building->building_name }}
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-slate-500">
                                Informasi gedung dan pengelolaan fasilitas.
                            </p>
                        </div>

                        {{-- Card Actions --}}
                        <div class="mt-6 flex items-center justify-between gap-2 border-t border-slate-100 pt-4">
                            <span class="text-xs text-slate-400">
                                Building information
                            </span>

                            <div class="flex items-center gap-1">
                                {{-- Edit --}}
                                <a href="{{ url('/admin/buildings/' . $building->id . '/edit') }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100 hover:text-slate-950">
                                    <i data-lucide="pencil" class="h-4 w-4"></i>
                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ url('/admin/buildings/' . $building->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus {{ addslashes($building->building_name) }}? Data yang dihapus tidak dapat dikembalikan.')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($buildings instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="pt-2">
                    {{ $buildings->links() }}
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-500">
                    <i data-lucide="building-2" class="h-7 w-7"></i>
                </div>

                <h2 class="mt-4 text-base font-semibold text-slate-900">
                    No buildings found
                </h2>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Belum ada data gedung yang terdaftar.
                    Mulai dengan menambahkan gedung pertama.
                </p>

                <a href="{{ url('/admin/buildings/create') }}"
                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Create your first building
                </a>
            </div>
        @endif
    </div>
@endsection
