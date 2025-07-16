<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tamu extends Model
{
    use HasFactory;


    protected $table = 'tamu';

    protected $fillable = [
        'gambar',
        'jenis_tamu',
        'plat_nomor',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'posisi',
        'tujuan',
    ];
}
