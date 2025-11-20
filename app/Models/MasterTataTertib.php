<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTataTertib extends Model
{
    use HasFactory;

    // 1. FIX NAMA TABEL
    protected $table = 'master_tata_tertib';

    // 2. FIX SEEDER
    protected $fillable = [
        'pasal',
        'judul',
        'tipe',
        'konten_teks',
        'urutan',
    ];

    // Tidak ada relasi, ini tabel master
}