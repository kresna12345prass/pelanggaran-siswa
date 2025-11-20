<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\VerifikasiData;
use Shuchkin\SimpleXLSXGen;

class VerifikasiController extends Controller
{
    // Menampilkan halaman daftar pelanggaran yang menunggu verifikasi
    public function index()
    {
        $pelanggarans = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'userPencatat'])
            ->where('status_verifikasi', 'menunggu')
            ->latest()
            ->get();

        return view('kesiswaan.verifikasi.index', compact('pelanggarans'));
    }

    // Menampilkan detail pelanggaran untuk verifikasi
    public function show($id)
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'userPencatat', 'verifikasiData.verifikator'])->findOrFail($id);
        return view('kesiswaan.verifikasi.show', compact('pelanggaran'));
    }

    // Memproses verifikasi pelanggaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diverifikasi,ditolak',
            'catatan' => 'nullable|string'
        ]);

        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->update([
            'status_verifikasi' => $request->status,
            'catatan_verifikasi' => $request->catatan,
            'user_verifikator' => auth()->id()
        ]);

        // Mencatat data verifikasi ke tabel verifikasi_data
        VerifikasiData::create([
            'tabel_terkait' => 'pelanggaran',
            'id_terkait' => $pelanggaran->id,
            'user_pencatat' => $pelanggaran->user_pencatat,
            'user_verifikator' => auth()->id(),
            'status' => $request->status,
            'catatan_verifikasi' => $request->catatan,
            'tanggal_pencatatan' => $pelanggaran->tanggal,
            'tanggal_verifikasi' => now()
        ]);

        return redirect()->route('kesiswaan.verifikasi.index')->with('success', 'Pelanggaran berhasil ' . $request->status);
    }

    // Menampilkan halaman riwayat verifikasi
    public function riwayat()
    {
        $pelanggarans = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'userPencatat', 'userVerifikator'])
            ->whereIn('status_verifikasi', ['diverifikasi', 'ditolak'])
            ->latest('updated_at')
            ->get();

        return view('kesiswaan.verifikasi.riwayat', compact('pelanggarans'));
    }

    // Export riwayat verifikasi ke Excel
    public function exportRiwayat()
    {
        $pelanggarans = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'userPencatat', 'userVerifikator'])
            ->whereIn('status_verifikasi', ['diverifikasi', 'ditolak'])
            ->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Pelanggaran</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Poin</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Verifikator</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Catatan</center></style>'
        ]];
        
        foreach ($pelanggarans as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->siswa?->nama_siswa ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->siswa?->kelas?->nama_kelas ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->jenisPelanggaran?->nama_pelanggaran ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->poin . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->tanggal . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ucfirst($item->status_verifikasi) . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->userVerifikator?->nama_lengkap ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->catatan_verifikasi ?? '-') . '</style>'
            ];
        }
        
        $filename = 'riwayat_verifikasi_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
