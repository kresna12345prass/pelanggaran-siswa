<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Shuchkin\SimpleXLSXGen;

class MonitoringController extends Controller
{
    // Menampilkan halaman monitoring siswa kelas
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->first() : null;
        
        $siswaList = $kelas ? $kelas->siswa()->with(['pelanggaran' => function($q) {
            $q->where('status_verifikasi', 'diverifikasi');
        }])->get()->map(function($siswa) {
            $totalPoin = $siswa->pelanggaran->sum('poin');
            $siswa->total_poin = $totalPoin;
            $siswa->status_poin = $totalPoin >= 90 ? 'Kritis' : ($totalPoin >= 16 ? 'Lampu Kuning' : 'Aman');
            return $siswa;
        })->sortByDesc('total_poin') : collect();
        
        return view('wali_kelas.monitoring.index', compact('siswaList', 'kelas'));
    }

    // Menampilkan detail monitoring siswa
    public function show($id)
    {
        $siswa = Siswa::with(['pelanggaran' => function($q) {
            $q->where('status_verifikasi', 'diverifikasi')->with(['jenisPelanggaran', 'userPencatat']);
        }, 'kelas'])->findOrFail($id);
        
        $totalPoin = $siswa->pelanggaran->sum('poin');
        
        return view('wali_kelas.monitoring.show', compact('siswa', 'totalPoin'));
    }

    // Export data monitoring kelas ke Excel
    public function export()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->first() : null;
        
        $siswaList = $kelas ? $kelas->siswa()->with(['pelanggaran' => function($q) {
            $q->where('status_verifikasi', 'diverifikasi');
        }])->get()->map(function($siswa) {
            $totalPoin = $siswa->pelanggaran->sum('poin');
            $siswa->total_poin = $totalPoin;
            $siswa->status_poin = $totalPoin >= 90 ? 'Kritis' : ($totalPoin >= 16 ? 'Lampu Kuning' : 'Aman');
            return $siswa;
        })->sortByDesc('total_poin') : collect();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>NIS</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Total Poin</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status</center></style>'
        ]];
        
        foreach ($siswaList as $index => $siswa) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $siswa->nis . '</center></style>',
                '<style border="thin" border-color="#000000">' . $siswa->nama_siswa . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($kelas?->nama_kelas ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $siswa->total_poin . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $siswa->status_poin . '</center></style>'
            ];
        }
        
        $filename = 'monitoring_kelas_' . ($kelas?->nama_kelas ?? 'data') . '_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
