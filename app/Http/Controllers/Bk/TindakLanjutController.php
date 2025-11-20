<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;
use Illuminate\Http\Request;
use Shuchkin\SimpleXLSXGen;

class TindakLanjutController extends Controller
{
    // Menampilkan halaman daftar tindak lanjut konseling
    public function index()
    {
        $tindakLanjut = BimbinganKonseling::with(['siswa', 'tahunAjaran'])
            ->where('user_id', auth()->id())
            ->where('status', 'tindak_lanjut')
            ->latest()
            ->get();

        return view('bk.tindak_lanjut.index', compact('tindakLanjut'));
    }

    // Menampilkan detail tindak lanjut konseling
    public function show($id)
    {
        $konseling = BimbinganKonseling::with(['siswa', 'tahunAjaran', 'guruBk'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('bk.tindak_lanjut.show', compact('konseling'));
    }

    // Menampilkan form untuk mengedit tindak lanjut
    public function edit($id)
    {
        $konseling = BimbinganKonseling::where('user_id', auth()->id())->findOrFail($id);

        return view('bk.tindak_lanjut.edit', compact('konseling'));
    }

    // Memperbarui data tindak lanjut di database
    public function update(Request $request, $id)
    {
        $konseling = BimbinganKonseling::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'tanggal_tindak_lanjut' => 'required|date',
            'hasil_evaluasi' => 'required|string',
            'status' => 'required|in:aktif,selesai,tindak_lanjut',
        ]);

        $konseling->update($validated);

        return redirect()->route('bk.tindak_lanjut.index')->with('success', 'Tindak lanjut berhasil diperbarui');
    }

    // Export data tindak lanjut ke Excel
    public function export()
    {
        $tindakLanjut = BimbinganKonseling::with(['siswa', 'tahunAjaran'])
            ->where('user_id', auth()->id())
            ->where('status', 'tindak_lanjut')
            ->latest()
            ->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal Konseling</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Siswa</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Topik</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal Tindak Lanjut</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Hasil Evaluasi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status</center></style>'
        ]];
        
        foreach ($tindakLanjut as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->tanggal_konseling . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->siswa?->nama_siswa ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . $item->topik . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->tanggal_tindak_lanjut ?? 'Belum dijadwalkan') . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->hasil_evaluasi ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ucfirst($item->status) . '</center></style>'
            ];
        }
        
        $filename = 'tindak_lanjut_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}
