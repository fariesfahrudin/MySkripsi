<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Penugasan;
use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PenugasanController extends Controller
{
    public function index()
    {
        // ambil laporan pending dengan eager loading fasilitas
        $laporan = Laporan::with('fasilitas')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        // ambil user petugas
        $petugas = User::where('role', 'petugas')->get();

        return view('penugasan.index', compact(
            'laporan',
            'petugas'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_laporan' => 'required',
            'id_user' => 'required'
        ]);

        // simpan penugasan
        Penugasan::create([
            'id_laporan' => $request->id_laporan,
            'id_user' => $request->id_user,
            'status' => 'diproses'
        ]);
        //notifikasi
        Notifikasi::create([
            'id_user' => $request->id_user,
            'judul' => 'Tugas Baru',
            'pesan' => 'Anda mendapatkan tugas perbaikan fasilitas',
            'tipe' => 'tugas_baru'
        ]);

        // invalidate cache notifikasi petugas yg ditugaskan
        Cache::forget('notif_count_' . $request->id_user);

        // update status laporan
        Laporan::where('id_laporan', $request->id_laporan)
            ->update([
                'status' => 'diproses'
            ]);

        return back()->with(
            'success',
            'Petugas berhasil ditugaskan'
        );
    }
}
