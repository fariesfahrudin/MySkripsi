<x-layouts.admin title="Tambah Fasilitas">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Tambah Fasilitas Baru</h2>
        <p class="text-sm text-slate-500">Masukkan data fasilitas baru yang akan didaftarkan ke sistem Makam Sunan Drajat.</p>
    </div>

    <form method="POST" action="{{ route('fasilitas.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white p-6 shadow-sm space-y-5">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2">Detail Informasi</h3>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nama Fasilitas</label>
                    <input type="text" name="nama_fasilitas"
                        class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition"
                        placeholder="Masukkan nama fasilitas (cth: Cungkup Makam)" required>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Lokasi / Area</label>
                    <input type="text" name="lokasi"
                        class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition"
                        placeholder="Masukkan detail titik lokasi (cth: Zona Kiri - Samping Foodcourt)" required>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Deskripsi Fasilitas</label>
                    <textarea name="deskripsi" rows="5"
                        class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition"
                        placeholder="Jelaskan deskripsi singkat mengenai fasilitas baru ini..."></textarea>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm space-y-5">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2">Dokumentasi</h3>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Preview Foto</label>
                    <div
                        class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 rounded-lg bg-slate-50 h-40 text-center">
                        <svg class="mx-auto h-10 w-10 text-slate-400 mb-2" stroke="currentColor" fill="none"
                            viewBox="0 0 48 48" aria-hidden="true">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="text-xs text-slate-400 italic">Belum ada file yang dipilih</span>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Unggah Foto Fasilitas</label>
                    <input type="file" name="foto"
                        class="w-full rounded-lg border border-slate-300 bg-slate-50 p-1.5 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1 file:text-xs file:font-semibold file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
                    <p class="mt-1.5 text-[11px] text-slate-400 italic leading-relaxed">*Gunakan format gambar standar
                        (JPG, PNG, JPEG) dengan ukuran maksimal yang ditentukan.</p>
                </div>
            </div>

        </div>

        <div class="mt-6 flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <button type="submit"
                class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 transition active:scale-95">
                Simpan Fasilitas
            </button>
            <a href="{{ route('fasilitas.index') }}"
                class="rounded-lg bg-slate-100 px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-200 transition">
                Batal
            </a>
        </div>

    </form>

</x-layouts.admin>
