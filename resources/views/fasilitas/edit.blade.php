<x-layouts.admin title="Edit Fasilitas">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Edit Fasilitas</h2>
        <p class="text-sm text-slate-500">Perbarui informasi detail fasilitas Makam Sunan Drajat.</p>
    </div>

    <form method="POST" action="{{ route('fasilitas.update', $data->id_fasilitas) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white p-6 shadow-sm space-y-5">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2">Informasi Fasilitas</h3>
                
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nama Fasilitas</label>
                    <input type="text" name="nama_fasilitas" value="{{ $data->nama_fasilitas }}" 
                        class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition"
                        placeholder="Contoh: Pendopo Makam" required>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Lokasi / Area</label>
                    <input type="text" name="lokasi" value="{{ $data->lokasi }}" 
                        class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition"
                        placeholder="Contoh: Zona 1 - Dekat Pintu Keluar" required>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Deskripsi Fasilitas</label>
                    <textarea name="deskripsi" rows="5"
                        class="w-full rounded-lg border border-slate-300 p-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition"
                        placeholder="Jelaskan detail singkat mengenai fasilitas ini...">{{ $data->deskripsi }}</textarea>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm space-y-5">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2">Media & Foto</h3>
                
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Foto Saat Ini</label>
                    <div class="flex justify-center p-2 border border-dashed border-slate-200 rounded-lg bg-slate-50">
                        @if ($data->foto)
                            <img src="{{ asset('uploads/' . $data->foto) }}" class="w-full rounded-md shadow-sm object-cover h-40 bg-white">
                        @else
                            <div class="h-40 flex flex-col items-center justify-center text-slate-400">
                                <span class="text-xs italic">Tidak ada foto contoh</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Ganti Foto Baru</label>
                    <input type="file" name="foto" 
                        class="w-full rounded-lg border border-slate-300 bg-slate-50 p-1.5 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1 file:text-xs file:font-semibold file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
                    <p class="mt-1.5 text-[11px] text-slate-400 italic leading-relaxed">*Biarkan kosong jika tidak ingin mengubah foto fasilitas.</p>
                </div>
            </div>

        </div>

        <div class="mt-6 flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <button type="submit" 
                class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 transition active:scale-95">
                Simpan Perubahan
            </button>
            <a href="{{ route('fasilitas.index') }}" 
                class="rounded-lg bg-slate-100 px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-200 transition">
                Batal
            </a>
        </div>

    </form>

</x-layouts.admin>