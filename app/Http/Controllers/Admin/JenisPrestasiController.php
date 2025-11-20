<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPrestasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Shuchkin\SimpleXLSXGen;

class JenisPrestasiController extends Controller
{
    // Menampilkan halaman daftar semua jenis prestasi
    public function index()
    {
        // Mengambil data dari database diurutkan dari yang terbaru (latest)
        $jenisPrestasi = JenisPrestasi::latest()->get();
        return view('admin.jenis_prestasi.index', compact('jenisPrestasi'));
    }

    // Menampilkan form untuk menambah data jenis prestasi baru
    public function create()
    {
        return view('admin.jenis_prestasi.create');
    }

    // Memproses penyimpanan data baru ke database
    public function store(Request $request)
    {
        // Validasi input agar sesuai aturan
        $request->validate([
            'nama_prestasi' => 'required|string|max:255|unique:jenis_prestasi', // Nama tidak boleh kembar
            'poin'          => 'required|integer|min:0', // Poin tidak boleh minus
            'kategori'      => 'required|string|max:100',
            'penghargaan'   => 'nullable|string|max:255', // Boleh kosong
            'keterangan'    => 'nullable|string',
        ]);

        // Simpan semua data yang lolos validasi ke database
        JenisPrestasi::create($request->all());

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.jenis_prestasi.index')
                         ->with('success', 'Jenis Prestasi berhasil ditambahkan.');
    }

    // Menampilkan detail lengkap satu data jenis prestasi
    public function show(JenisPrestasi $jenisPrestasi)
    {
        return view('admin.jenis_prestasi.show', compact('jenisPrestasi'));
    }

    // Menampilkan form untuk mengedit data yang sudah ada
    public function edit(JenisPrestasi $jenisPrestasi)
    {
        return view('admin.jenis_prestasi.edit', compact('jenisPrestasi'));
    }

    // Memproses update/perubahan data ke database
    public function update(Request $request, JenisPrestasi $jenisPrestasi)
    {
        // Validasi input update
        $request->validate([
            // Cek unik nama prestasi, TAPI abaikan (ignore) untuk data yang sedang diedit ini
            'nama_prestasi' => ['required', 'string', 'max:255', Rule::unique('jenis_prestasi')->ignore($jenisPrestasi->id)],
            'poin'          => 'required|integer|min:0',
            'kategori'      => 'required|string|max:100',
            'penghargaan'   => 'nullable|string|max:255',
            'keterangan'    => 'nullable|string',
        ]);

        // Lakukan update data
        $jenisPrestasi->update($request->all());

        return redirect()->route('admin.jenis_prestasi.index')
                         ->with('success', 'Jenis Prestasi berhasil diperbarui.');
    }

    // Menghapus data dari database
    public function destroy(JenisPrestasi $jenisPrestasi)
    {
        $jenisPrestasi->delete();
        
        return redirect()->route('admin.jenis_prestasi.index')
                         ->with('success', 'Jenis Prestasi berhasil dihapus.');
    }

    // Fitur Export data ke Excel (.xlsx)
    public function export()
    {
        // Ambil semua data jenis prestasi
        $jenisPrestasi = JenisPrestasi::all();
        
        // Siapkan array data untuk Excel, dimulai dengan Baris Header (Judul Kolom)
        // Menggunakan style HTML untuk memberi warna background biru dan teks putih
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Prestasi</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Poin</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kategori</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Penghargaan</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Keterangan</center></style>'
        ]];
        
        // Looping data dari database untuk dimasukkan ke baris-baris Excel berikutnya
        foreach ($jenisPrestasi as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->nama_prestasi . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->poin . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->kategori . '</style>',
                '<style border="thin" border-color="#000000">' . ($item->penghargaan ?? '-') . '</style>', // Jika kosong isi '-'
                '<style border="thin" border-color="#000000">' . ($item->keterangan ?? '-') . '</style>'
            ];
        }
        
        // Buat nama file unik dengan timestamp
        $filename = 'jenis_prestasi_' . date('Y-m-d_His') . '.xlsx';
        
        // Generate file dan download
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}