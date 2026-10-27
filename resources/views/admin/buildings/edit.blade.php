
@extends('layouts.admin')

@section('title', 'Edit Building - PinjamRuang')
@section('page-title', 'Edit Building')
@section('breadcrumb', 'Buildings / Edit')

@section('heading')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-slate-400">
                <i data-lucide="building-2" class="h-4 w-4"></i>
                <span>Facility Management</span>
                <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
                <span>Buildings</span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Edit Building
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Perbarui informasi gedung dan jurusan yang memiliki akses.
            </p>
        </div>

        <a
            href="{{ url('/admin/buildings') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-slate-900"
        >
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Back to Buildings
        </a>
    </div>
@endsection

@section('content')
    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">

        {{-- Card Header --}}
        <div class="flex items-center gap-4 border-b border-slate-100 px-6 py-5 sm:px-8">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                <i data-lucide="pencil-line" class="h-6 w-6"></i>
            </div>

            <div>
                <h2 class="text-base font-semibold text-slate-900">
                    Building Information
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Edit detail gedung berikut sesuai kebutuhan.
                </p>
            </div>
        </div>

        {{-- Form --}}
        <form
            action="{{ url('/admin/buildings/' . $building->id) }}"
            method="POST"
            class="space-y-6 p-6 sm:p-8"
        >
            @csrf
            @method('PUT')

            {{-- Building Name --}}
            <div>
                <label
                    for="building_name"
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    Building Name
                    <span class="text-red-500">*</span>
                </label>

                <div class="relative">
                    <i
                        data-lucide="building"
                        class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                    ></i>

                    <input
                        type="text"
                        id="building_name"
                        name="building_name"
                        value="{{ old('building_name', $building->building_name) }}"
                        placeholder="Enter building name..."
                        required
                        autofocus
                        class="w-full rounded-xl border bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:ring-4
                        {{ $errors->has('building_name')
                            ? 'border-red-300 focus:border-red-400 focus:ring-red-50'
                            : 'border-slate-200 focus:border-indigo-400 focus:ring-indigo-50' }}"
                    >
                </div>

                @error('building_name')
                    <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                        <i data-lucide="circle-alert" class="h-4 w-4"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Major --}}
            <div>
                <label
                    for="major_id"
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    Major
                </label>

                <div class="relative">
                    <i
                        data-lucide="graduation-cap"
                        class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                    ></i>

                    <select
                        name="major_id"
                        id="major_id"
                        class="w-full appearance-none rounded-xl border bg-white py-3 pl-11 pr-10 text-sm text-slate-900 outline-none transition focus:ring-4
                        {{ $errors->has('major_id')
                            ? 'border-red-300 focus:border-red-400 focus:ring-red-50'
                            : 'border-slate-200 focus:border-indigo-400 focus:ring-indigo-50' }}"
                    >
                        <option
                            value=""
                            @selected(old('major_id', $major?->id) == '')
                        >
                            Universal — All Majors
                        </option>

                        @foreach ($majors as $majorOption)
                            <option
                                value="{{ $majorOption->id }}"
                                @selected((string) old('major_id', $major?->id) === (string) $majorOption->id)
                            >
                                {{ $majorOption->major }}
                            </option>
                        @endforeach
                    </select>

                    <i
                        data-lucide="chevron-down"
                        class="pointer-events-none absolute right-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                    ></i>
                </div>

                @error('major_id')
                    <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                        <i data-lucide="circle-alert" class="h-4 w-4"></i>
                        {{ $message }}
                    </p>
                @enderror

                <p class="mt-2 text-xs leading-5 text-slate-400">
                    Pilih jurusan tertentu atau Universal jika gedung dapat digunakan oleh semua jurusan.
                </p>
            </div>

            {{-- Form Actions --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-slate-400">
                    <span class="text-red-500">*</span>
                    Wajib diisi
                </p>

                <div class="flex flex-col-reverse gap-3 sm:flex-row">
                    <a
                        href="{{ url('/admin/buildings') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100"
                    >
                        <i data-lucide="save" class="h-4 w-4"></i>
                        Update Building
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
