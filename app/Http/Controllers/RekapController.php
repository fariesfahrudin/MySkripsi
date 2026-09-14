<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $query = Laporan::join(
            'fasilitas',
            'laporan.id_fasilitas',
            '=',
            'fasilitas.id_fasilitas'
        )
            ->where('laporan.status', 'selesai')
            ->select(
                'fasilitas.nama_fasilitas',
                'fasilitas.lokasi',
                DB::raw('count(laporan.id_laporan) as jumlah_lapor')
            );

        // FILTER BULAN
        if ($bulan) {

            $query->whereMonth(
                'laporan.created_at',
                $bulan
            );
        }

        // FILTER TAHUN
        if ($tahun) {

            $query->whereYear(
                'laporan.created_at',
                $tahun
            );
        }

        $rekap = $query
            ->groupBy(
                'fasilitas.id_fasilitas',
                'fasilitas.nama_fasilitas',
                'fasilitas.lokasi'
            )
            ->get();

        return view(
            'rekap.index',
            compact(
                'rekap',
                'bulan',
                'tahun'
            )
        );
    }

    // CETAK PDF
    public function pdf(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $query = Laporan::join(
            'fasilitas',
            'laporan.id_fasilitas',
            '=',
            'fasilitas.id_fasilitas'
        )
            ->select(
                'fasilitas.nama_fasilitas',
                'fasilitas.lokasi',
                DB::raw('count(laporan.id_laporan) as jumlah_lapor')
            );

        // FILTER BULAN
        if ($bulan) {

            $query->whereMonth(
                'laporan.created_at',
                $bulan
            );
        }

        // FILTER TAHUN
        if ($tahun) {

            $query->whereYear(
                'laporan.created_at',
                $tahun
            );
        }

        $rekap = $query
            ->groupBy(
                'fasilitas.id_fasilitas',
                'fasilitas.nama_fasilitas',
                'fasilitas.lokasi'
            )
            ->get();

        // LOAD PDF
        $pdf = Pdf::loadView(
            'rekap.pdf',
            compact(
                'rekap',
                'bulan',
                'tahun'
            )
        );

        return $pdf->download('rekap-laporan.pdf');
    }
}
