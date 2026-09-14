<x-layouts.admin title="notifikasi">

    <h2 class="text-xl font-bold mb-4">
        Notifikasi
    </h2>

    @foreach ($notifikasi as $notif)
        @php
            $link = match($notif->tipe) {
                'laporan_baru'        => route('validasi_laporan.index'),
                'validasi_perbaikan'  => route('validasi.index'),
                'tugas_baru'          => route('penugasan.index'),
                'disetujui'           => route('validasi.index'),
                'ditolak'             => route('validasi.index'),
                default               => '#',
            };
        @endphp
        <a href="{{ $link }}" class="block bg-white p-4 rounded shadow mb-3 hover:bg-orange-50 hover:shadow-md transition duration-150 cursor-pointer group">

            <div class="flex items-center justify-between">
                <h3 class="font-semibold group-hover:text-orange-600 transition">
                    {{ $notif->judul }}
                </h3>
                <svg class="h-4 w-4 text-gray-300 group-hover:text-orange-500 transition shrink-0 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </div>

            <p class="text-sm text-gray-600 mt-1">
                {{ $notif->pesan }}
            </p>

            <small class="text-gray-400">
                {{ $notif->created_at }}
            </small>

        </a>
    @endforeach

    @if ($notifikasi->hasPages())
        <div class="mt-4">
            {{ $notifikasi->links() }}
        </div>
    @endif

</x-layouts.admin>
