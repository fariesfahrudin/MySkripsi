<?php

namespace App\Http\Controllers;

use App\Models\Perbaikan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ValidasiPerbaikanController extends Controller
{
    public function index()
    {
        $data = Perbaikan::with([
            'penugasan.laporan.fasilitas',
            'penugasan.user'
        ])
            ->where('status_validasi', 'menunggu_validasi')
            ->latest()
            ->paginate(10);

        return view(
            'validasi.index',
            compact('data')
        );
    }

    public function setujui($id)
    {
        $perbaikan = Perbaikan::findOrFail($id);

        $perbaikan->update([
            'status_validasi' => 'disetujui'
        ]);

        $perbaikan->penugasan->update([
            'status' => 'selesai'
        ]);

        $perbaikan->penugasan
            ->laporan
            ->update([
                'status' => 'selesai'
            ]);
        //notifikasi terima
        $notif = Notifikasi::create([
            'id_user' => $perbaikan->penugasan->id_user,
            'judul' => 'Perbaikan Disetujui',
            'pesan' => 'Bukti perbaikan telah disetujui Admin',
            'tipe' => 'disetujui'
        ]);

        // invalidate cache validasi & notif petugas
        Cache::forget('validasi_count');
        Cache::forget('notif_count_' . $perbaikan->penugasan->id_user);

        return back()->with(
            'success',
            'Perbaikan berhasil divalidasi'
        );
    }

    public function tolak($id)
    {
        $perbaikan = Perbaikan::findOrFail($id);

        $perbaikan->update([
            'status_validasi' => 'ditolak'
        ]);

        $perbaikan->penugasan->update([
            'status' => 'diproses'
        ]);

        $perbaikan->penugasan
            ->laporan
            ->update([
                'status' => 'diproses'
            ]);
        // notifikasi tolak
        Notifikasi::create([
            'id_user' => $perbaikan->penugasan->id_user,
            'judul' => 'Perbaikan Ditolak',
            'pesan' => 'Bukti perbaikan ditolak Admin',
            'tipe' => 'ditolak'
        ]);

        // invalidate cache validasi & notif petugas
        Cache::forget('validasi_count');
        Cache::forget('notif_count_' . $perbaikan->penugasan->id_user);

        return back()->with(
            'success',
            'Perbaikan ditolak'
        );
    }
}
