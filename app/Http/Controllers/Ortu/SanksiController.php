<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DataSanksi;

class SanksiController extends Controller
{
    // Menampilkan halaman daftar sanksi anak
    public function index()
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;
        
        if (!$orangtua) {
            return redirect()->route('login')->withErrors(['error' => 'Data orang tua tidak ditemukan']);
        }
        
        $siswa = $orangtua->siswa;
        
        $sanksi = DataSanksi::whereHas('pelanggaran', function($q) use ($siswa) {
            $q->where('siswa_id', $siswa->id);
        })
        ->with(['pelanggaran.jenisPelanggaran', 'pelanggaran.siswa', 'userPenetap'])
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('ortu.sanksi.index', compact('siswa', 'sanksi'));
    }
    
    // Menampilkan detail sanksi anak
    public function show($id)
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;
        
        if (!$orangtua) {
            return redirect()->route('login')->withErrors(['error' => 'Data orang tua tidak ditemukan']);
        }
        
        $siswa = $orangtua->siswa;
        
        $sanksi = DataSanksi::whereHas('pelanggaran', function($q) use ($siswa) {
            $q->where('siswa_id', $siswa->id);
        })
        ->where('id', $id)
        ->with(['pelanggaran.jenisPelanggaran', 'pelanggaran.siswa', 'userPenetap', 'pelaksanaan'])
        ->firstOrFail();
        
        return view('ortu.sanksi.show', compact('siswa', 'sanksi'));
    }
}
