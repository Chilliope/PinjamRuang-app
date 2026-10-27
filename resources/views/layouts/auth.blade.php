
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
    <main class="flex min-h-screen">

        {{-- Branding Panel --}}
        <section class="relative hidden w-1/2 flex-col justify-between overflow-hidden bg-slate-950 p-12 text-white lg:flex xl:p-16">

            {{-- Decorative Background --}}
            <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full bg-indigo-500/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-20 h-96 w-96 rounded-full bg-blue-500/10 blur-3xl"></div>

            {{-- Brand --}}
            <a href="/" class="relative z-10 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-500 text-white shadow-lg shadow-indigo-950/30">
                    <i data-lucide="building-2" class="h-6 w-6"></i>
                </div>

                <div>
                    <span class="text-lg font-bold tracking-tight">PinjamRuang</span>
                    <p class="text-xs text-slate-400">Room Booking Management</p>
                </div>
            </a>

            {{-- Main Message --}}
            <div class="relative z-10 my-12 max-w-xl">
                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-medium text-indigo-200">
                    <span class="h-2 w-2 rounded-full bg-indigo-400"></span>
                    Smart Campus Facility
                </div>

                <h1 class="text-4xl font-bold leading-tight tracking-tight xl:text-5xl">
                    Ruang yang tepat.
                    <span class="text-indigo-400">Aktivitas yang hebat.</span>
                </h1>

                <p class="mt-6 max-w-md text-base leading-7 text-slate-400">
                    Kelola peminjaman ruang kelas dengan lebih mudah, teratur, dan transparan dalam satu platform.
                </p>

                <div class="mt-10 space-y-5">
                    <div class="flex items-center gap-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-indigo-300">
                            <i data-lucide="calendar-check" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Peminjaman terorganisir</p>
                            <p class="mt-1 text-xs text-slate-400">Kelola jadwal penggunaan ruangan.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-indigo-300">
                            <i data-lucide="shield-check" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Akses sesuai peran</p>
                            <p class="mt-1 text-xs text-slate-400">Fitur disesuaikan dengan tanggung jawab pengguna.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="relative z-10 flex items-center justify-between border-t border-white/10 pt-6">
                <p class="text-xs text-slate-400">
                    &copy; {{ date('Y') }} PinjamRuang
                </p>
                <span class="text-xs text-slate-400">Room Booking System</span>
            </div>
        </section>

        {{-- Authentication Content --}}
        <section class="flex min-h-screen w-full items-center justify-center px-5 py-10 sm:px-10 lg:w-1/2 lg:px-12">
            <div class="w-full max-w-md">

                {{-- Mobile Brand --}}
                <a href="/" class="mb-10 flex items-center justify-center gap-3 lg:hidden">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-600 text-white">
                        <i data-lucide="building-2" class="h-6 w-6"></i>
                    </div>

                    <span class="text-xl font-bold tracking-tight text-slate-900">
                        PinjamRuang
                    </span>
                </a>

                @yield('content')

                <p class="mt-8 text-center text-xs leading-5 text-slate-400">
                    Dengan masuk, kamu dapat mengakses layanan sesuai peran akunmu.
                </p>
            </div>
        </section>
    </main>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
