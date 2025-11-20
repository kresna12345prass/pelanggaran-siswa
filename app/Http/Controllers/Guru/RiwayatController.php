<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    // Menampilkan halaman riwayat laporan pelanggaran guru
    public function index()
    {
        $pelanggarans = Pelanggaran::where('user_pencatat', Auth::id())
            ->with(['siswa', 'jenisPelanggaran', 'tahunAjaran'])
            ->latest()
            ->get();
        
        return view('guru.riwayat.index', compact('pelanggarans'));
    }

    // Menampilkan detail riwayat laporan pelanggaran
    public function show(Pelanggaran $riwayat)
    {
        // Validasi: Hanya guru yang membuat laporan yang bisa melihat
        if ($riwayat->user_pencatat != Auth::id()) {
            abort(403);
        }
        
        $riwayat->load(['siswa', 'jenisPelanggaran.kategori', 'tahunAjaran', 'pencatat']);
        return view('guru.riwayat.show', compact('riwayat'));
    }
}
