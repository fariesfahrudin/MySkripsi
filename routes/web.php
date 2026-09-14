<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\ValidasiPerbaikanController;
use App\Http\Controllers\ValidasiLaporanController;
use App\Http\Controllers\NotifikasiController;
// HALAMAN AWAL
Route::get('/', function () {
    return view('scan');
});

// LOGIN
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// LOGOUT
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// DASHBOARD
//login
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get(
        '/dashboard/admin',
        [DashboardController::class, 'admin']
    )->name('dashboard.admin');
});

Route::middleware(['auth', 'role:petugas'])->group(function () {

    Route::get(
        '/dashboard/petugas',
        [DashboardController::class, 'petugas']
    )->name('dashboard.petugas');
});
// USER CRUD
Route::middleware('auth')->group(function () {
    Route::resource('user', UserController::class);
});
//fasilitas
Route::middleware('auth')->group(function () {
    Route::resource('fasilitas', FasilitasController::class);
});

Route::get(
    '/validasi-perbaikan',
    [ValidasiPerbaikanController::class, 'index']
)->name('validasi.index');

Route::post(
    '/validasi-perbaikan/{id}/setujui',
    [ValidasiPerbaikanController::class, 'setujui']
)->name('validasi.setujui');

Route::post(
    '/validasi-perbaikan/{id}/tolak',
    [ValidasiPerbaikanController::class, 'tolak']
)->name('validasi.tolak');

// validasi laporan (pengunjung)
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get(
        '/validasi-laporan',
        [ValidasiLaporanController::class, 'index']
    )->name('validasi_laporan.index');

    Route::post(
        '/validasi-laporan/{id}/terima',
        [ValidasiLaporanController::class, 'terima']
    )->name('validasi_laporan.terima');

    Route::post(
        '/validasi-laporan/{id}/tolak',
        [ValidasiLaporanController::class, 'tolak']
    )->name('validasi_laporan.tolak');
});

//notifikasi

Route::middleware('auth')->group(function () {

    Route::get(
        '/notifikasi',
        [NotifikasiController::class, 'index']
    )->name('notifikasi.index');

    Route::get(
        '/notifikasi/baca/{id}',
        [NotifikasiController::class, 'baca']
    )->name('notifikasi.baca');

    Route::get(
        '/cek-notifikasi',
        [NotifikasiController::class, 'cek']
    )->name('cek.notifikasi')->middleware('close.session');
});

//penugasan
Route::middleware('auth')->group(function () {

    Route::get('/penugasan', [PenugasanController::class, 'index'])
        ->name('penugasan.index');

    Route::post('/penugasan/store', [PenugasanController::class, 'store'])
        ->name('penugasan.store');
});
//rekap laporan
Route::get('/rekap', [RekapController::class, 'index'])
    ->middleware('auth')
    ->name('rekap.index');
Route::get('/rekap/pdf', [RekapController::class, 'pdf'])
    ->middleware('auth')
    ->name('rekap.pdf');
//lapor user 
Route::get('/lapor/{id}', [LaporanController::class, 'create'])
    ->name('lapor.create');
Route::post('/lapor/store', [LaporanController::class, 'store'])
    ->name('lapor.store');
//scan user
Route::get('/scan', function () {
    return view('scan');
});
//petugas
Route::middleware('auth')->group(function () {

    Route::get('/tugas', [TugasController::class, 'index'])
        ->name('tugas.index');
});
Route::get(
    '/tugas/kirim/{id}',
    [TugasController::class, 'kirim']
)
    ->name('tugas.kirim');

Route::post(
    '/tugas/store',
    [TugasController::class, 'store']
)
    ->name('tugas.store');
