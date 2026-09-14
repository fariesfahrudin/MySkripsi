<x-layouts.petugas title="Tugas Saya">

    <div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Daftar Tugas Saya</h2>
            <p class="text-sm text-slate-500">Pantau dan selesaikan tugas perbaikan fasilitas yang ditugaskan.</p>
        </div>
    </div>

    @if (session('success'))
        <div id="success-alert"
            class="mb-5 flex items-center gap-3 rounded-xl bg-green-50 p-4 text-sm text-green-800 border border-green-200 transition-all duration-500 opacity-100 shadow-sm">
            <div class="rounded-full bg-green-500 p-1 text-white shrink-0">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div><span class="font-bold">Berhasil!</span> {{ session('success') }}</div>
        </div>
    @endif

    {{-- TOOLBAR: SORTING --}}
    <div class="mb-4 flex flex-wrap items-center gap-2">
        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mr-1">Filter:</span>

        {{-- Terbaru --}}
        <a href="{{ route('tugas.index', ['sort' => 'terbaru']) }}"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold transition duration-150 active:scale-95
                {{ $sort === 'terbaru' ? 'bg-slate-800 text-white border-slate-800 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Terbaru
        </a>

        {{-- Terlama --}}
        <a href="{{ route('tugas.index', ['sort' => 'terlama']) }}"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold transition duration-150 active:scale-95
                {{ $sort === 'terlama' ? 'bg-slate-800 text-white border-slate-800 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Terlama
        </a>

        {{-- Diproses (ORANGE saat aktif) --}}
        <a href="{{ route('tugas.index', ['sort' => 'diproses']) }}"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold transition duration-150 active:scale-95
                {{ $sort === 'diproses'
                    ? 'bg-orange-500 text-white border-orange-500 shadow-sm shadow-orange-200'
                    : 'bg-white text-orange-600 border-orange-200 hover:bg-orange-50' }}">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Diproses
            @if ($sort === 'diproses')
                <span class="ml-0.5 h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span>
            @endif
        </a>

        {{-- Validasi (BLUE saat aktif) --}}
        <a href="{{ route('tugas.index', ['sort' => 'menunggu_validasi']) }}"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold transition duration-150 active:scale-95
                {{ $sort === 'menunggu_validasi'
                    ? 'bg-blue-600 text-white border-blue-600 shadow-sm shadow-blue-200'
                    : 'bg-white text-blue-600 border-blue-200 hover:bg-blue-50' }}">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Validasi
        </a>

        {{-- Selesai (EMERALD saat aktif) --}}
        <a href="{{ route('tugas.index', ['sort' => 'selesai']) }}"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-semibold transition duration-150 active:scale-95
                {{ $sort === 'selesai'
                    ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm shadow-emerald-200'
                    : 'bg-white text-emerald-600 border-emerald-200 hover:bg-emerald-50' }}">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            Selesai
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-4 text-center w-12 text-xs font-semibold uppercase text-slate-500">No</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-slate-500">Nama Fasilitas
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-slate-500">Lokasi</th>
                        <th class="px-5 py-4 text-center w-44 text-xs font-semibold uppercase text-slate-500">Status
                        </th>
                        <th class="px-5 py-4 text-center w-48 text-xs font-semibold uppercase text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tugas as $y => $d)
                        <tr class="border-b border-slate-100 hover:bg-slate-50/70 transition duration-150">

                            <td class="px-5 py-4 text-center font-medium text-slate-400">{{ ($tugas->currentPage() - 1) * $tugas->perPage() + $y + 1 }}</td>

                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-800">{{ $d->laporan->fasilitas->nama_fasilitas }}
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">Laporan:
                                    {{ $d->created_at->format('d M Y') }}</div>
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center gap-1.5 text-slate-600 text-xs">
                                    <svg class="h-3.5 w-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $d->laporan->fasilitas->lokasi }}
                                </div>
                            </td>

                            <td class="px-5 py-4 text-center">
                                @if ($d->status == 'diproses')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-orange-50 px-3 py-1.5 text-xs font-bold text-orange-700 border border-orange-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                        Diproses
                                    </span>
                                @elseif ($d->status == 'menunggu_validasi')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700 border border-blue-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                        Menunggu Validasi
                                    </span>
                                @elseif ($d->status == 'selesai')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Selesai
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex justify-center gap-2">
                                    <button type="button" onclick="openModal('modal{{ $d->id_penugasan }}')"
                                        class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition duration-150 active:scale-95">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </button>

                                    @if ($d->status == 'diproses')
                                        <a href="{{ route('tugas.kirim', $d->id_penugasan) }}"
                                            class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition duration-150 active:scale-95">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                            </svg>
                                            Kirim
                                        </a>
                                    @elseif ($d->status == 'menunggu_validasi')
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 border border-blue-200 px-3 py-1.5 rounded-lg text-xs font-semibold cursor-default">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Menunggu
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-700 border border-emerald-200 px-3 py-1.5 rounded-lg text-xs font-semibold cursor-default">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Selesai
                                        </span>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">
                                Tidak ada tugas yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($tugas->hasPages())
        <div class="mt-4">
            {{ $tugas->links() }}
        </div>
    @endif

    {{-- =================== MODAL DETAIL LENGKAP =================== --}}
    @foreach ($tugas as $d)
        <div id="modal{{ $d->id_penugasan }}"
            class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">

            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[90vh] flex flex-col overflow-hidden">

                {{-- Header Modal --}}
                <div
                    class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-slate-50 shrink-0">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Detail Tugas Perbaikan</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Informasi lengkap laporan kerusakan fasilitas</p>
                    </div>
                    <button onclick="closeModal('modal{{ $d->id_penugasan }}')"
                        class="flex items-center justify-center h-8 w-8 rounded-full bg-slate-100 text-slate-500 hover:bg-red-50 hover:text-red-500 transition text-sm font-bold">
                        ✕
                    </button>
                </div>

                {{-- Scrollable Body --}}
                <div class="overflow-y-auto p-6 space-y-5 flex-1">

                    {{-- STATUS BADGE --}}
                    <div class="flex justify-center">
                        @if ($d->status == 'diproses')
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-orange-50 px-4 py-2 text-sm font-bold text-orange-700 border border-orange-200">
                                <span class="h-2 w-2 rounded-full bg-orange-500 animate-pulse"></span>
                                Sedang Diproses
                            </span>
                        @elseif ($d->status == 'menunggu_validasi')
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-sm font-bold text-blue-700 border border-blue-200">
                                <span class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                                Menunggu Validasi Admin
                            </span>
                        @elseif ($d->status == 'selesai')
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700 border border-emerald-200">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                Selesai & Divalidasi
                            </span>
                        @endif
                    </div>

                    {{-- DIVIDER SECTION: INFO FASILITAS --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="h-px flex-1 bg-slate-100"></div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Informasi
                                Fasilitas</span>
                            <div class="h-px flex-1 bg-slate-100"></div>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-4 space-y-3 border border-slate-100">

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">
                                        Nama Fasilitas</p>
                                    <p class="text-sm font-semibold text-slate-800">
                                        {{ $d->laporan->fasilitas->nama_fasilitas }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">
                                        Lokasi</p>
                                    <div class="flex items-start gap-1">
                                        <svg class="h-3.5 w-3.5 text-slate-400 mt-0.5 shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-sm font-semibold text-slate-800">
                                            {{ $d->laporan->fasilitas->lokasi }}</p>
                                    </div>
                                </div>
                            </div>

                            @if ($d->laporan->fasilitas->deskripsi)
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">
                                        Deskripsi Fasilitas</p>
                                    <p class="text-sm text-slate-600 leading-relaxed">
                                        {{ $d->laporan->fasilitas->deskripsi }}</p>
                                </div>
                            @endif

                        </div>
                    </div>

                    {{-- DIVIDER SECTION: INFO LAPORAN KERUSAKAN --}}
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="h-px flex-1 bg-slate-100"></div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Laporan
                                Kerusakan</span>
                            <div class="h-px flex-1 bg-slate-100"></div>
                        </div>

                        <div class="space-y-3">

                            {{-- Nama Pelapor --}}
                            <div
                                class="flex items-center gap-3 bg-amber-50 border border-amber-100 rounded-lg px-4 py-3">
                                <div
                                    class="flex-shrink-0 h-8 w-8 rounded-full bg-amber-200 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-amber-700" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-amber-600">Nama
                                        Pelapor</p>
                                    <p class="text-sm font-bold text-amber-900">{{ $d->laporan->nama_pelapor }}</p>
                                </div>
                            </div>

                            {{-- Deskripsi Kerusakan --}}
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Deskripsi
                                    Kerusakan</p>
                                <div class="bg-rose-50 border border-rose-100 rounded-lg px-4 py-3">
                                    <p class="text-sm text-rose-800 leading-relaxed">{{ $d->laporan->deskripsi }}</p>
                                </div>
                            </div>

                            {{-- Tanggal Laporan --}}
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Dilaporkan: <span
                                    class="font-semibold text-slate-700">{{ $d->laporan->created_at ? $d->laporan->created_at->format('d M Y, H:i') : '-' }}</span>
                            </div>

                            {{-- Foto Kerusakan --}}
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Foto
                                    Kerusakan</p>
                                @if ($d->laporan->foto)
                                    <img src="{{ asset('uploads/' . $d->laporan->foto) }}"
                                        class="rounded-xl border border-slate-200 w-full max-h-64 object-cover shadow-sm">
                                @else
                                    <div
                                        class="flex items-center justify-center h-24 rounded-xl border border-dashed border-slate-200 bg-slate-50">
                                        <p class="text-xs text-slate-400 italic">Tidak ada foto kerusakan</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>

                {{-- Footer Modal --}}
                <div
                    class="px-6 py-4 border-t border-slate-100 bg-slate-50 shrink-0 flex items-center justify-between">
                    <span class="text-xs text-slate-400">ID Penugasan #{{ $d->id_penugasan }}</span>
                    <div class="flex gap-2">
                        @if ($d->status == 'diproses')
                            <a href="{{ route('tugas.kirim', $d->id_penugasan) }}"
                                class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition active:scale-95">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Kirim Laporan Perbaikan
                            </a>
                        @endif
                        <button onclick="closeModal('modal{{ $d->id_penugasan }}')"
                            class="px-4 py-2 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold transition active:scale-95">
                            Tutup
                        </button>
                    </div>
                </div>

            </div>
        </div>
    @endforeach

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close on backdrop click
        document.querySelectorAll('[id^="modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) closeModal(this.id);
            });
        });

        // Auto-hide success alert
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 4000);
        });
    </script>

</x-layouts.petugas>
