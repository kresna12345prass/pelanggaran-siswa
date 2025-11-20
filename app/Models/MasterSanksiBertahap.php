<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSanksiBertahap extends Model
{
    use HasFactory;

    protected $table = 'master_sanksi_bertahap';

    protected $fillable = [
        'kategori', 
        'nama_sanksi',
        'poin_minimal',
        'poin_maksimal',
        'deskripsi_tindakan',
    ];
}