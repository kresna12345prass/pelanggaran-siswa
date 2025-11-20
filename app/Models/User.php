<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi (Mass Assignment).
     */
    protected $fillable = [
        'username',
        'nama_lengkap',
        'email',
        'password',
        'level', 
        'spesialisasi',
        'can_verify',
    ];

    /**
     * Kolom yang disembunyikan saat di-serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipe data kolom.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'can_verify' => 'boolean',
    ];

    // == RELASI ==

    /**
     * Relasi ke data Guru (jika user ini adalah guru/staf).
     */
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function orangtua()
    {
        return $this->hasOne(Orangtua::class);
    }



    public function bimbinganKonseling()
    {
        return $this->hasMany(BimbinganKonseling::class);
    }

    public function monitoringPelanggaran()
    {
        return $this->hasMany(MonitoringPelanggaran::class, 'kepala_sekolah_id');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }
}