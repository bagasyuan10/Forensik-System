<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Korban extends Model
{
    use HasFactory;

    protected $table = 'korban'; 

    protected $fillable = [
        'nama',
        'kontak',
        'alamat',
    ];
}
