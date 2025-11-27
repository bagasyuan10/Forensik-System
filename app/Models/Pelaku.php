<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelaku extends Model
{
    protected $table = 'pelaku';   // ← TAMBAHKAN INI

    protected $fillable = [
        'nama',
        'foto',
        'biodata',
        'runtutan'
    ];
}
