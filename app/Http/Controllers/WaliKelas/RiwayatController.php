<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    // Menampilkan halaman riwayat laporan wali kelas
    public function index()
    {
        $riwayat = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'tahunAjaran', 'userVerifikator'])
            ->where('user_pencatat', Auth::id())
            ->whereIn('status_verifikasi', ['diverifikasi', 'ditolak'])
            ->latest()
            ->paginate(10);
        
        return view('wali_kelas.riwayat.index', compact('riwayat'));
    }

    // Menampilkan detail riwayat laporan
    public function show($id)
    {
        $riwayat = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'tahunAjaran', 'userVerifikator'])->findOrFail($id);
        return view('wali_kelas.riwayat.show', compact('riwayat'));
    }
}
