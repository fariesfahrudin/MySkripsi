<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidasiLaporanController;
use App\Http\Controllers\ValidasiPerbaikanController;

/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/
// Halaman Scan QR Code (Halaman Utama Pengunjung)
Route::get('/', function () {
    return view('scan');
})->name('home');

Route::get('/scan', function () {
    return view('scan');
})->name('scan');

// Pelaporan Kerusakan oleh Pengunjung
Route::get('/lapor/{id}', [LaporanController::class, 'create'])->name('lapor.create');
Route::post('/lapor/store', [LaporanController::class, 'store'])->name('lapor.store');

// Login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Notifikasi (Admin & Petugas)
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/baca/{id}', [NotifikasiController::class, 'baca'])->name('notifikasi.baca');
    Route::get('/cek-notifikasi', [NotifikasiController::class, 'cek'])
        ->middleware('close.session')
        ->name('cek.notifikasi');

    /*
    |----------------------------------------------------------------------
    | Khusus Admin
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

        // CRUD Fasilitas & Petugas
        Route::resource('fasilitas', FasilitasController::class)->except(['show']);
        Route::resource('user', UserController::class)->except(['show']);

        // Validasi Laporan Pengunjung
        Route::get('/validasi-laporan', [ValidasiLaporanController::class, 'index'])->name('validasi_laporan.index');
        Route::post('/validasi-laporan/{id}/terima', [ValidasiLaporanController::class, 'terima'])->name('validasi_laporan.terima');
        Route::post('/validasi-laporan/{id}/tolak', [ValidasiLaporanController::class, 'tolak'])->name('validasi_laporan.tolak');

        // Manajemen Penugasan Petugas
        Route::get('/penugasan', [PenugasanController::class, 'index'])->name('penugasan.index');
        Route::post('/penugasan/store', [PenugasanController::class, 'store'])->name('penugasan.store');

        // Validasi Hasil Perbaikan Petugas
        Route::get('/validasi-perbaikan', [ValidasiPerbaikanController::class, 'index'])->name('validasi.index');
        Route::post('/validasi-perbaikan/{id}/setujui', [ValidasiPerbaikanController::class, 'setujui'])->name('validasi.setujui');
        Route::post('/validasi-perbaikan/{id}/tolak', [ValidasiPerbaikanController::class, 'tolak'])->name('validasi.tolak');

        // Rekap Laporan & Cetak PDF
        Route::get('/rekap', [RekapController::class, 'index'])->name('rekap.index');
        Route::get('/rekap/pdf', [RekapController::class, 'pdf'])->name('rekap.pdf');
    });

    /*
    |----------------------------------------------------------------------
    | Khusus Petugas
    |----------------------------------------------------------------------
    */
    Route::middleware('role:petugas')->group(function () {
        Route::get('/dashboard/petugas', [DashboardController::class, 'petugas'])->name('dashboard.petugas');
        Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');
        Route::get('/tugas/kirim/{id}', [TugasController::class, 'kirim'])->name('tugas.kirim');
        Route::post('/tugas/store', [TugasController::class, 'store'])->name('tugas.store');
    });
});
