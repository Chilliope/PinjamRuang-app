@extends('layouts.admin')

@section('title', 'Admin Dashboard - PinjamRuang')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Overview')

@section('heading')
    <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div>
            <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1.5">
                <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                <span class="text-[11px] font-semibold text-indigo-700">
                    Administrator Workspace
                </span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Dashboard Overview
            </h1>

            <p class="mt-2 max-w-xl text-sm leading-6 text-slate-500">
                Welcome back! Here's what's happening with your room management system.
            </p>
        </div>

        <div class="flex items-center gap-2 text-xs text-slate-500">
            <i data-lucide="calendar-days" class="h-4 w-4"></i>
            <span>{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>
@endsection

@section('content')

    {{-- Statistics --}}
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Users --}}
        <div class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Users
                    </p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                        {{ $totalUsers ?? '—' }}
                    </h2>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-100">
                    <i data-lucide="users" class="h-5 w-5"></i>
                </div>
            </div>

            <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4">
                <i data-lucide="user-round" class="h-4 w-4 text-slate-400"></i>
                <span class="text-xs text-slate-500">
                    Registered system users
                </span>
            </div>
        </div>

        {{-- Total Majors --}}
        <div class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Majors
                    </p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                        {{ $totalMajors ?? '—' }}
                    </h2>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600 transition group-hover:bg-violet-100">
                    <i data-lucide="graduation-cap" class="h-5 w-5"></i>
                </div>
            </div>

            <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4">
                <i data-lucide="layers-3" class="h-4 w-4 text-slate-400"></i>
                <span class="text-xs text-slate-500">
                    Academic departments
                </span>
            </div>
        </div>

        {{-- Total Buildings --}}
        <div class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Buildings
                    </p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                        {{ $totalBuildings ?? '—' }}
                    </h2>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-50 text-sky-600 transition group-hover:bg-sky-100">
                    <i data-lucide="building-2" class="h-5 w-5"></i>
                </div>
            </div>

            <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4">
                <i data-lucide="map-pin" class="h-4 w-4 text-slate-400"></i>
                <span class="text-xs text-slate-500">
                    Managed campus buildings
                </span>
            </div>
        </div>

        {{-- Total Rooms --}}
        <div class="group rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Rooms
                    </p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                        {{ $totalRooms ?? '—' }}
                    </h2>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-100">
                    <i data-lucide="door-open" class="h-5 w-5"></i>
                </div>
            </div>

            <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4">
                <i data-lucide="layout-grid" class="h-4 w-4 text-slate-400"></i>
                <span class="text-xs text-slate-500">
                    Available room records
                </span>
            </div>
        </div>

    </div>

    {{-- Main Dashboard Grid --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Welcome Panel --}}
        <div class="relative overflow-hidden rounded-2xl bg-indigo-600 p-6 text-white shadow-sm sm:p-8 xl:col-span-2">
            <div class="pointer-events-none absolute -right-12 -top-16 h-56 w-56 rounded-full border-[32px] border-white/5"></div>
            <div class="pointer-events-none absolute -bottom-20 right-24 h-48 w-48 rounded-full bg-indigo-500/50 blur-2xl"></div>

            <div class="relative z-10 max-w-xl">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl border border-white/15 bg-white/10">
                    <i data-lucide="sparkles" class="h-6 w-6"></i>
                </div>

                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-indigo-200">
                    PinjamRuang Management
                </p>

                <h2 class="mt-3 text-2xl font-bold tracking-tight sm:text-3xl">
                    Everything in one place.
                </h2>

                <p class="mt-3 max-w-lg text-sm leading-6 text-indigo-100">
                    Manage users, academic majors, buildings, and rooms through one centralized workspace.
                </p>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('users.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-50">
                        <i data-lucide="users" class="h-4 w-4"></i>
                        Manage Users
                        <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                    </a>

                    <a href="{{ route('buildings.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-white/15">
                        View Buildings
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Quick Access --}}
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-5">
                <h2 class="text-base font-bold text-slate-900">
                    Quick Access
                </h2>
                <p class="mt-1 text-xs text-slate-500">
                    Navigate to a management page.
                </p>
            </div>

            <div class="space-y-2">

                <a href="{{ route('users.index') }}"
                    class="group flex items-center gap-3 rounded-xl border border-transparent p-3 transition hover:border-slate-100 hover:bg-slate-50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                        <i data-lucide="users" class="h-[18px] w-[18px]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-800">Users</p>
                        <p class="mt-0.5 text-xs text-slate-400">Manage user accounts</p>
                    </div>
                    <i data-lucide="chevron-right" class="h-4 w-4 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-indigo-600"></i>
                </a>

                <a href="{{ route('majors.index') }}"
                    class="group flex items-center gap-3 rounded-xl border border-transparent p-3 transition hover:border-slate-100 hover:bg-slate-50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                        <i data-lucide="graduation-cap" class="h-[18px] w-[18px]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-800">Majors</p>
                        <p class="mt-0.5 text-xs text-slate-400">Manage departments</p>
                    </div>
                    <i data-lucide="chevron-right" class="h-4 w-4 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-indigo-600"></i>
                </a>

                <a href="{{ route('buildings.index') }}"
                    class="group flex items-center gap-3 rounded-xl border border-transparent p-3 transition hover:border-slate-100 hover:bg-slate-50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                        <i data-lucide="building-2" class="h-[18px] w-[18px]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-800">Buildings</p>
                        <p class="mt-0.5 text-xs text-slate-400">Manage campus buildings</p>
                    </div>
                    <i data-lucide="chevron-right" class="h-4 w-4 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-indigo-600"></i>
                </a>

                <a href="{{ route('rooms.index') }}"
                    class="group flex items-center gap-3 rounded-xl border border-transparent p-3 transition hover:border-slate-100 hover:bg-slate-50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i data-lucide="door-open" class="h-[18px] w-[18px]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-800">Rooms</p>
                        <p class="mt-0.5 text-xs text-slate-400">Manage classroom records</p>
                    </div>
                    <i data-lucide="chevron-right" class="h-4 w-4 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-indigo-600"></i>
                </a>

            </div>
        </div>
    </div>

    {{-- System Information --}}
    <div class="mt-6 rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="shield-check" class="h-5 w-5"></i>
                </div>

                <div>
                    <h2 class="text-sm font-bold text-slate-900">
                        System Overview
                    </h2>
                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Your centralized workspace for managing campus room resources.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 self-start rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1.5 sm:self-center">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                <span class="text-xs font-semibold text-emerald-700">
                    Ready to manage
                </span>
            </div>
        </div>
    </div>

@endsection
