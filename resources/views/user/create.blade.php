<x-layouts.admin title="Tambah User">

    <div class="w-full max-w-2xl py-4">

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">

            <div class="h-1 bg-sky-600 w-full"></div>

            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-xl font-bold text-slate-900">Tambah Pengguna Baru</h2>
                <p class="text-xs text-slate-500">Dafrarkan akun kredensial baru untuk memberikan hak akses ke dalam
                    sistem.</p>
            </div>

            <form method="POST" action="{{ route('user.store') }}" class="p-6">
                @csrf

                <div class="space-y-3.5">

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Nama
                            Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap..."
                            class="w-full border border-slate-200 bg-slate-50 px-3 py-1.5 rounded-md text-sm text-slate-800 focus:outline-none focus:border-sky-500 focus:bg-white focus:ring-1 focus:ring-sky-500 transition">
                        @error('name')
                            <p class="mt-0.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Username</label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 text-sm font-medium">@</span>
                            <input type="text" name="username" value="{{ old('username') }}"
                                placeholder="username_akses"
                                class="w-full border border-slate-200 bg-slate-50 pl-7 pr-3 py-1.5 rounded-md text-sm text-slate-800 focus:outline-none focus:border-sky-500 focus:bg-white focus:ring-1 focus:ring-sky-500 transition">
                        </div>
                        @error('username')
                            <p class="mt-0.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Kata
                            Sandi (Password)</label>
                        <input type="password" name="password" placeholder="Minimal 6 atau 8 karakter"
                            class="w-full border border-slate-200 bg-slate-50 px-3 py-1.5 rounded-md text-sm text-slate-800 focus:outline-none focus:border-sky-500 focus:bg-white focus:ring-1 focus:ring-sky-500 transition placeholder:text-xs">
                        @error('password')
                            <p class="mt-0.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Peran
                            Sistem (Role)</label>
                        <div class="relative">
                            <select name="role" id="roleSelect"
                                class="w-full border border-slate-200 bg-slate-50 px-3 py-1.5 rounded-md text-sm text-slate-800 appearance-none focus:outline-none focus:border-sky-500 focus:bg-white focus:ring-1 focus:ring-sky-500 transition">
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Hak Akses
                                    Penuh)</option>
                                <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas (Lembar
                                    Operasional)</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('role')
                            <p class="mt-0.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Field Job/Keahlian (hanya tampil jika role = petugas) --}}
                    <div id="jobField" class="{{ old('role', 'admin') == 'petugas' ? '' : 'hidden' }}">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                            Job / Keahlian Teknis
                        </label>
                        <div class="relative">
                            <select name="job"
                                class="w-full border border-slate-200 bg-slate-50 px-3 py-1.5 rounded-md text-sm text-slate-800 appearance-none focus:outline-none focus:border-sky-500 focus:bg-white focus:ring-1 focus:ring-sky-500 transition">
                                <option value="">-- Pilih Keahlian --</option>
                                <option value="Teknisi Listrik" {{ old('job') == 'Teknisi Listrik' ? 'selected' : '' }}>Teknisi Listrik</option>
                                <option value="Teknisi Plumbing (Air)" {{ old('job') == 'Teknisi Plumbing (Air)' ? 'selected' : '' }}>Teknisi Plumbing (Air)</option>
                                <option value="Teknisi AC / HVAC" {{ old('job') == 'Teknisi AC / HVAC' ? 'selected' : '' }}>Teknisi AC / HVAC</option>
                                <option value="Teknisi Bangunan / Sipil" {{ old('job') == 'Teknisi Bangunan / Sipil' ? 'selected' : '' }}>Teknisi Bangunan / Sipil</option>
                                <option value="Teknisi Elektronik" {{ old('job') == 'Teknisi Elektronik' ? 'selected' : '' }}>Teknisi Elektronik</option>
                                <option value="Teknisi Umum" {{ old('job') == 'Teknisi Umum' ? 'selected' : '' }}>Teknisi Umum</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-0.5 text-[10px] text-slate-400">Keahlian digunakan untuk mencocokkan penugasan perbaikan fasilitas.</p>
                        @error('job')
                            <p class="mt-0.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                    <a href="{{ route('user.index') }}"
                        class="rounded-md bg-slate-100 px-4 py-2 text-xs font-bold text-slate-600 transition hover:bg-slate-200 active:scale-95">
                        Batal
                    </a>
                    <button type="submit"
                        class="rounded-md bg-sky-600 px-4 py-2 text-xs font-bold text-white shadow-sm shadow-sky-600/10 transition duration-150 hover:bg-sky-700 active:scale-95">
                        Simpan Akun
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        const roleSelect = document.getElementById('roleSelect');
        const jobField = document.getElementById('jobField');

        function toggleJobField() {
            if (roleSelect.value === 'petugas') {
                jobField.classList.remove('hidden');
            } else {
                jobField.classList.add('hidden');
            }
        }

        roleSelect.addEventListener('change', toggleJobField);
        toggleJobField();
    </script>

</x-layouts.admin>

