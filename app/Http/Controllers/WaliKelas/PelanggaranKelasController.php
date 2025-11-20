<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Shuchkin\SimpleXLSXGen;

class PelanggaranKelasController extends Controller
{
    // Menampilkan halaman daftar pelanggaran kelas
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->first() : null;
        
        $pelanggaran = Pelanggaran::whereHas('siswa', function($q) use ($kelas) {
            if($kelas) $q->where('kelas_id', $kelas->id);
        })->with(['siswa', 'jenisPelanggaran', 'userPencatat.guru'])->latest()->get();
        
        return view('wali_kelas.pelanggaran_kelas.index', compact('pelanggaran', 'kelas'));
    }

    // Menampilkan detail pelanggaran kelas
    public function show($id)
    {
        $pelanggaran = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'userPencatat.guru'])->findOrFail($id);
        return view('wali_kelas.pelanggaran_kelas.show', compact('pelanggaran'));
    }

    // Export data pelanggaran kelas ke Excel
    public function export()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->first() : null;
        
        $pelanggaran = Pelanggaran::whereHas('siswa', function($q) use ($kelas) {
            if($kelas) $q->where('kelas_id', $kelas->id);
        })->with(['siswa', 'jenisPelanggaran', 'userPencatat.guru'])->latest()->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>NIS</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Pelanggaran</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Poin</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Pelapor</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Keterangan</center></style>'
        ]];
        
        foreach($pelanggaran as $index => $item) {
            $pelapor = '-';
            if($item->userPencatat) {
                if($item->userPencatat->guru) {
                    $pelapor = $item->userPencatat->guru->nama_guru;
                } else {
                    $pelapor = $item->userPencatat->nama_lengkap;
                }
            }
            
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y H:i') . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->siswa->nama_siswa . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->siswa->nis . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->jenisPelanggaran->nama_pelanggaran . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->poin . '</center></style>',
                '<style border="thin" border-color="#000000">' . $pelapor . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ucfirst($item->status_verifikasi) . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->keterangan ?? '-') . '</style>'
            ];
        }
        
        $filename = 'data-pelanggaran-kelas-' . ($kelas ? $kelas->nama_kelas : 'unknown') . '-' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
