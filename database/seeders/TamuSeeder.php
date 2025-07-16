<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tamu;

class TamuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tamu::create(
            [
                'gambar' => 'tamu-gambar/ahmad.jpg',
                'jenis' => 'Tamu Warga',
                'plat_nomor' => 'B 1234 ABC',
                'tanggal' => '2025-01-05',
                'jam_masuk' => '09:00:00',
                'jam_keluar' => null,
                'posisi' => 'sedang didalam',
                'tujuan' => 'Bertamu ke Blok A1',
            ]
        );
    }
}
