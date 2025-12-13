<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelaku extends Model
{
    protected $table = 'pelaku';

    protected $fillable = [
        'kasus_id',
        'nama',
        'foto',
        'biodata',
        'hubungan_korban',
        'peran',
        'pengakuan',
        'status_hukum',
    ];

    public function kasus()
    {
        return $this->belongsTo(Kasus::class);
    }

    public function barangBukti()
    {
        // Parameter ke-2 adalah nama tabel pivot: 'pelaku_bukti'
        return $this->belongsToMany(Bukti::class, 'pelaku_bukti', 'pelaku_id', 'bukti_id');
    }
}