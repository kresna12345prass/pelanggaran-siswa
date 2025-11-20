<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriPelanggaran;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard wali kelas dengan statistik kelas
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->with('siswa')->first() : null;
        
        $totalSiswa = $kelas ? $kelas->siswa->count() : 0;
        $siswaLampuKuning = $kelas ? $kelas->siswa->filter(function($siswa) {
            $totalPoin = $siswa->pelanggaran()->where('status_verifikasi', 'diverifikasi')->sum('poin');
            return $totalPoin >= 16 && $totalPoin < 90;
        })->count() : 0;
        
        $siswaKritis = $kelas ? $kelas->siswa->filter(function($siswa) {
            $totalPoin = $siswa->pelanggaran()->where('status_verifikasi', 'diverifikasi')->sum('poin');
            return $totalPoin >= 90;
        })->count() : 0;
        
        $laporanBaru = Pelanggaran::whereHas('siswa', function($q) use ($kelas) {
            if($kelas) $q->where('kelas_id', $kelas->id);
        })->where('status_verifikasi', 'menunggu')->count();
        
        $siswaAman = $totalSiswa - $siswaLampuKuning - $siswaKritis;
        
        $totalPelanggaran = Pelanggaran::whereHas('siswa', function($q) use ($kelas) {
            if($kelas) $q->where('kelas_id', $kelas->id);
        })->where('status_verifikasi', 'diverifikasi')->count();
        
        $totalPrestasi = \App\Models\Prestasi::whereHas('siswa', function($q) use ($kelas) {
            if($kelas) $q->where('kelas_id', $kelas->id);
        })->count();
        
        $totalSanksi = \App\Models\DataSanksi::whereHas('pelanggaran.siswa', function($q) use ($kelas) {
            if($kelas) $q->where('kelas_id', $kelas->id);
        })->count();
        
        $pelanggaranPerKategori = collect([]);
        if($kelas) {
            $pelanggaranPerKategori = Pelanggaran::whereHas('siswa', function($q) use ($kelas) {
                $q->where('kelas_id', $kelas->id);
            })
            ->where('status_verifikasi', 'diverifikasi')
            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->join('kategori_pelanggaran', 'jenis_pelanggaran.kategori_pelanggaran_id', '=', 'kategori_pelanggaran.id')
            ->select('kategori_pelanggaran.nama_kategori as kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori_pelanggaran.nama_kategori')
            ->get();
        }
        
        $chartStatusSiswa = [
            'labels' => ['Siswa Aman', 'Lampu Kuning', 'Kritis'],
            'data' => [$siswaAman, $siswaLampuKuning, $siswaKritis],
            'colors' => ['#28a745', '#ffc107', '#dc3545']
        ];
        
        $chartPelanggaranKategori = [
            'labels' => $pelanggaranPerKategori->pluck('kategori')->toArray(),
            'data' => $pelanggaranPerKategori->pluck('total')->toArray()
        ];
        
        return view('wali_kelas.dashboard.index', compact('kelas', 'totalSiswa', 'siswaLampuKuning', 'siswaKritis', 'laporanBaru', 'siswaAman', 'totalPelanggaran', 'totalPrestasi', 'totalSanksi', 'pelanggaranPerKategori', 'chartStatusSiswa', 'chartPelanggaranKategori'));
    }
}
