<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{DataSanksi, PelaksanaanSanksi};

class MonitoringController extends Controller
{
    // Menampilkan halaman monitoring sanksi
    public function index()
    {
        $sanksis = DataSanksi::with(['pelanggaran.siswa.kelas', 'pelaksanaan'])
            ->whereIn('status_sanksi', ['berjalan', 'pending'])
            ->latest()
            ->get();

        return view('kesiswaan.monitoring.index', compact('sanksis'));
    }

    // Menampilkan detail monitoring sanksi
    public function show($id)
    {
        $sanksi = DataSanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran', 'pelaksanaan'])->findOrFail($id);
        return view('kesiswaan.monitoring.show', compact('sanksi'));
    }

    // Memperbarui status sanksi
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,terlambat'
        ]);

        $sanksi = DataSanksi::findOrFail($id);
        $sanksi->update(['status_sanksi' => $request->status]);

        return redirect()->route('kesiswaan.monitoring.index')->with('success', 'Status sanksi berhasil diupdate');
    }
}
