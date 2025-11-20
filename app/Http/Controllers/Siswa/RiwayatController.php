<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggaran;

class RiwayatController extends Controller
{
    // Menampilkan halaman riwayat pelanggaran siswa
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        if (!$siswa) {
            return redirect()->route('login')->withErrors(['error' => 'Data siswa tidak ditemukan']);
        }
        
        $riwayat = Pelanggaran::where('siswa_id', $siswa->id)
            ->where('status_verifikasi', 'diverifikasi')
            ->with(['jenisPelanggaran', 'tahunAjaran', 'userPencatat'])
            ->orderBy('tanggal', 'desc')
            ->get();
        
        return view('siswa.riwayat.index', compact('riwayat', 'siswa'));
    }
    
    // Menampilkan detail riwayat pelanggaran siswa
    public function show($id)
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        $pelanggaran = Pelanggaran::where('siswa_id', $siswa->id)
            ->where('id', $id)
            ->with(['jenisPelanggaran', 'tahunAjaran', 'userPencatat', 'userVerifikator'])
            ->firstOrFail();
        
        return view('siswa.riwayat.show', compact('pelanggaran', 'siswa'));
    }
}
