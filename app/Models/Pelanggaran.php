<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;
    protected $table = 'pelanggaran';

    protected $fillable = [
        'siswa_id', 'jenis_pelanggaran_id', 'tahun_ajaran_id',
        'user_pencatat', 'user_verifikator',
        'poin', 'keterangan', 'foto_bukti', 
        'status_verifikasi', 'catatan_verifikasi', 'tanggal'
    ];

    // Relasi
    public function siswa() { return $this->belongsTo(Siswa::class); }
    public function jenisPelanggaran() { return $this->belongsTo(JenisPelanggaran::class); }
    public function tahunAjaran() { return $this->belongsTo(TahunAjaran::class); }
    public function userPencatat() { return $this->belongsTo(User::class, 'user_pencatat'); }
    public function userVerifikator() { return $this->belongsTo(User::class, 'user_verifikator'); }
    
    // Relasi ke Sanksi
    public function dataSanksi() { return $this->hasOne(DataSanksi::class); }
    
    // Relasi ke Monitoring
    public function monitoringPelanggaran() { return $this->hasOne(MonitoringPelanggaran::class); }
    
    // Relasi ke Verifikasi Data
    public function verifikasiData() { 
        return $this->hasMany(VerifikasiData::class, 'id_terkait')->where('tabel_terkait', 'pelanggaran'); 
    }
}