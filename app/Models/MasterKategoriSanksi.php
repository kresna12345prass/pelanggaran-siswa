<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKategoriSanksi extends Model
{
    protected $table = 'master_kategori_sanksi';
    
    protected $fillable = [
        'kategori',
        'pasal',
        'poin_min',
        'poin_max',
        'deskripsi_sanksi',
    ];

    public function dataSanksi()
    {
        return $this->hasMany(DataSanksi::class, 'kategori_sanksi_id');
    }
}
