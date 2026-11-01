@extends('layouts.admin')

@section('title', 'Tambah Kelas - PinjamRuang')

@section('content')
<div class="mx-auto max-w-3xl space-y-5">

    <div>
        <a href="{{ route('classes.index') }}"
           class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali ke Manajemen Kelas
        </a>

        <h1 class="mt-4 text-2xl font-bold text-slate-900">Tambah Kelas</h1>
        <p class="mt-1 text-sm text-slate-500">
            Tambahkan kelas dan tentukan Class Representative.
        </p>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        <form action="{{ route('classes.store') }}" method="POST" class="space-y-5">
            @csrf

            @if($errors->any())
                <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                    <p class="mb-2 font-semibold">Periksa kembali data berikut:</p>
                    <ul class="list-inside list-disc space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Program Studi
                </label>
                <select name="major_id" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500">
                    <option value="">Pilih Jurusan</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}"
                            @selected(old('major_id') == $major->id)>
                            {{ $major->major }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Nama Kelas
                </label>
                <input type="text" name="class_name"
                       value="{{ old('class_name') }}"
                       placeholder="Contoh: SI-2A"
                       required
                       class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Semester
                </label>
                <select name="semester" required
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500">
                    <option value="">Pilih Semester</option>
                    @foreach(range(1, 8) as $semester)
                        <option value="{{ $semester }}"
                            @selected(old('semester') == $semester)>
                            Semester {{ $semester }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Class Representative
                </label>
                <select name="class_representatives[]" multiple
                        class="min-h-36 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-indigo-500">
                    @foreach($classRepresentatives as $representative)
                        <option value="{{ $representative->id }}"
                            @selected(in_array(
                                $representative->id,
                                old('class_representatives', [])
                            ))>
                            {{ $representative->fullname }} — {{ $representative->email }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-2 text-xs text-slate-500">
                    Tahan Ctrl (Windows) atau Command (Mac) untuk memilih lebih dari satu akun.
                </p>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('classes.index') }}"
                   class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Batal
                </a>

                <button type="submit"
                        class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700">
                    Simpan Kelas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
