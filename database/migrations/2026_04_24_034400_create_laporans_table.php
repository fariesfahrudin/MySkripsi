<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {

            $table->id('id_laporan');

            $table->unsignedBigInteger('id_fasilitas');

            $table->string('nama_pelapor');

            $table->text('deskripsi');

            $table->string('foto')->nullable();

            $table->enum('status', [
                'pending',
                'diproses',
                'selesai'
            ])->default('pending');

            $table->timestamps();

            $table->foreign('id_fasilitas')
                ->references('id_fasilitas')
                ->on('fasilitas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};