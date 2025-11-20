<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard guru dengan statistik laporan
    public function index()
    {
        $user = Auth::user();
        
        // Mengumpulkan statistik laporan pelanggaran yang dibuat guru
        $totalLaporan = Pelanggaran::where('user_pencatat', $user->id)->count();
        $laporanMenunggu = Pelanggaran::where('user_pencatat', $user->id)
            ->where('status_verifikasi', 'menunggu')->count();
        $laporanDisetujui = Pelanggaran::where('user_pencatat', $user->id)
            ->where('status_verifikasi', 'diverifikasi')->count();
        $laporanDitolak = Pelanggaran::where('user_pencatat', $user->id)
            ->where('status_verifikasi', 'ditolak')->count();
        
        // Menghitung laporan bulan ini
        $laporanBulanIni = Pelanggaran::where('user_pencatat', $user->id)
            ->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->count();
        
        // Mengambil 5 laporan terbaru
        $laporanTerbaru = Pelanggaran::where('user_pencatat', $user->id)
            ->with(['siswa', 'jenisPelanggaran'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('guru.dashboard.index', compact(
            'totalLaporan',
            'laporanMenunggu',
            'laporanDisetujui',
            'laporanDitolak',
            'laporanBulanIni',
            'laporanTerbaru'
        ));
    }
}
