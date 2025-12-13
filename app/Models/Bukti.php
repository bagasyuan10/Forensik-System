<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bukti extends Model
{
    use HasFactory;

    protected $table = 'bukti';

    protected $fillable = [
        'kasus_id',
        'nama_bukti',
        'kategori',
        'file_path', // Ganti 'foto' jadi ini
        'file_type', 
        'file_size',
        'deskripsi',
        'lokasi_ditemukan',
        'waktu_ditemukan',
        'petugas_menemukan'
    ];

    public function kasus()
    {
        return $this->belongsTo(Kasus::class, 'kasus_id');
    }

    public function pelaku()
    {
        return $this->belongsToMany(Pelaku::class, 'pelaku_bukti', 'bukti_id', 'pelaku_id');
    }
}