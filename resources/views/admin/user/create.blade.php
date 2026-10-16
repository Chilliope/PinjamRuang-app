
@extends('layouts.admin')

@section('title', 'Tambah User - PinjamRuang')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div>
        <a href="{{ url('/admin/users') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-indigo-600">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali ke User Management
        </a>

        <div class="mt-4">
            <p class="text-sm font-medium text-indigo-600">
                Manajemen Pengguna
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Tambah Pengguna
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Buat akun baru dan tentukan peran pengguna dalam PinjamRuang.
            </p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center gap-3 border-b border-slate-200 px-6 py-5">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                <i data-lucide="user-round-plus" class="h-5 w-5"></i>
            </div>

            <div>
                <h2 class="font-semibold text-slate-900">
                    Informasi Akun
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Lengkapi semua informasi yang diperlukan.
                </p>
            </div>
        </div>

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

        <form action="{{ url('/admin/users') }}" method="POST">
            @csrf

            <div class="space-y-6 p-6">

                {{-- Name --}}
                <div>
                    <label for="fullname"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>

                    <input type="text"
                           id="fullname"
                           name="fullname"
                           value="{{ old('fullname') }}"
                           placeholder="Masukkan nama lengkap"
                           required
                           autocomplete="fullname"
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('name') border-rose-400 @enderror">

                    @error('name')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Email <span class="text-rose-500">*</span>
                    </label>

                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="nama@pinjamruang.com"
                           required
                           autocomplete="email"
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('email') border-rose-400 @enderror">

                    @error('email')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs text-slate-500">
                        Gunakan email yang belum terdaftar.
                    </p>
                </div>

                {{-- Role --}}
                <div>
                    <label for="role"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Role Pengguna <span class="text-rose-500">*</span>
                    </label>

                    <select id="role"
                            name="role"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('role') border-rose-400 @enderror">

                        @foreach ($roles as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('role', 'admin') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('role')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs text-slate-500">
                        Role menentukan jenis akses pengguna di dalam sistem.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    {{-- Password --}}
                    <div>
                        <label for="password"
                               class="mb-2 block text-sm font-semibold text-slate-700">
                            Password <span class="text-rose-500">*</span>
                        </label>

                        <input type="password"
                               id="password"
                               name="password"
                               placeholder="Minimal 8 karakter"
                               required
                               minlength="8"
                               autocomplete="new-password"
                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('password') border-rose-400 @enderror">

                        @error('password')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Confirmation --}}
                    <div>
                        <label for="password_confirmation"
                               class="mb-2 block text-sm font-semibold text-slate-700">
                            Konfirmasi Password <span class="text-rose-500">*</span>
                        </label>

                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="Ulangi password"
                               required
                               minlength="8"
                               autocomplete="new-password"
                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                    </div>
                </div>

                {{-- Security Notice --}}
                <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4">
                    <i data-lucide="shield-check" class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"></i>

                    <div>
                        <p class="text-sm font-semibold text-amber-900">
                            Keamanan akun
                        </p>
                        <p class="mt-1 text-sm leading-6 text-amber-800">
                            Pastikan role sudah sesuai. Password akan di-hash secara otomatis sebelum disimpan.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:justify-end">
                <a href="{{ url('/admin/users') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                    Batal
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                    <i data-lucide="user-plus" class="h-4 w-4"></i>
                    Simpan Pengguna
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
