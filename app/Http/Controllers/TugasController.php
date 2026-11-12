<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use App\Models\Perbaikan;
use Illuminate\Http\Request;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class TugasController extends Controller
{
    // dashboard tugas petugas
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'terbaru');

        $query = Penugasan::with([
            'laporan.fasilitas',
            'user'
        ])->where('id_user', auth()->user()->id);

        // Sorting logic
        match ($sort) {
            'terlama'           => $query->oldest(),
            'diproses'          => $query->where('status', 'diproses')->latest(),
            'menunggu_validasi' => $query->where('status', 'menunggu_validasi')->latest(),
            'selesai'           => $query->where('status', 'selesai')->latest(),
            default             => $query->latest(), // terbaru
        };

        $tugas = $query->paginate(10);

        return view('tugas.index', compact('tugas', 'sort'));
    }


    // halaman kirim laporan
    public function kirim($id)
    {
        $tugas = Penugasan::with(
            'laporan.fasilitas'
        )->where('id_user', auth()->id())
         ->findOrFail($id);

        return view(
            'perbaikan.create',
            compact('tugas')
        );
    }

    // simpan laporan perbaikan
    public function store(Request $request)
    {
        $request->validate([
            'id_penugasan' => 'required|exists:penugasans,id_penugasan',
            'foto_bukti'   => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
            'keterangan'   => 'required|string|min:5|max:1000'
        ]);

        // cari penugasan milik petugas yang login
        $penugasan = Penugasan::where('id_user', auth()->id())
            ->findOrFail($request->id_penugasan);

        $foto = null;

        // upload foto dengan resize maks 300 KB
        if ($request->hasFile('foto_bukti')) {
            $foto = $this->uploadAndResize($request->file('foto_bukti'), 'perbaikan');
        }

        // simpan perbaikan
        $perbaikan = Perbaikan::create([
            'id_penugasan' => $penugasan->id_penugasan,
            'foto_bukti' => $foto,
            'keterangan' => $request->keterangan,
            'status_validasi' => 'menunggu_validasi',
            'tgl_selesai' => now()
        ]);

        // notifikasi
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notifikasi::create([
                'id_user' => $admin->id,
                'judul' => 'Validasi Perbaikan',
                'pesan' => 'Petugas mengirim bukti perbaikan',
                'tipe' => 'validasi_perbaikan'
            ]);

            // invalidate cache notifikasi & validasi admin
            Cache::forget('notif_count_' . $admin->id);
            Cache::forget('validasi_count');
        }

        // update status penugasan menjadi menunggu_validasi
        $penugasan->update([
            'status' => 'menunggu_validasi'
        ]);

        // update status laporan menjadi diproses
        $penugasan->laporan->update([
            'status' => 'diproses'
        ]);

        return redirect()->route('tugas.index')
            ->with(
                'success',
                'Laporan perbaikan berhasil dikirim'
            );
    }

    /**
     * Upload dan resize foto agar ukuran file <= 300 KB.
     * Menggunakan GD library (bawaan PHP, tanpa dependency tambahan).
     */
    private function uploadAndResize($file, string $folder): string
    {
        $sourcePath = $file->getRealPath();
        $mimeType   = $file->getMimeType();

        $src = match (true) {
            str_contains($mimeType, 'png')  => imagecreatefrompng($sourcePath),
            str_contains($mimeType, 'gif')  => imagecreatefromgif($sourcePath),
            str_contains($mimeType, 'webp') => imagecreatefromwebp($sourcePath),
            default                          => imagecreatefromjpeg($sourcePath),
        };

        $origW = imagesx($src);
        $origH = imagesy($src);

        if ($origW > 1280) {
            $newW    = 1280;
            $newH    = (int) round($origH * (1280 / $origW));
            $resized = imagecreatetruecolor($newW, $newH);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled($resized, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
            imagedestroy($src);
            $src = $resized;
        }

        $quality  = 85;
        $maxBytes = 300 * 1024;

        do {
            ob_start();
            imagejpeg($src, null, $quality);
            $imgData = ob_get_clean();
            $quality -= 10;
        } while (strlen($imgData) > $maxBytes && $quality >= 20);

        imagedestroy($src);

        $filename = $folder . '/' . uniqid() . '.jpg';
        Storage::disk('uploads')->put($filename, $imgData);

        return $filename;
    }
}
