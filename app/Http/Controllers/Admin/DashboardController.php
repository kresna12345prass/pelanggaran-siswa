<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Orangtua;
use App\Models\JenisPelanggaran;
use App\Models\MasterSanksiBertahap;
use App\Models\MasterTataTertib;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\KategoriPelanggaran;
use App\Models\JenisPrestasi;
use App\Models\WaliKelas;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard admin dengan statistik dan grafik
    public function index()
    {
        // Mengumpulkan data statistik dari berbagai tabel
        $stats = [
            'total_users'      => User::count(),
            'total_siswa'      => Siswa::count(),
            'total_kelas'      => Kelas::count(),
            'total_tahun_ajaran' => TahunAjaran::count(),
            'total_orangtua'   => Orangtua::count(),
            'total_guru'       => Guru::count(),
            'total_wali_kelas' => WaliKelas::count(),
            'total_jurusan'    => Jurusan::count(),
            'total_kategori_pelanggaran' => KategoriPelanggaran::count(),
            'total_aturan_pelanggaran' => JenisPelanggaran::count(),
            'total_aturan_sanksi' => MasterSanksiBertahap::count(),
            'total_tata_tertib' => MasterTataTertib::count(),
            'total_jenis_prestasi' => JenisPrestasi::count(),
        ];

        // Grafik 1: Jumlah siswa per kelas
        $kelasData = Kelas::withCount('siswa')->orderBy('nama_kelas')->get();
        $kelasLabels = $kelasData->pluck('nama_kelas');
        $kelasCounts = $kelasData->pluck('siswa_count');

        // Grafik 2: Jumlah user berdasarkan role/level
        $roleData = User::groupBy('level')->select('level', DB::raw('count(*) as total'))->pluck('total', 'level');
        $roleLabels = $roleData->keys()->map(fn($level) => ucfirst($level));
        $roleCounts = $roleData->values();

        // Grafik 3: Top 5 pelanggaran dengan poin tertinggi
        $pelanggaranData = JenisPelanggaran::orderBy('poin', 'desc')->take(5)->get();
        $pelanggaranLabels = $pelanggaranData->isEmpty() ? collect(['Belum ada']) : $pelanggaranData->pluck('nama_pelanggaran');
        $pelanggaranPoin = $pelanggaranData->isEmpty() ? collect([0]) : $pelanggaranData->pluck('poin');

        // Grafik 4: Range poin sanksi bertahap
        $sanksiData = MasterSanksiBertahap::orderBy('poin_minimal')->get();
        $sanksiLabels = $sanksiData->pluck('nama_sanksi');
        $sanksiRange = $sanksiData->map(fn($s) => $s->poin_maksimal - $s->poin_minimal + 1);

        // Grafik 5: Jumlah kelas per jurusan
        $jurusanData = Kelas::join('jurusan', 'kelas.jurusan_id', '=', 'jurusan.id')
            ->select('jurusan.nama_jurusan', DB::raw('count(*) as total'))
            ->groupBy('jurusan.nama_jurusan')
            ->pluck('total', 'jurusan.nama_jurusan');
            
        $jurusanLabels = $jurusanData->keys();
        $jurusanCounts = $jurusanData->values();

        // Grafik 6: Status tahun ajaran (5 terakhir)
        $tahunData = TahunAjaran::orderBy('tahun_ajaran', 'desc')->take(5)->get();
        $tahunLabels = $tahunData->pluck('tahun_ajaran');
        $tahunStatus = $tahunData->map(fn($t) => $t->status_aktif ? 1 : 0);

        // Grafik 7: Jumlah pelanggaran per kategori
        $kategoriData = JenisPelanggaran::join('kategori_pelanggaran', 'jenis_pelanggaran.kategori_pelanggaran_id', '=', 'kategori_pelanggaran.id')
            ->select('kategori_pelanggaran.nama_kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori_pelanggaran.nama_kategori')
            ->pluck('total', 'kategori_pelanggaran.nama_kategori');

        $kategoriLabels = $kategoriData->keys();
        $kategoriCounts = $kategoriData->values();

        // Grafik 8: Range poin maksimal sanksi
        $rangeData = MasterSanksiBertahap::orderBy('poin_minimal')->get();
        $rangeLabels = $rangeData->map(fn($s) => $s->poin_minimal . '-' . $s->poin_maksimal);
        $rangeCounts = $rangeData->map(fn($s) => $s->poin_maksimal);
        
        // Menyiapkan data grafik dalam format JSON untuk Chart.js
        $charts = [
            'kelas_labels' => json_encode($kelasLabels),
            'kelas_data'   => json_encode($kelasCounts),
            'role_labels'  => json_encode($roleLabels),
            'role_data'    => json_encode($roleCounts),
            'pelanggaran_labels' => json_encode($pelanggaranLabels),
            'pelanggaran_data'   => json_encode($pelanggaranPoin),
            'sanksi_labels' => json_encode($sanksiLabels),
            'sanksi_data'   => json_encode($sanksiRange),
            'jurusan_labels' => json_encode($jurusanLabels),
            'jurusan_data'   => json_encode($jurusanCounts),
            'tahun_labels' => json_encode($tahunLabels),
            'tahun_data'   => json_encode($tahunStatus),
            'kategori_labels' => json_encode($kategoriLabels),
            'kategori_data'   => json_encode($kategoriCounts),
            'range_labels' => json_encode($rangeLabels),
            'range_data'   => json_encode($rangeCounts),
        ];

        return view('admin.dashboard.index', compact('stats', 'charts'));
    }
}