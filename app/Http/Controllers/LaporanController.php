<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Laporan;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class LaporanController extends Controller
{

    public function create($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        return view('laporan.create', compact('fasilitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_fasilitas' => 'required|integer',
            'nama_pelapor' => 'required|string|min:2|max:100',
            'deskripsi'    => 'required|string|min:10|max:500',
            // Client sudah crop 1:1 & compress ≤ 1MB; server validasi sebagai fallback
            'foto'         => 'nullable|image|mimes:jpeg,jpg,png,webp|max:1024',
        ], [
            'nama_pelapor.required' => 'Nama pelapor wajib diisi.',
            'nama_pelapor.min'      => 'Nama pelapor minimal 2 karakter.',
            'deskripsi.required'    => 'Deskripsi kerusakan wajib diisi.',
            'deskripsi.min'         => 'Deskripsi minimal 10 karakter.',
            'foto.max'              => 'Ukuran foto maksimal 1 MB.',
            'foto.mimes'            => 'Format foto harus JPG, PNG, atau WEBP.',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            // Foto sudah di-crop 1:1 dan di-compress ≤ 1MB oleh browser.
            // Server tetap melewati uploadAndResize sebagai pengaman.
            $foto = $this->uploadAndResize($request->file('foto'), 'laporan');
        }

        Laporan::create([
            'id_fasilitas' => $request->id_fasilitas,
            'nama_pelapor' => $request->nama_pelapor,
            'deskripsi'    => $request->deskripsi,
            'foto'         => $foto,
            'status'       => 'menunggu_validasi',
        ]);

        //notifikasi ke admin untuk validasi laporan
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {

            Notifikasi::create([
                'id_user' => $admin->id,
                'judul' => 'Laporan Baru Menunggu Validasi',
                'pesan' => 'Ada laporan kerusakan baru dari pengunjung yang perlu divalidasi',
                'tipe' => 'laporan_baru'
            ]);

            // invalidate cache notifikasi admin & validasi laporan
            Cache::forget('notif_count_' . $admin->id);
            Cache::forget('validasi_laporan_count');
        }

        return redirect('/scan')
            ->with('success', 'Laporan berhasil dikirim');
    }

    /**
     * Upload dan resize foto agar ukuran file <= 300 KB.
     * Menggunakan GD library (bawaan PHP).
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
