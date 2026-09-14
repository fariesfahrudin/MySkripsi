<x-layouts.admin title="Fasilitas">

    <!-- HEADER PAGE -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Data Fasilitas</h2>
            <p class="text-sm text-slate-500">Kelola seluruh daftar aset, lokasi objek wisata, beserta berkas integrasi
                kode QR.</p>
        </div>
        <div>
            <a href="{{ route('fasilitas.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm shadow-teal-600/10 transition duration-200 hover:bg-teal-700 active:scale-95">
                <!-- Icon Plus -->
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Fasilitas
            </a>
        </div>
    </div>

    <!-- NOTIFIKASI SUKSES (Soft Alert Teal) -->
    @if (session('success'))
        <div id="success-alert"
            class="mb-5 flex items-center gap-3 rounded-xl bg-teal-50 p-4 text-sm text-teal-800 border border-teal-200 transition-all duration-500 opacity-100 shadow-sm">
            <!-- Icon Check -->
            <div class="rounded-full bg-teal-500 p-1 text-white shrink-0">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <span class="font-bold">Berhasil!</span> {{ session('success') }}
            </div>
        </div>
    @endif

    <form method="GET" class="mb-4 flex gap-3">

        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama fasilitas..."
            class="border rounded-lg px-4 py-2">

        <select name="lokasi" class="border rounded-lg px-4 py-2">

            <option value="">
                Semua Lokasi
            </option>

            @foreach ($lokasiList as $lokasi)
                <option value="{{ $lokasi->lokasi }}" {{ request('lokasi') == $lokasi->lokasi ? 'selected' : '' }}>

                    {{ $lokasi->lokasi }}

                </option>
            @endforeach

        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">

            Filter

        </button>

    </form>

    <!-- TABLE CONTAINER -->
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-slate-500">
                <thead class="bg-slate-50 text-xs font-semibold uppercase text-slate-700 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center w-16">No</th>
                        <th scope="col" class="px-6 py-4">Nama Fasilitas</th>
                        <th scope="col" class="px-6 py-4">Lokasi Zona</th>
                        <th scope="col" class="px-6 py-4 text-center w-28">Foto Aset</th>
                        <th scope="col" class="px-6 py-4 text-center w-32">QR Code</th>
                        <th scope="col" class="px-6 py-4">Deskripsi</th>
                        <th scope="col" class="px-6 py-4 text-center w-40">Aksi Pengelolaan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($data as $y => $d)
                        <tr class="transition duration-150 hover:bg-slate-50/60">
                            <!-- Nomor -->
                            <td class="px-6 py-4 text-center font-medium text-slate-400">{{ $y + 1 }}</td>

                            <!-- Nama -->
                            <td class="px-6 py-4 font-bold text-slate-900 group-hover:text-teal-600 transition">
                                {{ $d->nama_fasilitas }}
                            </td>

                            <!-- Lokasi -->
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 text-slate-600 font-medium">
                                    <!-- Icon Map Pin -->
                                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $d->lokasi }}
                                </span>
                            </td>

                            <!-- Foto -->
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    @if ($d->foto)
                                        <img src="{{ asset('uploads/' . $d->foto) }}"
                                            alt="{{ $d->nama_fasilitas }}"
                                            data-name="{{ $d->nama_fasilitas }}"
                                            onclick="openLightbox(this)"
                                            class="h-14 w-14 object-cover rounded-xl border border-slate-200 shadow-sm transition duration-200 hover:scale-110 hover:shadow-md hover:border-teal-300 cursor-zoom-in bg-slate-50">
                                    @else
                                        <span
                                            class="text-xs text-slate-400 italic bg-slate-50 px-2 py-1 rounded-md border border-slate-100">No
                                            Photo</span>
                                    @endif
                                </div>
                            </td>

                            <!-- QR Code -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col items-center justify-center gap-1.5">
                                    @if ($d->qr_code)
                                        <img src="{{ asset('uploads/' . $d->qr_code) }}"
                                            class="h-14 w-14 p-1 border border-slate-200 rounded-lg bg-white shadow-sm">
                                        <a href="{{ asset('uploads/' . $d->qr_code) }}" download
                                            class="inline-flex items-center gap-0.5 text-[11px] font-bold text-teal-600 hover:text-teal-700 hover:underline">
                                            <!-- Icon Download -->
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Unduh QR
                                        </a>
                                    @else
                                        <span
                                            class="text-xs text-slate-400 italic bg-slate-50 px-2 py-1 rounded-md border border-slate-100">No
                                            QR</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Deskripsi -->
                            <td class="px-6 py-4 max-w-xs text-slate-500 text-xs leading-relaxed truncate"
                                title="{{ $d->deskripsi }}">
                                {{ $d->deskripsi ?? '-' }}
                            </td>

                            <!-- Tombol Aksi -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit (Amber Soft Button) -->
                                    <a href="{{ route('fasilitas.edit', $d->id_fasilitas) }}"
                                        class="inline-flex items-center rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700 border border-amber-200 transition duration-150 hover:bg-amber-100">
                                        Edit
                                    </a>
                                    <!-- Hapus (Red Soft Button) -->
                                    <form action="{{ route('fasilitas.destroy', $d->id_fasilitas) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data fasilitas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center rounded-lg bg-rose-50 px-3 py-1.5 text-xs font-bold text-rose-700 border border-rose-200 transition duration-150 hover:bg-rose-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 italic bg-slate-50/30">
                                Belum ada data fasilitas yang tersimpan di dalam sistem database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $data->links() }}
    </div>

    <!-- LIGHTBOX MODAL -->
    <div id="lightbox-modal"
        class="fixed inset-0 z-50 hidden items-center justify-center p-4"
        onclick="closeLightboxOnBackdrop(event)">

        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300" id="lightbox-backdrop"></div>

        <!-- Modal Content -->
        <div id="lightbox-content"
            class="relative z-10 max-w-2xl w-full flex flex-col items-center gap-4 scale-90 opacity-0 transition-all duration-300">

            <!-- Close Button -->
            <button onclick="closeLightbox()"
                class="absolute -top-3 -right-3 z-20 flex h-9 w-9 items-center justify-center rounded-full bg-white/90 text-slate-700 shadow-lg hover:bg-white hover:text-rose-500 transition duration-200">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Image -->
            <img id="lightbox-img" src="" alt=""
                class="max-h-[75vh] max-w-full rounded-2xl object-contain shadow-2xl border border-white/10">

            <!-- Caption -->
            <p id="lightbox-caption"
                class="text-sm font-semibold text-white/90 bg-black/40 px-4 py-1.5 rounded-full backdrop-blur-sm tracking-wide"></p>
        </div>
    </div>

    <!-- TIMEOUT ALERT SCRIPT -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 3500);
        });

        // ─── Lightbox ────────────────────────────────────────────
        const modal   = document.getElementById('lightbox-modal');
        const content = document.getElementById('lightbox-content');
        const img     = document.getElementById('lightbox-img');
        const caption = document.getElementById('lightbox-caption');

        function openLightbox(el) {
            img.src         = el.src;
            img.alt         = el.alt;
            caption.textContent = el.dataset.name || '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Trigger animation
            requestAnimationFrame(() => {
                content.classList.remove('scale-90', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            });
        }

        function closeLightbox() {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-90', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
                img.src = '';
            }, 250);
        }

        function closeLightboxOnBackdrop(e) {
            if (e.target === modal || e.target === document.getElementById('lightbox-backdrop')) {
                closeLightbox();
            }
        }

        // Tutup dengan tombol Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeLightbox();
            }
        });
    </script>
</x-layouts.admin>
