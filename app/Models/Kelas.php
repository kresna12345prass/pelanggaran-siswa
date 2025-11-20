<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    
    // 1. Menentukan nama tabel
    protected $table = 'kelas';

    // 2. Kolom yang boleh diisi
    protected $fillable = [
        'nama_kelas',
        'jurusan_id',
        'kapasitas',
    ];

    // == RELASI ==

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id', 'id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class);
    }
}