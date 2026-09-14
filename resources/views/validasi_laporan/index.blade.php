<x-layouts.admin title="Validasi Laporan Pengunjung">

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-900">Validasi Laporan Pengunjung</h2>
        <div class="text-xs text-slate-500 bg-amber-50 border border-amber-200 text-amber-700 px-3 py-1.5 rounded-full font-medium">
            Menunggu Validasi Admin
        </div>
    </div>

    {{-- ALERT --}}
    @if (session('success'))
        <div class="mb-5 flex items-center gap-3 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-800 shadow-sm">
            <svg class="h-5 w-5 flex-shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @forelse ($data as $laporan)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-5 overflow-hidden">

            {{-- HEADER CARD --}}
            <div class="bg-amber-50 border-b border-amber-100 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 bg-amber-500 rounded-full flex items-center justify-center shadow-sm">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19H19a2 2 0 001.75-2.93L13.75 4.07a2 2 0 00-3.5 0L3.25 16.07A2 2 0 005.07 19z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800">{{ $laporan->fasilitas->nama_fasilitas }}</p>
                        <p class="text-xs text-slate-500">{{ $laporan->fasilitas->lokasi }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700 border border-amber-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    Menunggu Validasi
                </span>
            </div>

            {{-- BODY CARD --}}
            <div class="px-6 py-5 grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- INFO LAPORAN --}}
                <div class="md:col-span-2 space-y-4">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Nama Pelapor</p>
                            <p class="font-semibold text-slate-800">{{ $laporan->nama_pelapor }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Tanggal Laporan</p>
                            <p class="font-semibold text-slate-800">{{ $laporan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Deskripsi Kerusakan</p>
                        <p class="text-slate-700 leading-relaxed text-sm bg-slate-50 rounded-lg p-3 border border-slate-100">
                            {{ $laporan->deskripsi }}
                        </p>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="flex gap-3 pt-2">

                        {{-- TERIMA --}}
                        <form action="{{ route('validasi_laporan.terima', $laporan->id_laporan) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold text-sm hover:bg-emerald-700 active:scale-95 transition-all duration-150 shadow-sm"
                                onclick="return confirm('Terima laporan ini? Laporan akan masuk ke sistem dan siap ditugaskan.')">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Terima Laporan
                            </button>
                        </form>

                        {{-- TOLAK --}}
                        <form action="{{ route('validasi_laporan.tolak', $laporan->id_laporan) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-600 text-white font-semibold text-sm hover:bg-red-700 active:scale-95 transition-all duration-150 shadow-sm"
                                onclick="return confirm('Tolak dan hapus laporan ini? Laporan akan dihapus permanen dari sistem.')">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Tolak Laporan
                            </button>
                        </form>

                    </div>
                </div>

                {{-- FOTO --}}
                <div class="flex flex-col items-center justify-center">
                    @if ($laporan->foto)
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2 self-start">Foto Kerusakan</p>
                        <img src="{{ asset('uploads/' . $laporan->foto) }}"
                            class="w-full max-h-48 object-cover rounded-xl border border-slate-200 shadow-sm cursor-pointer hover:opacity-90 transition"
                            onclick="document.getElementById('modal-foto-{{ $laporan->id_laporan }}').classList.remove('hidden')"
                            alt="Foto Kerusakan">
                        <p class="text-xs text-slate-400 mt-1">Klik foto untuk memperbesar</p>

                        {{-- MODAL FOTO --}}
                        <div id="modal-foto-{{ $laporan->id_laporan }}"
                            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm"
                            onclick="this.classList.add('hidden')">
                            <div class="max-w-3xl w-full mx-4">
                                <img src="{{ asset('uploads/' . $laporan->foto) }}"
                                    class="w-full rounded-2xl shadow-2xl"
                                    alt="Foto Kerusakan">
                                <p class="text-center text-white text-xs mt-3 opacity-70">Klik di mana saja untuk menutup</p>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-32 w-full rounded-xl bg-slate-50 border-2 border-dashed border-slate-200">
                            <svg class="h-8 w-8 text-slate-300 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-xs text-slate-400">Tidak ada foto</span>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-6 py-16 text-center">
            <svg class="mx-auto h-14 w-14 text-slate-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-slate-500 font-medium">Tidak ada laporan yang menunggu validasi</p>
            <p class="text-sm text-slate-400 mt-1">Semua laporan sudah divalidasi</p>
        </div>
    @endforelse

    @if ($data->hasPages())
        <div class="mt-6">
            {{ $data->links() }}
        </div>
    @endif

</x-layouts.admin>
