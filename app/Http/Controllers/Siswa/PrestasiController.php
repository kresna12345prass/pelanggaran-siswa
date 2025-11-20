<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestasiController extends Controller
{
    // Menampilkan halaman daftar prestasi siswa
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $prestasi = Prestasi::where('siswa_id', $siswa->id)
                           ->with(['jenisPrestasi', 'pencatat'])
                           ->orderBy('tanggal', 'desc')
                           ->get();

        return view('siswa.prestasi.index', compact('prestasi', 'siswa'));
    }

    // Menampilkan detail prestasi siswa
    public function show($id)
    {
        $siswa = Auth::user()->siswa;
        $prestasi = Prestasi::where('siswa_id', $siswa->id)
                           ->where('id', $id)
                           ->with(['jenisPrestasi', 'pencatat'])
                           ->firstOrFail();

        return view('siswa.prestasi.show', compact('prestasi', 'siswa'));
    }
}