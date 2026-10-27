
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'PinjamRuang')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Main Layout --}}
    <div class="min-h-screen lg:pl-72">

        {{-- Topbar --}}
        <header class="sticky top-0 z-30 flex h-[72px] items-center justify-between border-b border-slate-200/80 bg-white/90 px-5 backdrop-blur-xl sm:px-8">

            {{-- Mobile Menu + Page Title --}}
            <div class="flex min-w-0 items-center gap-3">

                <button
                    id="open-sidebar"
                    type="button"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50 hover:text-indigo-600 lg:hidden"
                    aria-label="Buka navigasi">

                    <i data-lucide="menu" class="h-5 w-5"></i>
                </button>

                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-slate-900">
                        @yield('page-title', 'Dashboard')
                    </p>

                    <p class="mt-0.5 hidden text-xs text-slate-400 sm:block">
                        PinjamRuang / @yield('breadcrumb', 'Overview')
                    </p>
                </div>
            </div>

            {{-- Topbar Right --}}
            <div class="ml-4 flex shrink-0 items-center gap-3">

                <div class="hidden items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1.5 sm:flex">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span class="text-xs font-medium text-emerald-700">
                        System Online
                    </span>
                </div>

                <div class="h-8 w-px bg-slate-200"></div>

                @php
                    $adminUser = auth()->user();
                    $adminName = $adminUser?->fullname
                        ?? $adminUser?->name
                        ?? 'User';
                @endphp

                <div class="flex items-center gap-2.5">
                    <div class="hidden text-right sm:block">
                        <p class="max-w-36 truncate text-xs font-semibold text-slate-800">
                            {{ $adminName }}
                        </p>

                        <p class="text-[11px] text-slate-400">
                            {{ str($adminUser?->role ?? 'User')->replace('_', ' ')->title() }}
                        </p>
                    </div>

                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700 ring-2 ring-white">
                        {{ strtoupper(substr($adminName, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="min-h-[calc(100vh-72px)] p-5 sm:p-8">

            {{-- Optional Page Heading --}}
            @hasSection('heading')
                <div class="mb-7">
                    @yield('heading')
                </div>
            @endif

            {{-- Content --}}
            @yield('content')

        </main>

        {{-- Footer --}}
        <footer class="border-t border-slate-200/70 px-5 py-4 sm:px-8">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} PinjamRuang. All rights reserved.
            </p>
        </footer>

    </div>

    {{-- Sidebar Icons & Mobile Interaction --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        lucide.createIcons();

        document.getElementById('open-sidebar')
            ?.addEventListener('click', () => {
                if (typeof openSidebar === 'function') {
                    openSidebar();
                }
            });
    </script>

</body>
</html>
