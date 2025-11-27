<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterKategoriSanksiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('master_kategori_sanksi')->insert([
            [
                'kategori' => 'Ringan',
                'pasal' => 'Pasal 11',
                'poin_min' => 1,
                'poin_max' => 5,
                'deskripsi_sanksi' => 'Dicatat dan konseling',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori' => 'Sedang',
                'pasal' => 'Pasal 12',
                'poin_min' => 6,
                'poin_max' => 15,
                'deskripsi_sanksi' => "6-10 peringatan lisan\n11-15 peringatan tertulis dengan perjanjian",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori' => 'Berat',
                'pasal' => 'Pasal 13',
                'poin_min' => 16,
                'poin_max' => 100,
                'deskripsi_sanksi' => "16-20 perjanjian orang tua dengan perjanjian siswa apabila sudah mencapai 100 dikeluarkan dari sekolah\n21-25 perjanjian orang tua dengan perjanjian diatas materai\n26-30 diskors selama 3 hari\n31-35 diskors selama 7 hari\n36-40 diserahkan kepada orang tua untuk dibina dalam jangka waktu dua (2) minggu\n41-90 diserahkan kepada orang tua untuk dibina dalam jangka waktu satu (1) bulan\n90-100 dikeluarkan dari sekolah (SMK BAKTI NUSANTARA 666)",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
