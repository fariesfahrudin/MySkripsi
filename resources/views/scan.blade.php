<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Scan QR Code - Pelaporan Kerusakan</title>

    <!-- Google Fonts (Inter & Poppins untuk nuansa wisata) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            -webkit-tap-highlight-color: transparent;
        }

        h1,
        h2,
        h3 {
            font-family: 'Poppins', sans-serif;
        }

        /* Desain area video kamera html5-qrcode agar pas bulat/melengkung */
        #reader video {
            border-radius: 1rem !important;
            object-cover: cover !important;
        }

        #reader {
            border: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col justify-between antialiased">
    @if (session('success'))
        <div id="success-alert"
            class="fixed top-5 right-5 bg-green-500 text-white px-5 py-3 rounded-xl shadow-lg z-50 font-semibold">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    <!-- HEADER WISATA (Gradasi Cantik Bertema Kebun Binatang) -->
    <header
        class="w-full bg-gradient-to-r from-orange-600 via-green-400 to-orange-500 py-6 px-5 shadow-md text-center shrink-0 rounded-b-[2rem]">
        <div class="max-w-md mx-auto">
            <span
                class="inline-block bg-white/20 text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full backdrop-blur-sm mb-2">
                Sistem Pelaporan Mandiri
            </span>
            <h1 class="text-white font-extrabold text-base sm:text-lg leading-snug">
                Makam Sunan Drajat
            </h1>
            <p class="text-emerald-100 text-[11px] mt-1 font-medium">
                Pindai kode QR pada fasilitas untuk melaporkan kendala atau kerusakan
            </p>
        </div>
    </header>

    <!-- CONTENT BOX (Pas di Tengah & Sangat Responsif di Layar HP) -->
    <main class="flex-1 flex items-center justify-center w-full px-5 py-6">

        <!-- CARD UTAMA -->
        <div
            class="bg-white rounded-3xl shadow-xl shadow-slate-100 border border-slate-100 w-full max-w-sm p-6 flex flex-col items-center">

            <!-- Ilustrasi / Logo Pembuka -->
            <div id="scan-illustration"
                class="w-20 h-20 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-5 border border-emerald-100 shadow-inner">
                <svg class="h-10 w-10 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5.636 5.636l1.414 1.414m12.728 0l-1.414 1.414M5.636 18.364l1.414-1.414M16 4h4" />
                </svg>
            </div>

            <div class="text-center mb-6">
                <h2 class="text-lg font-bold text-slate-800">Mulai Pindai QR</h2>
                <p class="text-xs text-slate-400 mt-1">Arahkan kamera HP Anda langsung ke kode QR di lokasi</p>
            </div>

            <!-- CONTAINER AREA DISPLAY JENDELA KAMERA (Html5Qrcode) -->
            <div id="reader"
                class="hidden w-full max-w-[280px] mb-5 rounded-2xl overflow-hidden shadow-inner border border-slate-200 bg-slate-950">
            </div>

            <!-- TOMBOL AKSI UTAMA HP (Paling Nyaman Diklik Jempol) -->
            <div class="w-full space-y-3">

                <!-- BUTTON SCAN KAMERA -->
                <button id="scanButton" onclick="startScanner()"
                    class="group relative overflow-hidden bg-gradient-to-b from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 active:scale-98 transition duration-150 text-slate-900 font-bold py-3.5 px-6 rounded-2xl shadow-md shadow-amber-500/10 w-full flex items-center justify-center gap-2">
                    <svg class="h-5 w-5 text-slate-900 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Buka Kamera Scan</span>
                </button>

                <!-- BUTTON UPLOAD FILE -->
                <label
                    class="bg-slate-100 hover:bg-slate-200 active:scale-98 transition duration-150 text-slate-600 font-bold py-3.5 px-6 rounded-2xl w-full flex items-center justify-center gap-2 cursor-pointer border border-slate-200">
                    <svg class="h-5 w-5 text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Pilih Gambar QR</span>
                    <input type="file" id="qr-input-file" accept="image/*" class="hidden" onchange="scanFile(this)">
                </label>

            </div>

            <!-- LIVE STATUS/RESULT -->
            <div id="result" class="mt-4 text-center text-xs text-emerald-600 font-bold"></div>

        </div>

    </main>

    <!-- FOOTER INFORMASI -->
    <footer class="w-full text-center py-4 shrink-0">
        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
            &copy; 2026 Makam Sunan Drajat <a href="/login" class="text-blue-500 hover:text-blue-700 hover:underline">Login</a>
        </p>
    </footer>

    <!-- KOTAK TOAST PESAN ERROR KUSTOM (Mencegah alert bawaan) -->
    <div id="custom-toast"
        class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-slate-900/95 text-white text-xs font-semibold px-5 py-3 rounded-xl shadow-2xl backdrop-blur-md flex items-center gap-2.5 border border-slate-800 transition-all duration-300 transform translate-y-20 opacity-0 pointer-events-none z-50 max-w-[90vw]">
        <span class="h-2 w-2 rounded-full bg-rose-500 animate-ping"></span>
        <span id="toast-message">Pesan error di sini</span>
    </div>

    <!-- SCANNER LOGIC -->
    <script>
        let scannerStarted = false;
        let html5QrCode;

        // FUNGSI TOAST PESAN ERROR KUSTOM
        function showToast(message) {
            const toast = document.getElementById('custom-toast');
            const msgSpan = document.getElementById('toast-message');
            msgSpan.textContent = message;

            // Munculkan toast
            toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');

            // Sembunyikan otomatis setelah 3,5 detik
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
            }, 3500);
        }

        // AKSI TOMBOL SCAN KAMERA HP
        async function startScanner() {
            if (scannerStarted) return;

            const readerDiv = document.getElementById('reader');
            const illustration = document.getElementById('scan-illustration');

            readerDiv.classList.remove('hidden');
            illustration.classList.add('hidden');

            html5QrCode = new Html5Qrcode("reader");

            try {
                const cameras = await Html5Qrcode.getCameras();

                if (!cameras.length) {
                    showToast("Perangkat kamera tidak ditemukan di HP Anda.");
                    readerDiv.classList.add('hidden');
                    illustration.classList.remove('hidden');
                    return;
                }

                scannerStarted = true;

                // Membuka kamera (Utamakan kamera belakang 'environment' jika diakses lewat HP)
                await html5QrCode.start({
                        facingMode: "environment"
                    }, {
                        fps: 12,
                        qrbox: {
                            width: 220,
                            height: 220
                        }
                    },
                    (decodedText) => {
                        document.getElementById('result').textContent = "Pindai sukses! Mengalihkan...";
                        // Matikan kamera terlebih dahulu sebelum berpindah halaman
                        html5QrCode.stop().then(() => {
                            window.location.href = decodedText;
                        });
                    },
                    (errorMessage) => {}
                );

            } catch (err) {
                console.log(err);
                showToast("Izin kamera ditolak atau gagal dibuka.");
                readerDiv.classList.add('hidden');
                illustration.classList.remove('hidden');
                scannerStarted = false;
            }
        }

        // AKSI PILIH FILE DARI GALERI HP
        async function scanFile(input) {
            if (!input.files.length) return;

            const file = input.files[0];
            const qrScanner = new Html5Qrcode("reader");

            try {
                const result = await qrScanner.scanFile(file, true);
                document.getElementById('result').textContent = "Pindai sukses! Mengalihkan...";
                window.location.href = result;
            } catch (err) {
                showToast("Sistem gagal mendeteksi Kode QR pada berkas foto tersebut.");
            }
        }
    </script>

</body>

</html>
