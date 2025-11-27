<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Korban extends Model
{
    protected $table = 'korban';

    protected $fillable = [
        'kasus_id',
        'nama',
        'kontak',
        'alamat',
        'umur',
        'jenis_kelamin',
        'kondisi',
        'keterangan',
        'versi_kejadian',
        'foto'
    ];

    public function kasus()
    {
        return $this->belongsTo(Kasus::class);
    }
}