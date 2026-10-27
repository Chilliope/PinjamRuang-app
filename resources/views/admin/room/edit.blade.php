
@extends('layouts.admin')

@section('title', 'Edit Ruangan - PinjamRuang')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div>
        <a href="{{ url('/admin/rooms') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-indigo-600">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali ke Room Management
        </a>

        <div class="mt-4">
            <p class="text-sm font-medium text-indigo-600">
                Manajemen Fasilitas
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Edit Ruangan
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Perbarui informasi ruangan yang terdaftar di PinjamRuang.
            </p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center gap-3 border-b border-slate-200 px-6 py-5">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                <i data-lucide="door-open" class="h-5 w-5"></i>
            </div>

            <div>
                <h2 class="font-semibold text-slate-900">
                    Informasi Ruangan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    ID Ruangan: {{ $room->id }}
                </p>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mx-6 mt-6 rounded-xl border border-rose-200 bg-rose-50 p-4">
                <div class="flex items-start gap-3">
                    <i data-lucide="circle-alert" class="mt-0.5 h-5 w-5 text-rose-600"></i>

                    <div>
                        <p class="font-semibold text-rose-800">
                            Data belum dapat disimpan
                        </p>

                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-rose-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ url('/admin/rooms/' . $room->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6 p-6">

                {{-- Room Name --}}
                <div>
                    <label for="room_name"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Nama Ruangan <span class="text-rose-500">*</span>
                    </label>

                    <input type="text"
                           id="room_name"
                           name="room_name"
                           value="{{ old('room_name', $room->room_name) }}"
                           placeholder="Contoh: Ruang Kelas A101"
                           required
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('room_name') border-rose-400 @enderror">

                    @error('room_name')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Building --}}
                <div>
                    <label for="building_id"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Gedung <span class="text-rose-500">*</span>
                    </label>

                    <select id="building_id"
                            name="building_id"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('building_id') border-rose-400 @enderror">

                        <option value="">Pilih gedung</option>

                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}"
                                @selected((string) old('building_id', $room->building_id) === (string) $building->id)>
                                {{ $building->building_name }}
                            </option>
                        @endforeach
                    </select>

                    @error('building_id')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror

                    @if ($buildings->isEmpty())
                        <p class="mt-2 text-sm text-amber-600">
                            Belum ada gedung yang tersedia. Tambahkan gedung terlebih dahulu.
                        </p>
                    @else
                        <p class="mt-2 text-xs text-slate-500">
                            Pilih gedung tempat ruangan ini berada.
                        </p>
                    @endif
                </div>

                {{-- Information Notice --}}
                <div class="flex items-start gap-3 rounded-xl border border-indigo-100 bg-indigo-50 p-4">
                    <i data-lucide="info" class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600"></i>

                    <div>
                        <p class="text-sm font-semibold text-indigo-900">
                            Informasi
                        </p>

                        <p class="mt-1 text-sm leading-6 text-indigo-800">
                            Perubahan akan diterapkan setelah kamu menekan tombol Simpan Perubahan.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:justify-end">
                <a href="{{ url('/admin/rooms') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                    Batal
                </a>

                <button type="submit"
                        @disabled($buildings->isEmpty())
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 disabled:cursor-not-allowed disabled:opacity-50">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    if (window.lucide) {
        window.lucide.createIcons();
    }
</script>
@endsection
