<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;
    
    protected $table = 'prestasi';

    protected $fillable = [
        'siswa_id',
        'jenis_prestasi_id',
        'tahun_ajaran_id',
        'poin',
        'keterangan',
        'tingkat',
        'penghargaan',
        'user_pencatat',
        'user_verifikator',
        'status_verifikasi',
        'catatan_verifikasi',
        'tanggal',
        'bukti_dokumen',
    ];

    // == RELASI ==

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function jenisPrestasi()
    {
        return $this->belongsTo(JenisPrestasi::class);
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