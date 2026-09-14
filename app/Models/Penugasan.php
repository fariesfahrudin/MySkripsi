<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    protected $primaryKey = 'id_penugasan';

    protected $fillable = [
        'id_laporan',
        'id_user',
        'status'
    ];

    public function laporan()
    {
        return $this->belongsTo(
            Laporan::class,
            'id_laporan'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user'
        );
    }

    public function perbaikan()
    {
        return $this->hasOne(
            Perbaikan::class,
            'id_penugasan'
        );
    }
}
