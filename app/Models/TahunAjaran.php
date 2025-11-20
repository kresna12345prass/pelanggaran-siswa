<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;
    
    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'kode_ajaran',
        'tahun_ajaran',
        'semester',
        'status_aktif',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    // == RELASI ==



    // (Relasi ke tabel transaksional)
    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class);
    }
}