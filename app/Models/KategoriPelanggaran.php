<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'kategori_pelanggaran';

    protected $fillable = [
        'nama_kategori',
        'kategori_induk',
        'deskripsi'
    ];

    public function jenisPelanggaran() {
        return $this->hasMany(JenisPelanggaran::class);
    }
}