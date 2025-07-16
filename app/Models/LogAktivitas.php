<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'aktivitas',
        'deskripsi',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    // Konstanta untuk jenis aktivitas
    const AKTIVITAS_TAMBAH_TAMU = 'tambah_tamu';
    const AKTIVITAS_LOGOUT_TAMU = 'logout_tamu';
    const AKTIVITAS_EDIT_TAMU = 'edit_tamu';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Method untuk mencatat aktivitas tambah tamu
    public static function catatTambahTamu($userId, $tamuData)
    {
        return self::create([
            'user_id' => $userId,
            'aktivitas' => self::AKTIVITAS_TAMBAH_TAMU,
            'deskripsi' => 'Menambahkan tamu baru: ' . $tamuData->jenis_tamu,
            'waktu' => now('Asia/Jakarta'),
        ]);
    }

    // Method untuk mencatat aktivitas logout tamu
    public static function catatLogoutTamu($userId, $tamuData)
    {
        return self::create([
            'user_id' => $userId,
            'aktivitas' => self::AKTIVITAS_LOGOUT_TAMU,
            'deskripsi' => 'Logout tamu: ' . $tamuData->jenis_tamu,
            'waktu' => now('Asia/Jakarta'),
        ]);
    }

    // Method untuk mencatat aktivitas edit tamu
    public static function catatEditTamu($userId, $tamuData)
    {
        return self::create([
            'user_id' => $userId,
            'aktivitas' => self::AKTIVITAS_EDIT_TAMU,
            'deskripsi' => 'Mengubah data tamu: ' . $tamuData->jenis_tamu,
            'waktu' => now('Asia/Jakarta'),
        ]);
    }
}