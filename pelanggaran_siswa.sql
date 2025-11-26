-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Nov 2025 pada 11.38
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pelanggaran_siswa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bimbingan_konseling`
--

CREATE TABLE `bimbingan_konseling` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_layanan` varchar(255) DEFAULT NULL,
  `topik` varchar(255) DEFAULT NULL,
  `keluhan_masalah` text DEFAULT NULL,
  `tindakan_solusi` text DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `tanggal_konseling` date DEFAULT NULL,
  `tanggal_tindak_lanjut` date DEFAULT NULL,
  `hasil_evaluasi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `data_sanksi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sumber_rujukan` enum('mandiri','sanksi','guru','ortu','wali_kelas') NOT NULL DEFAULT 'mandiri'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bimbingan_konseling`
--

INSERT INTO `bimbingan_konseling` (`id`, `siswa_id`, `tahun_ajaran_id`, `user_id`, `jenis_layanan`, `topik`, `keluhan_masalah`, `tindakan_solusi`, `status`, `tanggal_konseling`, `tanggal_tindak_lanjut`, `hasil_evaluasi`, `created_at`, `updated_at`, `data_sanksi_id`, `sumber_rujukan`) VALUES
(2, 3, 1, 6, 'Konseling Individual', 'Konseling Terkait Sanksi: Di serahkan kepada orang tua', 'Siswa mendapat sanksi: Di serahkan kepada orang tua dengan deskripsi: Di serahkan kepada orang tua untuk di bina 2 minggu', 'Siswa mendapat sanksi: Di serahkan kepada orang tua dengan deskripsi: Di serahkan kepada orang tua untuk di bina 2 minggu', 'tindak_lanjut', '2025-11-19', '2025-11-23', 'Siswa mendapat sanksi: Di serahkan kepada orang tua dengan deskripsi: Di serahkan kepada orang tua untuk di bina 2 minggu', '2025-11-19 14:42:39', '2025-11-23 05:29:58', 2, 'sanksi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_sanksi`
--

CREATE TABLE `data_sanksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pelanggaran_id` bigint(20) UNSIGNED NOT NULL,
  `user_penetap` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis_sanksi` varchar(255) NOT NULL,
  `deskripsi_hukuman` text NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status_sanksi` enum('pending','berjalan','selesai','terlambat') NOT NULL DEFAULT 'pending',
  `perlu_konseling` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bk_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `catatan_bk` text DEFAULT NULL,
  `status_konseling` enum('belum','proses','selesai') NOT NULL DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_sanksi`
--

INSERT INTO `data_sanksi` (`id`, `pelanggaran_id`, `user_penetap`, `jenis_sanksi`, `deskripsi_hukuman`, `tanggal_mulai`, `tanggal_selesai`, `status_sanksi`, `perlu_konseling`, `created_at`, `updated_at`, `bk_user_id`, `catatan_bk`, `status_konseling`) VALUES
(1, 2, 7, 'Peringatan lisan', 'Siswa sudah berjanji dan di tulis di catatan kesiswaan dan bk', '2025-11-15', '2025-11-16', 'selesai', 1, '2025-11-15 12:02:00', '2025-11-19 14:41:23', NULL, NULL, 'belum'),
(2, 3, 7, 'Di serahkan kepada orang tua', 'Di serahkan kepada orang tua untuk di bina 2 minggu', '2025-11-19', '2025-11-26', 'berjalan', 1, '2025-11-19 01:33:21', '2025-11-19 14:42:39', 6, NULL, 'proses'),
(3, 6, 7, 'Peringatan lisan', 'Siswa di pengarahan agar tidak bertengkar lagi', '2025-11-20', '2025-11-21', 'selesai', 0, '2025-11-20 04:35:15', '2025-11-22 15:39:21', NULL, NULL, 'belum'),
(4, 4, 7, 'Peringatan lisan', 'di beri pengarahan agar tobat', '2025-11-22', '2025-11-23', 'selesai', 0, '2025-11-22 14:48:21', '2025-11-22 15:07:13', NULL, NULL, 'belum');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `nama_guru` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `bidang_studi` varchar(255) DEFAULT NULL,
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif',
  `no_telepon` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama_guru`, `jenis_kelamin`, `bidang_studi`, `status`, `no_telepon`, `created_at`, `updated_at`) VALUES
(1, 4, '234589314585627139', 'Asep Ramdani', 'Laki-laki', 'Web', 'aktif', '08542671823', '2025-11-11 21:08:36', '2025-11-16 12:09:27'),
(2, 5, '328546732781856273', 'Suhendar Ekaalwi', 'Laki-laki', 'PAI', 'aktif', '0852675891', '2025-11-12 06:36:34', '2025-11-16 12:10:51'),
(3, 11, '345127849239579265', 'Gilang Guhon', 'Laki-laki', 'PPKN', 'aktif', '0812345738', '2025-11-14 00:49:23', '2025-11-16 12:10:32'),
(4, 14, '234589314585627165', 'Hurif Permana', 'Laki-laki', 'Mobile', 'aktif', '0812345742', '2025-11-18 07:40:18', '2025-11-18 07:40:18'),
(5, 16, '234589314585627113', 'Dedi Junaedi', 'Laki-laki', 'PAI', 'aktif', '08123457341', '2025-11-20 01:23:43', '2025-11-20 01:23:43'),
(6, 17, '234589314585627913', 'Elina Apiani', 'Perempuan', 'Matematika', 'aktif', '08823457365', '2025-11-20 01:32:14', '2025-11-20 01:32:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pelanggaran`
--

CREATE TABLE `jenis_pelanggaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori_pelanggaran_id` bigint(20) UNSIGNED NOT NULL,
  `nama_pelanggaran` varchar(255) NOT NULL,
  `poin` int(11) NOT NULL,
  `sanksi` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_pelanggaran`
--

INSERT INTO `jenis_pelanggaran` (`id`, `kategori_pelanggaran_id`, `nama_pelanggaran`, `poin`, `sanksi`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 'Membuat keributan / kegaduhan dalam kelas pada saat berlangsungnya pelajaran', 10, 'Peringatan lisan', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(2, 1, 'Masuk dan atau keluar lingkungan sekolah tidak melalui gerbang sekolah', 20, 'Panggilan orang tua dengan perjanjian siswa diatas materai', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(3, 1, 'Berkata tidak jujur, tidak sopan/kasar', 10, 'Peringatan lisan', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(4, 1, 'Mengotori (mencorat-coret) barang milik sekolah, guru, karyawan atau teman', 10, 'Peringatan lisan', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(5, 1, 'Merusak atau menghilangkan barang milik sekolah, guru, karyawan atau teman', 25, 'Perjanjian orang tua dengan perjanjian diatas materai', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(6, 1, 'Mengambil (mencuri) barang milik sekolah, guru, karyawan atau teman', 50, 'Diserahkan kepada orang tua untuk dibina (1 bulan)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(7, 1, 'Makan dan minum di dalam kelas saat berlangsungnya pelajaran', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(8, 1, 'Mengaktifkan alat komunikasi didalam kelas pada saat pelajaran berlangsung', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(9, 1, 'Membuang sampah tidak pada tempatnya', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(10, 1, 'Membawa teman selain siswa SMK BN maupun dengan siswa sekolah lain atau pihak lain', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(11, 1, 'Membawa benda yang tidak ada kaitannya dengan proses belajar mengajar', 10, 'Peringatan lisan', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(12, 1, 'Bertengkar bertentangan dengan teman di lingkungan sekolah', 15, 'Peringatan tertulis dengan perjanjian', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(13, 1, 'Memalsu tandatangan guru, walikelas, kepala sekolah', 40, 'Diserahkan kepada orang tua untuk dibina (2 minggu)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(14, 1, 'Menggunakan/menggelapkan SPP dari orang tua', 40, 'Diserahkan kepada orang tua untuk dibina (2 minggu)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(15, 1, 'Membentuk organisasi selain OSIS maupun kegiatan lainnya tanpa seijin Kepala Sekolah', 15, 'Peringatan tertulis dengan perjanjian', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(16, 1, 'Menyalahgunakan Uang SPP', 40, 'Diserahkan kepada orang tua untuk dibina (2 minggu)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(17, 1, 'Berbuat asusila', 100, 'Dikembalikan kepada orang tua (keluar dari sekolah)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(18, 2, 'Membawa rokok', 25, 'Perjanjian orang tua dengan perjanjian diatas materai', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(19, 2, 'Merokok/menghisap rokok di sekolah', 40, 'Diserahkan kepada orang tua untuk dibina (2 minggu)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(20, 2, 'Merokok/menghisap rokok di luar sekolah memakai seragam sekolah', 40, 'Diserahkan kepada orang tua untuk dibina (2 minggu)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(21, 3, 'Membawa buku, majalah, kaset terlarang atau HP berisi gambar dan film porno', 25, 'Perjanjian orang tua dengan perjanjian diatas materai', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(22, 3, 'Memperjual belikan buku, majalah atau kaset terlarang', 75, 'Diserahkan kepada orang tua untuk dibina (1 bulan)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(23, 4, 'Membawa senjata tajam tanpa ijin', 40, 'Diserahkan kepada orang tua untuk dibina (2 minggu)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(24, 4, 'Memperjual belikan senjata tajam di sekolah', 40, 'Diserahkan kepada orang tua untuk dibina (2 minggu)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(25, 4, 'Menggunakan senjata tajam untuk mengancam', 75, 'Diserahkan kepada orang tua untuk dibina (1 bulan)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(26, 4, 'Menggunakan senjata tajam untuk melukai', 75, 'Diserahkan kepada orang tua untuk dibina (1 bulan)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(27, 5, 'Membawa obat terlarang / minuman terlarang', 75, 'Diserahkan kepada orang tua untuk dibina (1 bulan)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(28, 5, 'Menggunakan obat minuman terlarang di dalam lingkungan sekolah', 100, 'Dikembalikan kepada orang tua (keluar dari sekolah)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(29, 5, 'Memperjual belikan obat / minuman terlarang di dalam / di luar sekolah', 100, 'Dikembalikan kepada orang tua (keluar dari sekolah)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(30, 6, 'Disebabkan oleh siswa di dalam sekolah (Intern)', 75, 'Diserahkan kepada orang tua untuk dibina (1 bulan)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(31, 6, 'Disebabkan oleh sekolah lain', 25, 'Perjanjian orang tua dengan perjanjian diatas materai', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(32, 6, 'Antar siswa SMK BN 666', 75, 'Diserahkan kepada orang tua untuk dibina (1 bulan)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(33, 7, 'Disertai ancaman', 75, 'Diserahkan kepada orang tua untuk dibina (1 bulan)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(34, 7, 'Disertai pemukulan', 100, 'Dikembalikan kepada orang tua (keluar dari sekolah)', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(35, 8, 'Terlambat masuk sekolah lebih dari 15 menit (Satu kali)', 2, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(36, 8, 'Terlambat masuk sekolah lebih dari 15 menit (Dua kali)', 3, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(37, 8, 'Terlambat masuk sekolah lebih dari 15 menit (Tiga kali dan selebihnya)', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(38, 8, 'Terlambat masuk karena izin', 3, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(39, 8, 'Terlambat masuk karena diberi tugas guru', 2, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(40, 8, 'Terlambat masuk karena alasan yang dibuat-buat', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(41, 8, 'Izin keluar saat proses belajar berlangsung dan tidak kembali', 10, 'Peringatan lisan', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(42, 8, 'Pulang tanpa izin', 10, 'Peringatan lisan', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(43, 9, 'Sakit tanpa keterangan (surat)', 2, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(44, 9, 'Izin tanpa keterangan (surat)', 2, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(45, 9, 'Alpa', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(46, 9, 'Tidak mengikuti kegiatan belajar (membolos)', 10, 'Peringatan lisan', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(47, 9, 'Siswa tidak masuk dengan membuat keterangan (surat) Palsu', 10, 'Peringatan lisan', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(48, 9, 'Siswa keluar kelas saat proses belajar mengajar berlangsung tanpa izin', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(49, 10, 'Memakai seragam tidak rapi / tidak dimasukkan', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(50, 10, 'Siswa putri memakai seragam yang ketat / rok pendek', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(51, 10, 'Tidak memakai perlengkapan upacara bendera (topi)', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(52, 10, 'Salah memakai baju, rok atau celana', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(53, 10, 'Salah atau tidak memakai ikat pinggang', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(54, 10, 'Salah memakai sepatu (tidak sesuai ketentuan)', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(55, 10, 'Tidak memakai kaos kaki', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(56, 10, 'Salah / tidak memakai kaos dalam', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(57, 10, 'Memakai topi yang bukan topi sekolah di lingkungan sekolah', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(58, 10, 'Siswa putri memakai perhiasan perlebihan', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(59, 10, 'Siswa putra memakai perhiasan atau aksesories (kalung, gelang, dll)', 5, 'Dicatat dan konseling', NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(64, 1, 'Tidur pada saat jam pembelajaran', 5, 'Dicatat dan konseling', NULL, '2025-11-13 20:33:44', '2025-11-13 20:34:19'),
(67, 14, 'Rambut di cat', 15, 'peringatan tertulis dengan perjanjian', NULL, '2025-11-20 04:16:42', '2025-11-20 04:16:42'),
(68, 15, 'Bertato', 100, 'di kembalikan ke orang tua (di keluarkan dari SMK BAKTI NUSANTARA 666 )', NULL, '2025-11-20 06:39:00', '2025-11-20 06:39:00'),
(69, 15, 'Kuku di cat', 20, 'Panggilan orang tua dengan perjanjian siswa diatas materai', NULL, '2025-11-20 06:40:26', '2025-11-20 06:40:26'),
(70, 14, 'Potongan rambut tidak sesuai dengan ketentuan sekolah', 15, 'peringatan tertulis dengan perjanjian', NULL, '2025-11-21 01:28:00', '2025-11-21 01:28:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_prestasi`
--

CREATE TABLE `jenis_prestasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_prestasi` varchar(255) NOT NULL,
  `poin` int(11) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `penghargaan` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_prestasi`
--

INSERT INTO `jenis_prestasi` (`id`, `nama_prestasi`, `poin`, `kategori`, `penghargaan`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Juara 1 Olimpiade Matematika Nasional', 100, 'Akademik', 'Medali Emas', 'Prestasi tingkat nasional', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(2, 'Juara 2 Olimpiade Fisika Provinsi', 80, 'Akademik', 'Medali Perak', 'Prestasi tingkat provinsi', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(3, 'Juara 3 Lomba Karya Ilmiah Remaja', 70, 'Akademik', 'Medali Perunggu', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(4, 'Juara 1 LKS RPL', 90, 'Kejuruan', 'Piala dan uang', 'Tingkat nasional', '2025-11-15 13:14:40', '2025-11-17 13:04:52'),
(5, 'Juara 2 Lomba Pidato Bahasa Indonesia', 75, 'Bahasa', 'Piagam Penghargaan', 'Tingkat provinsi', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(6, 'Juara 1 Sepak Bola Antar Sekolah', 85, 'Olahraga', 'Piala Bergilir', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(7, 'Juara 2 Bulu Tangkis Tingkat Provinsi', 80, 'Olahraga', 'Medali Perak', 'Prestasi olahraga', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(8, 'Juara 3 Basket Antar Pelajar', 70, 'Olahraga', 'Medali Perunggu', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(9, 'Juara 1 Lomba Seni Tari Tradisional', 85, 'Seni', 'Piala Bergilir', 'Tingkat provinsi', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(10, 'Juara 2 Lomba Musik Angklung', 75, 'Seni', 'Piagam Penghargaan', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(11, 'Juara 3 Lomba Melukis', 65, 'Seni', 'Sertifikat', 'Tingkat sekolah', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(12, 'Juara 1 Lomba Desain Grafis', 90, 'Teknologi', 'Piala dan Uang Pembinaan', 'Tingkat nasional', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(13, 'Juara 2 Lomba Robotika', 85, 'Teknologi', 'Medali Perak', 'Tingkat provinsi', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(14, 'Juara 3 Lomba Programming', 75, 'Teknologi', 'Sertifikat', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(15, 'Juara 1 Lomba Cerdas Cermat', 80, 'Akademik', 'Piala Bergilir', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(16, 'Juara 2 Olimpiade Kimia', 85, 'Akademik', 'Medali Perak', 'Tingkat provinsi', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(17, 'Juara 3 Olimpiade Biologi', 75, 'Akademik', 'Medali Perunggu', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(18, 'Juara 1 Lomba Menulis Cerpen', 70, 'Bahasa', 'Piagam Penghargaan', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(19, 'Juara 2 Lomba Puisi', 65, 'Bahasa', 'Sertifikat', 'Tingkat sekolah', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(20, 'Juara 1 Lomba Voli Antar Sekolah', 80, 'Olahraga', 'Piala Bergilir', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(21, 'Juara 2 Lomba Renang', 75, 'Olahraga', 'Medali Perak', 'Tingkat provinsi', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(22, 'Juara 3 Lomba Atletik', 70, 'Olahraga', 'Medali Perunggu', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(23, 'Juara 1 Lomba Teater', 80, 'Seni', 'Piala Bergilir', 'Tingkat provinsi', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(24, 'Juara 2 Lomba Paduan Suara', 75, 'Seni', 'Piagam Penghargaan', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(25, 'Juara 3 Lomba Band', 70, 'Seni', 'Sertifikat', 'Tingkat sekolah', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(26, 'Juara 1 Lomba Fotografi', 75, 'Seni', 'Piagam Penghargaan', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(27, 'Juara 2 Lomba Videografi', 70, 'Teknologi', 'Sertifikat', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(28, 'Juara 1 Lomba Kaligrafi', 65, 'Seni', 'Piagam Penghargaan', 'Tingkat sekolah', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(29, 'Juara 2 Lomba Tahfidz Quran', 85, 'Keagamaan', 'Piala dan Uang Pembinaan', 'Tingkat provinsi', '2025-11-15 13:14:40', '2025-11-15 13:14:40'),
(30, 'Juara 3 Lomba MTQ', 75, 'Keagamaan', 'Piagam Penghargaan', 'Tingkat kabupaten/kota', '2025-11-15 13:14:40', '2025-11-15 13:14:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_jurusan` varchar(255) NOT NULL,
  `kode_jurusan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id`, `nama_jurusan`, `kode_jurusan`, `created_at`, `updated_at`) VALUES
(1, 'Penegmbangan Perangkat Lunak dan Gim', 'PPLG', '2025-11-11 20:33:50', '2025-11-11 20:33:50'),
(2, 'Desain Komunikasi Visual', 'DKV', '2025-11-17 04:08:08', '2025-11-17 04:08:08'),
(4, 'Animasi', 'ANM', '2025-11-20 01:06:28', '2025-11-20 01:06:28'),
(5, 'Akutansi', 'AKT', '2025-11-20 01:06:59', '2025-11-20 01:06:59'),
(6, 'Bisnis Daring dan Pemasaran', 'BDP', '2025-11-20 01:07:27', '2025-11-20 01:07:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_pelanggaran`
--

CREATE TABLE `kategori_pelanggaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `kategori_induk` enum('KEPRIBADIAN','KERAJINAN','KERAPIAN') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_pelanggaran`
--

INSERT INTO `kategori_pelanggaran` (`id`, `nama_kategori`, `kategori_induk`, `created_at`, `updated_at`) VALUES
(1, 'KETERTIBAN', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(2, 'ROKOK', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(3, 'BUKU, MAJALAH, KASET TERLARANG', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(4, 'SENJATA', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(5, 'OBAT/MINUMAN TERLARANG', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(6, 'PERKELAHIAN', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(7, 'PELANGGARAN THD GURU/KARYAWAN', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(8, 'KETERLAMBATAN', 'KERAJINAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(9, 'KEHADIRAN', 'KERAJINAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(10, 'PAKAIAN', 'KERAPIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(14, 'Rambut', 'KERAPIAN', '2025-11-20 04:15:44', '2025-11-20 04:15:44'),
(15, 'BADAN', 'KERAPIAN', '2025-11-20 06:37:39', '2025-11-20 06:37:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `jurusan_id` bigint(20) UNSIGNED NOT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `jurusan_id`, `kapasitas`, `created_at`, `updated_at`) VALUES
(1, 'XII PPLG 1', 1, 35, '2025-11-11 20:34:10', '2025-11-12 06:36:54'),
(2, 'XII PPLG 2', 1, 30, '2025-11-14 00:50:03', '2025-11-18 08:24:24'),
(3, 'XII PPLG 3', 1, 30, '2025-11-20 01:08:09', '2025-11-20 01:08:09'),
(4, 'XII AKT 1', 5, 32, '2025-11-20 01:08:40', '2025-11-20 01:08:40'),
(5, 'XII AKT 2', 5, 32, '2025-11-20 01:09:05', '2025-11-20 01:09:05'),
(6, 'XII DKV', 2, 35, '2025-11-20 01:09:26', '2025-11-20 01:09:26'),
(7, 'XII ANM', 4, 30, '2025-11-20 01:09:58', '2025-11-20 01:09:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_sanksi_bertahap`
--

CREATE TABLE `master_sanksi_bertahap` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori` enum('RINGAN','SEDANG','BERAT') NOT NULL,
  `nama_sanksi` varchar(255) NOT NULL,
  `poin_minimal` int(11) NOT NULL,
  `poin_maksimal` int(11) NOT NULL,
  `deskripsi_tindakan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `master_sanksi_bertahap`
--

INSERT INTO `master_sanksi_bertahap` (`id`, `kategori`, `nama_sanksi`, `poin_minimal`, `poin_maksimal`, `deskripsi_tindakan`, `created_at`, `updated_at`) VALUES
(1, 'RINGAN', 'Dicatat dan konseling', 1, 5, 'Apabila skor pelanggaran mencapai 1 s/d 5 maka dikategorikan ringan berupa dicatat dan konseling.', '2025-11-11 23:52:32', '2025-11-11 23:52:32'),
(2, 'SEDANG', 'Peringatan lisan', 6, 10, 'Peringatan lisan untuk skor 6-10.', '2025-11-11 23:52:32', '2025-11-11 23:52:32'),
(3, 'SEDANG', 'Peringatan tertulis dengan perjanjian', 11, 15, 'Peringatan tertulis dengan perjanjian untuk skor 11-15.', '2025-11-11 23:52:32', '2025-11-11 23:52:32'),
(4, 'BERAT', 'Panggilan orang tua dengan perjanjian siswa diatas materai', 16, 20, 'Pemanggilan orang tua dan pembuatan perjanjian siswa di atas materai.', '2025-11-11 23:52:32', '2025-11-11 23:52:32'),
(5, 'BERAT', 'Perjanjian orang tua dengan perjanjian diatas materai', 21, 25, 'Pembuatan perjanjian orang tua di atas materai.', '2025-11-11 23:52:32', '2025-11-11 23:52:32'),
(6, 'BERAT', 'Diskors selama 3 hari', 26, 30, 'Siswa diskors selama 3 hari dari kegiatan sekolah.', '2025-11-11 23:52:32', '2025-11-11 23:52:32'),
(7, 'BERAT', 'Diskors selama 7 hari', 31, 35, 'Siswa diskors selama 7 hari dari kegiatan sekolah.', '2025-11-11 23:52:32', '2025-11-11 23:52:32'),
(8, 'BERAT', 'Diserahkan kepada orang tua untuk dibina (2 minggu)', 36, 40, 'Diserahkan kepada orang tua untuk dibina dalam jangka waktu dua (2) minggu.', '2025-11-11 23:52:32', '2025-11-11 23:52:32'),
(9, 'BERAT', 'Diserahkan kepada orang tua untuk dibina (1 bulan)', 41, 90, 'Diserahkan kepada orang tua untuk dibina dalam jangka waktu satu (1) bulan.', '2025-11-11 23:52:32', '2025-11-15 11:45:33'),
(10, 'BERAT', 'Dikembalikan kepada orang tua (keluar dari sekolah)', 90, 100, 'Dikembalikan kepada orang tua (keluar dari SMK BAKTI NUSANTARA 666).', '2025-11-11 23:52:32', '2025-11-15 11:46:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_tata_tertib`
--

CREATE TABLE `master_tata_tertib` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pasal` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tipe` enum('induk','poin','subpoin') NOT NULL,
  `konten_teks` text NOT NULL,
  `urutan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `master_tata_tertib`
--

INSERT INTO `master_tata_tertib` (`id`, `pasal`, `judul`, `tipe`, `konten_teks`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 'Pasal 6', 'KEWAJIBAN', 'induk', 'Setiap siswa wajib dan patuh pada ketentuan berikut:', 1, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(2, 'Pasal 6', 'KEWAJIBAN', 'poin', 'Siswa sudah berada di sekolah 15 menit sebelum bel masuk berbunyi.', 2, '2025-11-11 18:50:14', '2025-11-18 02:32:16'),
(3, 'Pasal 6', 'KEWAJIBAN', 'poin', 'Siswa yang datang terlambat wajib melapor dahulu kepada guru piket dengan ketentuan:', 3, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(4, 'Pasal 6', 'KEWAJIBAN', 'subpoin', 'Bila terlambat kurang dari lima belas menit dan dikelas belum ada guru pengajar, maka siswa di perkenankan langsung masuk kelas dengan surat izin masuk dari piket.', 4, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(5, 'Pasal 6', 'KEWAJIBAN', 'subpoin', 'Bila terlambat kurang dari lima belas menit dan dikelas sudah ada guru pengajar maka siswa menunggu pergantian jam pelajaran di perpustakaan untuk membuat resume atau kebersihan halaman ruang kelas, lingkungan sekolah, kemudian mendapat surat ijin masuk kelas dari guru piket.', 5, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(6, 'Pasal 6', 'KEWAJIBAN', 'subpoin', 'Bila terlambat lebih dari lima belas menit, maka siswa dipulangkan setelah mendapat surat pengantar dari sekolah atau Guru Piket.', 6, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(7, 'Pasal 6', 'KEWAJIBAN', 'poin', 'Bersikap dan bertingkah laku sopan santun kepada sesama kawan lebih-lebih kepada guru dan karyawan tata usaha.', 7, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(8, 'Pasal 6', 'KEWAJIBAN', 'poin', 'Siswa yang beragama Islam wajib mengikuti shalat Jum\'at berjama\'ah.', 8, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(9, 'Pasal 6', 'KEWAJIBAN', 'poin', 'Apabila seorang siswa tidak dapat hadir di sekolah wajib memberikan keterangan yang syah, yaitu:', 9, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(10, 'Pasal 6', 'KEWAJIBAN', 'subpoin', 'Surat keterangan dari orang tua', 10, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(11, 'Pasal 6', 'KEWAJIBAN', 'subpoin', 'Surat keterangan dokter apabila sakit.', 11, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(12, 'Pasal 6', 'KEWAJIBAN', 'subpoin', 'Tidak diperkenankan minta izin dengan telepon, apabila terpaksa maka pada hari pertama masuk sekolah harus memperlihatkan surat keterangan yang syah (ditanda tangani orang tua atau wali)', 12, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(13, 'Pasal 6', 'KEWAJIBAN', 'poin', 'Bila siswa karena sesuatu hal tertentu tidak dapat mengikuti pelajaran atau meninggalkan sekolah ia harus mendapatkan persetujuan dari guru piket.', 13, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(14, 'Pasal 6', 'KEWAJIBAN', 'poin', 'Pemeliharaan dan upaya 7 K (Keamanan, ketertiban, kedisiplinan, ketekunan, keindahan, kesehatan, kerindangan) atas kelas masing-masing serta lingkungan sekolah secara keseluruhan selama jam sekolah merupakan tanggung jawab bersama seluruh siswa.', 14, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(15, 'Pasal 6', 'KEWAJIBAN', 'poin', 'Selambat-lambatnya tanggal 10 setiap bulan pembayaran SPP dan biaya Praktikum harus sudah dilunasi.', 15, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(16, 'Pasal 7', 'LARANGAN', 'induk', 'Selama menjadi siswa-siswi SMK BAKTI NUSANTARA 666 dilarang:', 16, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(17, 'Pasal 7', 'LARANGAN', 'poin', 'Berpakaian seragam tidak sesuai ketentuan sekolah', 17, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(18, 'Pasal 7', 'LARANGAN', 'poin', 'Berhias atau bersolek secara berlebihan', 18, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(19, 'Pasal 7', 'LARANGAN', 'subpoin', 'Mewarnai rambut selain hitam, berambut gondrong bagi siswa putra', 19, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(20, 'Pasal 7', 'LARANGAN', 'subpoin', 'Make up', 20, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(21, 'Pasal 7', 'LARANGAN', 'subpoin', 'Aksesoris', 21, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(22, 'Pasal 7', 'LARANGAN', 'poin', 'Memakai topi selain topi sekolah.', 22, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(23, 'Pasal 7', 'LARANGAN', 'poin', 'Tidak memakai singlet bagi siswi perempuan.', 23, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(24, 'Pasal 7', 'LARANGAN', 'poin', 'Berbohong, mengambil barang milik orang lain (Mencuri)', 24, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(25, 'Pasal 7', 'LARANGAN', 'poin', 'Membawa barang yang tidak berhubungan dengan pelajaran.', 25, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(26, 'Pasal 7', 'LARANGAN', 'poin', 'Bermain dilapangan pada jam pelajaran.', 26, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(27, 'Pasal 7', 'LARANGAN', 'poin', 'Mengaktifkan alat komunikasi didalam kelas pada saat pelajaran berlangsung', 27, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(28, 'Pasal 7', 'LARANGAN', 'poin', 'Merokok di sekolah dan lingkungan sekolah.', 28, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(29, 'Pasal 7', 'LARANGAN', 'poin', 'Membawa buku, gambar, VCD porno atau handphone berisi gambar dan film porno', 29, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(30, 'Pasal 7', 'LARANGAN', 'poin', 'Membawa senjata tajam, kondom, pil KB.', 30, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(31, 'Pasal 7', 'LARANGAN', 'poin', 'Membawa teman selain siswa SMK BN 666 maupun dengan siswa sekolah lain atau pihak lain.', 31, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(32, 'Pasal 7', 'LARANGAN', 'poin', 'Berkelahi secara kelompok, massal baik dengan teman sekolah maupun dengan siswa sekolah lain atau pihak lain.', 32, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(33, 'Pasal 7', 'LARANGAN', 'poin', 'Melakukan tindakan yang mengakibatkan kerugian dan kerusakan sekolah', 33, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(34, 'Pasal 7', 'LARANGAN', 'poin', 'Memalsu tandatangan guru, walikelas, kepala sekolah.', 34, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(35, 'Pasal 7', 'LARANGAN', 'poin', 'Membentuk organisasi selain OSIS maupun kegiatan lainnya tanpa seijin Kepala Sekolah.', 35, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(36, 'Pasal 7', 'LARANGAN', 'poin', 'Berbuat asusila.', 36, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(37, 'Pasal 7', 'LARANGAN', 'poin', 'Badan bertato', 37, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(38, 'Pasal 7', 'LARANGAN', 'poin', 'Membawa, mengedarkan dan memakai NARKOBA.', 38, '2025-11-11 18:50:14', '2025-11-11 18:50:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_11_12_035829_add_user_id_to_siswa_and_guru_tables', 1),
(2, '2025_11_12_132151_add_jenis_kelamin_to_guru_table', 2),
(3, '2025_11_12_132218_add_wali_kelas_id_to_kelas_table', 3),
(4, '2025_11_15_182643_add_no_telepon_and_pendidikan_to_orangtua_table', 4),
(5, '2025_11_15_203100_add_bukti_dokumen_to_prestasi_table', 5),
(6, '2025_11_16_000000_remove_guru_id_from_users_table', 6),
(7, '2025_11_18_181925_create_wali_kelas_table', 7),
(8, '2025_11_18_182708_remove_wali_kelas_id_from_kelas_table', 8),
(9, '2025_11_19_213046_add_konseling_fields_to_data_sanksi_and_bimbingan_konseling', 9),
(10, '2025_11_21_082346_drop_kode_kategori_from_kategori_pelanggaran_table', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `monitoring_pelanggaran`
--

CREATE TABLE `monitoring_pelanggaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pelanggaran_id` bigint(20) UNSIGNED NOT NULL,
  `kepala_sekolah_id` bigint(20) UNSIGNED NOT NULL,
  `status_monitoring` varchar(100) DEFAULT NULL,
  `catatan_monitoring` text DEFAULT NULL,
  `tanggal_monitoring` date DEFAULT NULL,
  `tindak_lanjut` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `monitoring_pelanggaran`
--

INSERT INTO `monitoring_pelanggaran` (`id`, `pelanggaran_id`, `kepala_sekolah_id`, `status_monitoring`, `catatan_monitoring`, `tanggal_monitoring`, `tindak_lanjut`, `created_at`, `updated_at`) VALUES
(2, 3, 8, 'Proses', 'dmcksijdsovjdkosmvkdmvkfmvkmdkonvkdjfno kvckoxmkosmkomkzdjjkfjkvodsigjiowjrfovjdvdnkcfn', '2025-11-23', 'jfojdsiojvksmvklmklvmdfklvmklfdvnkldnfvkldsmvlkndsklvndvjdvjnkdfnkjnvikjdsvnkld', '2025-11-23 06:14:41', '2025-11-23 06:15:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orangtua`
--

CREATE TABLE `orangtua` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `hubungan` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `pendidikan` varchar(50) DEFAULT NULL,
  `pekerjaan` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orangtua`
--

INSERT INTO `orangtua` (`id`, `user_id`, `siswa_id`, `hubungan`, `no_telepon`, `pendidikan`, `pekerjaan`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Ayah', '083567426', 'SMA/SMK', 'Wiraswasta', 'Jl. Bandung No. 65', '2025-11-11 21:05:26', '2025-11-15 11:31:50'),
(2, 10, 2, 'Ayah', '084567239', 'D3', 'Pedagang', 'Jl. Soekarno No. 34', '2025-11-13 20:44:06', '2025-11-15 11:32:09'),
(3, 13, 3, 'Wali', '084576352418', 'SMA/SMK', 'PNS', 'Jl. Rancaekek No. 76', '2025-11-17 06:21:44', '2025-11-17 06:21:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelaksanaan_sanksi`
--

CREATE TABLE `pelaksanaan_sanksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data_sanksi_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pelaksanaan` date NOT NULL,
  `bukti_foto` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('hadir','tidak_hadir','tuntas') NOT NULL DEFAULT 'hadir',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelaksanaan_sanksi`
--

INSERT INTO `pelaksanaan_sanksi` (`id`, `data_sanksi_id`, `tanggal_pelaksanaan`, `bukti_foto`, `catatan`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-11-15', 'bukti_sanksi/jkvyZoxQ0IwjBbFONA9jDDNSofHxBTm1iEV2SpUl.jpg', 'Siswa sudah di beri pemahaman dan motivasi agar lebih bersemangat sekolah', 'tuntas', '2025-11-15 12:35:48', '2025-11-15 12:35:48'),
(2, 4, '2025-11-22', 'bukti_sanksi/2lKstK0JTxv5i5idzMZWxlTZWWZouzEk12FqwIPf.png', NULL, 'tuntas', '2025-11-22 15:07:13', '2025-11-22 15:07:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggaran`
--

CREATE TABLE `pelanggaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_pelanggaran_id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `user_pencatat` bigint(20) UNSIGNED DEFAULT NULL,
  `user_verifikator` bigint(20) UNSIGNED DEFAULT NULL,
  `poin` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `status_verifikasi` enum('menunggu','diverifikasi','ditolak') NOT NULL DEFAULT 'menunggu',
  `catatan_verifikasi` text DEFAULT NULL,
  `tanggal` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggaran`
--

INSERT INTO `pelanggaran` (`id`, `siswa_id`, `jenis_pelanggaran_id`, `tahun_ajaran_id`, `user_pencatat`, `user_verifikator`, `poin`, `keterangan`, `foto_bukti`, `status_verifikasi`, `catatan_verifikasi`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 2, 64, 1, 7, 7, 5, 'Tertidur saat jam pembelajaran', 'pelanggaran/7ry0jHMMg9whnMzdKpELpwxoFnnUgi7QjOgX0uwt.jpg', 'diverifikasi', NULL, '2025-11-14 10:36:00', '2025-11-13 20:36:35', '2025-11-13 20:36:35'),
(2, 2, 45, 1, 4, 7, 5, 'Tidak masuk', 'pelanggaran_bukti/dp27fqPp5VScvAN21P6AfSFtWnxFOfrauTQVtkqR.jpg', 'diverifikasi', NULL, '2025-11-14 14:13:00', '2025-11-14 00:13:48', '2025-11-19 12:42:13'),
(3, 3, 28, 1, 11, 7, 100, 'Ketauan mabok arbal', 'pelanggaran/oMeajqHPmFiXXJhcFtwWCEL0HQ78THjLdF2oCdXx.jpg', 'diverifikasi', 'ok aman akan saya berikan sanksi', '2025-11-17 13:55:00', '2025-11-17 06:55:35', '2025-11-17 07:20:28'),
(4, 4, 8, 1, 5, 7, 5, 'Pada saat pembelajaran menggunakan hp', 'pelanggaran/5iC1XWr0q0F9eNX9mAPdVxpVnG18h421Cux1ATt7.jpg', 'diverifikasi', NULL, '2025-11-20 10:41:00', '2025-11-20 03:42:47', '2025-11-22 13:28:54'),
(5, 5, 57, 1, 4, 7, 5, 'pada saat di kelas memakai topi', 'pelanggaran_bukti/Vioy97zriM9LXaQaSfL8y9bUjwpZAMT3mw2gONPr.png', 'ditolak', 'Karena tidak terbukti', '2025-11-20 11:17:00', '2025-11-20 04:18:25', '2025-11-22 13:36:25'),
(6, 1, 12, 1, 4, 7, 15, 'bertengkar dengan teman', 'pelanggaran_bukti/2R5L5LfSoiEjzIzqR3SRechYNsprPO3WZ2yrc0Yy.png', 'diverifikasi', NULL, '2025-11-20 11:32:00', '2025-11-20 04:33:11', '2025-11-20 04:34:01'),
(7, 4, 45, 1, 4, NULL, 5, 'mfkoasjfoijiosoifnsodnvfsnvofnsdjvnsdjvndfsjdivs', 'pelanggaran_bukti/wdM0RDQRYwvSo9FedSQbuLdBoWnNNFQpmxaeEtss.png', 'menunggu', NULL, '2025-11-22 20:51:00', '2025-11-22 13:52:01', '2025-11-22 13:52:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `prestasi`
--

CREATE TABLE `prestasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_prestasi_id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `poin` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tingkat` varchar(255) DEFAULT NULL,
  `penghargaan` varchar(255) DEFAULT NULL,
  `user_pencatat` bigint(20) UNSIGNED DEFAULT NULL,
  `user_verifikator` bigint(20) UNSIGNED DEFAULT NULL,
  `status_verifikasi` varchar(100) DEFAULT NULL,
  `catatan_verifikasi` text DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `bukti_dokumen` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `prestasi`
--

INSERT INTO `prestasi` (`id`, `siswa_id`, `jenis_prestasi_id`, `tahun_ajaran_id`, `poin`, `keterangan`, `tingkat`, `penghargaan`, `user_pencatat`, `user_verifikator`, `status_verifikasi`, `catatan_verifikasi`, `tanggal`, `bukti_dokumen`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 90, 'menjuarai LKS RPL tinggkat provinsi di bogor', 'Nasional', 'Piala dan uang', 7, NULL, 'diverifikasi', NULL, '2025-11-17 00:00:00', 'prestasi/BNoeObLXkT7MdoPKU2UUh30h7NUGPd1XLmau9kQe.png', '2025-11-17 13:07:30', '2025-11-19 14:10:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('nKwDrnuvLPIqqtV6P6rpCUdDOWTSaRG2KJXrMgau', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZERXSVpzZW9pWVplV25SN3NiclhQTDd6bEdsYXVyWW14Zk9OZ3dLcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764043629),
('ssQXi1JTB1JsVY0GDU0Me04ipBM7NW4HNF1ESyHZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaU1hcGNTNFZwU3lBYlVrd2h1RGRvTnNLdjNUWUl1QVloRG5kaUVXdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJ3ZWxjb21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764125490),
('xEuNYTuQ7FJ3OaUT9MEqHhPD6v5F4OUMH4gCUPuG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieHFnMmRwUmpFbEJLQjdtcTRjY3U5RjFidEtjaXg3VDNsQnFVWHdRdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJ3ZWxjb21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1764131446);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `nisn` varchar(50) DEFAULT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `user_id`, `nis`, `nisn`, `nama_siswa`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `alamat`, `no_telepon`, `foto`, `kelas_id`, `created_at`, `updated_at`) VALUES
(1, 2, '232417070065', '0034567891', 'Prasssetya Kresna', 'Bandung', '2008-04-15', 'L', 'Islam', 'Jl. Bandung No. 65', '088220437325', 'siswa_foto/DjfIFopEJhcfSjOsmIR4xyr1B8mZ01zgnweoMWML.png', 1, '2025-11-11 21:04:20', '2025-11-11 21:04:20'),
(2, 9, '232417080066', '0034567892', 'Dhimas Rakha Catur Pramudya', 'Bandung', '2007-09-11', 'L', 'Islam', 'Jl. Soekarno No. 34', '08987889110', 'siswa_foto/i4B4BOhakqWTDPDrQLdqPc8g3fIZ5wRNTfcfrXey.png', 1, '2025-11-13 20:27:54', '2025-11-16 11:55:26'),
(3, 12, '232417080076', '0034567295', 'Taufik Firmansyah', 'Bandung', '2007-11-14', 'L', 'Islam', 'Jl. Anfield No. 65', '084576352437', 'siswa_foto/7OOG7qBdK3BYpXeFCKGBZcbyBmKzaPXQ5YhpnERK.png', 2, '2025-11-17 02:54:26', '2025-11-17 02:55:08'),
(4, 15, '232417080088', '0036514511', 'Aldi Taufik Rahman', 'Bandung', '2007-07-18', 'L', 'Islam', 'Jl. Cipacing No. 34', '08512347893', 'siswa_foto/BQ7GSjj8MXCXw92AXUViyFHAJ6127vbDUA5s7UZv.png', 7, '2025-11-20 01:15:04', '2025-11-20 01:15:04'),
(5, 18, '232417080013', '0036514575', 'Alya Najla Huwaida', 'Bandung', '2007-07-18', 'P', 'Islam', 'Jl. Cianjur No. 3', '08512347827', 'siswa_foto/HJuOZ1jPflPLMHyvLMaVwsyYsk0v952yo85cLdZd.png', 4, '2025-11-20 03:00:36', '2025-11-20 03:00:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_ajaran` varchar(255) NOT NULL,
  `tahun_ajaran` varchar(50) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 0,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `kode_ajaran`, `tahun_ajaran`, `semester`, `status_aktif`, `tanggal_mulai`, `tanggal_selesai`, `created_at`, `updated_at`) VALUES
(1, '20251', '2025/2026', 'Ganjil', 1, '2025-06-09', '2025-12-31', '2025-11-11 20:54:47', '2025-11-12 19:09:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','kesiswaan','guru','wali_kelas','bk','kepsek','siswa','ortu') NOT NULL,
  `spesialisasi` varchar(255) DEFAULT NULL,
  `can_verify` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `nama_lengkap`, `email`, `password`, `level`, `spesialisasi`, `can_verify`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', 'admin@gmail.com', '$2y$12$u5Afe9xBPGiHRI68HI412u/GdxElBszendfkUzGQ8fWXZBqIrALKq', 'admin', 'Super Admin', 1, 'pZdDlGngprscV60O4oa8KtapAv68IVg2rE3vzeg8U1Fn5v18K17UHrpNVRXo', '2025-11-11 18:50:14', '2025-11-16 12:07:42'),
(2, 'Prass', 'Prasssetya Kresna', 'prassetyakresna15@gmail.com', '$2y$12$KnEtgBeAck/7UPCdKjPG6.PKDlVfQ.wcwgy.gpk28VYk85CaBooPW', 'siswa', 'Siswa', 1, NULL, '2025-11-11 21:04:18', '2025-11-12 09:10:25'),
(3, 'Andi', 'Andi Marwan', 'andi12345@gmail.com', '$2y$12$d1HnRpJWhHYG.MaN.Qo41.0jgjw9KuK9KPAo.ubfoOKcDUmJNtyRa', 'ortu', 'Orang Tua', 1, NULL, '2025-11-11 21:05:26', '2025-11-11 21:32:50'),
(4, 'guru', 'Asep Ramdani', 'guru_sekolah@gmail.com', '$2y$12$sgmCT.fuoCCO.K417cUqEeDZl4/hXe2jznRegw7SIyyQsRCdNtrFq', 'guru', 'Guru', 1, NULL, '2025-11-11 21:08:36', '2025-11-22 06:44:52'),
(5, 'wali_kelas', 'Suhendar Ekaalwi', 'wali_kelas@gmail.com', '$2y$12$CCRqGS2ZSmhEqQ2lHTk6ueUph7CkFCBQQG.D0FXSuH9pJDFXxwUGO', 'wali_kelas', 'Wali Kelas XII PPLG 1', 1, NULL, '2025-11-12 06:36:34', '2025-11-13 20:03:47'),
(6, 'ridwan', 'Ridwan Setiawan', 'bimbingan_konseling@gmail.com', '$2y$12$h8WZ29gvj8OewRqJp7KIZ.z.pNwgKdqPBluslEL.VxC4t.dycKd5W', 'bk', 'BK', 1, NULL, '2025-11-12 09:07:02', '2025-11-12 09:07:02'),
(7, 'Dini', 'Dini Susanti', 'dini_susanti@gmail.com', '$2y$12$W0fiwG56QVIMe0x8sLhrw.JVa4ffX1X3lAp3wBiJhcT5xqYFf3aE.', 'kesiswaan', 'Kesiswaan', 1, NULL, '2025-11-12 09:09:33', '2025-11-12 09:09:33'),
(8, 'Danis', 'Deni Danis', 'kepalasekolah@gmail.com', '$2y$12$so24nbJCua2uGX52QgHdb.LtA0CRel7j5eBdBFAXH8/1XxmWmmbkO', 'kepsek', 'Kepala Sekolah', 1, NULL, '2025-11-12 09:12:19', '2025-11-15 16:35:58'),
(9, 'Dhimas', 'Dhimas Rakha Catur Pramudya', 'dimas@gmail.com', '$2y$12$7O4gL0eaXOjMjUKgbSR.6eROsfxWzKJHLJskLCUcivwX1ESRbZm.6', 'siswa', 'siswa', 1, NULL, '2025-11-13 20:27:54', '2025-11-13 20:29:09'),
(10, 'mamat', 'Dede sunandar', 'mamat@gmail.com', '$2y$12$iOKparIATyFs25szIQ4W4eK76vSrqzAcZ9R5obJiLhQQLl8wJOCIy', 'ortu', 'Orang Tua', 1, NULL, '2025-11-13 20:44:06', '2025-11-18 02:24:17'),
(11, 'gurupkn', 'Gilang Guhon', 'wali_kelas2@gmail.com', '$2y$12$43SbT1WZiYiHzMHXTRdvrOTO717FfMrnB0kYijZtkQVqVKtOQkD72', 'wali_kelas', 'wali kelas', 1, NULL, '2025-11-14 00:49:23', '2025-11-19 01:06:14'),
(12, 'taufik', 'Taufik Firmansyah', 'taufik_racing@gmail.com', '$2y$12$beBjlgxFVlHpj7u7hY33sOw5q5wefPANdZMGZLAZ3araVOqW1GVaW', 'siswa', NULL, 0, NULL, '2025-11-17 02:54:26', '2025-11-17 02:54:26'),
(13, 'Rancabatok', 'Rancabatok', 'rancabatok@gmail.com', '$2y$12$sp0yD/J4RlhIzRowPXrjHO1ob8XrB0tueho9tfCe0JDdc3fBEi6gK', 'ortu', NULL, 0, NULL, '2025-11-17 06:21:44', '2025-11-17 06:21:44'),
(14, 'guru3', 'Hurif Permana', 'guru_sekolah3@gmail.com', '$2y$12$ZSxobbOHXHJvu72fkErcEe2aUsADdS8pF36HDIR4gfVQ7FaA8D.3q', 'wali_kelas', 'guru_mobile', 1, NULL, '2025-11-18 07:40:18', '2025-11-20 01:16:23'),
(15, 'Aldi', 'Aldi Taufik Rahman', 'alditaufiq071@gmail.com', '$2y$12$v56CS3NNRqa0pMLfphnJ..qgcuMkwaoD2Za5.A7Z40.SJFE5JRB1i', 'siswa', 'Siswa', 1, NULL, '2025-11-20 01:15:04', '2025-11-20 03:22:27'),
(16, 'ustadzdedi', 'Dedi Junaedi', 'guru5@gmail.com', '$2y$12$4xKUg3cO9v9idrixw89A7ussNfUjV3MhmTs2M3HNeyDnriYXiqy8G', 'wali_kelas', 'Wali Kelas', 1, NULL, '2025-11-20 01:23:43', '2025-11-20 01:27:59'),
(17, 'elina', 'Elina Apiani', 'guru6@gmail.com', '$2y$12$qQTrpISIU/ynMQhMmvtUFeuHHsdWfi3r1laofc/o2A7lt2H0ADJxS', 'wali_kelas', NULL, 0, NULL, '2025-11-20 01:32:14', '2025-11-20 01:32:43'),
(18, 'Huwaida', 'Alya Najla Huwaida', 'alya_najla@gmail.com', '$2y$12$MSt332EVNVUk1l0ISn3iK.BHkIP3qAbch3bzoReAyeQ.CKB7B5vJu', 'siswa', 'siswa', 1, NULL, '2025-11-20 03:00:36', '2025-11-20 03:22:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `verifikasi_data`
--

CREATE TABLE `verifikasi_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tabel_terkait` varchar(255) NOT NULL,
  `id_terkait` bigint(20) UNSIGNED NOT NULL,
  `user_pencatat` bigint(20) UNSIGNED DEFAULT NULL,
  `user_verifikator` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `catatan_verifikasi` text DEFAULT NULL,
  `tanggal_pencatatan` datetime DEFAULT NULL,
  `tanggal_verifikasi` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `verifikasi_data`
--

INSERT INTO `verifikasi_data` (`id`, `tabel_terkait`, `id_terkait`, `user_pencatat`, `user_verifikator`, `status`, `catatan_verifikasi`, `tanggal_pencatatan`, `tanggal_verifikasi`, `created_at`, `updated_at`) VALUES
(1, 'pelanggaran', 3, 11, 7, 'diverifikasi', 'ok aman akan saya berikan sanksi', '2025-11-17 13:55:00', '2025-11-17 14:20:28', '2025-11-17 07:20:28', '2025-11-17 07:20:28'),
(2, 'pelanggaran', 6, 4, 7, 'diverifikasi', NULL, '2025-11-20 11:32:00', '2025-11-20 11:34:01', '2025-11-20 04:34:01', '2025-11-20 04:34:01'),
(3, 'pelanggaran', 4, 5, 7, 'diverifikasi', NULL, '2025-11-20 10:41:00', '2025-11-22 20:28:54', '2025-11-22 13:28:54', '2025-11-22 13:28:54'),
(4, 'pelanggaran', 5, 4, 7, 'ditolak', 'Karena tidak terbukti', '2025-11-20 11:17:00', '2025-11-22 20:36:25', '2025-11-22 13:36:25', '2025-11-22 13:36:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wali_kelas`
--

CREATE TABLE `wali_kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `wali_kelas`
--

INSERT INTO `wali_kelas` (`id`, `tahun_ajaran_id`, `guru_id`, `kelas_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '2025-11-18 11:33:45', '2025-11-18 11:33:45'),
(2, 1, 3, 2, '2025-11-18 11:34:04', '2025-11-19 01:06:14'),
(3, 1, 4, 7, '2025-11-20 01:16:23', '2025-11-20 01:16:23'),
(4, 1, 5, 6, '2025-11-20 01:24:02', '2025-11-20 01:24:02'),
(5, 1, 6, 4, '2025-11-20 01:32:43', '2025-11-20 01:32:43');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bimbingan_konseling`
--
ALTER TABLE `bimbingan_konseling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bimbingan_konseling_data_sanksi_id_foreign` (`data_sanksi_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `data_sanksi`
--
ALTER TABLE `data_sanksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_sanksi_pelanggaran_id_foreign` (`pelanggaran_id`),
  ADD KEY `data_sanksi_user_penetap_foreign` (`user_penetap`),
  ADD KEY `data_sanksi_bk_user_id_foreign` (`bk_user_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `guru_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `jenis_pelanggaran`
--
ALTER TABLE `jenis_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_pelanggaran_id` (`kategori_pelanggaran_id`);

--
-- Indeks untuk tabel `jenis_prestasi`
--
ALTER TABLE `jenis_prestasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_jurusan` (`kode_jurusan`);

--
-- Indeks untuk tabel `kategori_pelanggaran`
--
ALTER TABLE `kategori_pelanggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurusan_id` (`jurusan_id`);

--
-- Indeks untuk tabel `master_sanksi_bertahap`
--
ALTER TABLE `master_sanksi_bertahap`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_tata_tertib`
--
ALTER TABLE `master_tata_tertib`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `monitoring_pelanggaran`
--
ALTER TABLE `monitoring_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `monitoring_pelanggaran_pelanggaran_id_foreign` (`pelanggaran_id`),
  ADD KEY `monitoring_pelanggaran_kepala_sekolah_id_foreign` (`kepala_sekolah_id`);

--
-- Indeks untuk tabel `orangtua`
--
ALTER TABLE `orangtua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pelaksanaan_sanksi`
--
ALTER TABLE `pelaksanaan_sanksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelaksanaan_sanksi_data_sanksi_id_foreign` (`data_sanksi_id`);

--
-- Indeks untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggaran_siswa_id_foreign` (`siswa_id`),
  ADD KEY `pelanggaran_jenis_pelanggaran_id_foreign` (`jenis_pelanggaran_id`),
  ADD KEY `pelanggaran_tahun_ajaran_id_foreign` (`tahun_ajaran_id`),
  ADD KEY `pelanggaran_user_pencatat_foreign` (`user_pencatat`),
  ADD KEY `pelanggaran_user_verifikator_foreign` (`user_verifikator`);

--
-- Indeks untuk tabel `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `jenis_prestasi_id` (`jenis_prestasi_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `user_pencatat` (`user_pencatat`),
  ADD KEY `user_verifikator` (`user_verifikator`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `siswa_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_ajaran` (`kode_ajaran`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `verifikasi_data`
--
ALTER TABLE `verifikasi_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_pencatat` (`user_pencatat`),
  ADD KEY `user_verifikator` (`user_verifikator`);

--
-- Indeks untuk tabel `wali_kelas`
--
ALTER TABLE `wali_kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_tahun_kelas` (`tahun_ajaran_id`,`kelas_id`),
  ADD KEY `wali_kelas_guru_id_foreign` (`guru_id`),
  ADD KEY `wali_kelas_kelas_id_foreign` (`kelas_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bimbingan_konseling`
--
ALTER TABLE `bimbingan_konseling`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `data_sanksi`
--
ALTER TABLE `data_sanksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jenis_pelanggaran`
--
ALTER TABLE `jenis_pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `jenis_prestasi`
--
ALTER TABLE `jenis_prestasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `kategori_pelanggaran`
--
ALTER TABLE `kategori_pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `master_sanksi_bertahap`
--
ALTER TABLE `master_sanksi_bertahap`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `master_tata_tertib`
--
ALTER TABLE `master_tata_tertib`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `monitoring_pelanggaran`
--
ALTER TABLE `monitoring_pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `orangtua`
--
ALTER TABLE `orangtua`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pelaksanaan_sanksi`
--
ALTER TABLE `pelaksanaan_sanksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `verifikasi_data`
--
ALTER TABLE `verifikasi_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `wali_kelas`
--
ALTER TABLE `wali_kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bimbingan_konseling`
--
ALTER TABLE `bimbingan_konseling`
  ADD CONSTRAINT `bimbingan_konseling_data_sanksi_id_foreign` FOREIGN KEY (`data_sanksi_id`) REFERENCES `data_sanksi` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bimbingan_konseling_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bimbingan_konseling_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bimbingan_konseling_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_sanksi`
--
ALTER TABLE `data_sanksi`
  ADD CONSTRAINT `data_sanksi_bk_user_id_foreign` FOREIGN KEY (`bk_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `data_sanksi_pelanggaran_id_foreign` FOREIGN KEY (`pelanggaran_id`) REFERENCES `pelanggaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `data_sanksi_user_penetap_foreign` FOREIGN KEY (`user_penetap`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jenis_pelanggaran`
--
ALTER TABLE `jenis_pelanggaran`
  ADD CONSTRAINT `jenis_pelanggaran_ibfk_1` FOREIGN KEY (`kategori_pelanggaran_id`) REFERENCES `kategori_pelanggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `monitoring_pelanggaran`
--
ALTER TABLE `monitoring_pelanggaran`
  ADD CONSTRAINT `monitoring_pelanggaran_kepala_sekolah_id_foreign` FOREIGN KEY (`kepala_sekolah_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `monitoring_pelanggaran_pelanggaran_id_foreign` FOREIGN KEY (`pelanggaran_id`) REFERENCES `pelanggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orangtua`
--
ALTER TABLE `orangtua`
  ADD CONSTRAINT `orangtua_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orangtua_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelaksanaan_sanksi`
--
ALTER TABLE `pelaksanaan_sanksi`
  ADD CONSTRAINT `pelaksanaan_sanksi_data_sanksi_id_foreign` FOREIGN KEY (`data_sanksi_id`) REFERENCES `data_sanksi` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD CONSTRAINT `pelanggaran_jenis_pelanggaran_id_foreign` FOREIGN KEY (`jenis_pelanggaran_id`) REFERENCES `jenis_pelanggaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggaran_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggaran_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggaran_user_pencatat_foreign` FOREIGN KEY (`user_pencatat`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pelanggaran_user_verifikator_foreign` FOREIGN KEY (`user_verifikator`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `prestasi`
--
ALTER TABLE `prestasi`
  ADD CONSTRAINT `prestasi_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestasi_ibfk_2` FOREIGN KEY (`jenis_prestasi_id`) REFERENCES `jenis_prestasi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestasi_ibfk_3` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestasi_ibfk_4` FOREIGN KEY (`user_pencatat`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `prestasi_ibfk_5` FOREIGN KEY (`user_verifikator`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `siswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `verifikasi_data`
--
ALTER TABLE `verifikasi_data`
  ADD CONSTRAINT `verifikasi_data_ibfk_1` FOREIGN KEY (`user_pencatat`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `verifikasi_data_ibfk_2` FOREIGN KEY (`user_verifikator`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `wali_kelas`
--
ALTER TABLE `wali_kelas`
  ADD CONSTRAINT `wali_kelas_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wali_kelas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wali_kelas_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
