<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaksanaanSanksi extends Model
{
    use HasFactory;
    protected $table = 'pelaksanaan_sanksi';

    protected $fillable = [
        'data_sanksi_id',
        'tanggal_pelaksanaan', 'bukti_foto', 'catatan', 'status'
    ];

    public function dataSanksi() { return $this->belongsTo(DataSanksi::class, 'data_sanksi_id'); }
}