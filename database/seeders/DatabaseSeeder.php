<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class, // <-- TAMBAHKAN INI DI PALING ATAS
            
            // Seeder lain yang sudah kita buat
            JenisPelanggaranSeeder::class,
            MasterSanksiBertahapSeeder::class,
            MasterTataTertibSeeder::class,
        ]);
    }
}