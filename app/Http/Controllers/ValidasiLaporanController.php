<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ValidasiLaporanController extends Controller
{
    public function index()
    {
        $data = Laporan::with('fasilitas')
            ->where('status', 'menunggu_validasi')
            ->latest()
            ->paginate(10);

        return view('validasi_laporan.index', compact('data'));
    }

    public function terima($id)
    {
        $laporan = Laporan::findOrFail($id);

        $laporan->update([
            'status' => 'pending'
        ]);

        // invalidate cache validasi laporan
        Cache::forget('validasi_laporan_count');

        return back()->with('success', 'Laporan diterima dan siap ditugaskan');
    }

    public function tolak($id)
    {
        $laporan = Laporan::findOrFail($id);

        // Hapus foto jika ada
        if ($laporan->foto) {
            Storage::disk('uploads')->delete($laporan->foto);
        }

        // Hapus laporan permanen
        $laporan->delete();

        // invalidate cache validasi laporan
        Cache::forget('validasi_laporan_count');

        return back()->with('success', 'Laporan ditolak dan dihapus');
    }
}
