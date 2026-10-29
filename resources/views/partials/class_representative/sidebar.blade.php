<aside
    id="cr-sidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-300 lg:translate-x-0"
>
    {{-- Brand --}}
    <div class="flex h-20 items-center gap-3 border-b border-slate-200 px-6">
        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-sm">
            <i data-lucide="door-open" class="h-6 w-6"></i>
        </div>

        <div>
            <h1 class="text-lg font-bold tracking-tight text-slate-900">
                PinjamRuang
            </h1>
            <p class="text-xs font-medium text-slate-500">
                Class Representative
            </p>
        </div>
    </div>

    {{-- User Profile --}}
    <div class="border-b border-slate-200 p-5">
        <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-indigo-100 font-bold text-indigo-700">
                {{ strtoupper(substr(auth()->user()->fullname ?? 'C', 0, 1)) }}
            </div>

            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-slate-900">
                    {{ auth()->user()->fullname ?? 'Pengguna' }}
                </p>
                <p class="mt-0.5 text-xs text-slate-500">
                    Class Representative
                </p>
            </div>

            <span class="h-2 w-2 rounded-full bg-emerald-500"
                  title="Akun aktif"></span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-5">
        <p class="mb-3 px-3 text-xs font-bold uppercase tracking-wider text-slate-400">
            Menu Utama
        </p>

        <a href="{{ url('/class-representative') }}"
           class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
           {{ request()->is('class-representative') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ url('/class-representative/bookings') }}"
           class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition
           {{ request()->is('class-representative/bookings') || request()->is('class-representative/bookings/*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i data-lucide="clipboard-list" class="h-5 w-5"></i>
            <span>Pengajuan Peminjaman</span>
        </a>
    </nav>

    {{-- Logout --}}
    <div class="border-t border-slate-200 p-4">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf

            <button type="submit"
                    class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                <i data-lucide="log-out" class="h-5 w-5"></i>
                Keluar dari Akun
            </button>
        </form>

        <p class="mt-3 text-center text-xs text-slate-400">
            PinjamRuang &copy; {{ date('Y') }}
        </p>
    </div>
</aside>

{{-- Mobile Overlay --}}
<div id="cr-sidebar-overlay"
     class="fixed inset-0 z-40 hidden bg-slate-900/40 lg:hidden"></div>

<script>
    (() => {
        const sidebar = document.getElementById('cr-sidebar');
        const overlay = document.getElementById('cr-sidebar-overlay');
        const openButton = document.getElementById('cr-sidebar-open');

        if (!sidebar || !overlay) return;

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        openButton?.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);

        if (window.lucide) {
            window.lucide.createIcons();
        }
    })();
</script>
