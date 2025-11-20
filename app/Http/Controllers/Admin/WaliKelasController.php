<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Shuchkin\SimpleXLSXGen;

class WaliKelasController extends Controller
{
    // Menampilkan halaman daftar semua wali kelas
    public function index()
    {
        $waliKelas = WaliKelas::with(['tahunAjaran', 'guru', 'kelas.jurusan'])->latest()->get();
        return view('admin.wali_kelas.index', compact('waliKelas'));
    }

    // Menampilkan form untuk menambah wali kelas baru
    public function create()
    {
        $tahunAjaran = TahunAjaran::all();
        $guru = Guru::with('user')->whereIn('status', ['Aktif', 'aktif', null])->get();
        $kelas = Kelas::with('jurusan')->get();
        
        return view('admin.wali_kelas.create', compact('tahunAjaran', 'guru', 'kelas'));
    }

    // Memproses penyimpanan data wali kelas baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Validasi: Cek apakah kelas sudah memiliki wali kelas di tahun ajaran yang sama
        $existingKelas = WaliKelas::where('tahun_ajaran_id', $request->tahun_ajaran_id)
                                 ->where('kelas_id', $request->kelas_id)
                                 ->first();
        
        if ($existingKelas) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Kelas ini sudah memiliki wali kelas untuk tahun ajaran tersebut.');
        }

        // Validasi: Cek apakah guru sudah menjadi wali kelas di tahun ajaran yang sama
        $existingGuru = WaliKelas::where('tahun_ajaran_id', $request->tahun_ajaran_id)
                                ->where('guru_id', $request->guru_id)
                                ->first();
        
        if ($existingGuru) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Guru ini sudah menjadi wali kelas untuk tahun ajaran tersebut.');
        }

        WaliKelas::create($request->all());

        // Update level user menjadi wali_kelas
        $guru = Guru::find($request->guru_id);
        if ($guru && $guru->user) {
            $guru->user->update(['level' => 'wali_kelas']);
        }

        return redirect()->route('admin.wali_kelas.index')
                         ->with('success', 'Wali kelas berhasil ditambahkan.');
    }

    // Menampilkan detail data wali kelas
    public function show(WaliKelas $waliKela)
    {
        $waliKela->load(['tahunAjaran', 'guru', 'kelas.jurusan', 'kelas.siswa']);
        return view('admin.wali_kelas.show', ['waliKelas' => $waliKela]);
    }

    // Menampilkan form untuk mengedit data wali kelas
    public function edit(WaliKelas $waliKela)
    {
        $tahunAjaran = TahunAjaran::all();
        $guru = Guru::with('user')->whereIn('status', ['Aktif', 'aktif', null])->get();
        $kelas = Kelas::with('jurusan')->get();
        
        return view('admin.wali_kelas.edit', [
            'waliKelas' => $waliKela,
            'tahunAjaran' => $tahunAjaran,
            'guru' => $guru,
            'kelas' => $kelas
        ]);
    }

    // Memproses update data wali kelas
    public function update(Request $request, WaliKelas $waliKela)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Validasi: Cek apakah kelas sudah memiliki wali kelas di tahun ajaran yang sama (kecuali data ini sendiri)
        $existingKelas = WaliKelas::where('tahun_ajaran_id', $request->tahun_ajaran_id)
                                 ->where('kelas_id', $request->kelas_id)
                                 ->where('id', '!=', $waliKela->id)
                                 ->first();
        
        if ($existingKelas) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Kelas ini sudah memiliki wali kelas untuk tahun ajaran tersebut.');
        }

        // Validasi: Cek apakah guru sudah menjadi wali kelas di tahun ajaran yang sama (kecuali data ini sendiri)
        $existingGuru = WaliKelas::where('tahun_ajaran_id', $request->tahun_ajaran_id)
                                ->where('guru_id', $request->guru_id)
                                ->where('id', '!=', $waliKela->id)
                                ->first();
        
        if ($existingGuru) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Guru ini sudah menjadi wali kelas untuk tahun ajaran tersebut.');
        }

        $oldGuruId = $waliKela->guru_id;
        
        $waliKela->update($request->all());

        // Update level user lama kembali menjadi guru jika tidak lagi menjadi wali kelas
        if ($oldGuruId && $oldGuruId != $request->guru_id) {
            $oldGuru = Guru::find($oldGuruId);
            if ($oldGuru && $oldGuru->user && !WaliKelas::where('guru_id', $oldGuruId)->exists()) {
                $oldGuru->user->update(['level' => 'guru']);
            }
        }

        // Update level user baru menjadi wali_kelas
        $newGuru = Guru::find($request->guru_id);
        if ($newGuru && $newGuru->user) {
            $newGuru->user->update(['level' => 'wali_kelas']);
        }

        return redirect()->route('admin.wali_kelas.index')
                         ->with('success', 'Data wali kelas berhasil diperbarui.');
    }

    // Menghapus data wali kelas
    public function destroy(WaliKelas $waliKela)
    {
        $guruId = $waliKela->guru_id;
        
        $waliKela->delete();

        // Update level user kembali menjadi guru jika tidak lagi menjadi wali kelas
        if ($guruId) {
            $guru = Guru::find($guruId);
            if ($guru && $guru->user && !WaliKelas::where('guru_id', $guruId)->exists()) {
                $guru->user->update(['level' => 'guru']);
            }
        }

        return redirect()->route('admin.wali_kelas.index')
                         ->with('success', 'Data wali kelas berhasil dihapus.');
    }

    // Export data wali kelas ke Excel
    public function export()
    {
        $waliKelas = WaliKelas::with(['tahunAjaran', 'guru', 'kelas.jurusan'])->get();
        
        $data = [[
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>No</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Tahun Ajaran</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Wali Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Kelas</center></style>',
            '<style bgcolor="#4472C4" color="#FFFFFF" font-size="12" font-style="bold" border="thin" border-color="#000000"><center>Jurusan</center></style>'
        ]];
        
        foreach ($waliKelas as $index => $item) {
            $data[] = [
                '<style border="thin" border-color="#000000"><center>' . ($index + 1) . '</center></style>',
                '<style border="thin" border-color="#000000"><center>' . $item->tahunAjaran->tahun_ajaran . '</center></style>',
                '<style border="thin" border-color="#000000">' . $item->guru->nama_guru . '</style>',
                '<style border="thin" border-color="#000000"><center>' . $item->kelas->nama_kelas . '</center></style>',
                '<style border="thin" border-color="#000000">' . ($item->kelas->jurusan?->nama_jurusan ?? '-') . '</style>'
            ];
        }
        
        $filename = 'wali_kelas_' . date('Y-m-d_His') . '.xlsx';
        
        return SimpleXLSXGen::fromArray($data)
            ->setDefaultFont('Calibri')
            ->setDefaultFontSize(11)
            ->downloadAs($filename);
    }
}