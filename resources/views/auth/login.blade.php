
@extends('layouts.auth')

@section('title', 'Login - PinjamRuang')

@section('content')
    <div>
        {{-- Heading --}}
        <div class="mb-8">
            <div class="mb-6 hidden h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 lg:flex">
                <i data-lucide="lock-keyhole" class="h-6 w-6"></i>
            </div>

            <p class="mb-2 text-sm font-semibold text-indigo-600">
                WELCOME BACKK
            </p>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                Login to your account
            </h1>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Masukkan email dan password untuk melanjutkan ke PinjamRuang.
            </p>
        </div>

        {{-- General Error --}}
        @if ($errors->any())
            <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 p-4">
                <i data-lucide="circle-alert" class="mt-0.5 h-5 w-5 shrink-0 text-red-500"></i>

                <div class="text-sm text-red-700">
                    <p class="font-semibold">Login gagal</p>
                    <p class="mt-1">
                        {{ $errors->first() }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Login Form --}}
        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-slate-700">
                    Email address
                </label>

                <div class="relative">
                    <i data-lucide="mail" class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"></i>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="email@pinjamruang.republikode.com"
                        autocomplete="email"
                        required
                        autofocus
                        class="w-full rounded-xl border bg-white py-3.5 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:ring-4
                        {{ $errors->has('email')
                            ? 'border-red-300 focus:border-red-400 focus:ring-red-50'
                            : 'border-slate-200 focus:border-indigo-400 focus:ring-indigo-50' }}"
                    >
                </div>

                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-slate-700">
                    Password
                </label>

                <div class="relative">
                    <i data-lucide="key-round" class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"></i>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                        class="w-full rounded-xl border bg-white py-3.5 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:ring-4
                        {{ $errors->has('password')
                            ? 'border-red-300 focus:border-red-400 focus:ring-red-50'
                            : 'border-slate-200 focus:border-indigo-400 focus:ring-indigo-50' }}"
                    >
                </div>

                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100"
            >
                Sign In
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </button>
        </form>

        {{-- Security Note --}}
        <div class="mt-6 flex items-center justify-center gap-2 text-xs text-slate-400">
            <i data-lucide="shield-check" class="h-4 w-4"></i>
            <span>Your account is protected and secure.</span>
        </div>
    </div>
@endsection
