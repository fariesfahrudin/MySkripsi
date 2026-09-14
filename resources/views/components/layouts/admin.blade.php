<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Admin' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-800">

    {{-- $jumlahValidasi is provided by AppServiceProvider View Composer --}}

    <!-- AUDIO -->
    <audio id="notifSound">
        <source src="{{ asset('sounds/notif.mp3') }}" type="audio/mpeg">
    </audio>

    <!-- SCRIPT NOTIF -->
    <script>
        let lastCount = {{ $jumlahNotif ?? 0 }};

        setInterval(() => {

            fetch('/cek-notifikasi')

                .then(response => response.json())

                .then(data => {

                    if (data.total > lastCount) {

                        document
                            .getElementById('notifSound')
                            .play()
                            .catch(() => {});

                        lastCount = data.total;
                    }

                });

        }, 30000);
    </script>

    <div class="flex h-screen overflow-hidden">

        <!-- OVERLAY MOBILE -->
        <div id="overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden">
        </div>

        <!-- SIDEBAR -->
        <div id="sidebar"
            class="fixed md:static inset-y-0 left-0 z-40
            w-64 bg-slate-900 text-slate-300 flex flex-col shadow-xl
            transform -translate-x-full md:translate-x-0
            transition duration-300">

            <!-- PROFILE -->
            <div class="border-b border-slate-800 p-6 text-center">

                <div class="h-14 w-14 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3 shadow-md">

                    <span class="text-white font-bold text-xl uppercase">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </span>

                </div>

                <p class="text-xs text-slate-400 uppercase tracking-wider">
                    Welcome
                </p>

                <h3 class="font-bold text-white mt-1 truncate">
                    {{ auth()->user()->name }}
                </h3>

                <p class="text-xs text-slate-500 mt-1">
                    Administrator
                </p>

            </div>

            <!-- MENU -->
            <nav class="flex-1 overflow-y-auto py-4">

                <ul class="space-y-1 px-3">

                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard.admin') }}"
                            class="block px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 border-l-4
                            {{ request()->routeIs('dashboard.admin')
                                ? 'bg-blue-600 text-white border-yellow-400 shadow-md'
                                : 'border-transparent text-slate-400 hover:bg-slate-800 hover:text-white hover:border-blue-500' }}">
                            Dashboard
                        </a>
                    </li>

                    <!-- Notifikasi -->
                    <li>
                        <a href="{{ route('notifikasi.index') }}"
                            class="flex justify-between items-center px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 border-l-4
                            {{ request()->routeIs('notifikasi.*')
                                ? 'bg-blue-600 text-white border-yellow-400 shadow-md'
                                : 'border-transparent text-slate-400 hover:bg-slate-800 hover:text-white hover:border-blue-500' }}">

                            <span>Notifikasi</span>

                            @if (($jumlahNotif ?? 0) > 0)
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $jumlahNotif }}
                                </span>
                            @endif

                        </a>
                    </li>

                    <!-- Fasilitas -->
                    <li>
                        <a href="{{ route('fasilitas.index') }}"
                            class="block px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 border-l-4
                            {{ request()->routeIs('fasilitas.*')
                                ? 'bg-blue-600 text-white border-yellow-400 shadow-md'
                                : 'border-transparent text-slate-400 hover:bg-slate-800 hover:text-white hover:border-blue-500' }}">
                            Kelola Fasilitas
                        </a>
                    </li>

                    <!-- User -->
                    <li>
                        <a href="{{ route('user.index') }}"
                            class="block px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 border-l-4
                            {{ request()->routeIs('user.*')
                                ? 'bg-blue-600 text-white border-yellow-400 shadow-md'
                                : 'border-transparent text-slate-400 hover:bg-slate-800 hover:text-white hover:border-blue-500' }}">
                            Kelola Akun Petugas
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('validasi_laporan.index') }}"
                            class="flex justify-between items-center px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 border-l-4
                            {{ request()->routeIs('validasi_laporan.*')
                                ? 'bg-blue-600 text-white border-yellow-400 shadow-md'
                                : 'border-transparent text-slate-400 hover:bg-slate-800 hover:text-white hover:border-blue-500' }}">

                            <span>Validasi Laporan</span>

                            @if (($jumlahValidasiLaporan ?? 0) > 0)
                                <span class="bg-amber-500 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $jumlahValidasiLaporan }}
                                </span>
                            @endif

                        </a>
                    </li>

                    <!-- Penugasan -->
                    <li>
                        <a href="{{ route('penugasan.index') }}"
                            class="block px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 border-l-4
                            {{ request()->routeIs('penugasan.*')
                                ? 'bg-blue-600 text-white border-yellow-400 shadow-md'
                                : 'border-transparent text-slate-400 hover:bg-slate-800 hover:text-white hover:border-blue-500' }}">
                            Manajemen Penugasan
                        </a>
                    </li>

                    <!-- Validasi -->
                    <li>
                        <a href="{{ route('validasi.index') }}"
                            class="flex justify-between items-center px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 border-l-4
                            {{ request()->routeIs('validasi.*')
                                ? 'bg-blue-600 text-white border-yellow-400 shadow-md'
                                : 'border-transparent text-slate-400 hover:bg-slate-800 hover:text-white hover:border-blue-500' }}">

                            <span>Validasi Perbaikan</span>

                            @if ($jumlahValidasi > 0)
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $jumlahValidasi }}
                                </span>
                            @endif

                        </a>
                    </li>

                    <!-- Rekap -->
                    <li>
                        <a href="{{ route('rekap.index') }}"
                            class="block px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 border-l-4
                            {{ request()->routeIs('rekap.*')
                                ? 'bg-blue-600 text-white border-yellow-400 shadow-md'
                                : 'border-transparent text-slate-400 hover:bg-slate-800 hover:text-white hover:border-blue-500' }}">
                            Rekap Laporan
                        </a>
                    </li>

                </ul>

            </nav>

            <!-- LOGOUT -->
            <div class="p-4 border-t border-slate-800">

                <button type="button" onclick="document.getElementById('modal-logout').classList.remove('hidden')"
                    class="w-full text-left px-4 py-3 rounded-lg text-sm font-medium text-slate-400 border-l-4 border-transparent hover:bg-red-950 hover:text-red-400 hover:border-red-500 transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                    </svg>
                    Logout
                </button>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="flex-1 flex flex-col min-w-0 bg-slate-50">

            <!-- HEADER -->
            <header
                class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-4 md:px-8 shadow-sm">

                <div class="flex items-center gap-3">

                    <!-- HAMBURGER -->
                    <button id="menuBtn" class="md:hidden p-2 rounded-lg border border-slate-300">

                        ☰

                    </button>

                    <h1 class="text-lg font-bold text-slate-800">
                        {{ $title ?? 'Dashboard Admin' }}
                    </h1>

                </div>

                <div class="text-xs font-medium text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full">

                    Administrator

                </div>

            </header>

            <!-- MAIN -->
            <main class="flex-1 p-4 md:p-8 overflow-y-auto">

                {{ $slot }}

            </main>

        </div>

    </div>

    <!-- MODAL KONFIRMASI LOGOUT -->
    <div id="modal-logout" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">
            <div class="bg-red-600 px-6 py-5 text-center">
                <svg class="mx-auto h-12 w-12 text-white mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                </svg>
                <h3 class="text-lg font-bold text-white">Konfirmasi Logout</h3>
            </div>
            <div class="px-6 py-5 text-center">
                <p class="text-slate-600 text-sm mb-6">Apakah Anda yakin ingin keluar dari sistem?</p>
                <div class="flex gap-3 justify-center">
                    <button type="button" onclick="document.getElementById('modal-logout').classList.add('hidden')"
                        class="px-6 py-2.5 rounded-lg bg-slate-100 text-slate-700 font-semibold text-sm hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-6 py-2.5 rounded-lg bg-red-600 text-white font-semibold text-sm hover:bg-red-700 transition">
                            Ya, Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SIDEBAR MOBILE SCRIPT -->
    <script>
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        menuBtn?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>

</body>

</html>
