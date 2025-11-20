<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DataSanksi;

class SanksiController extends Controller
{
    // Menampilkan halaman daftar sanksi siswa
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        if (!$siswa) {
            return redirect()->route('login')->withErrors(['error' => 'Data siswa tidak ditemukan']);
        }
        
        $sanksi = DataSanksi::whereHas('pelanggaran', function($q) use ($siswa) {
            $q->where('siswa_id', $siswa->id);
        })->with(['pelanggaran.jenisPelanggaran', 'userPenetap'])->orderBy('created_at', 'desc')->get();
        
        return view('siswa.sanksi.index', compact('sanksi', 'siswa'));
    }
    
    // Menampilkan detail sanksi siswa
    public function show($id)
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        $sanksi = DataSanksi::whereHas('pelanggaran', function($q) use ($siswa) {
            $q->where('siswa_id', $siswa->id);
        })->where('id', $id)->with(['pelanggaran.jenisPelanggaran', 'userPenetap', 'pelaksanaan'])->firstOrFail();
        
        return view('siswa.sanksi.show', compact('sanksi', 'siswa'));
    }
}
