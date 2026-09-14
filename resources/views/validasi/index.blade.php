<x-layouts.admin title="validasi perbaikan">

    <h1 class="text-2xl font-bold mb-5">
        Validasi Hasil Perbaikan
    </h1>

    @foreach ($data as $item)
        <div class="bg-white p-5 rounded shadow mb-4">

            <h3 class="font-bold">
                {{ $item->penugasan->laporan->fasilitas->nama_fasilitas }}
            </h3>

            <p>{{ $item->keterangan }}</p>

            <img src="{{ asset('uploads/' . $item->foto_bukti) }}" class="w-64 mt-3">

            <div class="mt-3 flex gap-2">

                <form action="{{ route('validasi.setujui', $item->id_perbaikan) }}" method="POST">
                    @csrf

                    <button class="bg-green-600 text-white px-4 py-2 rounded">
                        Setujui
                    </button>
                </form>

                <form action="{{ route('validasi.tolak', $item->id_perbaikan) }}" method="POST">
                    @csrf

                    <button class="bg-red-600 text-white px-4 py-2 rounded">
                        Tolak
                    </button>
                </form>

            </div>

        </div>
    @endforeach

    @if ($data->hasPages())
        <div class="mt-4">
            {{ $data->links() }}
        </div>
    @endif

</x-layouts.admin>

