<x-layouts.admin title="Manajemen Penugasan">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Manajemen Penugasan</h2>
        <p class="text-sm text-slate-500">Delegasikan laporan kerusakan infrastruktur yang masuk kepada petugas teknis
            lapangan.</p>
    </div>

    @if (session('success'))
        <div id="success-alert"
            class="mb-5 flex items-center gap-3 rounded-xl bg-indigo-50 p-4 text-sm text-indigo-800 border border-indigo-200 transition-all duration-500 opacity-100 shadow-sm">
            <div class="rounded-full bg-indigo-500 p-1 text-white shrink-0">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <span class="font-bold">Berhasil!</span> {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-indigo-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-slate-500">
                <thead class="bg-indigo-50/70 text-xs font-bold uppercase text-indigo-900 border-b border-indigo-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center w-16 text-indigo-600">No</th>
                        <th scope="col" class="px-6 py-4 w-52">Fasilitas</th>
                        <th scope="col" class="px-6 py-4 text-center w-32">Foto Kendala</th>
                        <th scope="col" class="px-6 py-4">Deskripsi Kerusakan</th>
                        <th scope="col" class="px-6 py-4 text-center w-72">Delegasi Petugas & Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($laporan as $y => $d)
                        <tr class="transition duration-150 hover:bg-indigo-50/30">
                            <td class="px-6 py-4 text-center font-bold text-slate-400">
                                {{ ($laporan->currentPage() - 1) * $laporan->perPage() + $y + 1 }}
                            </td>

                            <td class="px-6 py-4 font-bold text-slate-900">
                                {{ $d->fasilitas->nama_fasilitas }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    @if ($d->foto)
                                        <img src="{{ asset('uploads/' . $d->foto) }}"
                                            class="h-16 w-16 object-cover rounded-xl border border-slate-200 shadow-sm transition duration-200 hover:scale-105 bg-slate-50">
                                    @else
                                        <span
                                            class="text-xs text-slate-400 italic bg-slate-50 px-2.5 py-1.5 rounded-md border border-slate-150">No
                                            Photo</span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 text-slate-600 font-medium leading-relaxed">
                                {{ $d->deskripsi }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('penugasan.store') }}" method="POST"
                                    class="flex items-center justify-center gap-2">
                                    @csrf
                                    <input type="hidden" name="id_laporan" value="{{ $d->id_laporan }}">

                                    <div class="relative flex-1">
                                        <select name="id_user"
                                            class="w-full min-w-[160px] border border-indigo-200 bg-indigo-50/40 pl-3 pr-8 py-2 rounded-lg text-sm font-semibold text-slate-700 appearance-none focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-1 focus:ring-indigo-500 transition shadow-sm"
                                            required>
                                            <option value="">Pilih Petugas...</option>
                                            @foreach ($petugas as $ptg)
                                                <option value="{{ $ptg->id }}">
                                                    {{ $ptg->name }}{{ $ptg->job ? ' — ' . $ptg->job : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-indigo-500">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-bold text-white shadow-sm shadow-indigo-600/10 transition duration-150 hover:bg-indigo-700 active:scale-95">
                                        Assign
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic bg-slate-50/30">
                                Bersih! Tidak ada antrean laporan kerusakan baru (*pending*) saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

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
    </script>

    @if ($laporan->hasPages())
        <div class="mt-4">
            {{ $laporan->links() }}
        </div>
    @endif

</x-layouts.admin>
