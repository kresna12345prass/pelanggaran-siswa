<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran; // <-- Import
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // <-- Import
use Illuminate\Support\Facades\DB; // <-- Import
use Shuchkin\SimpleXLSXGen;

class TahunAjaranController extends Controller
{
    /**
     * Menampilkan daftar semua tahun ajaran.
     */
    public function index()
    {
        // 'withCount' untuk menghitung relasi (jika Anda menambahkannya di model)
        $tahun_ajaran = TahunAjaran::latest()->get();
        return view('admin.tahun_ajaran.index', compact('tahun_ajaran'));
    }

    /**
     * Menampilkan form untuk menambah tahun ajaran baru.
     */
    public function create()
    {
        return view('admin.tahun_ajaran.create');
    }

    /**
     * Menyimpan tahun ajaran baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'kode_ajaran'   => 'required|string|max:50|unique:tahun_ajaran',
            'tahun_ajaran'  => 'required|string|max:50',
            'semester'      => 'required|in:Ganjil,Genap',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_aktif'  => 'nullable|boolean',
        ]);

        $data = $request->except('status_aktif');
        $data['status_aktif'] = $request->boolean('status_aktif');

        // 2. LOGIKA KHUSUS: Jika ini di-set Aktif, nonaktifkan yang lain
        if ($data['status_aktif']) {
            DB::table('tahun_ajaran')->update(['status_aktif' => false]);
        }

        // 3. Buat Tahun Ajaran
        TahunAjaran::create($data);

        // 4. Redirect
        return redirect()->route('admin.tahun_ajaran.index')
                         ->with('success', 'Tahun Ajaran baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman detail.
     */
    public function show(TahunAjaran $tahun_ajaran)
    {
        // Eager load relasi (jika modelnya sudah di-setting)
        // $tahun_ajaran->loadCount('pelanggaran', 'prestasi');
        return view('admin.tahun_ajaran.show', compact('tahun_ajaran'));
    }

    /**
     * Menampilkan form untuk mengedit.
     */
    public function edit(TahunAjaran $tahun_ajaran)
    {
        return view('admin.tahun_ajaran.edit', compact('tahun_ajaran'));
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, TahunAjaran $tahun_ajaran)
    {
        // 1. Validasi
        $request->validate([
            'kode_ajaran'   => ['required', 'string', 'max:50', Rule::unique('tahun_ajaran')->ignore($tahun_ajaran->id)],
            'tahun_ajaran'  => 'required|string|max:50',
            'semester'      => 'required|in:Ganjil,Genap',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_aktif'  => 'nullable|boolean',
        ]);
        
        $data = $request->except('status_aktif');
        $data['status_aktif'] = $request->boolean('status_aktif');

        // 2. LOGIKA KHUSUS: Jika ini di-set Aktif, nonaktifkan yang lain
        if ($data['status_aktif']) {
            DB::table('tahun_ajaran')->where('id', '!=', $tahun_ajaran->id)->update(['status_aktif' => false]);
        }
        
        // 3. Update Tahun Ajaran
        $tahun_ajaran->update($data);

        // 4. Redirect
        return redirect()->route('admin.tahun_ajaran.index')
                         ->with('success', 'Data Tahun Ajaran berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(TahunAjaran $tahun_ajaran)
    {
        // 1. Proteksi: Cek apakah statusnya aktif
        if ($tahun_ajaran->status_aktif) {
            return redirect()->route('admin.tahun_ajaran.index')
                             ->with('error', 'Tidak dapat menghapus Tahun Ajaran yang sedang AKSIF!');
        }

        // 2. Proteksi (Opsional): Cek apakah ada data terkait
        // if ($tahun_ajaran->pelanggaran()->count() > 0 || $tahun_ajaran->prestasi()->count() > 0) {
        //     return redirect()->route('admin.tahun_ajaran.index')
        //                      ->with('error', 'Tidak dapat menghapus! Masih ada data pelanggaran/prestasi yang terkait dengan tahun ajaran ini.');
        // }

        // 3. Hapus data
        $tahun_ajaran->delete();

        // 4. Redirect
        return redirect()->route('admin.tahun_ajaran.index')
                         ->with('success', 'Data Tahun Ajaran berhasil dihapus.');
    }

    public function export()
    {
        $tahun_ajaran = TahunAjaran::all();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kode Ajaran</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tahun Ajaran</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Semester</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal Mulai</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tanggal Selesai</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Status</center></style>'
        ]];
        
        foreach ($tahun_ajaran as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->kode_ajaran . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->tahun_ajaran . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->semester . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->tanggal_mulai ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->tanggal_selesai ?? '-') . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . ($item->status_aktif ? 'Aktif' : 'Tidak Aktif') . '</center></style>'
            ];
        }
        
        $filename = 'tahun_ajaran_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}