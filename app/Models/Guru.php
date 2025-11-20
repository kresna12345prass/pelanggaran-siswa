<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    
    protected $table = 'guru';
    
    protected $fillable = [
        'user_id', 
        'nip', 
        'nama_guru', 
        'jenis_kelamin', 
        'bidang_studi', 
        'status', 
        'no_telepon'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class);
    }

    public function kelasAsWali()
    {
        return $this->hasManyThrough(Kelas::class, WaliKelas::class, 'guru_id', 'id', 'id', 'kelas_id');
    }
}