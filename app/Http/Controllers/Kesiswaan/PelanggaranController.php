<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Pelanggaran, Siswa, JenisPelanggaran, TahunAjaran};
use Illuminate\Support\Facades\Storage;
use Shuchkin\SimpleXLSXGen;
use Barryvdh\DomPDF\Facade\Pdf;

class PelanggaranController extends Controller
{
    // Menampilkan halaman daftar pelanggaran
    public function index()
    {
        $pelanggarans = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->oldest()
            ->get();

        return view('kesiswaan.pelanggaran.index', compact('pelanggarans'));
    }

    // Menampilkan form untuk mencatat pelanggaran baru
    public function create()
    {
        $siswas = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $tahunAjaran = TahunAjaran::where('status_aktif', 1)->first();
        $jenisPelanggarans = JenisPelanggaran::with('kategoriPelanggaran')->orderBy('nama_pelanggaran')->get();

        return view('kesiswaan.pelanggaran.create', compact('siswas', 'tahunAjaran', 'jenisPelanggarans'));
    }

    // Menyimpan data pelanggaran baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'foto_bukti' => 'nullable|image|max:2048'
        ]);

        $jenis = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);
        $tahunAjaran = TahunAjaran::where('status_aktif', 1)->first();

        $data = [
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $tahunAjaran->id,
            'user_pencatat' => auth()->id(),
            'poin' => $jenis->poin,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'status_verifikasi' => 'diverifikasi',
            'user_verifikator' => auth()->id()
        ];

        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('pelanggaran', 'public');
        }

        Pelanggaran::create($data);

        return redirect()->route('kesiswaan.pelanggaran.index')->with('success', 'Pelanggaran berhasil dicatat');
    }

    // Menampilkan detail pelanggaran
    public function show($id)
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'userPencatat'])->findOrFail($id);
        return view('kesiswaan.pelanggaran.show', compact('pelanggaran'));
    }

    // Menampilkan form untuk mengedit pelanggaran
    public function edit($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $siswas = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $jenisPelanggarans = JenisPelanggaran::with('kategoriPelanggaran')->orderBy('nama_pelanggaran')->get();

        return view('kesiswaan.pelanggaran.edit', compact('pelanggaran', 'siswas', 'jenisPelanggarans'));
    }

    // Memperbarui data pelanggaran di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'foto_bukti' => 'nullable|image|max:2048'
        ]);

        $pelanggaran = Pelanggaran::findOrFail($id);
        $jenis = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);

        $data = [
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'poin' => $jenis->poin,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
        ];

        if ($request->hasFile('foto_bukti')) {
            if ($pelanggaran->foto_bukti) {
                Storage::disk('public')->delete($pelanggaran->foto_bukti);
            }
            $data['foto_bukti'] = $request->file('foto_bukti')->store('pelanggaran', 'public');
        }

        $pelanggaran->update($data);

        return redirect()->route('kesiswaan.pelanggaran.index')->with('success', 'Pelanggaran berhasil diupdate');
    }

    // Menghapus data pelanggaran
    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        if ($pelanggaran->foto_bukti) {
            Storage::disk('public')->delete($pelanggaran->foto_bukti);
        }
        $pelanggaran->delete();

        return redirect()->route('kesiswaan.pelanggaran.index')->with('success', 'Pelanggaran berhasil dihapus');
    }

    // Export data pelanggaran ke Excel
    public function export()
    {
        $pelanggarans = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'tahunAjaran'])->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Pelanggaran</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Poin</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status Verifikasi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Keterangan</center></style>'
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
                '<style border="thin" border-color="#000000">' . ($item->keterangan ?? '-') . '</style>'
            ];
        }
        
        $filename = 'pelanggaran_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }

    // Export detail pelanggaran ke PDF
    public function exportPdf($id)
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'userPencatat', 'tahunAjaran'])->findOrFail($id);
        
        $pdf = Pdf::loadView('kesiswaan.pelanggaran.pdf', compact('pelanggaran'));
        
        $filename = 'pelanggaran_' . $pelanggaran->siswa->nama_siswa . '_' . date('Y-m-d', strtotime($pelanggaran->tanggal)) . '.pdf';
        
        return $pdf->download($filename);
    }
}
