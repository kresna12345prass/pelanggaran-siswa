<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;
use App\Models\Siswa;
use App\Models\Pelanggaran;
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

        return view('bk.dashboard.index', compact('stats', 'chartData'));
    }
}
