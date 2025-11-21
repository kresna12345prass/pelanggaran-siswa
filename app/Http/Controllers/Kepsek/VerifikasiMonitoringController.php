<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Shuchkin\SimpleXLSXGen;

class VerifikasiMonitoringController extends Controller
{
    // Menampilkan halaman verifikasi dan monitoring pelanggaran
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->orderBy('tanggal', 'desc');

        if ($status != 'all') {
            $query->where('status_verifikasi', $status);
        }

        $pelanggaran = $query->get();

        $stats = [
            'pending' => Pelanggaran::where('status_verifikasi', 'menunggu')->count(),
            'diverifikasi' => Pelanggaran::where('status_verifikasi', 'diverifikasi')->count(),
            'ditolak' => Pelanggaran::where('status_verifikasi', 'ditolak')->count(),
        ];

        return view('kepsek.verifikasi_monitoring.index', compact('pelanggaran', 'stats', 'status'));
    }

    // Export data verifikasi monitoring ke Excel
    public function export(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->orderBy('tanggal', 'desc');

        if ($status != 'all') {
            $query->where('status_verifikasi', $status);
        }

        $pelanggaran = $query->get();

        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>NIS</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Pelanggaran</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Poin</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status Verifikasi</center></style>'
        ]];
        
        foreach ($pelanggaran as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->siswa->nis ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->siswa->nama_siswa ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->siswa->kelas->nama_kelas ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->jenisPelanggaran->nama_pelanggaran ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->poin . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ucfirst($item->status_verifikasi) . '</center></style>'
            ];
        }
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs('verifikasi-monitoring-' . date('Y-m-d') . '.xlsx');
    }
}
