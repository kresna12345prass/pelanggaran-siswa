<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Shuchkin\SimpleXLSXGen;

class JurusanController extends Controller
{
    // Menampilkan halaman daftar semua jurusan
    public function index()
    {
        // Mengambil data jurusan diurutkan dari yang paling baru ditambahkan
        $jurusan = Jurusan::latest()->get();
        return view('admin.jurusan.index', compact('jurusan'));
    }

    // Menampilkan form untuk menambahkan jurusan baru
    public function create()
    {
        return view('admin.jurusan.create');
    }

    // Memproses penyimpanan data jurusan baru ke database
    public function store(Request $request)
    {
        // Validasi input: Nama dan Kode Jurusan WAJIB unik (tidak boleh ada yang sama)
        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:jurusan',
            'kode_jurusan' => 'required|string|max:10|unique:jurusan',
        ]);

        // Menyimpan data ke database
        Jurusan::create($request->all());

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.jurusan.index')
                         ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    // Menampilkan detail data satu jurusan
    public function show(Jurusan $jurusan)
    {
        return view('admin.jurusan.show', compact('jurusan'));
    }

    // Menampilkan form untuk mengedit jurusan
    public function edit(Jurusan $jurusan)
    {
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    // Memproses update data jurusan yang diedit
    public function update(Request $request, Jurusan $jurusan)
    {
        // Validasi input saat update
        $request->validate([
            // Rule unique ditambahkan 'ignore' agar tidak menganggap data sendiri sebagai duplikat
            'nama_jurusan' => ['required', 'string', 'max:255', Rule::unique('jurusan')->ignore($jurusan->id)],
            'kode_jurusan' => ['required', 'string', 'max:10', Rule::unique('jurusan')->ignore($jurusan->id)],
        ]);

        // Update data di database
        $jurusan->update($request->all());

        return redirect()->route('admin.jurusan.index')
                         ->with('success', 'Jurusan berhasil diperbarui.');
    }

    // Menghapus data jurusan
    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        
        return redirect()->route('admin.jurusan.index')
                         ->with('success', 'Jurusan berhasil dihapus.');
    }

    // Fitur Export data jurusan ke Excel (.xlsx)
    public function export()
    {
        // Mengambil semua data jurusan
        $jurusan = Jurusan::all();
        
        // Membuat Header Tabel Excel dengan style (Background Biru, Teks Putih, Bold)
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kode Jurusan</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Jurusan</center></style>'
        ]];
        
        // Melakukan looping data untuk mengisi baris Excel
        foreach ($jurusan as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->kode_jurusan . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->nama_jurusan . '</style>'
            ];
        }
        
        // Membuat nama file download dengan timestamp (waktu saat ini)
        $filename = 'jurusan_' . date('Y-m-d_His') . '.xlsx';
        
        // Generate file Excel dan download otomatis
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}