<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;

// == IMPORT CONTROLLER BARU ==
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\JenisPelanggaranController;
use App\Http\Controllers\Admin\AturanSanksiController;
use App\Http\Controllers\Admin\TataTertibController;
use App\Http\Controllers\Admin\OrangtuaController;
use App\Http\Controllers\Admin\KategoriPelanggaranController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\JenisPrestasiController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\WaliKelasController;
use App\Http\Controllers\Kesiswaan\DashboardKesiswaanController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\LaporanController;
use App\Http\Controllers\Guru\RiwayatController;
use App\Http\Controllers\WaliKelas\DashboardController as WaliKelasDashboardController;
use App\Http\Controllers\WaliKelas\LaporanController as WaliKelasLaporanController;
use App\Http\Controllers\WaliKelas\RiwayatController as WaliKelasRiwayatController;
use App\Http\Controllers\WaliKelas\MonitoringController as WaliKelasMonitoringController;
use App\Http\Controllers\WaliKelas\RekapitulasiController as WaliKelasRekapitulasiController;
use App\Http\Controllers\Bk\{DashboardController as BkDashboardController, WatchlistController, KonselingController, TindakLanjutController};
use App\Http\Controllers\Kepsek\DashboardController as KepsekDashboardController;
use App\Http\Controllers\Kepsek\MonitoringController as KepsekMonitoringController;
use App\Http\Controllers\Kepsek\LaporanController as KepsekLaporanController;
use App\Http\Controllers\Kepsek\MonitoringSanksiController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\RiwayatController as SiswaRiwayatController;
use App\Http\Controllers\Siswa\SanksiController as SiswaSanksiController;
use App\Http\Controllers\Siswa\ProfileController as SiswaProfileController;
use App\Http\Controllers\Siswa\PrestasiController as SiswaPrestasiController;
use App\Http\Controllers\Ortu\DashboardController as OrtuDashboardController;
use App\Http\Controllers\Ortu\RiwayatController as OrtuRiwayatController;
use App\Http\Controllers\Ortu\SanksiController as OrtuSanksiController;
use App\Http\Controllers\Ortu\PrestasiController as OrtuPrestasiController;
use App\Http\Controllers\Ortu\ProfileController as OrtuProfileController;
use App\Http\Controllers\Admin\BackupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Publik & Login
Route::get('/', [PublicController::class, 'index'])->name('welcome');
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ===================================================
// GRUP RUTE ADMIN
// ===================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Rute Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rute Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // == TAMBAHKAN RUTE INI ==
    // Ini akan membuat rute:
    // admin.users.index, admin.users.create, admin.users.store,
    // admin.users.edit, admin.users.update, admin.users.destroy
    Route::get('users-export', [UserController::class, 'export'])->name('users.export');
    Route::resource('users', UserController::class);
    Route::get('siswa-export', [SiswaController::class, 'export'])->name('siswa.export');
    Route::resource('siswa', SiswaController::class);
    Route::get('guru-export', [GuruController::class, 'export'])->name('guru.export');
    Route::resource('guru', GuruController::class);
    Route::get('jurusan-export', [JurusanController::class, 'export'])->name('jurusan.export');
    Route::resource('jurusan', JurusanController::class);
    Route::get('kelas-export', [KelasController::class, 'export'])->name('kelas.export');
    Route::resource('kelas', KelasController::class);
    Route::get('tahun_ajaran-export', [TahunAjaranController::class, 'export'])->name('tahun_ajaran.export');
    Route::resource('tahun_ajaran', TahunAjaranController::class);
    Route::resource('aturan_pelanggaran', JenisPelanggaranController::class);
    Route::get('aturan_pelanggaran/export/excel', [JenisPelanggaranController::class, 'export'])->name('aturan_pelanggaran.export');
    Route::get('aturan_pelanggaran-export', [JenisPelanggaranController::class, 'export'])->name('aturan_pelanggaran.export');
    Route::resource('aturan_pelanggaran', JenisPelanggaranController::class);
    Route::get('kategori_pelanggaran-export', [KategoriPelanggaranController::class, 'export'])->name('kategori_pelanggaran.export');
    Route::resource('kategori_pelanggaran', KategoriPelanggaranController::class);
    Route::get('aturan_sanksi-export', [AturanSanksiController::class, 'export'])->name('aturan_sanksi.export');
    Route::resource('aturan_sanksi', AturanSanksiController::class);
    Route::get('tata_tertib-export', [TataTertibController::class, 'export'])->name('tata_tertib.export');
    Route::resource('tata_tertib', TataTertibController::class);
    Route::get('orangtua-export', [OrangtuaController::class, 'export'])->name('orangtua.export');
    Route::resource('orangtua', OrangtuaController::class);
    Route::get('jenis_prestasi-export', [JenisPrestasiController::class, 'export'])->name('jenis_prestasi.export');
    Route::resource('jenis_prestasi', JenisPrestasiController::class);
    Route::get('wali_kelas-export', [WaliKelasController::class, 'export'])->name('wali_kelas.export');
    Route::resource('wali_kelas', WaliKelasController::class);
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup', [BackupController::class, 'create'])->name('backup.store');
    Route::get('/backup-export', [BackupController::class, 'export'])->name('backup.export');
    Route::get('/backup/download/{filename}', [BackupController::class, 'download'])->name('backup.download')->where('filename', '[a-zA-Z0-9\-\.]+');
    Route::delete('/backup/{filename}', [BackupController::class, 'destroy'])->name('backup.destroy')->where('filename', '[a-zA-Z0-9\-\.]+');

});

// ===================================================
// GRUP RUTE GURU
// ===================================================
Route::middleware(['auth', 'guru'])->prefix('guru')->name('guru.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
    
    // Laporan Pelanggaran (Full CRUD)
    Route::resource('laporan', LaporanController::class);
    
    // Riwayat Laporan (Read Only)
    Route::resource('riwayat', RiwayatController::class)->only(['index', 'show']);
    
    // Profile
    Route::get('/profile', function() {
        return view('guru.profile.index');
    })->name('profile');
    
});

// ===================================================
// GRUP RUTE WALI KELAS
// ===================================================
Route::middleware(['auth', 'wali_kelas'])->prefix('wali_kelas')->name('wali_kelas.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [WaliKelasDashboardController::class, 'index'])->name('dashboard');
    
    // Laporan Pelanggaran (Full CRUD)
    Route::resource('laporan', WaliKelasLaporanController::class);
    
    // Riwayat Laporan (Read Only)
    Route::resource('riwayat', WaliKelasRiwayatController::class)->only(['index', 'show']);
    
    // Monitoring Kelas
    Route::get('monitoring-export', [WaliKelasMonitoringController::class, 'export'])->name('monitoring.export');
    Route::resource('monitoring', WaliKelasMonitoringController::class)->only(['index', 'show']);
    
    // Data Pelanggaran Kelas
    Route::get('pelanggaran_kelas/export', [\App\Http\Controllers\WaliKelas\PelanggaranKelasController::class, 'export'])->name('pelanggaran_kelas.export');
    Route::resource('pelanggaran_kelas', \App\Http\Controllers\WaliKelas\PelanggaranKelasController::class)->only(['index', 'show']);
    
    // Data Prestasi Kelas
    Route::get('prestasi_kelas/export', [\App\Http\Controllers\WaliKelas\PrestasiKelasController::class, 'export'])->name('prestasi_kelas.export');
    Route::resource('prestasi_kelas', \App\Http\Controllers\WaliKelas\PrestasiKelasController::class)->only(['index', 'show']);
    
    // Data Sanksi Kelas
    Route::get('sanksi_kelas/export', [\App\Http\Controllers\WaliKelas\SanksiKelasController::class, 'export'])->name('sanksi_kelas.export');
    Route::resource('sanksi_kelas', \App\Http\Controllers\WaliKelas\SanksiKelasController::class)->only(['index', 'show']);
    
    // Rekapitulasi
    Route::get('/rekapitulasi', [WaliKelasRekapitulasiController::class, 'index'])->name('rekapitulasi.index');
    Route::post('/rekapitulasi/cetak', [WaliKelasRekapitulasiController::class, 'cetak'])->name('rekapitulasi.cetak');
    Route::get('/rekapitulasi-export', [WaliKelasRekapitulasiController::class, 'export'])->name('rekapitulasi.export');
    
    // Profile
    Route::get('/profile', function() {
        return view('wali_kelas.profile.index');
    })->name('profile');
    
});

// ===================================================
// GRUP RUTE BK / KONSELOR
// ===================================================
Route::middleware(['auth', 'bk'])->prefix('bk')->name('bk.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [BkDashboardController::class, 'index'])->name('dashboard');
    
    // Watchlist Siswa Bermasalah
    Route::get('watchlist-export', [WatchlistController::class, 'export'])->name('watchlist.export');
    Route::resource('watchlist', WatchlistController::class)->only(['index', 'show']);
    
    // Data Konseling (Full CRUD)
    Route::get('konseling-export', [KonselingController::class, 'export'])->name('konseling.export');
    Route::resource('konseling', KonselingController::class);
    
    // Tindak Lanjut
    Route::get('tindak_lanjut-export', [TindakLanjutController::class, 'export'])->name('tindak_lanjut.export');
    Route::resource('tindak_lanjut', TindakLanjutController::class)->only(['index', 'show', 'edit', 'update']);
    
    // Profile
    Route::get('/profile', function() {
        return view('bk.profile.index');
    })->name('profile');
    
});

// ===================================================
// GRUP RUTE KESISWAAN
// ===================================================
Route::middleware(['auth', 'kesiswaan'])->prefix('kesiswaan')->name('kesiswaan.')->group(function () {
    
    // Dashboard
    Route::resource('dashboard', \App\Http\Controllers\Kesiswaan\DashboardController::class)->only(['index']);
    
    // Verifikasi Laporan (Resource)
    Route::resource('verifikasi', \App\Http\Controllers\Kesiswaan\VerifikasiController::class)->except(['create', 'store', 'edit', 'destroy']);
    Route::get('verifikasi-riwayat', [\App\Http\Controllers\Kesiswaan\VerifikasiController::class, 'riwayat'])->name('verifikasi.riwayat');
    Route::get('verifikasi-riwayat-export', [\App\Http\Controllers\Kesiswaan\VerifikasiController::class, 'exportRiwayat'])->name('verifikasi.riwayat.export');
    
    // Data Pelanggaran (Full CRUD)
    Route::get('pelanggaran-export', [\App\Http\Controllers\Kesiswaan\PelanggaranController::class, 'export'])->name('pelanggaran.export');
    Route::get('pelanggaran/{id}/export-pdf', [\App\Http\Controllers\Kesiswaan\PelanggaranController::class, 'exportPdf'])->name('pelanggaran.exportPdf');
    Route::resource('pelanggaran', \App\Http\Controllers\Kesiswaan\PelanggaranController::class);
    
    // Data Sanksi (Full CRUD)
    Route::get('sanksi-export', [\App\Http\Controllers\Kesiswaan\SanksiController::class, 'export'])->name('sanksi.export');
    Route::resource('sanksi', \App\Http\Controllers\Kesiswaan\SanksiController::class);
    Route::get('/sanksi/{sanksi}/cetak-panggilan', [\App\Http\Controllers\Kesiswaan\SanksiController::class, 'cetakPanggilan'])->name('sanksi.cetak-panggilan');
    Route::get('/sanksi/{sanksi}/cetak-skorsing', [\App\Http\Controllers\Kesiswaan\SanksiController::class, 'cetakSkorsing'])->name('sanksi.cetak-skorsing');
    Route::get('/sanksi/{sanksi}/cetak-peringatan', [\App\Http\Controllers\Kesiswaan\SanksiController::class, 'cetakPeringatan'])->name('sanksi.cetak-peringatan');
    
    // Monitoring Sanksi (Resource)
    Route::resource('monitoring', \App\Http\Controllers\Kesiswaan\MonitoringController::class)->except(['create', 'store', 'edit', 'destroy']);
    
    // Data Prestasi (Full CRUD)
    Route::get('prestasi-export', [\App\Http\Controllers\Kesiswaan\PrestasiController::class, 'export'])->name('prestasi.export');
    Route::resource('prestasi', \App\Http\Controllers\Kesiswaan\PrestasiController::class);
    
    // Pelaksanaan Sanksi (Update)
    Route::get('/pelaksanaan', [\App\Http\Controllers\Kesiswaan\PelaksanaanSanksiController::class, 'index'])->name('pelaksanaan.index');
    Route::put('/pelaksanaan/{id}', [\App\Http\Controllers\Kesiswaan\PelaksanaanSanksiController::class, 'update'])->name('pelaksanaan.update');
    Route::get('/pelaksanaan-riwayat', [\App\Http\Controllers\Kesiswaan\PelaksanaanSanksiController::class, 'riwayat'])->name('pelaksanaan.riwayat');
    Route::get('/pelaksanaan-riwayat-export', [\App\Http\Controllers\Kesiswaan\PelaksanaanSanksiController::class, 'exportRiwayat'])->name('pelaksanaan.riwayat.export');
    Route::get('/pelaksanaan-riwayat/{id}', [\App\Http\Controllers\Kesiswaan\PelaksanaanSanksiController::class, 'showRiwayat'])->name('pelaksanaan.riwayat.show');
    Route::get('/pelaksanaan-riwayat/{id}/cetak', [\App\Http\Controllers\Kesiswaan\PelaksanaanSanksiController::class, 'cetakBeritaAcara'])->name('pelaksanaan.cetak-berita-acara');
    
    // Profile
    Route::get('/profile', function() {
        return view('kesiswaan.profile.index');
    })->name('profile');
    
});

// ===================================================
// GRUP RUTE KEPALA SEKOLAH
// ===================================================
Route::middleware(['auth', 'kepsek'])->prefix('kepsek')->name('kepsek.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [KepsekDashboardController::class, 'index'])->name('dashboard');
    
    // Monitoring Kasus Berat (Full CRUD)
    Route::resource('monitoring', KepsekMonitoringController::class);
    
    // Monitoring Siswa Bermasalah
    Route::get('/siswa-bermasalah', [\App\Http\Controllers\Kepsek\SiswaBermasalahController::class, 'index'])->name('siswa_bermasalah.index');
    Route::get('/siswa-bermasalah/{id}', [\App\Http\Controllers\Kepsek\SiswaBermasalahController::class, 'show'])->name('siswa_bermasalah.show');
    Route::get('/siswa-bermasalah-export', [\App\Http\Controllers\Kepsek\SiswaBermasalahController::class, 'export'])->name('siswa_bermasalah.export');
    
    // Monitoring Verifikasi
    Route::get('/verifikasi-monitoring', [\App\Http\Controllers\Kepsek\VerifikasiMonitoringController::class, 'index'])->name('verifikasi_monitoring.index');
    Route::get('/verifikasi-monitoring-export', [\App\Http\Controllers\Kepsek\VerifikasiMonitoringController::class, 'export'])->name('verifikasi_monitoring.export');
    
    // Monitoring Sanksi
    Route::get('/monitoring-sanksi', [MonitoringSanksiController::class, 'index'])->name('monitoring_sanksi.index');
    Route::get('/monitoring-sanksi-export', [MonitoringSanksiController::class, 'export'])->name('monitoring_sanksi.export');
    
    // Laporan Menyeluruh
    Route::get('/laporan', [KepsekLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/show', [KepsekLaporanController::class, 'show'])->name('laporan.show');
    Route::get('/laporan/export', [KepsekLaporanController::class, 'export'])->name('laporan.export');

    
    // Profile
    Route::get('/profile', function() {
        return view('kepsek.profile.index');
    })->name('profile');
    
});

// ===================================================
// GRUP RUTE SISWA
// ===================================================
Route::middleware(['auth', 'siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    
    // Riwayat Pelanggaran (Read Only)
    Route::resource('riwayat', SiswaRiwayatController::class)->only(['index', 'show']);
    
    // Status Sanksi (Read Only)
    Route::resource('sanksi', SiswaSanksiController::class)->only(['index', 'show']);
    
    // Data Prestasi (Read Only)
    Route::resource('prestasi', SiswaPrestasiController::class)->only(['index', 'show']);
    
    // Profile
    Route::get('/profile', [SiswaProfileController::class, 'index'])->name('profile');
    
});

// ===================================================
// GRUP RUTE ORANG TUA
// ===================================================
Route::middleware(['auth', 'ortu'])->prefix('ortu')->name('ortu.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [OrtuDashboardController::class, 'index'])->name('dashboard');
    
    // Riwayat Poin (Read Only)
    Route::resource('riwayat', OrtuRiwayatController::class)->only(['index', 'show']);
    
    // Info Sanksi (Read Only)
    Route::resource('sanksi', OrtuSanksiController::class)->only(['index', 'show']);
    
    // Data Prestasi (Read Only)
    Route::resource('prestasi', OrtuPrestasiController::class)->only(['index', 'show']);
    
    // Profile
    Route::get('/profile', [OrtuProfileController::class, 'index'])->name('profile');
    
});
