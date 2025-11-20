<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shuchkin\SimpleXLSXGen;

class SiswaBermasalahController extends Controller
{
    // Menampilkan halaman daftar siswa bermasalah
    public function index()
    {
        $siswa = Siswa::with('kelas')
            ->select('siswa.id', 'siswa.nis', 'siswa.nisn', 'siswa.nama_siswa', 'siswa.kelas_id', DB::raw('COALESCE(SUM(pelanggaran.poin), 0) as total_poin'))
            ->leftJoin('pelanggaran', function($join) {
                $join->on('siswa.id', '=', 'pelanggaran.siswa_id')
                    ->where('pelanggaran.status_verifikasi', '=', 'diverifikasi');
            })
            ->groupBy('siswa.id', 'siswa.nis', 'siswa.nisn', 'siswa.nama_siswa', 'siswa.kelas_id')
            ->having('total_poin', '>', 0)
            ->orderBy('total_poin', 'desc')
            ->get();

        return view('kepsek.siswa_bermasalah.index', compact('siswa'));
    }

    // Menampilkan detail siswa bermasalah
    public function show($id)
    {
        $siswa = Siswa::with(['kelas', 'pelanggaran' => function($q) {
            $q->where('status_verifikasi', 'diverifikasi')
              ->with('jenisPelanggaran')
              ->orderBy('tanggal', 'desc');
        }])->findOrFail($id);

        $totalPoin = $siswa->pelanggaran->sum('poin');

        return view('kepsek.siswa_bermasalah.show', compact('siswa', 'totalPoin'));
    }

    // Export data siswa bermasalah ke Excel
    public function export()
    {
        $siswa = Siswa::with('kelas')
            ->select('siswa.id', 'siswa.nis', 'siswa.nisn', 'siswa.nama_siswa', 'siswa.kelas_id', DB::raw('COALESCE(SUM(pelanggaran.poin), 0) as total_poin'))
            ->leftJoin('pelanggaran', function($join) {
                $join->on('siswa.id', '=', 'pelanggaran.siswa_id')
                    ->where('pelanggaran.status_verifikasi', '=', 'diverifikasi');
            })
            ->groupBy('siswa.id', 'siswa.nis', 'siswa.nisn', 'siswa.nama_siswa', 'siswa.kelas_id')
            ->having('total_poin', '>', 0)
            ->orderBy('total_poin', 'desc')
            ->get();

        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>NIS</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Total Poin</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status</center></style>'
        ]];
        
        foreach ($siswa as $index => $item) {
            $status = $item->total_poin >= 100 ? 'Sangat Bermasalah' : 
                     ($item->total_poin >= 50 ? 'Bermasalah' : 'Perlu Perhatian');
            
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->nis . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->nama_siswa . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->kelas->nama_kelas ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->total_poin . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $status . '</center></style>'
            ];
        }
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs('siswa-bermasalah-' . date('Y-m-d') . '.xlsx');
    }
}
