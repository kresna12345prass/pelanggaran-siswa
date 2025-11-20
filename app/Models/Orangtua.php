<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
    use HasFactory;
    
    protected $table = 'orangtua';

    protected $fillable = [
        'user_id',
        'siswa_id',
        'hubungan',
        'no_telepon',
        'pendidikan',
        'pekerjaan',
        'alamat',
    ];

    // == RELASI ==

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}