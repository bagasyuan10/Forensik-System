<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasus extends Model
{
    use HasFactory;

    protected $table = 'kasus';

    protected $fillable = [
        'judul',
        'nomor_kasus',
        'jenis_kasus',      // Pastikan nama ini sama dengan di DB
        'status',           // Tambahkan ini
        'lokasi',
        'tanggal_kejadian', // Ganti 'tanggal' jadi 'tanggal_kejadian'
        'deskripsi',
        'penyidik'          // Tambahkan ini
    ];

    // Relasi (Biarkan seperti semula)
    public function pelaku() { return $this->hasMany(Pelaku::class); }
    public function korban() { return $this->hasMany(Korban::class); }
    public function bukti() { return $this->hasMany(Bukti::class); }
    public function tindakan() { return $this->hasMany(Tindakan::class); }
}