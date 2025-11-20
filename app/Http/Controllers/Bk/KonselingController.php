<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;
use App\Models\DataSanksi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Shuchkin\SimpleXLSXGen;

class KonselingController extends Controller
{
    // Menampilkan halaman daftar konseling
    public function index()
    {
        $konseling = BimbinganKonseling::with(['siswa', 'tahunAjaran', 'dataSanksi'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        // Mengambil rekomendasi sanksi yang memerlukan konseling
        $rekomendasi = DataSanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran'])
            ->where('perlu_konseling', true)
            ->where('status_konseling', 'belum')
            ->latest()
            ->get();

        return view('bk.konseling.index', compact('konseling', 'rekomendasi'));
    }

    // Menampilkan form untuk menambah data konseling baru
    public function create(Request $request)
    {
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $tahunAjaran = TahunAjaran::where('status_aktif', 1)->first();
        
        // Mengambil data sanksi jika berasal dari rekomendasi
        $sanksi = null;
        if ($request->has('sanksi_id')) {
            $sanksi = DataSanksi::with(['pelanggaran.siswa'])->findOrFail($request->sanksi_id);
        }

        return view('bk.konseling.create', compact('siswa', 'tahunAjaran', 'sanksi'));
    }

    // Menyimpan data konseling baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'data_sanksi_id' => 'nullable|exists:data_sanksi,id',
            'sumber_rujukan' => 'required|in:mandiri,sanksi,guru,ortu,wali_kelas',
            'jenis_layanan' => 'nullable|string',
            'topik' => 'required|string',
            'keluhan_masalah' => 'required|string',
            'tindakan_solusi' => 'required|string',
            'status' => 'required|in:aktif,selesai,tindak_lanjut',
            'tanggal_konseling' => 'required|date',
            'hasil_evaluasi' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        BimbinganKonseling::create($validated);

        // Update status konseling pada data sanksi jika ada
        if ($request->data_sanksi_id) {
            DataSanksi::where('id', $request->data_sanksi_id)->update([
                'status_konseling' => 'proses',
                'bk_user_id' => auth()->id()
            ]);
        }

        return redirect()->route('bk.konseling.index')->with('success', 'Data konseling berhasil ditambahkan');
    }

    // Menampilkan detail data konseling
    public function show($id)
    {
        $konseling = BimbinganKonseling::with(['siswa', 'tahunAjaran', 'guruBk'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('bk.konseling.show', compact('konseling'));
    }

    // Menampilkan form untuk mengedit data konseling
    public function edit($id)
    {
        $konseling = BimbinganKonseling::where('user_id', auth()->id())->findOrFail($id);
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $tahunAjaran = TahunAjaran::all();

        return view('bk.konseling.edit', compact('konseling', 'siswa', 'tahunAjaran'));
    }

    // Memperbarui data konseling di database
    public function update(Request $request, $id)
    {
        $konseling = BimbinganKonseling::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'jenis_layanan' => 'nullable|string',
            'topik' => 'required|string',
            'keluhan_masalah' => 'required|string',
            'tindakan_solusi' => 'required|string',
            'status' => 'required|in:aktif,selesai,tindak_lanjut',
            'tanggal_konseling' => 'required|date',
            'hasil_evaluasi' => 'nullable|string',
        ]);

        $konseling->update($validated);

        return redirect()->route('bk.konseling.index')->with('success', 'Data konseling berhasil diperbarui');
    }

    // Menghapus data konseling
    public function destroy($id)
    {
        $konseling = BimbinganKonseling::where('user_id', auth()->id())->findOrFail($id);
        $konseling->delete();

        return redirect()->route('bk.konseling.index')->with('success', 'Data konseling berhasil dihapus');
    }

    // Export data konseling ke Excel
    public function export()
    {
        $konseling = BimbinganKonseling::with(['siswa', 'tahunAjaran'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Topik</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jenis Layanan</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Keluhan/Masalah</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tindakan/Solusi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Hasil Evaluasi</center></style>'
        ]];
        
        foreach ($konseling as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->tanggal_konseling . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->siswa?->nama_siswa ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . $item->topik . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->jenis_layanan ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . $item->keluhan_masalah . '</style>',
                '<style border="thin" border-color="#000000">' . $item->tindakan_solusi . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ucfirst($item->status) . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->hasil_evaluasi ?? '-') . '</style>'
            ];
        }
        
        $filename = 'konseling_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
