<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware ini menutup session segera setelah session dibaca,
 * agar file session lock tidak memblokir request lain dari browser
 * yang sama (terutama AJAX polling yang bisa memblokir navigasi).
 */
class CloseSessionEarly
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jalankan request normal terlebih dahulu
        $response = $next($request);

        // Simpan dan tutup session segera setelah response dihasilkan
        // Ini melepas file lock sehingga request lain tidak perlu menunggu
        if (session()->isStarted()) {
            session()->save();
        }

        return $response;
    }
}
