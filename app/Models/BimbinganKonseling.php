<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimbinganKonseling extends Model
{
    use HasFactory;
    
    protected $table = 'bimbingan_konseling';

    protected $fillable = [
        'siswa_id',
        'tahun_ajaran_id',
        'user_id',
        'data_sanksi_id',
        'sumber_rujukan',
        'jenis_layanan',
        'topik',
        'keluhan_masalah',
        'tindakan_solusi',
        'status',
        'tanggal_konseling',
        'tanggal_tindak_lanjut',
        'hasil_evaluasi',
    ];

    // == RELASI ==

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function guruBk()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dataSanksi()
    {
        return $this->belongsTo(DataSanksi::class, 'data_sanksi_id');
    }
}