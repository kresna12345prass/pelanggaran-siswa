<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    // Menampilkan halaman daftar laporan pelanggaran yang dibuat guru
    public function index()
    {
        $pelanggarans = Pelanggaran::where('user_pencatat', Auth::id())
            ->with(['siswa', 'jenisPelanggaran', 'tahunAjaran'])
            ->latest()
            ->get();
        
        return view('guru.laporan.index', compact('pelanggarans'));
    }

    // Menampilkan form untuk membuat laporan pelanggaran baru
    public function create()
    {
        $siswas = Siswa::orderBy('nama_siswa')->get();
        $jenisPelanggarans = JenisPelanggaran::with('kategori')->orderBy('nama_pelanggaran')->get();
        $tahunAjaranAktif = TahunAjaran::where('status_aktif', 1)->first();
        
        return view('guru.laporan.create', compact('siswas', 'jenisPelanggarans', 'tahunAjaranAktif'));
    }

    // Menyimpan laporan pelanggaran baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $tahunAjaranAktif = TahunAjaran::where('status_aktif', 1)->first();
        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);

        $data = [
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
            'user_pencatat' => Auth::id(),
            'poin' => $jenisPelanggaran->poin,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'status_verifikasi' => 'menunggu',
        ];

        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('pelanggaran_bukti', 'public');
        }

        Pelanggaran::create($data);

        return redirect()->route('guru.laporan.index')->with('success', 'Laporan pelanggaran berhasil ditambahkan.');
    }

    // Menampilkan detail laporan pelanggaran
    public function show(Pelanggaran $laporan)
    {
        // Validasi: Hanya guru yang membuat laporan yang bisa melihat
        if ($laporan->user_pencatat != Auth::id()) {
            abort(403);
        }
        
        $laporan->load(['siswa', 'jenisPelanggaran.kategori', 'tahunAjaran', 'pencatat']);
        return view('guru.laporan.show', compact('laporan'));
    }

    // Menampilkan form untuk mengedit laporan pelanggaran
    public function edit(Pelanggaran $laporan)
    {
        // Validasi: Hanya guru yang membuat laporan yang bisa mengedit
        if ($laporan->user_pencatat != Auth::id()) {
            abort(403);
        }
        
        // Validasi: Hanya laporan yang belum diverifikasi yang bisa diedit
        if ($laporan->status_verifikasi != 'menunggu') {
            return redirect()->route('guru.laporan.index')->with('error', 'Laporan yang sudah diverifikasi tidak dapat diedit.');
        }
        
        $siswas = Siswa::orderBy('nama_siswa')->get();
        $jenisPelanggarans = JenisPelanggaran::with('kategori')->orderBy('nama_pelanggaran')->get();
        
        return view('guru.laporan.edit', compact('laporan', 'siswas', 'jenisPelanggarans'));
    }

    // Memperbarui data laporan pelanggaran
    public function update(Request $request, Pelanggaran $laporan)
    {
        // Validasi: Hanya guru yang membuat laporan yang bisa mengupdate
        if ($laporan->user_pencatat != Auth::id()) {
            abort(403);
        }
        
        // Validasi: Hanya laporan yang belum diverifikasi yang bisa diupdate
        if ($laporan->status_verifikasi != 'menunggu') {
            return redirect()->route('guru.laporan.index')->with('error', 'Laporan yang sudah diverifikasi tidak dapat diedit.');
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);

        $data = [
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'poin' => $jenisPelanggaran->poin,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
        ];

        if ($request->hasFile('foto_bukti')) {
            if ($laporan->foto_bukti) {
                Storage::disk('public')->delete($laporan->foto_bukti);
            }
            $data['foto_bukti'] = $request->file('foto_bukti')->store('pelanggaran_bukti', 'public');
        }

        $laporan->update($data);

        return redirect()->route('guru.laporan.index')->with('success', 'Laporan pelanggaran berhasil diperbarui.');
    }

    // Menghapus laporan pelanggaran
    public function destroy(Pelanggaran $laporan)
    {
        // Validasi: Hanya guru yang membuat laporan yang bisa menghapus
        if ($laporan->user_pencatat != Auth::id()) {
            abort(403);
        }
        
        // Validasi: Hanya laporan yang belum diverifikasi yang bisa dihapus
        if ($laporan->status_verifikasi != 'menunggu') {
            return redirect()->route('guru.laporan.index')->with('error', 'Laporan yang sudah diverifikasi tidak dapat dihapus.');
        }

        if ($laporan->foto_bukti) {
            Storage::disk('public')->delete($laporan->foto_bukti);
        }

        $laporan->delete();

        return redirect()->route('guru.laporan.index')->with('success', 'Laporan pelanggaran berhasil dihapus.');
    }
}
