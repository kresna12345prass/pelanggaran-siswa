<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggaran;

class RiwayatController extends Controller
{
    // Menampilkan halaman riwayat pelanggaran anak
    public function index()
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;
        
        if (!$orangtua) {
            return redirect()->route('login')->withErrors(['error' => 'Data orang tua tidak ditemukan']);
        }
        
        $siswa = $orangtua->siswa;
        
        $pelanggaran = Pelanggaran::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'diverifikasi')
            ->with(['jenisPelanggaran.kategoriPelanggaran', 'tahunAjaran', 'userPencatat'])
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $totalPoin = Pelanggaran::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
        
        return view('ortu.riwayat.index', compact('siswa', 'pelanggaran', 'totalPoin'));
    }
    
    // Menampilkan detail riwayat pelanggaran anak
    public function show($id)
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;
        
        if (!$orangtua) {
            return redirect()->route('login')->withErrors(['error' => 'Data orang tua tidak ditemukan']);
        }
        
        $siswa = $orangtua->siswa;
        
        $pelanggaran = Pelanggaran::where('siswa_id', $siswa->id)
            ->where('id', $id)
            ->with(['jenisPelanggaran.kategoriPelanggaran', 'tahunAjaran', 'userPencatat', 'userVerifikator', 'dataSanksi'])
            ->firstOrFail();
        
        return view('ortu.riwayat.show', compact('siswa', 'pelanggaran'));
    }
}
