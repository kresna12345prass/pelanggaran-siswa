<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{DataSanksi, Pelanggaran, Siswa, MasterSanksiBertahap};
use Barryvdh\DomPDF\Facade\Pdf;
use Shuchkin\SimpleXLSXGen;

class SanksiController extends Controller
{
    // Menampilkan halaman daftar sanksi
    public function index()
    {
        $sanksis = DataSanksi::with(['pelanggaran.siswa.kelas'])->latest()->get();
        $masterSanksi = MasterSanksiBertahap::orderBy('poin_minimal')->get();

        return view('kesiswaan.sanksi.index', compact('sanksis', 'masterSanksi'));
    }

    // Menampilkan form untuk menetapkan sanksi baru
    public function create()
    {
        $siswas = Siswa::with(['kelas', 'pelanggaran' => function($q) {
                $q->where('status_verifikasi', 'diverifikasi');
            }])
            ->withSum(['pelanggaran as total_poin' => function($q) {
                $q->where('status_verifikasi', 'diverifikasi');
            }], 'poin')
            ->having('total_poin', '>', 0)
            ->orderBy('total_poin', 'desc')
            ->get();

        $masterSanksi = MasterSanksiBertahap::orderBy('poin_minimal')->get();

        return view('kesiswaan.sanksi.create', compact('siswas', 'masterSanksi'));
    }

    // Menyimpan data sanksi baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi' => 'required|string',
            'deskripsi_hukuman' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
        ]);

        // Mengecek apakah siswa perlu konseling
        $pelanggaran = Pelanggaran::with('siswa')->findOrFail($request->pelanggaran_id);
        $perluKonseling = $this->cekPerluKonseling($request->jenis_sanksi, $pelanggaran->siswa_id);

        DataSanksi::create([
            'pelanggaran_id' => $request->pelanggaran_id,
            'user_penetap' => auth()->id(),
            'jenis_sanksi' => $request->jenis_sanksi,
            'deskripsi_hukuman' => $request->deskripsi_hukuman,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_sanksi' => 'berjalan',
            'perlu_konseling' => $perluKonseling
        ]);

        return redirect()->route('kesiswaan.sanksi.index')->with('success', 'Sanksi berhasil ditetapkan');
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
        $sanksi = DataSanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran', 'pelaksanaan'])->findOrFail($id);
        return view('kesiswaan.sanksi.show', compact('sanksi'));
    }

    // Menampilkan form untuk mengedit sanksi
    public function edit($id)
    {
        $sanksi = DataSanksi::with(['pelanggaran.siswa'])->findOrFail($id);
        return view('kesiswaan.sanksi.edit', compact('sanksi'));
    }

    // Memperbarui data sanksi di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_sanksi' => 'required|string',
            'deskripsi_hukuman' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_sanksi' => 'required|in:pending,berjalan,selesai,terlambat'
        ]);

        $sanksi = DataSanksi::findOrFail($id);
        $sanksi->update($request->all());

        return redirect()->route('kesiswaan.sanksi.index')->with('success', 'Sanksi berhasil diupdate');
    }

    // Menghapus data sanksi
    public function destroy($id)
    {
        DataSanksi::findOrFail($id)->delete();
        return redirect()->route('kesiswaan.sanksi.index')->with('success', 'Sanksi berhasil dihapus');
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
