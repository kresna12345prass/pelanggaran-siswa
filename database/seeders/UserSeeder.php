<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // <-- IMPORT MODEL USER
use Illuminate\Support\Facades\Hash; // <-- IMPORT HASH

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::firstOrCreate(
            ['email' => 'admin@sekolah.com'], // Kunci unik untuk mencari
            [
                'nama_lengkap' => 'Administrator',
                'username'     => 'admin', // (Sesuai ERD, kita tetap isi)
                'password'     => Hash::make('password'), // <-- Password-nya: "password"
                'level'        => 'admin',
                'can_verify'   => true,       // Admin bisa verifikasi
                'spesialisasi' => 'Super Admin'
            ]
        );

        // Akun BK/Konselor
        User::firstOrCreate(
            ['email' => 'bk@sekolah.com'],
            [
                'nama_lengkap' => 'Konselor BK',
                'username'     => 'bk',
                'password'     => Hash::make('password'),
                'level'        => 'bk',
                'can_verify'   => false,
                'spesialisasi' => 'Bimbingan Konseling'
            ]
        );
    }
}