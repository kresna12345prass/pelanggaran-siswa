<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\{Prestasi, Siswa, JenisPrestasi, TahunAjaran};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Shuchkin\SimpleXLSXGen;

class PrestasiController extends Controller
{
    // Menampilkan halaman daftar prestasi
    public function index()
    {
        $prestasis = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'tahunAjaran'])->latest()->get();
        return view('kesiswaan.prestasi.index', compact('prestasis'));
    }

    // Menampilkan form untuk mencatat prestasi baru
    public function create()
    {
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $jenisPrestasi = JenisPrestasi::orderBy('nama_prestasi')->get();
        $tahunAjaran = TahunAjaran::where('status_aktif', true)->get();
        return view('kesiswaan.prestasi.create', compact('siswa', 'jenisPrestasi', 'tahunAjaran'));
    }

    // Menyimpan data prestasi baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_prestasi_id' => 'required|exists:jenis_prestasi,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal' => 'required|date',
            'tingkat' => 'required|string',
            'penghargaan' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'bukti_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        $jenisPrestasi = JenisPrestasi::find($request->jenis_prestasi_id);
        $data['poin'] = $jenisPrestasi->poin;
        $data['user_pencatat'] = auth()->id();
        $data['status_verifikasi'] = 'diverifikasi';
        $data['user_verifikator'] = auth()->id();

        if ($request->hasFile('bukti_dokumen')) {
            $data['bukti_dokumen'] = $request->file('bukti_dokumen')->store('prestasi', 'public');
        }

        Prestasi::create($data);

        return redirect()->route('kesiswaan.prestasi.index')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    // Menampilkan detail prestasi
    public function show(Prestasi $prestasi)
    {
        $prestasi->load(['siswa.kelas', 'jenisPrestasi', 'tahunAjaran', 'pencatat']);
        return view('kesiswaan.prestasi.show', compact('prestasi'));
    }

    // Menampilkan form untuk mengedit prestasi
    public function edit(Prestasi $prestasi)
    {
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $jenisPrestasi = JenisPrestasi::orderBy('nama_prestasi')->get();
        $tahunAjaran = TahunAjaran::where('status_aktif', true)->get();
        return view('kesiswaan.prestasi.edit', compact('prestasi', 'siswa', 'jenisPrestasi', 'tahunAjaran'));
    }

    // Memperbarui data prestasi di database
    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_prestasi_id' => 'required|exists:jenis_prestasi,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal' => 'required|date',
            'tingkat' => 'required|string',
            'penghargaan' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'bukti_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        $jenisPrestasi = JenisPrestasi::find($request->jenis_prestasi_id);
        $data['poin'] = $jenisPrestasi->poin;

        if ($request->hasFile('bukti_dokumen')) {
            if ($prestasi->bukti_dokumen) {
                Storage::disk('public')->delete($prestasi->bukti_dokumen);
            }
            $data['bukti_dokumen'] = $request->file('bukti_dokumen')->store('prestasi', 'public');
        }

        $prestasi->update($data);

        return redirect()->route('kesiswaan.prestasi.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    // Menghapus data prestasi
    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->bukti_dokumen) {
            Storage::disk('public')->delete($prestasi->bukti_dokumen);
        }
        $prestasi->delete();
        
        return redirect()->route('kesiswaan.prestasi.index')->with('success', 'Prestasi berhasil dihapus.');
    }

    // Export data prestasi ke Excel
    public function export()
    {
        $prestasis = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'tahunAjaran'])->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Prestasi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Poin</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tingkat</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Penghargaan</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Keterangan</center></style>'
        ]];
        
        foreach ($prestasis as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->siswa?->nama_siswa ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->siswa?->kelas?->nama_kelas ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->jenisPrestasi?->nama_prestasi ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->poin . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->tingkat . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->tanggal . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->penghargaan ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->keterangan ?? '-') . '</style>'
            ];
        }
        
        $filename = 'prestasi_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
