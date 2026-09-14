<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perbaikans', function (Blueprint $table) {

            $table->id('id_perbaikan');

            $table->unsignedBigInteger('id_penugasan');

            $table->string('foto_bukti')->nullable();

            $table->text('keterangan');

            $table->enum('status_validasi', [
                'menunggu_validasi',
                'disetujui',
                'ditolak'
            ])->default('menunggu_validasi');

            $table->timestamp('tgl_selesai')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perbaikans');
    }
};
