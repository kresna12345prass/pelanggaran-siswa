<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggaran;
use App\Models\DataSanksi;
use App\Models\Prestasi;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard orang tua dengan data anak
    public function index()
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;
        
        if (!$orangtua) {
            return redirect()->route('login')->withErrors(['error' => 'Data orang tua tidak ditemukan']);
        }
        
        $siswa = $orangtua->siswa;
        
        // Menghitung total poin pelanggaran anak
        $totalPoin = Pelanggaran::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
        
        // Menghitung jumlah pelanggaran anak
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
        
        // Menghitung total poin prestasi anak
        $totalPoinPrestasi = Prestasi::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
        
        // Menghitung jumlah prestasi anak
        $jumlahPrestasi = Prestasi::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'diverifikasi')
            ->count();
        
        return view('ortu.dashboard.index', compact('orangtua', 'siswa', 'totalPoin', 'jumlahPelanggaran', 'sanksiAktif', 'sanksiSelesai', 'totalPoinPrestasi', 'jumlahPrestasi'));
    }
}
