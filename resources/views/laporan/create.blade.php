<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kerusakan – {{ $fasilitas->nama_fasilitas }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; -webkit-tap-highlight-color: transparent; }
        h1, h2, h3 { font-family: 'Poppins', sans-serif; }

        /* ── Foto preview 1:1 ── */
        #photo-preview-area {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
            background: #f8fafc;
            border-radius: 1rem;
            overflow: hidden;
            border: 2px dashed #cbd5e1;
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }
        #photo-preview-area:hover { background: #f1f5f9; }
        #photo-preview-area.has-photo {
            border-style: solid;
            border-color: #fb923c;
        }
        #photo-preview-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: calc(1rem - 2px);
        }
        #photo-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }
        #compress-bar { transition: width .3s ease; }

        /* Input focus */
        input:focus, textarea:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(251,146,60,.2);
            border-color: #fb923c !important;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-orange-50 via-white to-amber-50 min-h-screen flex flex-col antialiased">

    {{-- ── HEADER ────────────────────────────────────────────────────── --}}
    <header class="w-full bg-gradient-to-r from-orange-600 via-amber-500 to-orange-500 py-5 px-6 shadow-lg text-center shrink-0 rounded-b-[2rem]">
        <div class="max-w-5xl mx-auto">
            <span class="inline-block bg-white/20 text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full backdrop-blur-sm mb-2">
                📋 Form Pelaporan
            </span>
            <h1 class="text-white font-extrabold text-base leading-snug">
                Laporan Kerusakan Fasilitas
            </h1>
            <p class="text-orange-100 text-[11px] mt-1">Makam Sunan Drajat</p>
        </div>
    </header>

    <main class="flex-1 px-4 py-6 w-full max-w-5xl mx-auto">

        {{-- ── KARTU FASILITAS ─────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-4 mb-5 flex items-center gap-4">
            <div class="h-11 w-11 rounded-xl bg-orange-100 flex items-center justify-center shrink-0">
                <svg class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-wider">Fasilitas yang dilaporkan</p>
                <p class="font-bold text-slate-800 text-sm mt-0.5">{{ $fasilitas->nama_fasilitas }}</p>
                <p class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                    <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $fasilitas->lokasi }}
                </p>
            </div>
        </div>

        {{-- ── ALERT SUKSES ─────────────────────────────────────────────── --}}
        @if (session('success'))
            <div id="success-alert"
                class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm font-semibold px-4 py-3 rounded-xl shadow-sm">
                <span class="flex-shrink-0 h-6 w-6 bg-green-500 rounded-full flex items-center justify-center text-white text-xs">✓</span>
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    const el = document.getElementById('success-alert');
                    if (el) { el.style.opacity='0'; el.style.transition='opacity .5s'; setTimeout(()=>el.remove(),500); }
                }, 3500);
            </script>
        @endif

        {{-- ── VALIDASI ERROR ───────────────────────────────────────────── --}}
        @if ($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-xs px-4 py-3 rounded-xl space-y-1">
                @foreach ($errors->all() as $err)
                    <p class="flex items-center gap-1.5"><span class="font-bold">•</span> {{ $err }}</p>
                @endforeach
            </div>
        @endif

        {{-- ── FORM ─────────────────────────────────────────────────────── --}}
        <form id="report-form" action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_fasilitas" value="{{ $fasilitas->id_fasilitas }}">
            {{-- File hasil crop + compress dikirim lewat sini --}}
            <input type="file" id="processed-foto" name="foto" class="hidden" accept="image/*">

            {{-- ══ 2 KOLOM di laptop, 1 kolom di HP ══ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">

                {{-- ── KOLOM KIRI: Foto Kerusakan ──────────────────────── --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">
                        Foto Kerusakan
                        <span class="ml-1 normal-case font-normal text-[10px] text-slate-400">(opsional · crop 1:1 · maks 1 MB)</span>
                    </label>

                    {{-- Kotak preview 1:1 --}}
                    <div id="photo-preview-area" onclick="document.getElementById('raw-foto-input').click()" class="mb-3">
                        <div id="photo-placeholder">
                            <svg class="h-12 w-12 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-xs font-semibold text-slate-400">Ketuk untuk buka kamera</span>
                            <span class="text-[10px] text-slate-300">Ambil foto kerusakan</span>
                        </div>
                        <img id="photo-preview-img" src="" alt="Preview" class="hidden">
                    </div>

                    {{-- Input asli tersembunyi --}}
                    <input type="file" id="raw-foto-input" accept="image/*" capture="environment" class="hidden">

                    {{-- Progress bar compress --}}
                    <div id="compress-progress" class="hidden mb-3">
                        <div class="flex items-center justify-between text-[10px] text-slate-400 mb-1">
                            <span>Memproses foto…</span>
                            <span id="compress-size-label"></span>
                        </div>
                        <div class="h-1.5 rounded-full bg-slate-100 overflow-hidden">
                            <div id="compress-bar" class="h-full bg-orange-400 rounded-full" style="width:0%"></div>
                        </div>
                    </div>

                    {{-- Info hasil & hapus --}}
                    <div id="photo-info" class="hidden items-center justify-between text-[10px] text-slate-400 mt-1.5 mb-3">
                        <span id="photo-info-text" class="text-emerald-600 font-semibold"></span>
                        <button type="button" onclick="removePhoto()"
                            class="text-red-400 hover:text-red-600 font-semibold transition ml-2">✕ Hapus</button>
                    </div>

                    {{-- Tombol pilih foto --}}
                    <button type="button" onclick="document.getElementById('raw-foto-input').click()"
                        class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-dashed border-orange-300 text-orange-500 text-xs font-semibold bg-orange-50 hover:bg-orange-100 transition duration-150 active:scale-95">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        📷 Buka Kamera
                    </button>
                </div>

                {{-- ── KOLOM KANAN: Input + Tombol Kirim ───────────────── --}}
                <div class="flex flex-col gap-4">

                    {{-- Nama Pelapor --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                        <label for="nama_pelapor" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Nama Pelapor <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="nama_pelapor" name="nama_pelapor"
                            value="{{ old('nama_pelapor') }}"
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300 bg-slate-50 transition duration-150"
                            required>
                    </div>

                    {{-- Deskripsi Kerusakan --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex-1">
                        <label for="deskripsi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Deskripsi Kerusakan <span class="text-red-400">*</span>
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="7"
                            placeholder="Ceritakan secara singkat kerusakan yang Anda temukan…"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300 bg-slate-50 resize-none transition duration-150"
                            required>{{ old('deskripsi') }}</textarea>
                        <p class="text-[10px] text-slate-400 mt-1.5">Minimal 10 karakter, maksimal 500 karakter.</p>
                    </div>

                    {{-- Tombol Kirim --}}
                    <button type="submit" id="submit-btn"
                        class="w-full bg-gradient-to-b from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 active:scale-95 text-white font-bold py-4 rounded-2xl shadow-lg shadow-orange-200 transition duration-150 flex items-center justify-center gap-2 text-sm">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Kirim Laporan
                    </button>

                    <p class="text-center text-[10px] text-slate-400 -mt-1">
                        Laporan Anda akan segera ditindaklanjuti oleh petugas.
                    </p>

                </div>{{-- end kanan --}}

            </div>{{-- end grid --}}
        </form>

    </main>

    <footer class="w-full text-center py-4 shrink-0">
        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-300">
            &copy; 2026 Makam Sunan Drajat
        </p>
    </footer>

    {{-- Canvas tersembunyi untuk crop & compress --}}
    <canvas id="crop-canvas" class="hidden"></canvas>

    <script>
        // ── Referensi elemen ──────────────────────────────────────────────
        const rawInput       = document.getElementById('raw-foto-input');
        const processedInput = document.getElementById('processed-foto');
        const previewArea    = document.getElementById('photo-preview-area');
        const previewImg     = document.getElementById('photo-preview-img');
        const placeholder    = document.getElementById('photo-placeholder');
        const progressWrap   = document.getElementById('compress-progress');
        const progressBar    = document.getElementById('compress-bar');
        const progressLabel  = document.getElementById('compress-size-label');
        const photoInfo      = document.getElementById('photo-info');
        const photoInfoText  = document.getElementById('photo-info-text');
        const canvas         = document.getElementById('crop-canvas');
        const ctx            = canvas.getContext('2d');

        const MAX_BYTES   = 1 * 1024 * 1024; // 1 MB
        const CANVAS_SIZE = 1080;             // output 1080 × 1080 px

        // ── Saat user pilih foto ──────────────────────────────────────────
        rawInput.addEventListener('change', async function () {
            const file = this.files[0];
            if (!file) return;

            progressWrap.classList.remove('hidden');
            progressBar.style.width = '10%';
            progressLabel.textContent = formatBytes(file.size) + ' → memproses…';

            try {
                const blob = await processImage(file);

                progressBar.style.width = '100%';
                progressLabel.textContent = formatBytes(file.size) + ' → ' + formatBytes(blob.size);

                // Taruh hasil ke hidden input
                const dt = new DataTransfer();
                dt.items.add(new File([blob], 'foto.jpg', { type: 'image/jpeg' }));
                processedInput.files = dt.files;

                // Tampilkan preview
                previewImg.src = URL.createObjectURL(blob);
                previewImg.classList.remove('hidden');
                placeholder.classList.add('hidden');
                previewArea.classList.add('has-photo');

                photoInfoText.textContent = '✅ ' + formatBytes(blob.size) + ' · 1:1 · siap dikirim';
                photoInfo.classList.remove('hidden');
                photoInfo.style.display = 'flex';

                setTimeout(() => progressWrap.classList.add('hidden'), 1500);

            } catch (e) {
                console.error(e);
                progressWrap.classList.add('hidden');
                alert('Gagal memproses foto. Silakan coba foto lain.');
            }

            this.value = ''; // reset agar bisa pilih file yang sama lagi
        });

        // ── Crop 1:1 lalu compress hingga ≤ 1 MB ───────────────────────
        function processImage(file) {
            return new Promise((resolve, reject) => {
                const img    = new Image();
                const objUrl = URL.createObjectURL(file);

                img.onload = () => {
                    URL.revokeObjectURL(objUrl);

                    // Center-crop ke persegi
                    const side = Math.min(img.naturalWidth, img.naturalHeight);
                    const sx   = (img.naturalWidth  - side) / 2;
                    const sy   = (img.naturalHeight - side) / 2;

                    canvas.width = canvas.height = CANVAS_SIZE;
                    ctx.drawImage(img, sx, sy, side, side, 0, 0, CANVAS_SIZE, CANVAS_SIZE);

                    // Compress iteratif
                    let quality = 0.90;
                    const tryCompress = () => {
                        canvas.toBlob(blob => {
                            if (!blob) { reject(new Error('toBlob failed')); return; }
                            if (blob.size <= MAX_BYTES || quality <= 0.10) {
                                resolve(blob);
                            } else {
                                progressBar.style.width = (10 + ((0.90 - quality) / 0.80) * 80) + '%';
                                quality = Math.max(quality - 0.08, 0.10);
                                tryCompress();
                            }
                        }, 'image/jpeg', quality);
                    };
                    tryCompress();
                };
                img.onerror = reject;
                img.src = objUrl;
            });
        }

        // ── Hapus foto ───────────────────────────────────────────────────
        function removePhoto() {
            previewImg.src = '';
            previewImg.classList.add('hidden');
            placeholder.classList.remove('hidden');
            previewArea.classList.remove('has-photo');
            photoInfo.style.display = 'none';
            photoInfo.classList.add('hidden');
            const dt = new DataTransfer();
            processedInput.files = dt.files;
            rawInput.value = '';
        }

        // ── Utilitas format bytes ────────────────────────────────────────
        function formatBytes(b) {
            if (b < 1024) return b + ' B';
            if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
            return (b / 1048576).toFixed(2) + ' MB';
        }

        // ── Loading state saat submit ────────────────────────────────────
        document.getElementById('report-form').addEventListener('submit', function () {
            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                Mengirim…`;
        });
    </script>

</body>
</html>
