<x-layouts.admin title="Dashboard Admin">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Ringkasan Dashboard</h2>
        <p class="text-sm text-slate-500">Pantau performa operasional, statistik kerusakan, dan laporan masuk secara
            real-time.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">

        <div
            class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between transition hover:shadow-md border-l-4 border-l-emerald-500">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Fasilitas</p>
                <h3 class="text-3xl font-extrabold mt-2 text-emerald-600">{{ $totalFasilitas }}</h3>
                <p class="text-xs text-slate-400 mt-1">Aset terdaftar di sistem</p>
            </div>
            <div class="rounded-xl bg-emerald-50 p-3.5 text-emerald-600 border border-emerald-100">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between transition hover:shadow-md border-l-4 border-l-amber-500">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Berkas Laporan</p>
                <h3 class="text-3xl font-extrabold mt-2 text-amber-600">{{ $totalLaporan }}</h3>
                <p class="text-xs text-slate-400 mt-1">Akumulasi laporan masuk</p>
            </div>
            <div class="rounded-xl bg-amber-50 p-3.5 text-amber-600 border border-amber-100">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 border-t-4 border-t-blue-500">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Kerusakan 7 Hari Terakhir</h3>
                    <p class="text-xs text-slate-400">Volume masuknya laporan kerusakan harian.</p>
                </div>
                <span
                    class="text-xs font-semibold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-md border border-blue-100">Line
                    Chart</span>
            </div>
            <div style="height:320px" class="relative">
                <canvas id="grafikHarian"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 border-t-4 border-t-rose-500">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Fasilitas Terbanyak Dilaporkan</h3>
                    <p class="text-xs text-slate-400">Peringkat fasilitas dengan intensitas gangguan tertinggi.</p>
                </div>
                <span
                    class="text-xs font-semibold bg-rose-50 text-rose-700 px-2.5 py-1 rounded-md border border-rose-100">Bar
                    Chart</span>
            </div>
            <div style="height:320px" class="relative">
                <canvas id="grafikFasilitas"></canvas>
            </div>
        </div>

    </div>

    <div class="bg-blue-800 rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-base font-bold text-white">Laporan Menunggu Tindak Lanjut</h3>
            <p class="text-xs text-white">Daftar antrean laporan terbaru yang memerlukan delegasi Petugas Lapangan.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-slate-500">
                <thead class="bg-blue-400 text-xs font-semibold uppercase text-white border-b border-blue-500">
                    <tr>
                        <th scope="col" class="px-6 py-4">Fasilitas</th>
                        <th scope="col" class="px-6 py-4">Nama Pelapor</th>
                        <th scope="col" class="px-6 py-4 text-center w-40">Status Progres</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-500 bg-white">
                    @forelse ($laporanTerbaru as $d)
                        <tr class="transition hover:bg-slate-50/50">
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                {{ $d->fasilitas->nama_fasilitas }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $d->nama_pelapor }}
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if ($d->status == 'pending')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700 border border-amber-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        {{ ucfirst($d->status) }}
                                    </span>
                                @elseif($d->status == 'diproses')
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 border border-blue-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                        {{ ucfirst($d->status) }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        {{ ucfirst($d->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-400 italic bg-slate-50/30">
                                Tidak ada laporan tertunda yang membutuhkan tindakan saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ============================================
            // CONFIG: GRAFIK LINE (TEMA BIRU)
            // ============================================
            const canvasHarian = document.getElementById('grafikHarian');
            const ctxHarian = canvasHarian.getContext('2d');
            const gradientBlue = ctxHarian.createLinearGradient(0, 0, 0, 300);

            gradientBlue.addColorStop(0, 'rgba(59, 130, 246, 0.35)');
            gradientBlue.addColorStop(1, 'rgba(59, 130, 246, 0.00)');

            new Chart(canvasHarian, {
                type: 'line',
                data: {
                    labels: [
                        @foreach ($grafikHarian as $g)
                            '{{ $g['hari'] }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: [
                            @foreach ($grafikHarian as $g)
                                {{ $g['jumlah'] }},
                            @endforeach
                        ],
                        borderColor: '#3b82f6',
                        backgroundColor: gradientBlue,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#3b82f6',
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

            // ============================================
            // CONFIG: GRAFIK BAR (TEMA ROSE/MERAH GRADASI)
            // ============================================
            new Chart(document.getElementById('grafikFasilitas'), {
                type: 'bar',
                data: {
                    labels: [
                        @foreach ($fasilitasRusak as $f)
                            '{{ $f->nama_fasilitas }}',
                        @endforeach
                    ],
                    datasets: [{
                        data: [
                            @foreach ($fasilitasRusak as $f)
                                {{ $f->total }},
                            @endforeach
                        ],
                        // Menggunakan palette warna Rose/Merah untuk indikasi kerusakan tertinggi
                        backgroundColor: [
                            '#e11d48', // Rose 600
                            '#f43f5e', // Rose 500
                            '#fb7185', // Rose 400
                            '#fda4af', // Rose 300
                            '#ffe4e6' // Rose 100
                        ],
                        borderRadius: 6,
                        maxBarThickness: 40
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

</x-layouts.admin>
