<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\TahunAjaran;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // Menampilkan halaman daftar laporan pelanggaran wali kelas
    public function index()
    {
        $guru = Guru::where('user_id', Auth::id())->first();
        $kelas = $guru ? $guru->kelasAsWali()->first() : null;
        
        $laporan = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'tahunAjaran'])
            ->where('user_pencatat', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('wali_kelas.laporan.index', compact('laporan'));
    }

    // Menampilkan form untuk membuat laporan pelanggaran baru
    public function create()
    {
        $siswa = Siswa::orderBy('nama_siswa')->get();
        $jenisPelanggaran = JenisPelanggaran::with('kategori')->get();
        $tahunAjaran = TahunAjaran::where('status_aktif', 1)->first();
        
        return view('wali_kelas.laporan.create', compact('siswa', 'jenisPelanggaran', 'tahunAjaran'));
    }

    // Menyimpan laporan pelanggaran baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'foto_bukti' => 'nullable|image|max:2048'
        ]);

        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);
        $tahunAjaran = TahunAjaran::where('status_aktif', 1)->first();

        $data = $request->all();
        $data['poin'] = $jenisPelanggaran->poin;
        $data['tahun_ajaran_id'] = $tahunAjaran->id;
        $data['user_pencatat'] = Auth::id();
        $data['status_verifikasi'] = 'menunggu';

        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('pelanggaran', 'public');
        }

        Pelanggaran::create($data);

        return redirect()->route('wali_kelas.laporan.index')->with('success', 'Laporan berhasil dibuat');
    }

    // Menampilkan detail laporan pelanggaran
    public function show($id)
    {
        $laporan = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'tahunAjaran'])->findOrFail($id);
        return view('wali_kelas.laporan.show', compact('laporan'));
    }

    // Menampilkan form untuk mengedit laporan pelanggaran
    public function edit($id)
    {
        $laporan = Pelanggaran::findOrFail($id);
        
        if ($laporan->status_verifikasi != 'menunggu') {
            return redirect()->back()->with('error', 'Laporan yang sudah diverifikasi tidak dapat diedit');
        }

        $siswa = Siswa::orderBy('nama_siswa')->get();
        $jenisPelanggaran = JenisPelanggaran::with('kategori')->get();
        $tahunAjaran = TahunAjaran::where('status_aktif', 1)->first();
        
        return view('wali_kelas.laporan.edit', compact('laporan', 'siswa', 'jenisPelanggaran', 'tahunAjaran'));
    }

    // Memperbarui data laporan pelanggaran
    public function update(Request $request, $id)
    {
        $laporan = Pelanggaran::findOrFail($id);
        
        if ($laporan->status_verifikasi != 'menunggu') {
            return redirect()->back()->with('error', 'Laporan yang sudah diverifikasi tidak dapat diedit');
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'foto_bukti' => 'nullable|image|max:2048'
        ]);

        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);

        $data = $request->all();
        $data['poin'] = $jenisPelanggaran->poin;

        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('pelanggaran', 'public');
        }

        $laporan->update($data);

        return redirect()->route('wali_kelas.laporan.index')->with('success', 'Laporan berhasil diupdate');
    }

    // Menghapus laporan pelanggaran
    public function destroy($id)
    {
        $laporan = Pelanggaran::findOrFail($id);
        
        if ($laporan->status_verifikasi != 'menunggu') {
            return redirect()->back()->with('error', 'Laporan yang sudah diverifikasi tidak dapat dihapus');
        }

        $laporan->delete();

        return redirect()->route('wali_kelas.laporan.index')->with('success', 'Laporan berhasil dihapus');
    }
}
