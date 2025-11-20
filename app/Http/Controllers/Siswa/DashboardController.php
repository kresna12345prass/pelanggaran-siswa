<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggaran;
use App\Models\DataSanksi;
use App\Models\Prestasi;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard siswa dengan statistik
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        if (!$siswa) {
            return redirect()->route('login')->withErrors(['error' => 'Data siswa tidak ditemukan']);
        }
        
        // Menghitung total poin pelanggaran
        $totalPoin = Pelanggaran::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
        
        // Menghitung jumlah pelanggaran
        $jumlahPelanggaran = Pelanggaran::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'diverifikasi')
            ->count();
        
        // Menghitung sanksi yang sedang berjalan
        $sanksiAktif = DataSanksi::whereHas('pelanggaran', function($q) use ($siswa) {
            $q->where('siswa_id', $siswa->id);
        })->whereIn('status_sanksi', ['pending', 'berjalan'])->count();
        
        // Menghitung sanksi yang sudah selesai
        $sanksiSelesai = DataSanksi::whereHas('pelanggaran', function($q) use ($siswa) {
            $q->where('siswa_id', $siswa->id);
        })->where('status_sanksi', 'selesai')->count();
        
        // Menghitung total prestasi
        $totalPrestasi = Prestasi::where('siswa_id', $siswa->id)->count();
        
        return view('siswa.dashboard.index', compact('siswa', 'totalPoin', 'jumlahPelanggaran', 'sanksiAktif', 'sanksiSelesai', 'totalPrestasi'));
    }
}
