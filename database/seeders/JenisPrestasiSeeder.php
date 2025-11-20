<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisPrestasi;

class JenisPrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_prestasi' => 'Juara 1 Olimpiade Matematika Nasional', 'poin' => 100, 'kategori' => 'Akademik', 'penghargaan' => 'Medali Emas', 'keterangan' => 'Prestasi tingkat nasional'],
            ['nama_prestasi' => 'Juara 2 Olimpiade Fisika Provinsi', 'poin' => 80, 'kategori' => 'Akademik', 'penghargaan' => 'Medali Perak', 'keterangan' => 'Prestasi tingkat provinsi'],
            ['nama_prestasi' => 'Juara 3 Lomba Karya Ilmiah Remaja', 'poin' => 70, 'kategori' => 'Akademik', 'penghargaan' => 'Medali Perunggu', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 1 Lomba Debat Bahasa Inggris', 'poin' => 90, 'kategori' => 'Bahasa', 'penghargaan' => 'Piala Bergilir', 'keterangan' => 'Tingkat nasional'],
            ['nama_prestasi' => 'Juara 2 Lomba Pidato Bahasa Indonesia', 'poin' => 75, 'kategori' => 'Bahasa', 'penghargaan' => 'Piagam Penghargaan', 'keterangan' => 'Tingkat provinsi'],
            ['nama_prestasi' => 'Juara 1 Sepak Bola Antar Sekolah', 'poin' => 85, 'kategori' => 'Olahraga', 'penghargaan' => 'Piala Bergilir', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 2 Bulu Tangkis Tingkat Provinsi', 'poin' => 80, 'kategori' => 'Olahraga', 'penghargaan' => 'Medali Perak', 'keterangan' => 'Prestasi olahraga'],
            ['nama_prestasi' => 'Juara 3 Basket Antar Pelajar', 'poin' => 70, 'kategori' => 'Olahraga', 'penghargaan' => 'Medali Perunggu', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 1 Lomba Seni Tari Tradisional', 'poin' => 85, 'kategori' => 'Seni', 'penghargaan' => 'Piala Bergilir', 'keterangan' => 'Tingkat provinsi'],
            ['nama_prestasi' => 'Juara 2 Lomba Musik Angklung', 'poin' => 75, 'kategori' => 'Seni', 'penghargaan' => 'Piagam Penghargaan', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 3 Lomba Melukis', 'poin' => 65, 'kategori' => 'Seni', 'penghargaan' => 'Sertifikat', 'keterangan' => 'Tingkat sekolah'],
            ['nama_prestasi' => 'Juara 1 Lomba Desain Grafis', 'poin' => 90, 'kategori' => 'Teknologi', 'penghargaan' => 'Piala dan Uang Pembinaan', 'keterangan' => 'Tingkat nasional'],
            ['nama_prestasi' => 'Juara 2 Lomba Robotika', 'poin' => 85, 'kategori' => 'Teknologi', 'penghargaan' => 'Medali Perak', 'keterangan' => 'Tingkat provinsi'],
            ['nama_prestasi' => 'Juara 3 Lomba Programming', 'poin' => 75, 'kategori' => 'Teknologi', 'penghargaan' => 'Sertifikat', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 1 Lomba Cerdas Cermat', 'poin' => 80, 'kategori' => 'Akademik', 'penghargaan' => 'Piala Bergilir', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 2 Olimpiade Kimia', 'poin' => 85, 'kategori' => 'Akademik', 'penghargaan' => 'Medali Perak', 'keterangan' => 'Tingkat provinsi'],
            ['nama_prestasi' => 'Juara 3 Olimpiade Biologi', 'poin' => 75, 'kategori' => 'Akademik', 'penghargaan' => 'Medali Perunggu', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 1 Lomba Menulis Cerpen', 'poin' => 70, 'kategori' => 'Bahasa', 'penghargaan' => 'Piagam Penghargaan', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 2 Lomba Puisi', 'poin' => 65, 'kategori' => 'Bahasa', 'penghargaan' => 'Sertifikat', 'keterangan' => 'Tingkat sekolah'],
            ['nama_prestasi' => 'Juara 1 Lomba Voli Antar Sekolah', 'poin' => 80, 'kategori' => 'Olahraga', 'penghargaan' => 'Piala Bergilir', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 2 Lomba Renang', 'poin' => 75, 'kategori' => 'Olahraga', 'penghargaan' => 'Medali Perak', 'keterangan' => 'Tingkat provinsi'],
            ['nama_prestasi' => 'Juara 3 Lomba Atletik', 'poin' => 70, 'kategori' => 'Olahraga', 'penghargaan' => 'Medali Perunggu', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 1 Lomba Teater', 'poin' => 80, 'kategori' => 'Seni', 'penghargaan' => 'Piala Bergilir', 'keterangan' => 'Tingkat provinsi'],
            ['nama_prestasi' => 'Juara 2 Lomba Paduan Suara', 'poin' => 75, 'kategori' => 'Seni', 'penghargaan' => 'Piagam Penghargaan', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 3 Lomba Band', 'poin' => 70, 'kategori' => 'Seni', 'penghargaan' => 'Sertifikat', 'keterangan' => 'Tingkat sekolah'],
            ['nama_prestasi' => 'Juara 1 Lomba Fotografi', 'poin' => 75, 'kategori' => 'Seni', 'penghargaan' => 'Piagam Penghargaan', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 2 Lomba Videografi', 'poin' => 70, 'kategori' => 'Teknologi', 'penghargaan' => 'Sertifikat', 'keterangan' => 'Tingkat kabupaten/kota'],
            ['nama_prestasi' => 'Juara 1 Lomba Kaligrafi', 'poin' => 65, 'kategori' => 'Seni', 'penghargaan' => 'Piagam Penghargaan', 'keterangan' => 'Tingkat sekolah'],
            ['nama_prestasi' => 'Juara 2 Lomba Tahfidz Quran', 'poin' => 85, 'kategori' => 'Keagamaan', 'penghargaan' => 'Piala dan Uang Pembinaan', 'keterangan' => 'Tingkat provinsi'],
            ['nama_prestasi' => 'Juara 3 Lomba MTQ', 'poin' => 75, 'kategori' => 'Keagamaan', 'penghargaan' => 'Piagam Penghargaan', 'keterangan' => 'Tingkat kabupaten/kota'],
        ];

        foreach ($data as $item) {
            JenisPrestasi::create($item);
        }
    }
}
