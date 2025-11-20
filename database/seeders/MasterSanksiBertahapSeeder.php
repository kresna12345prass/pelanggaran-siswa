<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterSanksiBertahap;
use Illuminate\Support\Facades\DB;

class MasterSanksiBertahapSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama
        DB::table('master_sanksi_bertahap')->truncate();

        // ====================================================
        // PASAL 11: SANKSI SKOR RINGAN (1 - 5)
        // ====================================================
        MasterSanksiBertahap::create([
            'kategori' => 'RINGAN',
            'nama_sanksi' => 'Dicatat dan konseling',
            'poin_minimal' => 1,
            'poin_maksimal' => 5,
            'deskripsi_tindakan' => 'Apabila skor pelanggaran mencapai 1 s/d 5 maka dikategorikan ringan berupa dicatat dan konseling.'
        ]);

        // ====================================================
        // PASAL 12: SANKSI SKOR SEDANG (6 - 15)
        // ====================================================
        MasterSanksiBertahap::create([
            'kategori' => 'SEDANG',
            'nama_sanksi' => 'Peringatan lisan',
            'poin_minimal' => 6,
            'poin_maksimal' => 10,
            'deskripsi_tindakan' => 'Peringatan lisan untuk skor 6-10.'
        ]);

        MasterSanksiBertahap::create([
            'kategori' => 'SEDANG',
            'nama_sanksi' => 'Peringatan tertulis dengan perjanjian',
            'poin_minimal' => 11,
            'poin_maksimal' => 15,
            'deskripsi_tindakan' => 'Peringatan tertulis dengan perjanjian untuk skor 11-15.'
        ]);

        // ====================================================
        // PASAL 13: SANKSI SKOR BERAT (16 - 100)
        // ====================================================
        
        // Poin 1: 16-20
        MasterSanksiBertahap::create([
            'kategori' => 'BERAT',
            'nama_sanksi' => 'Panggilan orang tua dengan perjanjian siswa diatas materai',
            'poin_minimal' => 16,
            'poin_maksimal' => 20,
            'deskripsi_tindakan' => 'Pemanggilan orang tua dan pembuatan perjanjian siswa di atas materai.'
        ]);

        // Poin 2: 21-25
        MasterSanksiBertahap::create([
            'kategori' => 'BERAT',
            'nama_sanksi' => 'Perjanjian orang tua dengan perjanjian diatas materai',
            'poin_minimal' => 21,
            'poin_maksimal' => 25,
            'deskripsi_tindakan' => 'Pembuatan perjanjian orang tua di atas materai.'
        ]);

        // Poin 3: 26-30
        MasterSanksiBertahap::create([
            'kategori' => 'BERAT',
            'nama_sanksi' => 'Diskors selama 3 hari',
            'poin_minimal' => 26,
            'poin_maksimal' => 30,
            'deskripsi_tindakan' => 'Siswa diskors selama 3 hari dari kegiatan sekolah.'
        ]);

        // Poin 4: 31-35
        MasterSanksiBertahap::create([
            'kategori' => 'BERAT',
            'nama_sanksi' => 'Diskors selama 7 hari',
            'poin_minimal' => 31,
            'poin_maksimal' => 35,
            'deskripsi_tindakan' => 'Siswa diskors selama 7 hari dari kegiatan sekolah.'
        ]);

        // Poin 5: 36-40
        MasterSanksiBertahap::create([
            'kategori' => 'BERAT',
            'nama_sanksi' => 'Diserahkan kepada orang tua untuk dibina (2 minggu)',
            'poin_minimal' => 36,
            'poin_maksimal' => 40,
            'deskripsi_tindakan' => 'Diserahkan kepada orang tua untuk dibina dalam jangka waktu dua (2) minggu.'
        ]);

        // Poin 6: 41-90 (Di dokumen tertulis 41-90)
        MasterSanksiBertahap::create([
            'kategori' => 'BERAT',
            'nama_sanksi' => 'Diserahkan kepada orang tua untuk dibina (1 bulan)',
            'poin_minimal' => 41,
            'poin_maksimal' => 89, // Kita set 89 agar tidak bentrok dengan 90 di aturan selanjutnya
            'deskripsi_tindakan' => 'Diserahkan kepada orang tua untuk dibina dalam jangka waktu satu (1) bulan.'
        ]);

        // Poin 7: 90-100
        MasterSanksiBertahap::create([
            'kategori' => 'BERAT',
            'nama_sanksi' => 'Dikembalikan kepada orang tua (keluar dari sekolah)',
            'poin_minimal' => 90,
            'poin_maksimal' => 1000, // Set lebih tinggi untuk menampung poin > 100
            'deskripsi_tindakan' => 'Dikembalikan kepada orang tua (keluar dari SMK BAKTI NUSANTARA 666).'
        ]);
    }
}