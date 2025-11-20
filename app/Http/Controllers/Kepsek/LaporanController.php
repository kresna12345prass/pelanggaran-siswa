<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Prestasi;
use App\Models\MonitoringPelanggaran;
use App\Models\BimbinganKonseling;
use App\Models\PelaksanaanSanksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shuchkin\SimpleXLSXGen;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Menampilkan halaman laporan dengan statistik dan grafik
    public function index()
    {
        $kelas = Kelas::all();
        
        // Mengambil data statistik dashboard
        $stats = $this->getDashboardStats();
        
        // Mengambil data untuk grafik
        $chartData = $this->getChartData();
        
        return view('kepsek.laporan.index', compact('kelas', 'stats', 'chartData'));
    }
    
    // Mengumpulkan statistik dashboard
    private function getDashboardStats()
    {
        return [
            'total_pelanggaran' => Pelanggaran::where('status_verifikasi', 'diverifikasi')->count(),
            'total_siswa_bermasalah' => Pelanggaran::where('status_verifikasi', 'diverifikasi')
                ->distinct('siswa_id')->count('siswa_id'),
            'kasus_berat' => Pelanggaran::where('status_verifikasi', 'diverifikasi')
                ->where('poin', '>=', 50)->count(),
            'total_prestasi' => Prestasi::count(),
            'monitoring_aktif' => MonitoringPelanggaran::count(),
            'konseling_selesai' => BimbinganKonseling::count(),
            'sanksi_terlaksana' => 0,
            'pelanggaran_bulan_ini' => Pelanggaran::where('status_verifikasi', 'diverifikasi')
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count(),
        ];
    }
    
    // Mengumpulkan data untuk grafik
    private function getChartData()
    {
        // Mengambil tren pelanggaran 6 bulan terakhir
        $trendData = Pelanggaran::where('status_verifikasi', 'diverifikasi')
            ->where('tanggal', '>=', now()->subMonths(6))
            ->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m") as bulan'), DB::raw('count(*) as total'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
            
        // Mengambil top 5 siswa bermasalah
        $topSiswa = Siswa::select('siswa.id', 'siswa.nama_siswa', 'siswa.kelas_id', DB::raw('COALESCE(SUM(pelanggaran.poin), 0) as total_poin'))
            ->leftJoin('pelanggaran', function($join) {
                $join->on('siswa.id', '=', 'pelanggaran.siswa_id')
                    ->where('pelanggaran.status_verifikasi', '=', 'diverifikasi');
            })
            ->with('kelas')
            ->groupBy('siswa.id', 'siswa.nama_siswa', 'siswa.kelas_id')
            ->orderBy('total_poin', 'desc')
            ->take(5)
            ->get();
            
        // Mengambil data pelanggaran per kategori
        $kategoriData = Pelanggaran::join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->join('kategori_pelanggaran', 'jenis_pelanggaran.kategori_pelanggaran_id', '=', 'kategori_pelanggaran.id')
            ->where('pelanggaran.status_verifikasi', 'diverifikasi')
            ->select('kategori_pelanggaran.nama_kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori_pelanggaran.nama_kategori')
            ->orderBy('total', 'desc')
            ->get();
            
        return [
            'trend_data' => $trendData,
            'top_siswa' => $topSiswa,
            'kategori_data' => $kategoriData,
        ];
    }

    // Menampilkan detail laporan berdasarkan filter
    public function show(Request $request)
    {
        $jenis = $request->get('jenis', 'pelanggaran_siswa');
        $kelas_id = $request->get('kelas_id');
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_selesai = $request->get('tanggal_selesai');

        $data = [];

        if ($jenis == 'pelanggaran_siswa') {
            $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
                ->where('status_verifikasi', 'diverifikasi');

            if ($kelas_id) {
                $query->whereHas('siswa', function($q) use ($kelas_id) {
                    $q->where('kelas_id', $kelas_id);
                });
            }

            if ($tanggal_mulai && $tanggal_selesai) {
                $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai]);
            }

            $data = $query->orderBy('tanggal', 'desc')->get();
        } elseif ($jenis == 'rekapitulasi_kelas') {
            $query = Siswa::with('kelas')
                ->select('siswa.id', 'siswa.nis', 'siswa.nisn', 'siswa.nama_siswa', 'siswa.kelas_id', DB::raw('COALESCE(SUM(pelanggaran.poin), 0) as total_poin'))
                ->leftJoin('pelanggaran', function($join) {
                    $join->on('siswa.id', '=', 'pelanggaran.siswa_id')
                        ->where('pelanggaran.status_verifikasi', '=', 'diverifikasi');
                })
                ->groupBy('siswa.id', 'siswa.nis', 'siswa.nisn', 'siswa.nama_siswa', 'siswa.kelas_id');

            if ($kelas_id) {
                $query->where('siswa.kelas_id', $kelas_id);
            }

            $data = $query->orderBy('total_poin', 'desc')->get();
        }

        $kelas = Kelas::all();
        return view('kepsek.laporan.show', compact('data', 'jenis', 'kelas', 'kelas_id', 'tanggal_mulai', 'tanggal_selesai'));
    }

    // Export laporan ke Excel
    public function export(Request $request)
    {
        $jenis = $request->get('jenis', 'pelanggaran_siswa');
        $kelas_id = $request->get('kelas_id');
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_selesai = $request->get('tanggal_selesai');

        if ($jenis == 'pelanggaran_siswa') {
            $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
                ->where('status_verifikasi', 'diverifikasi');

            if ($kelas_id) {
                $query->whereHas('siswa', function($q) use ($kelas_id) {
                    $q->where('kelas_id', $kelas_id);
                });
            }

            if ($tanggal_mulai && $tanggal_selesai) {
                $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai]);
            }

            $result = $query->orderBy('tanggal', 'desc')->get();
            
            $data = [[
                '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
                '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal</center></style>',
                '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>NIS</center></style>',
                '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
                '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
                '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Pelanggaran</center></style>',
                '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Poin</center></style>'
            ]];
            
            foreach ($result as $index => $item) {
                $data[] = [
                    '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                    '<style border="thin" border-color="#000000"><center>' . ($item->tanggal)->format('d/m/Y') . '</center></style>',
                    '<style border="thin" border-color="#000000"><center>' . ($item->siswa->nis ?? '-') . '</center></style>',
                    '<style border="thin" border-color="#000000">' . ($item->siswa->nama_siswa ?? '-') . '</style>',
                    '<style border="thin" border-color="#000000"><center>' . ($item->siswa->kelas->nama_kelas ?? '-') . '</center></style>',
                    '<style border="thin" border-color="#000000">' . ($item->jenisPelanggaran->nama_pelanggaran ?? '-') . '</style>',
                    '<style border="thin" border-color="#000000"><center>' . $item->poin . '</center></style>'
                ];
            }
        } else {
            $query = Siswa::with('kelas')
                ->select('siswa.id', 'siswa.nis', 'siswa.nisn', 'siswa.nama_siswa', 'siswa.kelas_id', DB::raw('COALESCE(SUM(pelanggaran.poin), 0) as total_poin'))
                ->leftJoin('pelanggaran', function($join) {
                    $join->on('siswa.id', '=', 'pelanggaran.siswa_id')
                        ->where('pelanggaran.status_verifikasi', '=', 'diverifikasi');
                })
                ->groupBy('siswa.id', 'siswa.nis', 'siswa.nisn', 'siswa.nama_siswa', 'siswa.kelas_id');

            if ($kelas_id) {
                $query->where('siswa.kelas_id', $kelas_id);
            }

            $result = $query->orderBy('total_poin', 'desc')->get();
            
            $data = [[
                '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
                '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>NIS</center></style>',
                '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
                '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
                '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Total Poin</center></style>'
            ]];
            
            foreach ($result as $index => $item) {
                $data[] = [
                    '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                    '<style border="thin" border-color="#000000"><center>' . $item->nis . '</center></style>',
                    '<style border="thin" border-color="#000000">' . $item->nama_siswa . '</style>',
                    '<style border="thin" border-color="#000000"><center>' . ($item->kelas->nama_kelas ?? '-') . '</center></style>',
                    '<style border="thin" border-color="#000000"><center>' . $item->total_poin . '</center></style>'
                ];
            }
        }

        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs('laporan-' . $jenis . '-' . date('Y-m-d') . '.xlsx');
    }
    
    // Menampilkan halaman analisis mendalam
    public function analisisMendalam()
    {
        // Menganalisis tren pelanggaran per bulan
        $trenBulanan = Pelanggaran::where('status_verifikasi', 'diverifikasi')
            ->where('tanggal', '>=', now()->subYear())
            ->select(
                DB::raw('DATE_FORMAT(tanggal, "%Y-%m") as periode'),
                DB::raw('COUNT(*) as total_kasus'),
                DB::raw('SUM(poin) as total_poin'),
                DB::raw('AVG(poin) as rata_poin')
            )
            ->groupBy('periode')
            ->orderBy('periode')
            ->get();
            
        // Menganalisis efektivitas sanksi
        $efektivitasSanksi = PelaksanaanSanksi::select(
                'data_sanksi.nama_sanksi',
                DB::raw('COUNT(*) as total_pelaksanaan'),
                DB::raw('SUM(CASE WHEN pelaksanaan_sanksi.status = "selesai" THEN 1 ELSE 0 END) as selesai'),
                DB::raw('ROUND((SUM(CASE WHEN pelaksanaan_sanksi.status = "selesai" THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as persentase_selesai')
            )
            ->join('data_sanksi', 'pelaksanaan_sanksi.sanksi_id', '=', 'data_sanksi.id')
            ->groupBy('data_sanksi.id', 'data_sanksi.nama_sanksi')
            ->orderBy('total_pelaksanaan', 'desc')
            ->get();
            
        // Menganalisis siswa berisiko tinggi
        $siswaBerisiko = Siswa::select(
                'siswa.*',
                'kelas.nama_kelas',
                DB::raw('COUNT(pelanggaran.id) as total_pelanggaran'),
                DB::raw('SUM(pelanggaran.poin) as total_poin'),
                DB::raw('MAX(pelanggaran.tanggal) as pelanggaran_terakhir')
            )
            ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
            ->join('pelanggaran', 'siswa.id', '=', 'pelanggaran.siswa_id')
            ->where('pelanggaran.status_verifikasi', 'diverifikasi')
            ->groupBy('siswa.id')
            ->having('total_poin', '>=', 30)
            ->orderBy('total_poin', 'desc')
            ->get();
            
        // Menganalisis kelas bermasalah
        $kelasBermasalah = Kelas::select(
                'kelas.*',
                DB::raw('COUNT(DISTINCT siswa.id) as total_siswa'),
                DB::raw('COUNT(pelanggaran.id) as total_pelanggaran'),
                DB::raw('SUM(pelanggaran.poin) as total_poin'),
                DB::raw('ROUND(COUNT(pelanggaran.id) / COUNT(DISTINCT siswa.id), 2) as rata_pelanggaran_per_siswa')
            )
            ->leftJoin('siswa', 'kelas.id', '=', 'siswa.kelas_id')
            ->leftJoin('pelanggaran', function($join) {
                $join->on('siswa.id', '=', 'pelanggaran.siswa_id')
                    ->where('pelanggaran.status_verifikasi', '=', 'diverifikasi');
            })
            ->groupBy('kelas.id')
            ->orderBy('rata_pelanggaran_per_siswa', 'desc')
            ->get();
            
        return view('kepsek.laporan.analisis', compact(
            'trenBulanan', 'efektivitasSanksi', 'siswaBerisiko', 'kelasBermasalah'
        ));
    }
    
    // Menampilkan halaman monitoring
    public function monitoring()
    {
        // Mengambil data monitoring aktif
        $monitoringAktif = MonitoringPelanggaran::with(['pelanggaran.siswa.kelas'])
            ->whereNotNull('status_monitoring')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Mengambil data konseling yang sedang berjalan
        $konselingBerjalan = BimbinganKonseling::with(['siswa.kelas'])
            ->orderBy('tanggal_konseling', 'desc')
            ->get();
            
        // Mengambil data sanksi yang belum selesai
        $sansiBelumSelesai = DB::table('pelaksanaan_sanksi')
            ->join('siswa', 'pelaksanaan_sanksi.siswa_id', '=', 'siswa.id')
            ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
            ->leftJoin('data_sanksi', 'pelaksanaan_sanksi.sanksi_id', '=', 'data_sanksi.id')
            ->select('pelaksanaan_sanksi.*', 'siswa.nama_siswa', 'kelas.nama_kelas', 'data_sanksi.nama_sanksi')
            ->where('pelaksanaan_sanksi.status', '!=', 'selesai')
            ->orderBy('pelaksanaan_sanksi.tanggal_mulai', 'asc')
            ->get();
            
        return view('kepsek.laporan.monitoring', compact(
            'monitoringAktif', 'konselingBerjalan', 'sansiBelumSelesai'
        ));
    }
    
    // Mengirim follow up sanksi
    public function followUpSanksi($id)
    {
        try {
            $sanksi = PelaksanaanSanksi::findOrFail($id);
            
            // Mengupdate status follow up
            $sanksi->update([
                'follow_up_date' => now(),
                'follow_up_status' => 'reminded'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Follow up berhasil dikirim'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim follow up'
            ], 500);
        }
    }
}
