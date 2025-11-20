<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiData extends Model
{
    use HasFactory;
    
    protected $table = 'verifikasi_data';

    protected $fillable = [
        'tabel_terkait',
        'id_terkait',
        'user_pencatat',
        'user_verifikator',
        'status',
        'catatan_verifikasi',
        'tanggal_pencatatan',
        'tanggal_verifikasi',
    ];

    // == RELASI ==
    
    public function pencatat()
    {
        return $this->belongsTo(User::class, 'user_pencatat');
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'user_verifikator');
    }
}