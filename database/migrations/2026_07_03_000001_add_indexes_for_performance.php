<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Index pada tabel laporan
        Schema::table('laporan', function (Blueprint $table) {
            $table->index('status', 'idx_laporan_status');
            $table->index('id_fasilitas', 'idx_laporan_fasilitas');
            $table->index('created_at', 'idx_laporan_created_at');
        });

        // Index pada tabel penugasans
        Schema::table('penugasans', function (Blueprint $table) {
            $table->index('id_user', 'idx_penugasans_user');
            $table->index('status', 'idx_penugasans_status');
            $table->index('id_laporan', 'idx_penugasans_laporan');
        });

        // Index pada tabel notifikasis
        Schema::table('notifikasis', function (Blueprint $table) {
            $table->index('id_user', 'idx_notifikasis_user');
            $table->index('is_read', 'idx_notifikasis_is_read');
            $table->index(['id_user', 'is_read'], 'idx_notifikasis_user_read');
        });

        // Index pada tabel perbaikans
        Schema::table('perbaikans', function (Blueprint $table) {
            $table->index('status_validasi', 'idx_perbaikans_validasi');
            $table->index('id_penugasan', 'idx_perbaikans_penugasan');
        });
    }

    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropIndex('idx_laporan_status');
            $table->dropIndex('idx_laporan_fasilitas');
            $table->dropIndex('idx_laporan_created_at');
        });

        Schema::table('penugasans', function (Blueprint $table) {
            $table->dropIndex('idx_penugasans_user');
            $table->dropIndex('idx_penugasans_status');
            $table->dropIndex('idx_penugasans_laporan');
        });

        Schema::table('notifikasis', function (Blueprint $table) {
            $table->dropIndex('idx_notifikasis_user');
            $table->dropIndex('idx_notifikasis_is_read');
            $table->dropIndex('idx_notifikasis_user_read');
        });

        Schema::table('perbaikans', function (Blueprint $table) {
            $table->dropIndex('idx_perbaikans_validasi');
            $table->dropIndex('idx_perbaikans_penugasan');
        });
    }
};
