<x-layouts.petugas title="Dashboard Petugas">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Dashboard Petugas</h2>
            <p class="text-sm text-slate-500">Selamat datang kembali! Berikut adalah ringkasan performa dan tugas Anda.
            </p>
        </div>
        <div
            class="hidden sm:block text-xs font-semibold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-100">
            Ruang Kerja Petugas
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        <div
            class="md:col-span-2 rounded-xl border border-slate-200 bg-white p-6 shadow-sm flex items-center justify-between transition hover:shadow-md">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Tugas Aktif Saat Ini</p>
                <h3 class="text-4xl font-extrabold mt-2 text-indigo-600">
                    {{ $tugasAktif }} <span class="text-sm font-normal text-slate-400">Penugasan</span>
                </h3>
            </div>
            <div class="rounded-xl bg-indigo-50 p-4 text-indigo-600 border border-indigo-100">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
        </div>

        <div
            class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col justify-center transition hover:shadow-md">
            <p class="text-xs text-center text-slate-400 mb-3 leading-relaxed">Perlu memeriksa lembar instruksi kerja
                perbaikan?</p>
            <a href="{{ route('tugas.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-700 active:scale-95">
                Lihat Tugas Saya
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
            <div>
                <h3 class="text-base font-bold text-slate-900">Penyelesaian Tugas 7 Hari Terakhir</h3>
                <p class="text-xs text-slate-400">Metrik kuantitas laporan perbaikan yang berhasil diselesaikan.</p>
            </div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                <span class="h-2 w-2 rounded-full bg-violet-500"></span> Progres Kerja
            </div>
        </div>

        <div class="h-64 md:h-96">
            <canvas id="grafikTugas"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('grafikTugas');
            const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);

            // Gradasi warna ungu/violet modern
            gradient.addColorStop(0, 'rgba(139, 92, 246, 0.35)');
            gradient.addColorStop(1, 'rgba(139, 92, 246, 0.00)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                        @foreach ($grafikTugas as $g)
                            '{{ $g['hari'] }}',
                        @endforeach
                    ],
                    datasets: [{
                        data: [
                            @foreach ($grafikTugas as $g)
                                {{ $g['jumlah'] }},
                            @endforeach
                        ],
                        borderColor: '#8b5cf6', // Violet 500
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: 'Inter, sans-serif',
                                    size: 11
                                },
                                color: '#64748b'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9'
                            },
                            ticks: {
                                stepSize: 1,
                                font: {
                                    family: 'Inter, sans-serif',
                                    size: 11
                                },
                                color: '#64748b'
                            }
                        }
                    }
                }
            });
        });
    </script>

</x-layouts.petugas>
