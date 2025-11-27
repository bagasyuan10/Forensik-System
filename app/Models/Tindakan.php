<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    protected $table = 'tindakan';

    protected $fillable = [
        'kasus_id',
        'judul_tindakan',
        'deskripsi',
        'waktu_tindakan',
        'petugas'
    ];

    public function kasus()
    {
        return $this->belongsTo(Kasus::class);
    }
}