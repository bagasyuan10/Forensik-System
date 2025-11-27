<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'kasus_id',
        'judul_laporan',
        'isi_laporan',
        'tanggal_laporan',
        'penyusun'
    ];

    public function kasus()
    {
        return $this->belongsTo(Kasus::class);
    }
}