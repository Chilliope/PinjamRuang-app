
@extends('layouts.admin')

@section('title', 'Edit User - PinjamRuang')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div>
        <a href="{{ url('/admin/users?role=' . $user->role) }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-indigo-600">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Kembali ke User Management
        </a>

        <div class="mt-4">
            <p class="text-sm font-medium text-indigo-600">
                Manajemen Pengguna
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Edit Pengguna
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Perbarui informasi akun dan hak akses pengguna.
            </p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center gap-3 border-b border-slate-200 px-6 py-5">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                <i data-lucide="user-round-pen" class="h-5 w-5"></i>
            </div>

            <div>
                <h2 class="font-semibold text-slate-900">
                    Informasi Akun
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    ID Pengguna: {{ $user->id }}
                </p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mx-6 mt-6 rounded-xl border border-rose-200 bg-rose-50 p-4">
                <p class="font-semibold text-rose-800">
                    Data belum dapat disimpan
                </p>

                <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-rose-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/admin/users/' . $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6 p-6">

                {{-- Fullname --}}
                <div>
                    <label for="fullname"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>

                    <input type="text"
                           id="fullname"
                           name="fullname"
                           value="{{ old('fullname', $user->fullname) }}"
                           placeholder="Masukkan nama lengkap"
                           autocomplete="name"
                           required
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

                    @error('fullname')
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
                           value="{{ old('email', $user->email) }}"
                           placeholder="nama@pinjamruang.com"
                           autocomplete="email"
                           required
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

                    @error('email')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
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
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

                        @foreach ($roles as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('role', $user->role) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('role')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="rounded-xl border border-slate-200 p-5">
                    <div class="mb-4">
                        <h3 class="font-semibold text-slate-800">
                            Ubah Password
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Kosongkan jika tidak ingin mengganti password saat ini.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="password"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Password Baru
                            </label>

                            <input type="password"
                                   id="password"
                                   name="password"
                                   placeholder="Minimal 8 karakter"
                                   minlength="8"
                                   autocomplete="new-password"
                                   class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

                            @error('password')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Konfirmasi Password Baru
                            </label>

                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Ulangi password baru"
                                   minlength="8"
                                   autocomplete="new-password"
                                   class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:justify-end">
                <a href="{{ url('/admin/users?role=' . $user->role) }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                    Batal
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100">
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
