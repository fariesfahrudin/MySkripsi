<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penugasans', function (Blueprint $table) {

            $table->id('id_penugasan');

            $table->unsignedBigInteger('id_laporan');

            $table->unsignedBigInteger('id_user');

            $table->enum('status', [
                'diproses',
                'menunggu_validasi',
                'selesai'
            ])->default('diproses');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasans');
    }
};
