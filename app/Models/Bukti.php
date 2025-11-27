<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bukti extends Model
{
    protected $table = 'bukti';

    protected $fillable = [
        'id_kasus',
        'nama_bukti',
        'deskripsi',
        'tanggal_ditemukan'
    ];
}
