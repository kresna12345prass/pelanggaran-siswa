<?php

namespace App\Http\Controllers;

use App\Models\DataSanksi;
use App\Models\MasterKategoriSanksi;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SanksiController extends Controller
{
    public function index()
    {
        $sanksi = DataSanksi::with(['siswa.kelas', 'kategoriSanksi', 'userPenetap'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('sanksi.index', compact('sanksi'));
    }

    public function create()
    {
        $siswa = Siswa::with('kelas')->orderBy('nama')->get();
        $kategoriSanksi = MasterKategoriSanksi::all();
        
        return view('sanksi.create', compact('siswa', 'kategoriSanksi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kategori_sanksi_id' => 'required|exists:master_kategori_sanksi,id',
            'jenis_sanksi' => 'required|string',
            'deskripsi_hukuman' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $validated['user_penetap'] = auth()->id();
        $validated['status_sanksi'] = 'pending';

        DataSanksi::create($validated);

        return redirect()->route('sanksi.index')
            ->with('success', 'Sanksi berhasil ditambahkan');
    }

    public function show(DataSanksi $sanksi)
    {
        $sanksi->load(['siswa.kelas', 'kategoriSanksi', 'userPenetap', 'pelaksanaan']);
        
        return view('sanksi.show', compact('sanksi'));
    }

    public function edit(DataSanksi $sanksi)
    {
        $siswa = Siswa::with('kelas')->orderBy('nama')->get();
        $kategoriSanksi = MasterKategoriSanksi::all();
        
        return view('sanksi.edit', compact('sanksi', 'siswa', 'kategoriSanksi'));
    }

    public function update(Request $request, DataSanksi $sanksi)
    {
        $validated = $request->validate([
            'kategori_sanksi_id' => 'required|exists:master_kategori_sanksi,id',
            'jenis_sanksi' => 'required|string',
            'deskripsi_hukuman' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_sanksi' => 'required|in:pending,berjalan,selesai,terlambat',
        ]);

        $sanksi->update($validated);

        return redirect()->route('sanksi.index')
            ->with('success', 'Sanksi berhasil diupdate');
    }

    public function destroy(DataSanksi $sanksi)
    {
        $sanksi->delete();

        return redirect()->route('sanksi.index')
            ->with('success', 'Sanksi berhasil dihapus');
    }

    public function getSiswaInfo($siswaId)
    {
        $siswa = Siswa::with('kelas')->findOrFail($siswaId);
        
        $totalPoin = Pelanggaran::where('siswa_id', $siswaId)
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
        
        return response()->json([
            'nama' => $siswa->nama,
            'kelas' => $siswa->kelas->nama_kelas ?? '-',
            'total_poin' => $totalPoin,
        ]);
    }
}
