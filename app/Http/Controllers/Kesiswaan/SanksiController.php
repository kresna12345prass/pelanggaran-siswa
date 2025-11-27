<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{DataSanksi, Pelanggaran, Siswa, MasterSanksiBertahap, MasterKategoriSanksi};
use Barryvdh\DomPDF\Facade\Pdf;
use Shuchkin\SimpleXLSXGen;

class SanksiController extends Controller
{
    // Menampilkan halaman daftar sanksi
    public function index()
    {
        $sanksi = DataSanksi::with(['siswa.kelas', 'kategoriSanksi', 'userPenetap'])
            ->latest()
            ->paginate(20);

        return view('kesiswaan.sanksi.index', compact('sanksi'));
    }

    // Menampilkan form untuk menetapkan sanksi baru
    public function create()
    {
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $kategoriSanksi = MasterKategoriSanksi::orderBy('poin_min')->get();

        return view('kesiswaan.sanksi.create', compact('siswa', 'kategoriSanksi'));
    }

    // Menyimpan data sanksi baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kategori_sanksi_id' => 'required|exists:master_kategori_sanksi,id',
            'jenis_sanksi' => 'required|string',
            'deskripsi_hukuman' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
        ]);

        $validated['user_penetap'] = auth()->id();
        $validated['status_sanksi'] = 'pending';

        DataSanksi::create($validated);

        return redirect()->route('kesiswaan.sanksi.index')
            ->with('success', 'Sanksi berhasil ditambahkan');
    }

    // Mengecek apakah sanksi memerlukan konseling
    private function cekPerluKonseling($jenisSanksi, $siswaId)
    {
        // Sanksi berat otomatis perlu konseling
        $saksiBerat = ['Skorsing', 'Panggilan Orang Tua', 'Surat Peringatan', 'Dikembalikan ke Orang Tua'];
        if (in_array($jenisSanksi, $saksiBerat)) {
            return true;
        }

        // Mengecek jumlah sanksi siswa dalam 6 bulan terakhir
        $jumlahSanksi = DataSanksi::whereHas('pelanggaran', function($q) use ($siswaId) {
            $q->where('siswa_id', $siswaId);
        })->where('created_at', '>=', now()->subMonths(6))->count();

        return $jumlahSanksi >= 2;
    }

    // Menampilkan detail sanksi
    public function show($id)
    {
        $sanksi = DataSanksi::with(['siswa.kelas', 'kategoriSanksi', 'pelanggaran.jenisPelanggaran', 'pelaksanaan'])
            ->findOrFail($id);
        return view('kesiswaan.sanksi.show', compact('sanksi'));
    }

    // Menampilkan form untuk mengedit sanksi
    public function edit($id)
    {
        $sanksi = DataSanksi::with(['siswa.kelas', 'kategoriSanksi'])->findOrFail($id);
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $kategoriSanksi = MasterKategoriSanksi::orderBy('poin_min')->get();
        
        return view('kesiswaan.sanksi.edit', compact('sanksi', 'siswa', 'kategoriSanksi'));
    }

    // Memperbarui data sanksi di database
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_sanksi_id' => 'required|exists:master_kategori_sanksi,id',
            'jenis_sanksi' => 'required|string',
            'deskripsi_hukuman' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_sanksi' => 'required|in:pending,berjalan,selesai,terlambat'
        ]);

        $sanksi = DataSanksi::findOrFail($id);
        $sanksi->update($validated);

        return redirect()->route('kesiswaan.sanksi.index')
            ->with('success', 'Sanksi berhasil diupdate');
    }

    // Menghapus data sanksi
    public function destroy($id)
    {
        DataSanksi::findOrFail($id)->delete();
        return redirect()->route('kesiswaan.sanksi.index')
            ->with('success', 'Sanksi berhasil dihapus');
    }

    // API untuk mendapatkan info siswa
    public function getSiswaInfo($siswaId)
    {
        $siswa = Siswa::with('kelas')->findOrFail($siswaId);
        
        $totalPoin = Pelanggaran::where('siswa_id', $siswaId)
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
        
        return response()->json([
            'nama' => $siswa->nama_siswa,
            'kelas' => $siswa->kelas->nama_kelas ?? '-',
            'total_poin' => $totalPoin,
        ]);
    }

    // Mencetak surat panggilan orang tua ke PDF
    public function cetakPanggilan($id)
    {
        $sanksi = DataSanksi::with(['pelanggaran.siswa.kelas.jurusan', 'pelanggaran.jenisPelanggaran'])->findOrFail($id);
        $siswa = $sanksi->pelanggaran->siswa;

        $pdf = Pdf::loadView('kesiswaan.sanksi.surat_panggilan', compact('sanksi', 'siswa'));
        return $pdf->download('Surat_Panggilan_' . $siswa->nama_siswa . '.pdf');
    }

    // Mencetak surat skorsing ke PDF
    public function cetakSkorsing($id)
    {
        $sanksi = DataSanksi::with(['pelanggaran.siswa.kelas.jurusan', 'pelanggaran.jenisPelanggaran'])->findOrFail($id);
        $siswa = $sanksi->pelanggaran->siswa;

        $pdf = Pdf::loadView('kesiswaan.sanksi.surat_skorsing', compact('sanksi', 'siswa'));
        return $pdf->download('Surat_Skorsing_' . $siswa->nama_siswa . '.pdf');
    }

    // Mencetak surat peringatan ke PDF
    public function cetakPeringatan($id)
    {
        $sanksi = DataSanksi::with(['pelanggaran.siswa.kelas.jurusan', 'pelanggaran.jenisPelanggaran'])->findOrFail($id);
        $siswa = $sanksi->pelanggaran->siswa;

        $pdf = Pdf::loadView('kesiswaan.sanksi.surat_peringatan', compact('sanksi', 'siswa'));
        return $pdf->download('Surat_Peringatan_' . $siswa->nama_siswa . '.pdf');
    }

    // Export data sanksi ke Excel
    public function export()
    {
        $sanksis = DataSanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran'])->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Sanksi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Deskripsi Hukuman</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal Mulai</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal Selesai</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status</center></style>'
        ]];
        
        foreach ($sanksis as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->pelanggaran?->siswa?->nama_siswa ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->pelanggaran?->siswa?->kelas?->nama_kelas ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->jenis_sanksi . '</style>',
                '<style border="thin" border-color="#000000">' . $item->deskripsi_hukuman . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->tanggal_mulai . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->tanggal_selesai ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ucfirst($item->status_sanksi) . '</center></style>'
            ];
        }
        
        $filename = 'sanksi_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
