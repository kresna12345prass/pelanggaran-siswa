<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSanksi extends Model
{
    use HasFactory;
    protected $table = 'data_sanksi';

    protected $fillable = [
        'siswa_id', 'pelanggaran_id', 'kategori_sanksi_id', 'user_penetap',
        'jenis_sanksi', 'deskripsi_hukuman',
        'tanggal_mulai', 'tanggal_selesai', 'status_sanksi',
        'perlu_konseling', 'bk_user_id', 'catatan_bk', 'status_konseling'
    ];

    public function siswa() { return $this->belongsTo(Siswa::class); }
    public function pelanggaran() { return $this->belongsTo(Pelanggaran::class); }
    public function kategoriSanksi() { return $this->belongsTo(MasterKategoriSanksi::class, 'kategori_sanksi_id'); }
    public function userPenetap() { return $this->belongsTo(User::class, 'user_penetap'); }
    public function guruBk() { return $this->belongsTo(User::class, 'bk_user_id'); }
    public function bimbinganKonseling() { return $this->hasMany(BimbinganKonseling::class, 'data_sanksi_id'); }
    public function pelaksanaan() { return $this->hasMany(PelaksanaanSanksi::class, 'data_sanksi_id'); }
}