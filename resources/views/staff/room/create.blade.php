@extends('layouts.staff')

@section('title', 'Tambah Ruangan - PinjamRuang')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">

    <div>
        <a href="{{ route('staff.rooms.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-indigo-600">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali ke Manajemen Ruangan
        </a>

        <h1 class="mt-4 text-2xl font-bold text-slate-900">
            Tambah Ruangan
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Masukkan informasi ruangan yang ingin ditambahkan.
        </p>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form action="{{ route('staff.rooms.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="room_name" class="mb-2 block text-sm font-semibold text-slate-700">
                    Nama Ruangan
                </label>

                <input type="text"
                       name="room_name"
                       id="room_name"
                       value="{{ old('room_name') }}"
                       placeholder="Contoh: Laboratorium Komputer 1"
                       required
                       class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">

                @error('room_name')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="building_id" class="mb-2 block text-sm font-semibold text-slate-700">
                    Gedung
                </label>

                <select name="building_id"
                        id="building_id"
                        required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                    <option value="">Pilih Gedung</option>

                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}"
                            {{ old('building_id') == $building->id ? 'selected' : '' }}>
                            {{ $building->building_name }}
                        </option>
                    @endforeach
                </select>

                @error('building_id')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror

                <p class="mt-2 text-xs text-slate-500">
                    Pilihan hanya menampilkan gedung yang ditugaskan kepadamu.
                </p>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
                <a href="{{ route('staff.rooms.index') }}"
                   class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Batal
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Simpan Ruangan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
