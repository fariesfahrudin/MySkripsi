<x-layouts.admin title="Edit User">

    <div class="w-full max-w-2xl py-4">

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">

            <div class="h-1 bg-amber-500 w-full"></div>

            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-xl font-bold text-slate-900">Edit Akun Pengguna</h2>
                <p class="text-xs text-slate-500">Perbarui profil kredensial, sandi, atau hak akses user.</p>
            </div>

            <form method="POST" action="{{ route('user.update', $user->id) }}"
                class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-3.5">

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Nama
                            Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full border border-slate-200 bg-slate-50 px-3 py-1.5 rounded-md text-sm text-slate-800 focus:outline-none focus:border-amber-500 focus:bg-white focus:ring-1 focus:ring-amber-500 transition">
                        @error('name')
                            <p class="mt-0.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Username
                            Akses</label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 text-sm font-medium">@</span>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                class="w-full border border-slate-200 bg-slate-50 pl-7 pr-3 py-1.5 rounded-md text-sm text-slate-800 focus:outline-none focus:border-amber-500 focus:bg-white focus:ring-1 focus:ring-amber-500 transition">
                        </div>
                        @error('username')
                            <p class="mt-0.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600">Kata
                                Sandi Baru</label>
                            <span
                                class="text-[10px] font-medium text-amber-600 bg-amber-50 px-1.5 rounded border border-amber-100">Opsional</span>
                        </div>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                            class="w-full border border-slate-200 bg-slate-50 px-3 py-1.5 rounded-md text-sm text-slate-800 focus:outline-none focus:border-amber-500 focus:bg-white focus:ring-1 focus:ring-amber-500 transition placeholder:text-xs">
                        @error('password')
                            <p class="mt-0.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Peran
                            Sistem (Role)</label>
                        <div class="relative">
                            <select name="role" id="roleSelectEdit"
                                class="w-full border border-slate-200 bg-slate-50 px-3 py-1.5 rounded-md text-sm text-slate-800 appearance-none focus:outline-none focus:border-amber-500 focus:bg-white focus:ring-1 focus:ring-amber-500 transition">
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                                    (Hak Akses Penuh)</option>
                                <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>
                                    Petugas (Lembar Operasional)</option>
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
                    <div id="jobFieldEdit" class="{{ old('role', $user->role) == 'petugas' ? '' : 'hidden' }}">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">
                            Job / Keahlian Teknis
                        </label>
                        <div class="relative">
                            <select name="job"
                                class="w-full border border-slate-200 bg-slate-50 px-3 py-1.5 rounded-md text-sm text-slate-800 appearance-none focus:outline-none focus:border-amber-500 focus:bg-white focus:ring-1 focus:ring-amber-500 transition">
                                <option value="">-- Pilih Keahlian --</option>
                                @php
                                    $currentJob = old('job', $user->job);
                                    $jobs = ['Teknisi Listrik', 'Teknisi Plumbing (Air)', 'Teknisi AC / HVAC', 'Teknisi Bangunan / Sipil', 'Teknisi Elektronik', 'Teknisi Umum'];
                                @endphp
                                @foreach ($jobs as $jobOption)
                                    <option value="{{ $jobOption }}" {{ $currentJob == $jobOption ? 'selected' : '' }}>
                                        {{ $jobOption }}
                                    </option>
                                @endforeach
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
                        class="rounded-md bg-amber-600 px-4 py-2 text-xs font-bold text-white shadow-sm transition duration-150 hover:bg-amber-700 active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        const roleSelectEdit = document.getElementById('roleSelectEdit');
        const jobFieldEdit = document.getElementById('jobFieldEdit');

        function toggleJobFieldEdit() {
            if (roleSelectEdit.value === 'petugas') {
                jobFieldEdit.classList.remove('hidden');
            } else {
                jobFieldEdit.classList.add('hidden');
            }
        }

        roleSelectEdit.addEventListener('change', toggleJobFieldEdit);
        toggleJobFieldEdit();
    </script>

</x-layouts.admin>

