<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kasus extends Model
{
    protected $table = 'kasus';

    protected $fillable = [
        'judul',
        'nomor_kasus',
        'jenis_kasus',
        'lokasi',
        'tanggal',
        'deskripsi'
    ];

    public function pelaku()
    {
        return $this->hasMany(Pelaku::class);
    }

    public function korban()
    {
        return $this->hasMany(Korban::class);
    }

    public function bukti()
    {
        return $this->hasMany(Bukti::class);
    }

    public function tindakan()
    {
        return $this->hasMany(Tindakan::class);
    }
}