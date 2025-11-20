<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\MonitoringPelanggaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard kepala sekolah dengan statistik dan grafik
    public function index()
    {
        // Mengumpulkan data statistik pelanggaran
        $stats = [
            'total_pelanggaran' => Pelanggaran::where('status_verifikasi', 'diverifikasi')->count(),
            'total_siswa_bermasalah' => Pelanggaran::where('status_verifikasi', 'diverifikasi')
                ->distinct('siswa_id')->count('siswa_id'),
            'kasus_berat' => Pelanggaran::where('status_verifikasi', 'diverifikasi')
                ->where('poin', '>=', 50)->count(),
            'total_monitoring' => MonitoringPelanggaran::count(),
        ];

        // Mengambil data tren pelanggaran 6 bulan terakhir untuk grafik
        $trendData = Pelanggaran::where('status_verifikasi', 'diverifikasi')
            ->where('tanggal', '>=', now()->subMonths(6))
            ->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m") as bulan'), DB::raw('count(*) as total'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $trendLabels = $trendData->pluck('bulan');
        $trendCounts = $trendData->pluck('total');

        // Mengambil top 5 kategori pelanggaran terbanyak
        $kategoriData = Pelanggaran::join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->join('kategori_pelanggaran', 'jenis_pelanggaran.kategori_pelanggaran_id', '=', 'kategori_pelanggaran.id')
            ->where('pelanggaran.status_verifikasi', 'diverifikasi')
            ->select('kategori_pelanggaran.nama_kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori_pelanggaran.nama_kategori')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        $kategoriLabels = $kategoriData->pluck('nama_kategori');
        $kategoriCounts = $kategoriData->pluck('total');

        // Mengambil top 10 kelas dengan pelanggaran terbanyak
        $kelasData = Pelanggaran::join('siswa', 'pelanggaran.siswa_id', '=', 'siswa.id')
            ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
            ->where('pelanggaran.status_verifikasi', 'diverifikasi')
            ->select('kelas.nama_kelas', DB::raw('count(*) as total'))
            ->groupBy('kelas.nama_kelas')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $kelasLabels = $kelasData->pluck('nama_kelas');
        $kelasCounts = $kelasData->pluck('total');

        // Mengambil data status verifikasi pelanggaran
        $statusData = Pelanggaran::select('status_verifikasi', DB::raw('count(*) as total'))
            ->groupBy('status_verifikasi')
            ->get();

        $statusLabels = $statusData->pluck('status_verifikasi')->map(function($item) {
            return ucfirst($item);
        });
        $statusCounts = $statusData->pluck('total');

        $charts = [
            'trend_labels' => json_encode($trendLabels),
            'trend_data' => json_encode($trendCounts),
            'kategori_labels' => json_encode($kategoriLabels),
            'kategori_data' => json_encode($kategoriCounts),
            'kelas_labels' => json_encode($kelasLabels),
            'kelas_data' => json_encode($kelasCounts),
            'status_labels' => json_encode($statusLabels),
            'status_data' => json_encode($statusCounts),
        ];

        return view('kepsek.dashboard.index', compact('stats', 'charts'));
    }
}
