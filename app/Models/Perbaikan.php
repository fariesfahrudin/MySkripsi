<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    protected $primaryKey = 'id_perbaikan';

    protected $fillable = [
        'id_penugasan',
        'foto_bukti',
        'keterangan',
        'status_validasi',
        'tgl_selesai'
    ];

    public function penugasan()
    {
        return $this->belongsTo(
            Penugasan::class,
            'id_penugasan'
        );
    }
}