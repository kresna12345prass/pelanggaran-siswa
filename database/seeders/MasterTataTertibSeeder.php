<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterTataTertib; // <-- Import Model

class MasterTataTertibSeeder extends Seeder
{
    public function run(): void
    {
        // ========================================================
        // DATA UNTUK PASAL 6: KEWAJIBAN
        // ========================================================

        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'induk',
            'konten_teks' => 'Setiap siswa wajib dan patuh pada ketentuan berikut:', 'urutan' => 1
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'poin',
            'konten_teks' => 'Siswa sudah berada di sekolah 5 menit sebelum bel masuk berbunyi.', 'urutan' => 2
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'poin',
            'konten_teks' => 'Siswa yang datang terlambat wajib melapor dahulu kepada guru piket dengan ketentuan:', 'urutan' => 3
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'subpoin',
            'konten_teks' => 'Bila terlambat kurang dari lima belas menit dan dikelas belum ada guru pengajar, maka siswa di perkenankan langsung masuk kelas dengan surat izin masuk dari piket.', 'urutan' => 4
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'subpoin',
            'konten_teks' => 'Bila terlambat kurang dari lima belas menit dan dikelas sudah ada guru pengajar maka siswa menunggu pergantian jam pelajaran di perpustakaan untuk membuat resume atau kebersihan halaman ruang kelas, lingkungan sekolah, kemudian mendapat surat ijin masuk kelas dari guru piket.', 'urutan' => 5
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'subpoin',
            'konten_teks' => 'Bila terlambat lebih dari lima belas menit, maka siswa dipulangkan setelah mendapat surat pengantar dari sekolah atau Guru Piket.', 'urutan' => 6
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'poin',
            'konten_teks' => 'Bersikap dan bertingkah laku sopan santun kepada sesama kawan lebih-lebih kepada guru dan karyawan tata usaha.', 'urutan' => 7
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'poin',
            'konten_teks' => 'Siswa yang beragama Islam wajib mengikuti shalat Jum\'at berjama\'ah.', 'urutan' => 8
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'poin',
            'konten_teks' => 'Apabila seorang siswa tidak dapat hadir di sekolah wajib memberikan keterangan yang syah, yaitu:', 'urutan' => 9
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'subpoin',
            'konten_teks' => 'Surat keterangan dari orang tua', 'urutan' => 10
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'subpoin',
            'konten_teks' => 'Surat keterangan dokter apabila sakit.', 'urutan' => 11
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'subpoin',
            'konten_teks' => 'Tidak diperkenankan minta izin dengan telepon, apabila terpaksa maka pada hari pertama masuk sekolah harus memperlihatkan surat keterangan yang syah (ditanda tangani orang tua atau wali)', 'urutan' => 12
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'poin',
            'konten_teks' => 'Bila siswa karena sesuatu hal tertentu tidak dapat mengikuti pelajaran atau meninggalkan sekolah ia harus mendapatkan persetujuan dari guru piket.', 'urutan' => 13
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'poin',
            'konten_teks' => 'Pemeliharaan dan upaya 7 K (Keamanan, ketertiban, kedisiplinan, ketekunan, keindahan, kesehatan, kerindangan) atas kelas masing-masing serta lingkungan sekolah secara keseluruhan selama jam sekolah merupakan tanggung jawab bersama seluruh siswa.', 'urutan' => 14
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 6', 'judul' => 'KEWAJIBAN', 'tipe' => 'poin',
            'konten_teks' => 'Selambat-lambatnya tanggal 10 setiap bulan pembayaran SPP dan biaya Praktikum harus sudah dilunasi.', 'urutan' => 15
        ]);


        // ========================================================
        // DATA UNTUK PASAL 7: LARANGAN
        // ========================================================

        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'induk',
            'konten_teks' => 'Selama menjadi siswa-siswi SMK BAKTI NUSANTARA 666 dilarang:', 'urutan' => 16
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Berpakaian seragam tidak sesuai ketentuan sekolah', 'urutan' => 17
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Berhias atau bersolek secara berlebihan', 'urutan' => 18
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'subpoin',
            'konten_teks' => 'Mewarnai rambut selain hitam, berambut gondrong bagi siswa putra', 'urutan' => 19
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'subpoin',
            'konten_teks' => 'Make up', 'urutan' => 20
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'subpoin',
            'konten_teks' => 'Aksesoris', 'urutan' => 21
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Memakai topi selain topi sekolah.', 'urutan' => 22
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Tidak memakai singlet bagi siswi perempuan.', 'urutan' => 23
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Berbohong, mengambil barang milik orang lain (Mencuri)', 'urutan' => 24
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Membawa barang yang tidak berhubungan dengan pelajaran.', 'urutan' => 25
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Bermain dilapangan pada jam pelajaran.', 'urutan' => 26
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Mengaktifkan alat komunikasi didalam kelas pada saat pelajaran berlangsung', 'urutan' => 27
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Merokok di sekolah dan lingkungan sekolah.', 'urutan' => 28
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Membawa buku, gambar, VCD porno atau handphone berisi gambar dan film porno', 'urutan' => 29
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Membawa senjata tajam, kondom, pil KB.', 'urutan' => 30
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Membawa teman selain siswa SMK BN 666 maupun dengan siswa sekolah lain atau pihak lain.', 'urutan' => 31
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Berkelahi secara kelompok, massal baik dengan teman sekolah maupun dengan siswa sekolah lain atau pihak lain.', 'urutan' => 32
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Melakukan tindakan yang mengakibatkan kerugian dan kerusakan sekolah', 'urutan' => 33
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Memalsu tandatangan guru, walikelas, kepala sekolah.', 'urutan' => 34
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Membentuk organisasi selain OSIS maupun kegiatan lainnya tanpa seijin Kepala Sekolah.', 'urutan' => 35
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Berbuat asusila.', 'urutan' => 36
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Badan bertato', 'urutan' => 37
        ]);
        MasterTataTertib::create([
            'pasal' => 'Pasal 7', 'judul' => 'LARANGAN', 'tipe' => 'poin',
            'konten_teks' => 'Membawa, mengedarkan dan memakai NARKOBA.', 'urutan' => 38
        ]);
    }
}