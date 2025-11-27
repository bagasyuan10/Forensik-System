<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bukti extends Model
{
    protected $table = 'bukti';

    protected $fillable = [
        'kasus_id',
        'kategori',
        'nama_bukti',
        'foto',
        'deskripsi',
        'lokasi_ditemukan',
        'waktu_ditemukan',
        'petugas_menemukan'
    ];

    public function kasus()
    {
        return $this->belongsTo(Kasus::class);
    }
}