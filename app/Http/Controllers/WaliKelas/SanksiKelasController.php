<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\DataSanksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Shuchkin\SimpleXLSXGen;

class SanksiKelasController extends Controller
{
    // Menampilkan halaman daftar sanksi kelas
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->first() : null;
        
        $sanksi = DataSanksi::whereHas('pelanggaran.siswa', function($q) use ($kelas) {
            if($kelas) $q->where('kelas_id', $kelas->id);
        })->with(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran'])->latest()->get();
        
        return view('wali_kelas.sanksi_kelas.index', compact('sanksi', 'kelas'));
    }

    // Menampilkan detail sanksi kelas
    public function show($id)
    {
        $sanksi = DataSanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran', 'pelaksanaan'])->findOrFail($id);
        return view('wali_kelas.sanksi_kelas.show', compact('sanksi'));
    }

    // Export data sanksi kelas ke Excel
    public function export()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->first() : null;
        
        $sanksi = DataSanksi::whereHas('pelanggaran.siswa', function($q) use ($kelas) {
            if($kelas) $q->where('kelas_id', $kelas->id);
        })->with(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran'])->latest()->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal Mulai</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>NIS</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Sanksi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Deskripsi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal Selesai</center></style>'
        ]];
        
        foreach($sanksi as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') : '-') . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->pelanggaran->siswa->nama_siswa ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->pelanggaran->siswa->nis ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->jenis_sanksi . '</style>',
                '<style border="thin" border-color="#000000">' . $item->deskripsi_hukuman . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ucfirst($item->status_sanksi) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') : '-') . '</center></style>'
            ];
        }
        
        $filename = 'data-sanksi-kelas-' . ($kelas ? $kelas->nama_kelas : 'unknown') . '-' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
