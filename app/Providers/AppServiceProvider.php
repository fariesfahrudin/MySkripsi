<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Notifikasi;
use App\Models\Perbaikan;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Hanya daftarkan pada layout utama, bukan semua view ('*')
        // Ini mencegah query dijalankan berkali-kali per request
        View::composer(
            [
                'components.layouts.admin',
                'components.layouts.petugas',
            ],
            function ($view) {

                if (!Auth::check()) {
                    $view->with('jumlahNotif', 0);
                    $view->with('jumlahValidasi', 0);
                    return;
                }

                $userId = Auth::id();
                $role   = Auth::user()->role;

                // Cache jumlah notifikasi per user, refresh tiap 60 detik
                $jumlahNotif = Cache::remember(
                    "notif_count_{$userId}",
                    60,
                    fn () => Notifikasi::where('id_user', $userId)
                        ->where('is_read', false)
                        ->count()
                );

                // Cache jumlah validasi perbaikan hanya untuk admin, refresh tiap 60 detik
                $jumlahValidasi = 0;
                $jumlahValidasiLaporan = 0;
                if ($role === 'admin') {
                    $jumlahValidasi = Cache::remember(
                        'validasi_count',
                        60,
                        fn () => Perbaikan::where('status_validasi', 'menunggu_validasi')
                            ->count()
                    );

                    $jumlahValidasiLaporan = Cache::remember(
                        'validasi_laporan_count',
                        60,
                        fn () => Laporan::where('status', 'menunggu_validasi')
                            ->count()
                    );
                }

                $view->with('jumlahNotif', $jumlahNotif);
                $view->with('jumlahValidasi', $jumlahValidasi);
                $view->with('jumlahValidasiLaporan', $jumlahValidasiLaporan);
            }
        );
    }
}
