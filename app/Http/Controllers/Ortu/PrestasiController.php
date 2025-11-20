<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestasi;

class PrestasiController extends Controller
{
    // Menampilkan halaman daftar prestasi anak
    public function index()
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;
        
        if (!$orangtua) {
            return redirect()->route('login')->withErrors(['error' => 'Data orang tua tidak ditemukan']);
        }
        
        $siswa = $orangtua->siswa;
        
        $prestasi = Prestasi::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'diverifikasi')
            ->with(['jenisPrestasi', 'tahunAjaran', 'pencatat'])
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $totalPoin = Prestasi::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
        
        return view('ortu.prestasi.index', compact('siswa', 'prestasi', 'totalPoin'));
    }
    
    // Menampilkan detail prestasi anak
    public function show($id)
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;
        
        if (!$orangtua) {
            return redirect()->route('login')->withErrors(['error' => 'Data orang tua tidak ditemukan']);
        }
        
        $siswa = $orangtua->siswa;
        
        $prestasi = Prestasi::where('siswa_id', $siswa->id)
            ->where('id', $id)
            ->with(['jenisPrestasi', 'tahunAjaran', 'pencatat', 'verifikator'])
            ->firstOrFail();
        
        return view('ortu.prestasi.show', compact('siswa', 'prestasi'));
    }
}
