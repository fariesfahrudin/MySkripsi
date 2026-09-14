<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Support\Facades\Cache;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where(
            'id_user',
            auth()->id()
        )->latest()->paginate(10);

        // tandai semua notifikasi sebagai sudah dibaca
        Notifikasi::where(
            'id_user',
            auth()->id()
        )->where(
            'is_read',
            false
        )->update([
            'is_read' => true
        ]);

        // reset cache agar badge langsung 0
        Cache::forget('notif_count_' . auth()->id());

        if (auth()->user()->role == 'admin') {

            return view(
                'notifikasi.admin',
                compact('notifikasi')
            );
        }

        return view(
            'notifikasi.petugas',
            compact('notifikasi')
        );
    }

    public function baca($id)
    {
        $notif = Notifikasi::findOrFail($id);

        $notif->update([
            'is_read' => true
        ]);

        return back();
    }

    public function cek()
    {
        // Lepas session lock segera agar tidak memblokir request lain
        // (session file locking menyebabkan navigasi perlu 2x klik)
        session()->save();

        return response()->json([
            'total' => Notifikasi::where(
                'id_user',
                auth()->id()
            )
                ->where('is_read', false)
                ->count()
        ]);
    }
}
