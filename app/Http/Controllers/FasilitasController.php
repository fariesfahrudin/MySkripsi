<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index(Request $request)
    {
        $query = Fasilitas::query();

        if ($request->filled('search')) {
            $query->where('nama_fasilitas', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }

        $data = $query->paginate(10);

        $lokasiList = Fasilitas::select('lokasi')
            ->distinct()
            ->orderBy('lokasi')
            ->get();

        return view('fasilitas.index', compact('data', 'lokasiList'));
    }

    public function create()
    {
        return view('fasilitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'foto' => 'nullable|image'
        ]);

        // upload foto dengan resize maks 300 KB
        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $this->uploadAndResize($request->file('foto'), 'fasilitas');
        }

        // simpan fasilitas
        $fasilitas = Fasilitas::create([
            'nama_fasilitas' => $request->nama_fasilitas,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto
        ]);

        // link QR
        $url = url('/lapor/' . $fasilitas->id_fasilitas);

        // nama file QR
        $namaQr = 'qr-' . time() . '.svg';
        //simpan QR Code
        Storage::disk('uploads')->put(
            'qrcode/' . $namaQr,
            QrCode::size(300)->generate($url)
        );

        // update DB
        $fasilitas->update([
            'qr_code' => 'qrcode/' . $namaQr
        ]);

        return redirect()->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Fasilitas::findOrFail($id);
        return view('fasilitas.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Fasilitas::findOrFail($id);

        $request->validate([
            'nama_fasilitas' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'foto' => 'nullable|image'
        ]);

        // FOTO
        $foto = $data->foto;

        if ($request->hasFile('foto')) {

            if ($data->foto) {
                Storage::disk('uploads')->delete($data->foto);
            }

            $foto = $this->uploadAndResize($request->file('foto'), 'fasilitas');
        }

        // UPDATE DATA
        $data->update([
            'nama_fasilitas' => $request->nama_fasilitas,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto
        ]);

        // HAPUS QR LAMA
        if ($data->qr_code) {
            Storage::disk('uploads')->delete($data->qr_code);
        }

        // LINK QR BARU
        $url = url('/lapor/' . $data->id_fasilitas);

        // NAMA FILE QR
        $namaQr = 'qr-' . time() . '.svg';

        // GENERATE QR
        Storage::disk('uploads')->put(
            'qrcode/' . $namaQr,
            QrCode::size(300)->generate($url)
        );

        // UPDATE QR DATABASE
        $data->update([
            'qr_code' => 'qrcode/' . $namaQr
        ]);

        return redirect()->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = Fasilitas::findOrFail($id);

        if ($data->foto) {
            Storage::disk('uploads')->delete($data->foto);
        }

        if ($data->qr_code) {
            Storage::disk('uploads')->delete($data->qr_code);
        }

        $data->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    /**
     * Upload dan resize foto agar ukuran file <= 300 KB.
     * Menggunakan GD library (bawaan PHP) tanpa dependency tambahan.
     * Gambar di-resize proporsional jika lebar > 1280px,
     * lalu dikompres JPEG bertahap sampai < 300 KB.
     */
    private function uploadAndResize($file, string $folder): string
    {
        $sourcePath = $file->getRealPath();
        $mimeType   = $file->getMimeType();

        // Load image dengan GD sesuai format
        $src = match (true) {
            str_contains($mimeType, 'png')  => imagecreatefrompng($sourcePath),
            str_contains($mimeType, 'gif')  => imagecreatefromgif($sourcePath),
            str_contains($mimeType, 'webp') => imagecreatefromwebp($sourcePath),
            default                          => imagecreatefromjpeg($sourcePath),
        };

        $origW = imagesx($src);
        $origH = imagesy($src);

        // Resize proporsional jika lebar > 1280px
        if ($origW > 1280) {
            $newW  = 1280;
            $newH  = (int) round($origH * (1280 / $origW));
            $resized = imagecreatetruecolor($newW, $newH);
            // Preserve transparency untuk PNG
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled($resized, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
            imagedestroy($src);
            $src = $resized;
        }

        // Kompres JPEG bertahap hingga <= 300 KB
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
