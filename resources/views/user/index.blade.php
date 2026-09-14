<x-layouts.admin title="Data User">

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Manajemen Data User</h2>
            <p class="text-sm text-slate-500">Kelola hak akses pengguna, kredensial akun login, serta otorisasi peran
                sistem.</p>
        </div>
        <div>
            <a href="/user/create"
                class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm shadow-sky-600/10 transition duration-200 hover:bg-sky-700 active:scale-95">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah User
            </a>
        </div>
    </div>

    @if (session('success'))
        <div id="success-alert"
            class="mb-5 flex items-center gap-3 rounded-xl bg-sky-50 p-4 text-sm text-sky-800 border border-sky-200 transition-all duration-500 opacity-100 shadow-sm">
            <div class="rounded-full bg-sky-500 p-1 text-white shrink-0">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <span class="font-bold">Berhasil!</span> {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="mb-5 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <form method="GET" class="flex flex-wrap items-center gap-2">
            <div class="relative w-full sm:w-72">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau username..."
                    class="w-full border border-slate-200 bg-slate-50 pl-9 pr-4 py-2 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:bg-white focus:ring-1 focus:ring-sky-500 transition">
            </div>
            <button type="submit"
                class="w-full sm:w-auto rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-900 active:scale-95">
                Cari
            </button>
            @if (request('search'))
                <a href="{{ url()->current() }}"
                    class="text-xs text-slate-400 hover:text-sky-600 hover:underline px-2 py-1">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-slate-500">
                <thead class="bg-slate-50 text-xs font-semibold uppercase text-slate-700 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center w-16">No</th>
                        <th scope="col" class="px-6 py-4">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-4">Username</th>
                        <th scope="col" class="px-6 py-4 text-center w-36">Role Otoritas</th>
                        <th scope="col" class="px-6 py-4 text-center w-44">Job / Keahlian</th>
                        <th scope="col" class="px-6 py-4 text-center w-40">Aksi Pengelolaan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($users as $i => $u)
                        <tr class="transition duration-150 hover:bg-slate-50/60">
                            <td class="px-6 py-4 text-center font-medium text-slate-400">{{ $i + 1 }}</td>

                            <td class="px-6 py-4 font-bold text-slate-900">
                                {{ $u->name }}
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-600">
                                @ {{ $u->username }}
                            </td>

                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if ($u->role == 'admin')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 border border-indigo-150">
                                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                                        {{ strtoupper($u->role) }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-violet-50 px-3 py-1 text-xs font-bold text-violet-700 border border-violet-150">
                                        <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>
                                        {{ strtoupper($u->role) }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if ($u->role == 'petugas' && $u->job)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-700 border border-teal-200">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>
                                        {{ $u->job }}
                                    </span>
                                @elseif ($u->role == 'petugas')
                                    <span class="text-xs text-slate-400 italic">Belum diset</span>
                                @else
                                    <span class="text-xs text-slate-300">—</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('user.edit', $u->id) }}"
                                        class="inline-flex items-center rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700 border border-amber-200 transition duration-150 hover:bg-amber-100">
                                        Edit
                                    </a>
                                    <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun user ini?')">
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
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic bg-slate-50/30">
                                Tidak ditemukan data akun user yang cocok dengan kriteria pencarian Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4 bg-red">
        {{ $users->links() }}
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 4000);
        });
    </script>
</x-layouts.admin>
