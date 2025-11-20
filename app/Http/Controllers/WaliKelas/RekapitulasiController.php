<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\TahunAjaran;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\DataSanksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Shuchkin\SimpleXLSXGen;

class RekapitulasiController extends Controller
{
    // Menampilkan halaman rekapitulasi kelas
    public function index(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->with('siswa')->first() : null;
        $tahunAjaran = TahunAjaran::all();
        
        $tahunAjaranId = $request->tahun_ajaran_id;
        
        $siswaList = collect();
        if($kelas) {
            $siswaList = $kelas->siswa->map(function($siswa) use ($tahunAjaranId) {
                $pelanggaranQuery = $siswa->pelanggaran()->where('status_verifikasi', 'diverifikasi');
                $prestasiQuery = $siswa->prestasi();
                
                if($tahunAjaranId) {
                    $pelanggaranQuery->where('tahun_ajaran_id', $tahunAjaranId);
                    $prestasiQuery->where('tahun_ajaran_id', $tahunAjaranId);
                }
                
                $siswa->total_poin = $pelanggaranQuery->sum('poin');
                $siswa->jumlah_pelanggaran = $pelanggaranQuery->count();
                $siswa->jumlah_prestasi = $prestasiQuery->count();
                $siswa->jumlah_sanksi = DataSanksi::whereHas('pelanggaran', function($q) use ($siswa) {
                    $q->where('siswa_id', $siswa->id);
                })->count();
                
                return $siswa;
            });
        }
        
        return view('wali_kelas.rekapitulasi.index', compact('kelas', 'tahunAjaran', 'siswaList', 'tahunAjaranId'));
    }

    // Mencetak rekapitulasi kelas ke PDF
    public function cetak(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->with('siswa')->first() : null;
        
        $tahunAjaran = $request->tahun_ajaran_id ? TahunAjaran::find($request->tahun_ajaran_id) : null;
        $tahunAjaranId = $request->tahun_ajaran_id;
        
        $siswaList = collect();
        if($kelas) {
            $siswaList = $kelas->siswa->map(function($siswa) use ($tahunAjaranId) {
                $pelanggaranQuery = $siswa->pelanggaran()->where('status_verifikasi', 'diverifikasi');
                $prestasiQuery = $siswa->prestasi();
                
                if($tahunAjaranId) {
                    $pelanggaranQuery->where('tahun_ajaran_id', $tahunAjaranId);
                    $prestasiQuery->where('tahun_ajaran_id', $tahunAjaranId);
                }
                
                $siswa->total_poin = $pelanggaranQuery->sum('poin');
                $siswa->jumlah_pelanggaran = $pelanggaranQuery->count();
                $siswa->jumlah_prestasi = $prestasiQuery->count();
                $siswa->jumlah_sanksi = DataSanksi::whereHas('pelanggaran', function($q) use ($siswa) {
                    $q->where('siswa_id', $siswa->id);
                })->count();
                
                return $siswa;
            });
        }
        
        $pdf = Pdf::loadView('wali_kelas.rekapitulasi.cetak', compact('kelas', 'siswaList', 'tahunAjaran'));
        return $pdf->download('rekapitulasi-kelas-' . ($kelas ? $kelas->nama_kelas : 'unknown') . '.pdf');
    }
    
    // Export rekapitulasi kelas ke Excel
    public function export(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->with('siswa')->first() : null;
        
        $tahunAjaran = $request->tahun_ajaran_id ? TahunAjaran::find($request->tahun_ajaran_id) : null;
        $tahunAjaranId = $request->tahun_ajaran_id;
        
        $data = [
            ['No', 'NIS', 'Nama Siswa', 'Total Poin', 'Jumlah Pelanggaran', 'Jumlah Prestasi', 'Jumlah Sanksi', 'Status']
        ];
        
        if($kelas) {
            foreach($kelas->siswa as $index => $siswa) {
                $pelanggaranQuery = $siswa->pelanggaran()->where('status_verifikasi', 'diverifikasi');
                $prestasiQuery = $siswa->prestasi();
                
                if($tahunAjaranId) {
                    $pelanggaranQuery->where('tahun_ajaran_id', $tahunAjaranId);
                    $prestasiQuery->where('tahun_ajaran_id', $tahunAjaranId);
                }
                
                $totalPoin = $pelanggaranQuery->sum('poin');
                $status = $totalPoin >= 90 ? 'Kritis' : ($totalPoin >= 16 ? 'Lampu Kuning' : 'Aman');
                
                $data[] = [
                    $index + 1,
                    $siswa->nis,
                    $siswa->nama_siswa,
                    $totalPoin,
                    $pelanggaranQuery->count(),
                    $prestasiQuery->count(),
                    DataSanksi::whereHas('pelanggaran', function($q) use ($siswa) {
                        $q->where('siswa_id', $siswa->id);
                    })->count(),
                    $status
                ];
            }
        }
        
        $xlsx = SimpleXLSXGen::fromArray($data);
        $filename = 'rekapitulasi-kelas-' . ($kelas ? $kelas->nama_kelas : 'unknown') . '-' . date('Y-m-d') . '.xlsx';
        $xlsx->downloadAs($filename);
        exit;
    }
}
