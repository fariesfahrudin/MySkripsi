<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Laporan;
use App\Models\Penugasan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalFasilitas = Fasilitas::count();

        $totalLaporan = Laporan::count();

        $laporanTerbaru = Laporan::with('fasilitas')
            ->whereIn('status', [
                'pending',
                'diproses'
            ])
            ->latest()
            ->take(5)
            ->get();

        $fasilitasRusak = Laporan::join(
            'fasilitas',
            'laporan.id_fasilitas',
            '=',
            'fasilitas.id_fasilitas'
        )
            ->selectRaw(
                'fasilitas.nama_fasilitas,
                 COUNT(*) as total'
            )
            ->groupBy(
                'fasilitas.id_fasilitas',
                'fasilitas.nama_fasilitas'
            )
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Grafik harian: 1 query saja, bukan 7 query dalam loop
        $namaHari = [
            'Sun' => 'Min',
            'Mon' => 'Sen',
            'Tue' => 'Sel',
            'Wed' => 'Rab',
            'Thu' => 'Kam',
            'Fri' => 'Jum',
            'Sat' => 'Sab'
        ];

        $startDate = Carbon::now()->subDays(6)->startOfDay();

        $rawData = Laporan::selectRaw("DATE(created_at) as tgl, COUNT(*) as jumlah")
            ->where('created_at', '>=', $startDate)
            ->groupBy('tgl')
            ->pluck('jumlah', 'tgl')
            ->toArray();

        $grafikHarian = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);
            $key = $tanggal->format('Y-m-d');
            $grafikHarian[] = [
                'hari'   => $namaHari[$tanggal->format('D')],
                'jumlah' => $rawData[$key] ?? 0
            ];
        }

        return view(
            'dashboard.admin.index',
            compact(
                'totalFasilitas',
                'totalLaporan',
                'laporanTerbaru',
                'fasilitasRusak',
                'grafikHarian'
            )
        );
    }

    public function petugas()
    {
        $tugasAktif = Penugasan::where(
            'id_user',
            auth()->user()->id
        )
            ->where('status', 'diproses')
            ->count();

        // Grafik tugas: 1 query saja, bukan 7 query dalam loop
        $namaHari = [
            'Sun' => 'Min',
            'Mon' => 'Sen',
            'Tue' => 'Sel',
            'Wed' => 'Rab',
            'Thu' => 'Kam',
            'Fri' => 'Jum',
            'Sat' => 'Sab'
        ];

        $startDate = Carbon::now()->subDays(6)->startOfDay();

        $rawData = Penugasan::selectRaw("DATE(updated_at) as tgl, COUNT(*) as jumlah")
            ->where('id_user', auth()->user()->id)
            ->where('status', 'selesai')
            ->where('updated_at', '>=', $startDate)
            ->groupBy('tgl')
            ->pluck('jumlah', 'tgl')
            ->toArray();

        $grafikTugas = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);
            $key = $tanggal->format('Y-m-d');
            $grafikTugas[] = [
                'hari'   => $namaHari[$tanggal->format('D')],
                'jumlah' => $rawData[$key] ?? 0
            ];
        }

        return view(
            'dashboard.petugas.index',
            compact(
                'tugasAktif',
                'grafikTugas'
            )
        );
    }
}
