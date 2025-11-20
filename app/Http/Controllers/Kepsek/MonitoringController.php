<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\MonitoringPelanggaran;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    // Menampilkan halaman daftar monitoring pelanggaran
    public function index()
    {
        $monitoring = MonitoringPelanggaran::with(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran', 'kepalaSekolah'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('kepsek.monitoring.index', compact('monitoring'));
    }

    // Menampilkan form untuk menambah monitoring baru
    public function create()
    {
        $pelanggaranBerat = Pelanggaran::with(['siswa', 'jenisPelanggaran'])
            ->where('status_verifikasi', 'diverifikasi')
            ->where('poin', '>=', 50)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kepsek.monitoring.create', compact('pelanggaranBerat'));
    }

    // Menyimpan data monitoring baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'status_monitoring' => 'required|string',
            'catatan_monitoring' => 'required|string',
            'tanggal_monitoring' => 'required|date',
            'tindak_lanjut' => 'nullable|string',
        ]);

        $validated['kepala_sekolah_id'] = auth()->id();

        MonitoringPelanggaran::create($validated);

        return redirect()->route('kepsek.monitoring.index')->with('success', 'Monitoring berhasil ditambahkan');
    }

    // Menampilkan detail monitoring
    public function show($id)
    {
        $monitoring = MonitoringPelanggaran::with(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran', 'kepalaSekolah'])
            ->findOrFail($id);

        return view('kepsek.monitoring.show', compact('monitoring'));
    }

    // Menampilkan form untuk mengedit monitoring
    public function edit($id)
    {
        $monitoring = MonitoringPelanggaran::findOrFail($id);
        $pelanggaranBerat = Pelanggaran::with(['siswa', 'jenisPelanggaran'])
            ->where('status_verifikasi', 'diverifikasi')
            ->where('poin', '>=', 50)
            ->get();

        return view('kepsek.monitoring.edit', compact('monitoring', 'pelanggaranBerat'));
    }

    // Memperbarui data monitoring di database
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status_monitoring' => 'required|string',
            'catatan_monitoring' => 'required|string',
            'tanggal_monitoring' => 'required|date',
            'tindak_lanjut' => 'nullable|string',
        ]);

        $monitoring = MonitoringPelanggaran::findOrFail($id);
        $monitoring->update($validated);

        return redirect()->route('kepsek.monitoring.index')->with('success', 'Monitoring berhasil diperbarui');
    }

    // Menghapus data monitoring
    public function destroy($id)
    {
        $monitoring = MonitoringPelanggaran::findOrFail($id);
        $monitoring->delete();

        return redirect()->route('kepsek.monitoring.index')->with('success', 'Monitoring berhasil dihapus');
    }
}
