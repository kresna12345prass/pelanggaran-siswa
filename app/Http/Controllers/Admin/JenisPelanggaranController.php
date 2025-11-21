<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Shuchkin\SimpleXLSXGen;

class JenisPelanggaranController extends Controller
{
    /**
     * Menampilkan daftar semua aturan pelanggaran.
     */
    public function index()
    {
        $aturan = JenisPelanggaran::with('kategori')->latest()->get();
        return view('admin.aturan_pelanggaran.index', compact('aturan'));
    }

    /**
     * Menampilkan form untuk menambah aturan baru.
     */
    public function create()
    {
        $kategori = \App\Models\KategoriPelanggaran::all();
        $sanksi = \App\Models\MasterSanksiBertahap::orderBy('poin_minimal')->get();
        return view('admin.aturan_pelanggaran.create', compact('kategori', 'sanksi'));
    }

    /**
     * Menyimpan aturan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|string|max:255|unique:jenis_pelanggaran',
            'poin' => 'required|integer',
            'kategori_pelanggaran_id' => 'nullable|exists:kategori_pelanggaran,id',
            'sanksi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        JenisPelanggaran::create($request->all());

        return redirect()->route('admin.aturan_pelanggaran.index')
                         ->with('success', 'Aturan pelanggaran baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman detail spesifik.
     */
    public function show(JenisPelanggaran $aturan_pelanggaran)
    {
        // $aturan_pelanggaran adalah nama variabel yang dikirim ke view
        return view('admin.aturan_pelanggaran.show', ['aturan' => $aturan_pelanggaran]);
    }

    /**
     * Menampilkan form untuk mengedit.
     */
    public function edit(JenisPelanggaran $aturan_pelanggaran)
    {
        $kategori = \App\Models\KategoriPelanggaran::all();
        $sanksi = \App\Models\MasterSanksiBertahap::orderBy('poin_minimal')->get();
        return view('admin.aturan_pelanggaran.edit', ['aturan' => $aturan_pelanggaran, 'kategori' => $kategori, 'sanksi' => $sanksi]);
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, JenisPelanggaran $aturan_pelanggaran)
    {
        $request->validate([
            'nama_pelanggaran' => ['required', 'string', 'max:255', Rule::unique('jenis_pelanggaran')->ignore($aturan_pelanggaran->id)],
            'poin' => 'required|integer',
            'kategori_pelanggaran_id' => 'nullable|exists:kategori_pelanggaran,id',
            'sanksi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $aturan_pelanggaran->update($request->all());

        return redirect()->route('admin.aturan_pelanggaran.index')
                         ->with('success', 'Aturan pelanggaran berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(JenisPelanggaran $aturan_pelanggaran)
    {
        //tambahkan proteksi jika aturan ini sudah dipakai di tabel 'pelanggaran'
        
        $aturan_pelanggaran->delete();
        
        return redirect()->route('admin.aturan_pelanggaran.index')
                         ->with('success', 'Aturan pelanggaran berhasil dihapus.');
    }

    public function export()
    {
        $aturan = JenisPelanggaran::with('kategori')->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Pelanggaran</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Poin</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kategori</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kategori Induk</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Sanksi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Keterangan</center></style>'
        ]];
        
        foreach ($aturan as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->nama_pelanggaran . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->poin . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->kategori?->nama_kategori ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->kategori?->kategori_induk ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->sanksi ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->keterangan ?? '-') . '</style>'
            ];
        }
        
        $filename = 'aturan_pelanggaran_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}