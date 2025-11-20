<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use HasFactory;
    
    protected $table = 'wali_kelas';
    
    protected $fillable = [
        'tahun_ajaran_id',
        'guru_id', 
        'kelas_id'
    ];
    
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
    
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}