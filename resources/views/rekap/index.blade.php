<x-layouts.admin title="Rekap Laporan">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Rekap Laporan Fasilitas</h2>
        <p class="text-sm text-slate-500">Analisis frekuensi kerusakan fasilitas untuk menentukan tindakan perawatan.</p>
    </div>

    <div
        class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">

        <form method="GET" class="flex flex-wrap items-center gap-3 flex-1">
            <div class="w-full sm:w-44">
                <select name="bulan"
                    class="w-full rounded-lg border border-slate-300 bg-white p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                    <option value="">Pilih Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="w-full sm:w-36">
                <select name="tahun"
                    class="w-full rounded-lg border border-slate-300 bg-white p-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                    <option value="">Pilih Tahun</option>
                    @for ($i = date('Y'); $i >= 2024; $i--)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <button type="submit"
                class="w-full sm:w-auto rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition active:scale-95">
                Filter
            </button>
        </form>

        <div class="w-full md:w-auto pt-4 md:pt-0 border-t md:border-t-0 border-slate-100 flex justify-end">
            <a href="{{ route('rekap.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 active:scale-95">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak PDF
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto w-full">
            <table class="min-w-[600px] w-full border-collapse text-left text-sm text-slate-500">
                <thead class="bg-slate-50 text-xs font-semibold uppercase text-slate-700 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-center w-12">No</th>
                        <th scope="col" class="px-4 py-3">Nama Fasilitas</th>
                        <th scope="col" class="px-4 py-3">Lokasi</th>
                        <th scope="col" class="px-4 py-3 text-center">Jumlah Lapor</th>
                        <th scope="col" class="px-4 py-3 text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($rekap as $y => $d)
                        <tr class="transition hover:bg-slate-50/70">
                            <td class="px-4 py-3 text-center font-medium text-slate-900">
                                {{ $y + 1 }}
                            </td>

                            <td class="px-4 py-3 font-semibold text-slate-900">
                                {{ $d->nama_fasilitas }}
                            </td>

                            <td class="px-4 py-3 text-slate-600">
                                {{ $d->lokasi }}
                            </td>

                            <td class="px-4 py-3 text-center font-bold text-slate-700">
                                {{ $d->jumlah_lapor }} <span class="text-xs font-normal text-slate-400">Kali</span>
                            </td>

                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                @if ($d->jumlah_lapor >= 5)
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700 border border-red-200 animate-pulse">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        Perlu Ganti Baru
                                    </span>
                                @elseif($d->jumlah_lapor >= 3)
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700 border border-amber-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        Perlu Monitoring
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Aman
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-slate-400 italic bg-slate-50/50">
                                <svg class="mx-auto h-8 w-8 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Tidak ada data rekapitulasi laporan pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.admin>
