<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PinjamRuang - Class Representative')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

    {{-- Sidebar --}}
    @include('partials.class_representative.sidebar')

    {{-- Main Content --}}
    <div class="min-h-screen lg:pl-72">

        {{-- Topbar --}}
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">

                <div class="flex items-center gap-3">
                    <button
                        id="cr-sidebar-open"
                        type="button"
                        aria-label="Buka menu navigasi"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:bg-slate-50 lg:hidden"
                    >
                        <i data-lucide="menu" class="h-5 w-5"></i>
                    </button>

                    <div>
                        <p class="text-sm font-semibold text-slate-900">
                            Area Perwakilan Kelas
                        </p>
                        <p class="hidden text-xs text-slate-500 sm:block">
                            Pengelolaan peminjaman ruangan
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden text-right sm:block">
                        <p class="text-sm font-semibold text-slate-800">
                            {{ auth()->user()->fullname ?? 'Pengguna' }}
                        </p>
                        <p class="text-xs text-slate-500">
                            Class Representative
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700">
                        {{ strtoupper(substr(auth()->user()->fullname ?? 'C', 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="p-4 sm:p-6 lg:p-8">

            {{-- Success Notification --}}
            @if (session('success'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                    <i data-lucide="check-circle" class="mt-0.5 h-5 w-5 shrink-0"></i>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Error Notification --}}
            @if (session('error'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                    <i data-lucide="alert-circle" class="mt-0.5 h-5 w-5 shrink-0"></i>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        if (window.lucide) {
            window.lucide.createIcons();
        }
    </script>

    @stack('scripts')
</body>
</html>
