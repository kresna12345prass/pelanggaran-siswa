<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kesiswaan extends Model
{
    use HasFactory;
    
    protected $table = 'kesiswaan';

    protected $fillable = [
        'siswa_id',
        'tahun_ajaran_id',
        'status',
        'tanggal_daftar',
        'jam_masuk',
        'no_ijazah',
        'catatan_khusus',
        'user_pencatat',
        'user_verifikator',
        'status_verifikasi',
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

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'user_pencatat');
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'user_verifikator');
    }
}