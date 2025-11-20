<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Shuchkin\SimpleXLSXGen;

class PrestasiKelasController extends Controller
{
    // Menampilkan halaman daftar prestasi kelas
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->first() : null;
        
        $prestasi = Prestasi::whereHas('siswa', function($q) use ($kelas) {
            if($kelas) $q->where('kelas_id', $kelas->id);
        })->with(['siswa', 'jenisPrestasi'])->latest()->get();
        
        return view('wali_kelas.prestasi_kelas.index', compact('prestasi', 'kelas'));
    }

    // Menampilkan detail prestasi kelas
    public function show($id)
    {
        $prestasi = Prestasi::with(['siswa', 'jenisPrestasi'])->findOrFail($id);
        return view('wali_kelas.prestasi_kelas.show', compact('prestasi'));
    }

    // Export data prestasi kelas ke Excel
    public function export()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->first() : null;
        
        $prestasi = Prestasi::whereHas('siswa', function($q) use ($kelas) {
            if($kelas) $q->where('kelas_id', $kelas->id);
        })->with(['siswa', 'jenisPrestasi'])->latest()->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>NIS</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Prestasi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tingkat</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Peringkat</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Keterangan</center></style>'
        ]];
        
        foreach($prestasi as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->siswa->nama_siswa . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->siswa->nis . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->jenisPrestasi->nama_prestasi . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ucfirst($item->tingkat) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->peringkat . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->keterangan ?? '-') . '</style>'
            ];
        }
        
        $filename = 'data-prestasi-kelas-' . ($kelas ? $kelas->nama_kelas : 'unknown') . '-' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
