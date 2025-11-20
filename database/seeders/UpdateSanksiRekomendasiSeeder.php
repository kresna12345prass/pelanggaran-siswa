<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateSanksiRekomendasiSeeder extends Seeder
{
    public function run(): void
    {
        $pelanggarans = DB::table('jenis_pelanggaran')->get();
        
        foreach ($pelanggarans as $pelanggaran) {
            $sanksi = DB::table('master_sanksi_bertahap')
                ->where('poin_minimal', '<=', $pelanggaran->poin)
                ->where('poin_maksimal', '>=', $pelanggaran->poin)
                ->first();
            
            if ($sanksi) {
                DB::table('jenis_pelanggaran')
                    ->where('id', $pelanggaran->id)
                    ->update(['sanksi' => $sanksi->nama_sanksi]);
            }
        }
    }
}
