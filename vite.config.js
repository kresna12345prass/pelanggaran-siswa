import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // File utama & login
                'resources/css/app.css',
                'resources/css/login.css',
                'resources/js/app.js',

                // File Admin
                'resources/css/admin/layout.css',
                'resources/css/admin/dashboard.css',
                'resources/css/admin/users.css',
                'resources/css/admin/siswa.css',
                'resources/css/admin/kelas.css',
                'resources/css/admin/tahun_ajaran.css',
                'resources/css/admin/aturan_pelanggaran.css',
                'resources/css/admin/orangtua.css',
                'resources/css/admin/kategori_pelanggaran.css',
                'resources/css/admin/jurusan.css',
                'resources/css/admin/guru.css',
                'resources/css/admin/jenis_prestasi.css',
                'resources/css/admin/wali_kelas.css',
                
                'resources/js/admin/layout.js',
                'resources/js/admin/dashboard.js',
                'resources/js/admin/users.js',
                'resources/js/admin/siswa.js',
                'resources/js/admin/kelas.js',
                'resources/js/admin/tahun_ajaran.js',
                'resources/js/admin/aturan_pelanggaran.js',
                'resources/js/admin/orangtua.js',
                'resources/js/admin/kategori_pelanggaran.js',
                'resources/js/admin/jurusan.js',
                'resources/js/admin/guru.js',
                'resources/js/admin/jenis_prestasi.js',
                'resources/js/admin/wali_kelas.js',

                // File Kesiswaan
                'resources/css/kesiswaan/layout.css',
                'resources/css/kesiswaan/dashboard.css',
                'resources/css/kesiswaan/verifikasi.css',
                'resources/css/kesiswaan/pelanggaran.css',
                'resources/css/kesiswaan/sanksi.css',
                'resources/css/kesiswaan/monitoring.css',
                'resources/css/kesiswaan/prestasi.css',
                
                'resources/js/kesiswaan/layout.js',
                'resources/js/kesiswaan/dashboard.js',
                'resources/js/kesiswaan/verifikasi.js',
                'resources/js/kesiswaan/pelanggaran.js',
                'resources/js/kesiswaan/sanksi.js',
                'resources/js/kesiswaan/monitoring.js',
                'resources/js/kesiswaan/prestasi.js',

                // File Guru
                'resources/css/guru/layout.css',
                'resources/css/guru/dashboard.css',
                'resources/css/guru/laporan.css',
                'resources/css/guru/riwayat.css',
                
                'resources/js/guru/layout.js',
                'resources/js/guru/dashboard.js',
                'resources/js/guru/laporan.js',
                'resources/js/guru/riwayat.js',

                // File Wali Kelas
                'resources/css/wali_kelas/layout.css',
                'resources/css/wali_kelas/dashboard.css',
                'resources/css/wali_kelas/laporan.css',
                'resources/css/wali_kelas/riwayat.css',
                'resources/css/wali_kelas/monitoring.css',
                'resources/css/wali_kelas/rekapitulasi.css',
                
                'resources/js/wali_kelas/layout.js',
                'resources/js/wali_kelas/dashboard.js',
                'resources/js/wali_kelas/laporan.js',
                'resources/js/wali_kelas/riwayat.js',
                'resources/js/wali_kelas/monitoring.js',
                'resources/js/wali_kelas/rekapitulasi.js',

                // File BK
                'resources/css/bk/layout.css',
                'resources/css/bk/dashboard.css',
                'resources/css/bk/watchlist.css',
                'resources/css/bk/konseling.css',
                'resources/css/bk/tindak_lanjut.css',
                'resources/css/bk/profile.css',
                
                'resources/js/bk/layout.js',
                'resources/js/bk/dashboard.js',
                'resources/js/bk/watchlist.js',
                'resources/js/bk/konseling.js',
                'resources/js/bk/tindak_lanjut.js',
                'resources/js/bk/profile.js',

                // File Kepala Sekolah
                'resources/css/kepsek/layout.css',
                'resources/css/kepsek/dashboard.css',
                'resources/css/kepsek/monitoring.css',
                'resources/css/kepsek/laporan.css',
                
                'resources/js/kepsek/layout.js',
                'resources/js/kepsek/dashboard.js',
                'resources/js/kepsek/monitoring.js',
                'resources/js/kepsek/laporan.js',

                // File Siswa
                'resources/css/siswa/layout.css',
                'resources/css/siswa/dashboard.css',
                'resources/css/siswa/riwayat.css',
                'resources/css/siswa/sanksi.css',
                'resources/css/siswa/prestasi.css',
                'resources/css/siswa/profile.css',
                
                'resources/js/siswa/layout.js',
                'resources/js/siswa/dashboard.js',
                'resources/js/siswa/riwayat.js',
                'resources/js/siswa/sanksi.js',
                'resources/js/siswa/prestasi.js',
                'resources/js/siswa/profile.js',

                // File Orang Tua
                'resources/css/ortu/layout.css',
                'resources/css/ortu/dashboard.css',
                'resources/css/ortu/riwayat.css',
                'resources/css/ortu/sanksi.css',
                'resources/css/ortu/prestasi.css',
                'resources/css/ortu/profile.css',
                
                'resources/js/ortu/layout.js',
                'resources/js/ortu/dashboard.js',
                'resources/js/ortu/riwayat.js',
                'resources/js/ortu/sanksi.js',
                'resources/js/ortu/prestasi.js',
                'resources/js/ortu/profile.js',
            ],
            refresh: true,
        }),
    ],
});