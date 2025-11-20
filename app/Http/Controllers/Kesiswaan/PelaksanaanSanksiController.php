<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\DataSanksi;
use App\Models\PelaksanaanSanksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Shuchkin\SimpleXLSXGen;

class PelaksanaanSanksiController extends Controller
{
    // Menampilkan halaman daftar sanksi aktif
    public function index()
    {
        $sanksiAktif = DataSanksi::with(['pelanggaran.siswa.kelas', 'userPenetap'])
            ->whereIn('status_sanksi', ['pending', 'berjalan'])
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('kesiswaan.pelaksanaan.index', compact('sanksiAktif'));
    }

    // Memperbarui pelaksanaan sanksi
    public function update(Request $request, $id)
    {
        $request->validate([
            'bukti_foto' => 'nullable|image|max:2048',
            'catatan' => 'nullable|string'
        ]);

        $dataSanksi = DataSanksi::findOrFail($id);

        $buktiPath = null;
        if ($request->hasFile('bukti_foto')) {
            $buktiPath = $request->file('bukti_foto')->store('bukti_sanksi', 'public');
        }

        PelaksanaanSanksi::create([
            'data_sanksi_id' => $dataSanksi->id,
            'tanggal_pelaksanaan' => now(),
            'bukti_foto' => $buktiPath,
            'catatan' => $request->catatan,
            'status' => 'tuntas'
        ]);

        $dataSanksi->update(['status_sanksi' => 'selesai']);

        return redirect()->route('kesiswaan.pelaksanaan.index')
            ->with('success', 'Pelaksanaan sanksi berhasil diupdate!');
    }

    // Menampilkan halaman riwayat pelaksanaan sanksi
    public function riwayat()
    {
        $riwayatPelaksanaan = PelaksanaanSanksi::with(['dataSanksi.pelanggaran.siswa.kelas'])
            ->latest('tanggal_pelaksanaan')
            ->get();

        return view('kesiswaan.pelaksanaan.riwayat', compact('riwayatPelaksanaan'));
    }

    // Menampilkan detail riwayat pelaksanaan sanksi
    public function showRiwayat($id)
    {
        $pelaksanaan = PelaksanaanSanksi::with(['dataSanksi.pelanggaran.siswa.kelas.jurusan', 'dataSanksi.pelanggaran.jenisPelanggaran', 'dataSanksi.userPenetap'])
            ->findOrFail($id);

        return view('kesiswaan.pelaksanaan.show', compact('pelaksanaan'));
    }

    // Mencetak berita acara pelaksanaan sanksi ke PDF
    public function cetakBeritaAcara($id)
    {
        $pelaksanaan = PelaksanaanSanksi::with(['dataSanksi.pelanggaran.siswa.kelas.jurusan', 'dataSanksi.pelanggaran.jenisPelanggaran'])
            ->findOrFail($id);
        $siswa = $pelaksanaan->dataSanksi->pelanggaran->siswa;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('kesiswaan.pelaksanaan.berita_acara', compact('pelaksanaan', 'siswa'));
        return $pdf->download('Berita_Acara_Pelaksanaan_' . $siswa->nama_siswa . '.pdf');
    }

    // Export riwayat pelaksanaan sanksi ke Excel
    public function exportRiwayat()
    {
        $riwayatPelaksanaan = PelaksanaanSanksi::with(['dataSanksi.pelanggaran.siswa.kelas', 'dataSanksi.pelanggaran.jenisPelanggaran'])->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Pelanggaran</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Sanksi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal Pelaksanaan</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Catatan</center></style>'
        ]];
        
        foreach ($riwayatPelaksanaan as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->dataSanksi?->pelanggaran?->siswa?->nama_siswa ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->dataSanksi?->pelanggaran?->siswa?->kelas?->nama_kelas ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->dataSanksi?->pelanggaran?->jenisPelanggaran?->nama_pelanggaran ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->dataSanksi?->jenis_sanksi ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->tanggal_pelaksanaan . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ucfirst($item->status) . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->catatan ?? '-') . '</style>'
            ];
        }
        
        $filename = 'riwayat_pelaksanaan_sanksi_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
