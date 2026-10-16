<aside id="app-sidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200/80 bg-white text-slate-700 transition-transform duration-300 ease-in-out lg:translate-x-0">

    {{-- Brand --}}
    <div class="flex h-[84px] shrink-0 items-center gap-3 border-b border-slate-100 px-6">
        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-600 text-white shadow-md shadow-indigo-200/70">
            <i data-lucide="building-2" class="h-5 w-5"></i>
        </div>

        <div class="min-w-0">
            <h1 class="text-[17px] font-bold tracking-tight text-slate-900">
                PinjamRuang
            </h1>
            <p class="mt-0.5 text-[11px] font-medium tracking-wide text-slate-400">
                ROOM MANAGEMENT
            </p>
        </div>

        <button id="close-sidebar"
            type="button"
            class="ml-auto rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 lg:hidden"
            aria-label="Tutup sidebar">
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 space-y-8 overflow-y-auto px-4 py-7">

        <div>
            <p class="mb-3 px-3 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">
                Workspace
            </p>

            <div class="space-y-1.5">
                {{-- Dashboard Admin --}}
                <a href="{{ route('admin.index') }}"
                    class="group relative flex items-center gap-3 rounded-xl px-3.5 py-3 text-[13px] font-medium transition-all duration-200
                    {{ request()->routeIs('admin.*')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">

                    @if(request()->routeIs('admin.index'))
                        <span class="absolute bottom-2.5 left-0 top-2.5 w-[3px] rounded-r-full bg-indigo-600"></span>
                    @endif

                    <i data-lucide="gauge"
                        class="h-[18px] w-[18px] shrink-0 transition-colors
                        {{ request()->routeIs('admin.index') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                    </i>

                    <span>Dashboard</span>

                    @if(request()->routeIs('admin.index'))
                        <i data-lucide="chevron-right"
                            class="ml-auto h-4 w-4 text-indigo-400">
                        </i>
                    @endif
                </a>

                {{-- User --}}
                <a href="{{ route('users.index') }}"
                    class="group relative flex items-center gap-3 rounded-xl px-3.5 py-3 text-[13px] font-medium transition-all duration-200
                    {{ request()->routeIs('users.*')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">

                    @if(request()->routeIs('users.*'))
                        <span class="absolute bottom-2.5 left-0 top-2.5 w-[3px] rounded-r-full bg-indigo-600"></span>
                    @endif

                    <i data-lucide="users"
                        class="h-[18px] w-[18px] shrink-0 transition-colors
                        {{ request()->routeIs('users.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                    </i>

                    <span>User</span>

                    @if(request()->routeIs('users.*'))
                        <i data-lucide="chevron-right"
                            class="ml-auto h-4 w-4 text-indigo-400">
                        </i>
                    @endif
                </a>

                {{-- Major --}}
                <a href="{{ route('majors.index') }}"
                    class="group relative flex items-center gap-3 rounded-xl px-3.5 py-3 text-[13px] font-medium transition-all duration-200
                    {{ request()->routeIs('majors.*')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">

                    @if(request()->routeIs('majors.*'))
                        <span class="absolute bottom-2.5 left-0 top-2.5 w-[3px] rounded-r-full bg-indigo-600"></span>
                    @endif

                    <i data-lucide="graduation-cap"
                        class="h-[18px] w-[18px] shrink-0 transition-colors
                        {{ request()->routeIs('majors.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                    </i>

                    <span>Major</span>

                    @if(request()->routeIs('majors.*'))
                        <i data-lucide="chevron-right"
                            class="ml-auto h-4 w-4 text-indigo-400">
                        </i>
                    @endif
                </a>

                {{-- Building --}}
                <a href="{{ route('buildings.index') }}"
                    class="group relative flex items-center gap-3 rounded-xl px-3.5 py-3 text-[13px] font-medium transition-all duration-200
                    {{ request()->routeIs('buildings.*')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">

                    @if(request()->routeIs('buildings.*'))
                        <span class="absolute bottom-2.5 left-0 top-2.5 w-[3px] rounded-r-full bg-indigo-600"></span>
                    @endif

                    <i data-lucide="building-2"
                        class="h-[18px] w-[18px] shrink-0 transition-colors
                        {{ request()->routeIs('buildings.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                    </i>

                    <span>Building</span>

                    @if(request()->routeIs('buildings.*'))
                        <i data-lucide="chevron-right"
                            class="ml-auto h-4 w-4 text-indigo-400">
                        </i>
                    @endif
                </a>

                {{-- Room --}}
                <a href="/"
                    class="group relative flex items-center gap-3 rounded-xl px-3.5 py-3 text-[13px] font-medium transition-all duration-200
                    {{ request()->routeIs('rooms.*')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">

                    @if(request()->routeIs('rooms.*'))
                        <span class="absolute bottom-2.5 left-0 top-2.5 w-[3px] rounded-r-full bg-indigo-600"></span>
                    @endif

                    <i data-lucide="door-open"
                        class="h-[18px] w-[18px] shrink-0 transition-colors
                        {{ request()->routeIs('rooms.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                    </i>

                    <span>Room</span>

                    @if(request()->routeIs('rooms.*'))
                        <i data-lucide="chevron-right"
                            class="ml-auto h-4 w-4 text-indigo-400">
                        </i>
                    @endif
                </a>

            </div>
        </div>

        {{-- Information --}}
        <div class="px-3">
            <div class="flex items-start gap-3 rounded-2xl border border-indigo-100/80 bg-indigo-50/60 p-3.5">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-indigo-600 shadow-sm shadow-indigo-100">
                    <i data-lucide="calendar-check" class="h-[18px] w-[18px]"></i>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-800">
                        Room made simple.
                    </p>
                    <p class="mt-1 text-[11px] leading-relaxed text-slate-500">
                        Manage buildings and classroom resources in one place.
                    </p>
                </div>
            </div>
        </div>
    </nav>

    {{-- User Profile --}}
    @php
        $sidebarUser = auth()->user();

        $sidebarName = $sidebarUser->fullname
            ?? $sidebarUser->name
            ?? 'User';

        $sidebarEmail = $sidebarUser->email ?? '';

        $sidebarRole = str($sidebarUser->role ?? 'User')
            ->replace('_', ' ')
            ->replace('-', ' ')
            ->title();
    @endphp

    <div class="shrink-0 border-t border-slate-100 bg-white p-4">

        {{-- Profile Card --}}
        <div class="group mb-2 flex items-center gap-3 rounded-2xl border border-slate-100 bg-slate-50/70 p-3 transition-colors hover:border-slate-200 hover:bg-slate-50">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 text-sm font-bold text-white ring-4 ring-white">
                {{ strtoupper(substr($sidebarName, 0, 1)) }}
            </div>

            <div class="min-w-0 flex-1">
                <p class="truncate text-[13px] font-semibold text-slate-800">
                    {{ $sidebarName }}
                </p>

                <p class="mt-0.5 truncate text-[11px] text-slate-500">
                    {{ $sidebarEmail }}
                </p>

                <span class="mt-1.5 inline-flex max-w-full items-center gap-1 rounded-md border border-indigo-100 bg-indigo-50 px-2 py-0.5 text-[10px] font-semibold text-indigo-700">
                    <i data-lucide="shield-check" class="h-3 w-3 shrink-0"></i>
                    <span class="truncate">{{ $sidebarRole }}</span>
                </span>
            </div>

            <i data-lucide="user-round"
                class="h-4 w-4 shrink-0 text-slate-300 transition-colors group-hover:text-slate-500">
            </i>
        </div>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                class="group flex w-full items-center gap-3 rounded-xl px-3.5 py-2.5 text-[13px] font-medium text-slate-500 transition-all duration-200 hover:bg-rose-50 hover:text-rose-600">

                <i data-lucide="log-out"
                    class="h-[18px] w-[18px] text-slate-400 transition-colors group-hover:text-rose-500">
                </i>

                <span>Sign out</span>

                <i data-lucide="arrow-up-right"
                    class="ml-auto h-4 w-4 text-transparent transition-all group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:text-rose-400">
                </i>
            </button>
        </form>

        <p class="mt-4 text-center text-[10px] font-medium tracking-wide text-slate-400">
            PinjamRuang <span class="mx-1 text-slate-300">·</span> {{ date('Y') }}
        </p>
    </div>
</aside>

{{-- Mobile Overlay --}}
<div id="sidebar-overlay"
    class="fixed inset-0 z-40 hidden bg-slate-900/30 backdrop-blur-[2px] lg:hidden">
</div>

{{-- Mobile Toggle + Icons --}}
<script src="https://unpkg.com/lucide@latest"></script>

<script>
    lucide.createIcons();

    const sidebar = document.getElementById('app-sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const closeButton = document.getElementById('close-sidebar');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    closeButton?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });
</script>
