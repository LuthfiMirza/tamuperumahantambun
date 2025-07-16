<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan semua seeder.
     */
    public function run(): void
    {
        // Panggil seeder lain di sini
        $this->call([
            TamuSeeder::class,
        ]);
    }
}
