<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Shuchkin\SimpleXLSXGen;

class KelasController extends Controller
{
    /**
     * Menampilkan daftar semua kelas (untuk DataTables).
     */
    public function index()
    {
        $kelas = Kelas::with(['jurusan', 'siswa'])->latest()->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Menampilkan form untuk menambah kelas baru.
     */
    public function create()
    {
        $jurusan = \App\Models\Jurusan::all();
        return view('admin.kelas.create', compact('jurusan'));
    }

    /**
     * Menyimpan kelas baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'kapasitas'  => 'nullable|integer|min:0',
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Kelas baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman detail kelas.
     */
    public function show(Kelas $kela) // Laravel otomatis resolve 'kela'
    {
        // Load data siswa yang ada di kelas ini
        $kela->load('siswa');
        return view('admin.kelas.show', ['kelas' => $kela]);
    }

    /**
     * Menampilkan form untuk mengedit kelas.
     */
    public function edit(Kelas $kela)
    {
        $jurusan = \App\Models\Jurusan::all();
        return view('admin.kelas.edit', ['kelas' => $kela, 'jurusan' => $jurusan]);
    }

    /**
     * Memperbarui data kelas di database.
     */
    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => ['required', 'string', 'max:255', Rule::unique('kelas')->ignore($kela->id)],
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'kapasitas'  => 'nullable|integer|min:0',
        ]);

        $kela->update($request->all());

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Menghapus kelas dari database.
     */
    public function destroy(Kelas $kela)
    {
        if ($kela->siswa()->count() > 0) {
            return redirect()->route('admin.kelas.index')
                             ->with('error', 'Tidak dapat menghapus kelas! Masih ada siswa yang terdaftar di kelas ini.');
        }

        $kela->delete();

        return redirect()->route('admin.kelas.index')
                         ->with('success', 'Data kelas berhasil dihapus.');
    }

    public function export()
    {
        $kelas = Kelas::with(['jurusan'])->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Nama Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jurusan</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kapasitas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jumlah Siswa</center></style>'
        ]];
        
        foreach ($kelas as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->nama_kelas . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->jurusan?->nama_jurusan ?? '-') . '</style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->kapasitas ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->siswa()->count() . '</center></style>'
            ];
        }
        
        $filename = 'kelas_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}