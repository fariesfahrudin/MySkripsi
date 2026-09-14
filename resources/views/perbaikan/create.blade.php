<x-layouts.petugas title="Kirim Laporan">

    <h2 class="text-2xl font-bold mb-6 text-blue-500">

        Kirim Laporan Perbaikan

    </h2>

    <div class="bg-white p-6 rounded shadow w-full max-w-xl">

        <form action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <input type="hidden" name="id_penugasan" value="{{ $tugas->id_penugasan }}">

            {{-- fasilitas --}}
            <div class="mb-4">

                <label class="font-semibold">

                    Fasilitas

                </label>

                <input type="text" value="{{ $tugas->laporan->fasilitas->nama_fasilitas }}"
                    class="w-full border p-3 rounded bg-gray-100" readonly>

            </div>

            {{-- foto --}}
            <div class="mb-4">

                <label class="font-semibold">

                    Upload Foto Bukti

                </label>

                <input type="file" name="foto_bukti" class="w-full border p-3 rounded" required>

            </div>

            {{-- keterangan --}}
            <div class="mb-4">

                <label class="font-semibold">

                    Keterangan

                </label>

                <textarea name="keterangan" rows="5" class="w-full border p-3 rounded" required></textarea>

            </div>

            <button class="bg-blue-600 hover:bg-blue-700
                text-white px-6 py-3 rounded">

                Submit

            </button>

        </form>

    </div>

</x-layouts.petugas>
