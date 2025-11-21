<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Shuchkin\SimpleXLSXGen;

class KategoriPelanggaranController extends Controller
{
    // Menampilkan halaman daftar semua kategori pelanggaran
    public function index()
    {
        // Mengambil data kategori diurutkan dari yang paling baru (latest)
        $kategori = KategoriPelanggaran::latest()->get();
        return view('admin.kategori_pelanggaran.index', compact('kategori'));
    }

    // Menampilkan form untuk menambah kategori pelanggaran baru
    public function create()
    {
        // Mengambil daftar 'kategori_induk' yang unik dari database untuk opsi dropdown/saran
        $kategoriInduk = KategoriPelanggaran::distinct()->pluck('kategori_induk')->filter();
        return view('admin.kategori_pelanggaran.create', compact('kategoriInduk'));
    }

    // Memproses penyimpanan kategori baru ke database
    public function store(Request $request)
    {
        // Validasi input: Nama Kategori harus unik (tidak boleh kembar)
        $request->validate([
            'nama_kategori'  => 'required|string|max:255|unique:kategori_pelanggaran',
            'kategori_induk' => 'nullable|string|max:255', // Boleh kosong
        ]);

        // Simpan data ke database
        KategoriPelanggaran::create($request->all());

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.kategori_pelanggaran.index')
                         ->with('success', 'Kategori pelanggaran berhasil ditambahkan.');
    }

    // Menampilkan detail lengkap satu kategori pelanggaran
    public function show(KategoriPelanggaran $kategori_pelanggaran)
    {
        return view('admin.kategori_pelanggaran.show', ['kategori' => $kategori_pelanggaran]);
    }

    // Menampilkan form untuk mengedit data kategori
    public function edit(KategoriPelanggaran $kategori_pelanggaran)
    {
        // Mengambil daftar kategori induk untuk opsi edit
        $kategoriInduk = KategoriPelanggaran::distinct()->pluck('kategori_induk')->filter();
        return view('admin.kategori_pelanggaran.edit', ['kategori' => $kategori_pelanggaran, 'kategoriInduk' => $kategoriInduk]);
    }

    // Memproses update data kategori yang diedit
    public function update(Request $request, KategoriPelanggaran $kategori_pelanggaran)
    {
        // Validasi input update
        $request->validate([
            // Gunakan 'ignore' agar validasi unik tidak memblokir data dirinya sendiri saat disimpan
            'nama_kategori'  => ['required', 'string', 'max:255', Rule::unique('kategori_pelanggaran')->ignore($kategori_pelanggaran->id)],
            'kategori_induk' => 'nullable|string|max:255',
        ]);

        // Lakukan update data
        $kategori_pelanggaran->update($request->all());

        return redirect()->route('admin.kategori_pelanggaran.index')
                         ->with('success', 'Kategori pelanggaran berhasil diperbarui.');
    }

    // Menghapus data kategori pelanggaran
    public function destroy(KategoriPelanggaran $kategori_pelanggaran)
    {
        $kategori_pelanggaran->delete();
        
        return redirect()->route('admin.kategori_pelanggaran.index')
                         ->with('success', 'Kategori pelanggaran berhasil dihapus.');
    }

    // Fitur Export data kategori ke Excel (.xlsx)
    public function export()
    {
        // Mengambil semua data kategori
        $kategori = KategoriPelanggaran::all();
        
        // Menyiapkan Header Excel dengan styling HTML (Background Biru, Teks Putih)
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Kategori</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kategori Induk</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Deskripsi</center></style>'
        ]];
        
        // Melakukan looping data untuk mengisi baris Excel
        foreach ($kategori as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->nama_kategori . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->kategori_induk ?? '-') . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->deskripsi ?? '-') . '</style>'
            ];
        }
        
        // Membuat nama file unik dengan tanggal dan jam
        $filename = 'kategori_pelanggaran_' . date('Y-m-d_His') . '.xlsx';
        
        // Generate dan download file Excel
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}