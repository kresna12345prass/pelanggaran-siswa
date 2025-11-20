<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\DataSanksi;
use Illuminate\Http\Request;
use Shuchkin\SimpleXLSXGen;

class MonitoringSanksiController extends Controller
{
    // Menampilkan halaman monitoring sanksi
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = DataSanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran']);
        
        if ($status !== 'all') {
            $query->where('status_sanksi', $status);
        }
        
        $sanksi = $query->orderBy('tanggal_mulai', 'desc')->get();
        
        $stats = [
            'pending' => DataSanksi::where('status_sanksi', 'pending')->count(),
            'berjalan' => DataSanksi::where('status_sanksi', 'berjalan')->count(),
            'selesai' => DataSanksi::where('status_sanksi', 'selesai')->count(),
        ];
        
        return view('kepsek.monitoring_sanksi.index', compact('sanksi', 'stats', 'status'));
    }
    
    // Export data monitoring sanksi ke Excel
    public function export(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = DataSanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran']);
        
        if ($status !== 'all') {
            $query->where('status_sanksi', $status);
        }
        
        $sanksi = $query->orderBy('tanggal_mulai', 'desc')->get();
        
        $data = [
            ['No', 'Tanggal', 'NIS', 'Nama Siswa', 'Kelas', 'Jenis Pelanggaran', 'Jenis Sanksi', 'Status']
        ];
        
        foreach ($sanksi as $index => $s) {
            $data[] = [
                $index + 1,
                \Carbon\Carbon::parse($s->tanggal_mulai)->format('d/m/Y'),
                $s->pelanggaran->siswa->nis ?? '-',
                $s->pelanggaran->siswa->nama_siswa ?? '-',
                $s->pelanggaran->siswa->kelas->nama_kelas ?? '-',
                $s->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-',
                $s->jenis_sanksi ?? '-',
                ucfirst(str_replace('_', ' ', $s->status_sanksi))
            ];
        }
        
        $filename = 'monitoring_sanksi_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}