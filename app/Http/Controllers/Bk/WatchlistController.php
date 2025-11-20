<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Shuchkin\SimpleXLSXGen;

class WatchlistController extends Controller
{
    // Menampilkan halaman watchlist siswa bermasalah
    public function index()
    {
        $topPelanggar = Siswa::with(['kelas', 'pelanggaran'])
            ->withSum('pelanggaran', 'poin')
            ->having('pelanggaran_sum_poin', '>', 0)
            ->orderByDesc('pelanggaran_sum_poin')
            ->get();

        return view('bk.watchlist.index', compact('topPelanggar'));
    }

    // Menampilkan detail siswa bermasalah
    public function show($id)
    {
        $siswa = Siswa::with(['kelas', 'pelanggaran.jenisPelanggaran', 'bimbinganKonseling'])
            ->withSum('pelanggaran', 'poin')
            ->findOrFail($id);

        return view('bk.watchlist.show', compact('siswa'));
    }

    // Export data watchlist siswa ke Excel
    public function export()
    {
        $topPelanggar = Siswa::with(['kelas'])
            ->withSum('pelanggaran', 'poin')
            ->having('pelanggaran_sum_poin', '>', 0)
            ->orderByDesc('pelanggaran_sum_poin')
            ->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Ranking</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>NIS</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Total Poin</center></style>'
        ]];
        
        foreach ($topPelanggar as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>#' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->nis . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->nama_siswa . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->kelas?->nama_kelas ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->pelanggaran_sum_poin . ' Poin</center></style>'
            ];
        }
        
        $filename = 'watchlist_siswa_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
