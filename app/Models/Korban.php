<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Korban extends Model
{
    use HasFactory;

    protected $table = 'korban';

    protected $fillable = [
        'kasus_id',
        'nik',              // Tambahkan
        'nama',
        'tempat_lahir',     // Tambahkan
        'tanggal_lahir',    // Tambahkan
        'jenis_kelamin',
        'no_telp',          // Sesuaikan
        'alamat',
        'foto',
        'status_korban',    // Tambahkan
        'keterangan_luka',  // Sesuaikan
        'versi_kejadian',
    ];

    public function kasus()
    {
        return $this->belongsTo(Kasus::class);
    }
}