<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambahkan nilai 'menunggu_validasi' ke enum status laporan.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE laporan MODIFY COLUMN status ENUM(
            'menunggu_validasi',
            'pending',
            'diproses',
            'selesai'
        ) NOT NULL DEFAULT 'menunggu_validasi'");
    }

    /**
     * Kembalikan enum ke nilai semula.
     */
    public function down(): void
    {
        Schema::table('laporan_status', function (Blueprint $table) {
            //
        });
    }
};
