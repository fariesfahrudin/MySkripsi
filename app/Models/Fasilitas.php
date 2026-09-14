<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Fasilitas extends Model
{
    protected $fillable = [
        'nama_fasilitas',
        'lokasi',
        'qr_code',
        'deskripsi',
        'foto'
    ];
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_fasilitas');
    }

    protected $primaryKey = 'id_fasilitas';
    public $timestamps = false;
}
