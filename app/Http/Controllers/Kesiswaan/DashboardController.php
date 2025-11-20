<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\{Pelanggaran, DataSanksi, Prestasi};

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard kesiswaan dengan statistik
    public function index()
    {
        // Mengumpulkan data statistik pelanggaran dan sanksi
        $stats = [
            'menunggu' => Pelanggaran::where('status_verifikasi', 'menunggu')->count(),
            'diverifikasi' => Pelanggaran::where('status_verifikasi', 'diverifikasi')->count(),
            'sanksi_berjalan' => DataSanksi::where('status_sanksi', 'berjalan')->count(),
            'sanksi_selesai' => DataSanksi::where('status_sanksi', 'selesai')->count(),
            'total_prestasi' => Prestasi::count(),
        ];

        $pelanggaranMenunggu = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'pencatat'])
            ->where('status_verifikasi', 'menunggu')
            ->latest()
            ->take(5)
            ->get();

        return view('kesiswaan.dashboard.index', compact('stats', 'pelanggaranMenunggu'));
    }
}
