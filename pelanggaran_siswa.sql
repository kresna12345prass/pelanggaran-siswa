-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Nov 2025 pada 16.54
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 4, '2345893145', 'Asep Ramdani', 'Laki-laki', 'Web', 'aktif', '08542671823', '2025-11-11 21:08:36', '2025-11-11 21:08:36'),
(2, 5, '3285467327', 'Suhendar Eka Lawi', 'Laki-laki', 'PAI', 'aktif', '0852675891', '2025-11-12 06:36:34', '2025-11-12 06:36:34');

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
(1, 1, 'Membuat keributan / kegaduhan dalam kelas pada saat berlangsungnya pelajaran', 10, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(2, 1, 'Masuk dan atau keluar lingkungan sekolah tidak melalui gerbang sekolah', 20, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(3, 1, 'Berkata tidak jujur, tidak sopan/kasar', 10, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(4, 1, 'Mengotori (mencorat-coret) barang milik sekolah, guru, karyawan atau teman', 10, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(5, 1, 'Merusak atau menghilangkan barang milik sekolah, guru, karyawan atau teman', 25, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(6, 1, 'Mengambil (mencuri) barang milik sekolah, guru, karyawan atau teman', 50, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(7, 1, 'Makan dan minum di dalam kelas saat berlangsungnya pelajaran', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(8, 1, 'Mengaktifkan alat komunikasi didalam kelas pada saat pelajaran berlangsung', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(9, 1, 'Membuang sampah tidak pada tempatnya', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(10, 1, 'Membawa teman selain siswa SMK BN maupun dengan siswa sekolah lain atau pihak lain', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(11, 1, 'Membawa benda yang tidak ada kaitannya dengan proses belajar mengajar', 10, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(12, 1, 'Bertengkar bertentangan dengan teman di lingkungan sekolah', 15, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(13, 1, 'Memalsu tandatangan guru, walikelas, kepala sekolah', 40, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(14, 1, 'Menggunakan/menggelapkan SPP dari orang tua', 40, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(15, 1, 'Membentuk organisasi selain OSIS maupun kegiatan lainnya tanpa seijin Kepala Sekolah', 15, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(16, 1, 'Menyalahgunakan Uang SPP', 40, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(17, 1, 'Berbuat asusila', 100, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(18, 2, 'Membawa rokok', 25, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(19, 2, 'Merokok/menghisap rokok di sekolah', 40, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(20, 2, 'Merokok/menghisap rokok di luar sekolah memakai seragam sekolah', 40, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(21, 3, 'Membawa buku, majalah, kaset terlarang atau HP berisi gambar dan film porno', 25, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(22, 3, 'Memperjual belikan buku, majalah atau kaset terlarang', 75, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(23, 4, 'Membawa senjata tajam tanpa ijin', 40, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(24, 4, 'Memperjual belikan senjata tajam di sekolah', 40, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(25, 4, 'Menggunakan senjata tajam untuk mengancam', 75, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(26, 4, 'Menggunakan senjata tajam untuk melukai', 75, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(27, 5, 'Membawa obat terlarang / minuman terlarang', 75, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(28, 5, 'Menggunakan obat minuman terlarang di dalam lingkungan sekolah', 100, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(29, 5, 'Memperjual belikan obat / minuman terlarang di dalam / di luar sekolah', 100, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(30, 6, 'Disebabkan oleh siswa di dalam sekolah (Intern)', 75, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(31, 6, 'Disebabkan oleh sekolah lain', 25, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(32, 6, 'Antar siswa SMK BN 666', 75, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(33, 7, 'Disertai ancaman', 75, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(34, 7, 'Disertai pemukulan', 100, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(35, 8, 'Terlambat masuk sekolah lebih dari 15 menit (Satu kali)', 2, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(36, 8, 'Terlambat masuk sekolah lebih dari 15 menit (Dua kali)', 3, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(37, 8, 'Terlambat masuk sekolah lebih dari 15 menit (Tiga kali dan selebihnya)', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(38, 8, 'Terlambat masuk karena izin', 3, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(39, 8, 'Terlambat masuk karena diberi tugas guru', 2, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(40, 8, 'Terlambat masuk karena alasan yang dibuat-buat', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(41, 8, 'Izin keluar saat proses belajar berlangsung dan tidak kembali', 10, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(42, 8, 'Pulang tanpa izin', 10, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(43, 9, 'Sakit tanpa keterangan (surat)', 2, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(44, 9, 'Izin tanpa keterangan (surat)', 2, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(45, 9, 'Alpa', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(46, 9, 'Tidak mengikuti kegiatan belajar (membolos)', 10, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(47, 9, 'Siswa tidak masuk dengan membuat keterangan (surat) Palsu', 10, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(48, 9, 'Siswa keluar kelas saat proses belajar mengajar berlangsung tanpa izin', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(49, 10, 'Memakai seragam tidak rapi / tidak dimasukkan', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(50, 10, 'Siswa putri memakai seragam yang ketat / rok pendek', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(51, 10, 'Tidak memakai perlengkapan upacara bendera (topi)', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(52, 10, 'Salah memakai baju, rok atau celana', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(53, 10, 'Salah atau tidak memakai ikat pinggang', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(54, 10, 'Salah memakai sepatu (tidak sesuai ketentuan)', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(55, 10, 'Tidak memakai kaos kaki', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(56, 10, 'Salah / tidak memakai kaos dalam', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(57, 10, 'Memakai topi yang bukan topi sekolah di lingkungan sekolah', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(58, 10, 'Siswa putri memakai perhiasan perlebihan', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(59, 10, 'Siswa putra memakai perhiasan atau aksesories (kalung, gelang, dll)', 5, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(60, 11, 'Potongan rambut putra tidak sesuai dengan ketentuan sekolah', 15, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(61, 11, 'Dicat / diwarna-warnai (putra-putri)', 15, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(62, 12, 'Bertato', 100, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(63, 12, 'Kuku di cat', 20, NULL, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14');

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
(1, 'Penegmbangan Perangkat Lunak dan Gim', 'PPLG', '2025-11-11 20:33:50', '2025-11-11 20:33:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_pelanggaran`
--

CREATE TABLE `kategori_pelanggaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `kode_kategori` varchar(255) DEFAULT NULL,
  `kategori_induk` enum('KEPRIBADIAN','KERAJINAN','KERAPIAN') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_pelanggaran`
--

INSERT INTO `kategori_pelanggaran` (`id`, `nama_kategori`, `kode_kategori`, `kategori_induk`, `created_at`, `updated_at`) VALUES
(1, 'KETERTIBAN', 'A', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(2, 'ROKOK', 'B', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(3, 'BUKU, MAJALAH, KASET TERLARANG', 'C', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(4, 'SENJATA', 'D', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(5, 'OBAT/MINUMAN TERLARANG', 'E', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(6, 'PERKELAHIAN', 'F', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(7, 'PELANGGARAN THD GURU/KARYAWAN', 'G', 'KEPRIBADIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(8, 'KETERLAMBATAN', 'A', 'KERAJINAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(9, 'KEHADIRAN', 'B', 'KERAJINAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(10, 'PAKAIAN', 'A', 'KERAPIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(11, 'RAMBUT', 'B', 'KERAPIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(12, 'BADAN', 'C', 'KERAPIAN', '2025-11-11 18:50:14', '2025-11-11 18:50:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `jurusan_id` bigint(20) UNSIGNED NOT NULL,
  `wali_kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `jurusan_id`, `wali_kelas_id`, `kapasitas`, `created_at`, `updated_at`) VALUES
(1, 'XII PPLG 1', 1, 2, 35, '2025-11-11 20:34:10', '2025-11-12 06:36:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kesiswaan`
--

CREATE TABLE `kesiswaan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  `jam_masuk` varchar(50) DEFAULT NULL,
  `no_ijazah` varchar(100) DEFAULT NULL,
  `catatan_khusus` varchar(255) DEFAULT NULL,
  `user_pencatat` bigint(20) UNSIGNED DEFAULT NULL,
  `user_verifikator` bigint(20) UNSIGNED DEFAULT NULL,
  `status_verifikasi` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(9, 'BERAT', 'Diserahkan kepada orang tua untuk dibina (1 bulan)', 41, 89, 'Diserahkan kepada orang tua untuk dibina dalam jangka waktu satu (1) bulan.', '2025-11-11 23:52:32', '2025-11-11 23:52:32'),
(10, 'BERAT', 'Dikembalikan kepada orang tua (keluar dari sekolah)', 90, 1000, 'Dikembalikan kepada orang tua (keluar dari SMK BAKTI NUSANTARA 666).', '2025-11-11 23:52:32', '2025-11-11 23:52:32');

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
(2, 'Pasal 6', 'KEWAJIBAN', 'poin', 'Siswa sudah berada di sekolah 10 menit sebelum bel masuk berbunyi.', 2, '2025-11-11 18:50:14', '2025-11-11 20:19:11'),
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
(3, '2025_11_12_132218_add_wali_kelas_id_to_kelas_table', 3);

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `orangtua`
--

CREATE TABLE `orangtua` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `hubungan` varchar(255) DEFAULT NULL,
  `pekerjaan` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orangtua`
--

INSERT INTO `orangtua` (`id`, `user_id`, `siswa_id`, `hubungan`, `pekerjaan`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Ayah', 'Wiraswasta', 'Jl. Bandung No. 65', '2025-11-11 21:05:26', '2025-11-11 21:05:26');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('t0xSp8IGyal7Gp5YuzAA25nIR0BlpAFkhznxZMTm', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieTNyZWVxelR2RkNEaHZnUkhpR1FPQjlFZExaUTV2NUhNNDBrSHdSRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2VycyI7czo1OiJyb3V0ZSI7czoxNzoiYWRtaW4udXNlcnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1762961594);

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
(1, 2, '232417070065', '0034567891', 'Prasssetya Kresna', 'Bandung', '2008-04-15', 'L', 'Islam', 'Jl. Bandung No. 65', '088220437325', 'siswa_foto/DjfIFopEJhcfSjOsmIR4xyr1B8mZ01zgnweoMWML.png', 1, '2025-11-11 21:04:20', '2025-11-11 21:04:20');

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
(1, '20251', '2025/2026', 'Ganjil', 0, '2025-06-09', '2025-12-31', '2025-11-11 20:54:47', '2025-11-11 21:19:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED DEFAULT NULL,
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

INSERT INTO `users` (`id`, `guru_id`, `username`, `nama_lengkap`, `email`, `password`, `level`, `spesialisasi`, `can_verify`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'admin', 'Administrator', 'admin@sekolah.com', '$2y$12$u5Afe9xBPGiHRI68HI412u/GdxElBszendfkUzGQ8fWXZBqIrALKq', 'admin', 'Super Admin', 1, NULL, '2025-11-11 18:50:14', '2025-11-11 18:50:14'),
(2, NULL, 'Prass', 'Prasssetya Kresna', 'prassetyakresna15@gmail.com', '$2y$12$KnEtgBeAck/7UPCdKjPG6.PKDlVfQ.wcwgy.gpk28VYk85CaBooPW', 'siswa', 'Siswa', 0, NULL, '2025-11-11 21:04:18', '2025-11-11 21:33:14'),
(3, NULL, 'Andi', 'Andi Marwan', 'andi12345@gmail.com', '$2y$12$d1HnRpJWhHYG.MaN.Qo41.0jgjw9KuK9KPAo.ubfoOKcDUmJNtyRa', 'ortu', 'Orang Tua', 1, NULL, '2025-11-11 21:05:26', '2025-11-11 21:32:50'),
(4, NULL, 'guru', 'Asep Ramdani', 'guru_sekolah@gmail.com', '$2y$12$sgmCT.fuoCCO.K417cUqEeDZl4/hXe2jznRegw7SIyyQsRCdNtrFq', 'guru', 'Guru', 0, NULL, '2025-11-11 21:08:36', '2025-11-11 21:33:05'),
(5, NULL, 'wali_kelas', 'Suhendar Eka Lawi', 'wali_kelas@gmail.com', '$2y$12$CCRqGS2ZSmhEqQ2lHTk6ueUph7CkFCBQQG.D0FXSuH9pJDFXxwUGO', 'wali_kelas', NULL, 0, NULL, '2025-11-12 06:36:34', '2025-11-12 06:36:54');

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
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bimbingan_konseling`
--
ALTER TABLE `bimbingan_konseling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD KEY `data_sanksi_user_penetap_foreign` (`user_penetap`);

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
  ADD KEY `jurusan_id` (`jurusan_id`),
  ADD KEY `kelas_wali_kelas_id_foreign` (`wali_kelas_id`);

--
-- Indeks untuk tabel `kesiswaan`
--
ALTER TABLE `kesiswaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `user_pencatat` (`user_pencatat`),
  ADD KEY `user_verifikator` (`user_verifikator`);

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
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indeks untuk tabel `verifikasi_data`
--
ALTER TABLE `verifikasi_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_pencatat` (`user_pencatat`),
  ADD KEY `user_verifikator` (`user_verifikator`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bimbingan_konseling`
--
ALTER TABLE `bimbingan_konseling`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_sanksi`
--
ALTER TABLE `data_sanksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jenis_pelanggaran`
--
ALTER TABLE `jenis_pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `jenis_prestasi`
--
ALTER TABLE `jenis_prestasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kategori_pelanggaran`
--
ALTER TABLE `kategori_pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kesiswaan`
--
ALTER TABLE `kesiswaan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_sanksi_bertahap`
--
ALTER TABLE `master_sanksi_bertahap`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `master_tata_tertib`
--
ALTER TABLE `master_tata_tertib`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `monitoring_pelanggaran`
--
ALTER TABLE `monitoring_pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `orangtua`
--
ALTER TABLE `orangtua`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pelaksanaan_sanksi`
--
ALTER TABLE `pelaksanaan_sanksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `verifikasi_data`
--
ALTER TABLE `verifikasi_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bimbingan_konseling`
--
ALTER TABLE `bimbingan_konseling`
  ADD CONSTRAINT `bimbingan_konseling_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bimbingan_konseling_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bimbingan_konseling_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `data_sanksi`
--
ALTER TABLE `data_sanksi`
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
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kelas_wali_kelas_id_foreign` FOREIGN KEY (`wali_kelas_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `kesiswaan`
--
ALTER TABLE `kesiswaan`
  ADD CONSTRAINT `kesiswaan_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kesiswaan_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kesiswaan_ibfk_3` FOREIGN KEY (`user_pencatat`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kesiswaan_ibfk_4` FOREIGN KEY (`user_verifikator`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `verifikasi_data`
--
ALTER TABLE `verifikasi_data`
  ADD CONSTRAINT `verifikasi_data_ibfk_1` FOREIGN KEY (`user_pencatat`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `verifikasi_data_ibfk_2` FOREIGN KEY (`user_verifikator`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONECTION */;
