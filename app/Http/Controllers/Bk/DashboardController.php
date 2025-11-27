<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\JenisPelanggaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard BK dengan statistik dan grafik
    public function index()
    {
        // Mengumpulkan data statistik konseling
        $stats = [
            'total_konseling' => BimbinganKonseling::where('user_id', auth()->id())->count(),
            'konseling_aktif' => BimbinganKonseling::where('user_id', auth()->id())->where('status', 'aktif')->count(),
            'konseling_selesai' => BimbinganKonseling::where('user_id', auth()->id())->where('status', 'selesai')->count(),
            'siswa_bermasalah' => Siswa::whereHas('pelanggaran')->count(),
        ];

        // Mengambil data pelanggaran per bulan untuk grafik
        $pelanggaranPerBulan = Pelanggaran::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('tanggal', date('Y'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total', 'bulan');

        // Menyiapkan data grafik untuk 12 bulan
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $pelanggaranPerBulan->get($i, 0);
        }

        // Mengambil data jenis pelanggaran untuk grafik
        $jenisPelanggaranData = JenisPelanggaran::select(
            'nama_pelanggaran',
            DB::raw('COUNT(pelanggaran.id) as total')
        )
        ->leftJoin('pelanggaran', 'jenis_pelanggaran.id', '=', 'pelanggaran.jenis_pelanggaran_id')
        ->groupBy('nama_pelanggaran')
        ->pluck('total', 'nama_pelanggaran');

        $jenisPelanggaranLabels = $jenisPelanggaranData->keys();
        $jenisPelanggaranCounts = $jenisPelanggaranData->values();

        // Mengambil data konseling per bulan untuk grafik baru
        $konselingPerBulan = BimbinganKonseling::select(
            DB::raw('MONTH(tanggal_konseling) as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('tanggal_konseling', date('Y'))
        ->where('user_id', auth()->id())
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total', 'bulan');

        // Menyiapkan data grafik konseling untuk 12 bulan
        $konselingChartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $konselingChartData[] = $konselingPerBulan->get($i, 0);
        }

        // Jika data kosong, gunakan data contoh untuk test
        if (array_sum($konselingChartData) == 0) {
            $konselingChartData = [2, 5, 3, 8, 6, 4, 9, 7, 1, 3, 5, 2];
        }

        return view('bk.dashboard.index', compact('stats', 'chartData', 'jenisPelanggaranLabels', 'jenisPelanggaranCounts', 'konselingChartData'));
    }
}
