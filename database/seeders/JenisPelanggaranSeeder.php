<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriPelanggaran;
use App\Models\JenisPelanggaran;
use Illuminate\Support\Facades\Schema;

class JenisPelanggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Matikan check foreign key sementara untuk membersihkan data lama
        Schema::disableForeignKeyConstraints();
        
        // Bersihkan data lama agar tidak duplikat
        JenisPelanggaran::truncate();
        KategoriPelanggaran::truncate();

        Schema::enableForeignKeyConstraints();

        // ==============================================================
        // I. KEPRIBADIAN (Sikap)
        // ==============================================================

        // A. KETERTIBAN
        $cat = KategoriPelanggaran::create([
            'nama_kategori' => 'KETERTIBAN', 
            'kategori_induk' => 'KEPRIBADIAN'
        ]);
        
        $this->insertViolations($cat->id, [
            ['Membuat keributan / kegaduhan dalam kelas pada saat berlangsungnya pelajaran', 10],
            ['Masuk dan atau keluar lingkungan sekolah tidak melalui gerbang sekolah', 20],
            ['Berkata tidak jujur, tidak sopan/kasar', 10],
            ['Mengotori (mencorat-coret) barang milik sekolah, guru, karyawan atau teman', 10],
            ['Merusak atau menghilangkan barang milik sekolah, guru, karyawan atau teman', 25],
            ['Mengambil (mencuri) barang milik sekolah, guru, karyawan atau teman', 50],
            ['Makan dan minum di dalam kelas saat berlangsungnya pelajaran', 5],
            ['Mengaktifkan alat komunikasi didalam kelas pada saat pelajaran berlangsung', 5],
            ['Membuang sampah tidak pada tempatnya', 5],
            ['Membawa teman selain siswa SMK BN maupun dengan siswa sekolah lain atau pihak lain', 5],
            ['Membawa benda yang tidak ada kaitannya dengan proses belajar mengajar', 10],
            ['Bertengkar bertentangan dengan teman di lingkungan sekolah', 15],
            ['Memalsu tandatangan guru, walikelas, kepala sekolah', 40],
            ['Menggunakan/menggelapkan SPP dari orang tua', 40],
            ['Membentuk organisasi selain OSIS maupun kegiatan lainnya tanpa seijin Kepala Sekolah', 15],
            ['Menyalahgunakan Uang SPP', 40],
            ['Berbuat asusila', 100],
        ]);

        // B. ROKOK
        $cat = KategoriPelanggaran::create([
            'nama_kategori' => 'ROKOK', 
            'kategori_induk' => 'KEPRIBADIAN'
        ]);

        $this->insertViolations($cat->id, [
            ['Membawa rokok', 25],
            ['Merokok/menghisap rokok di sekolah', 40],
            ['Merokok/menghisap rokok di luar sekolah memakai seragam sekolah', 40],
        ]);

        // C. BUKU, MAJALAH ATAU KASET TERLARANG
        $cat = KategoriPelanggaran::create([
            'nama_kategori' => 'BUKU, MAJALAH, KASET TERLARANG', 
            'kategori_induk' => 'KEPRIBADIAN'
        ]);

        $this->insertViolations($cat->id, [
            ['Membawa buku, majalah, kaset terlarang atau HP berisi gambar dan film porno', 25],
            ['Memperjual belikan buku, majalah atau kaset terlarang', 75],
        ]);

        // D. SENJATA
        $cat = KategoriPelanggaran::create([
            'nama_kategori' => 'SENJATA', 
            'kategori_induk' => 'KEPRIBADIAN'
        ]);

        $this->insertViolations($cat->id, [
            ['Membawa senjata tajam tanpa ijin', 40],
            ['Memperjual belikan senjata tajam di sekolah', 40],
            ['Menggunakan senjata tajam untuk mengancam', 75],
            ['Menggunakan senjata tajam untuk melukai', 75],
        ]);

        // E. OBAT/MINUMAN TERLARANG
        $cat = KategoriPelanggaran::create([
            'nama_kategori' => 'OBAT/MINUMAN TERLARANG', 
            'kategori_induk' => 'KEPRIBADIAN'
        ]);

        $this->insertViolations($cat->id, [
            ['Membawa obat terlarang / minuman terlarang', 75],
            ['Menggunakan obat minuman terlarang di dalam lingkungan sekolah', 100],
            ['Memperjual belikan obat / minuman terlarang di dalam / di luar sekolah', 100],
        ]);

        // F. PERKELAHIAN
        $cat = KategoriPelanggaran::create([
            'nama_kategori' => 'PERKELAHIAN', 
            'kategori_induk' => 'KEPRIBADIAN'
        ]);

        $this->insertViolations($cat->id, [
            ['Disebabkan oleh siswa di dalam sekolah (Intern)', 75],
            ['Disebabkan oleh sekolah lain', 25],
            ['Antar siswa SMK BN 666', 75],
        ]);

        // G. PELANGGARAN TERHADAP KEPALA SEKOLAH, GURU DAN KARYAWAN
        $cat = KategoriPelanggaran::create([
            'nama_kategori' => 'PELANGGARAN THD GURU/KARYAWAN', 
            'kategori_induk' => 'KEPRIBADIAN'
        ]);

        $this->insertViolations($cat->id, [
            ['Disertai ancaman', 75],
            ['Disertai pemukulan', 100],
        ]);


        // ==============================================================
        // II. KERAJINAN
        // ==============================================================

        // A. KETERLAMBATAN
        $cat = KategoriPelanggaran::create([
            'nama_kategori' => 'KETERLAMBATAN', 
            'kategori_induk' => 'KERAJINAN'
        ]);

        $this->insertViolations($cat->id, [
            ['Terlambat masuk sekolah lebih dari 15 menit (Satu kali)', 2],
            ['Terlambat masuk sekolah lebih dari 15 menit (Dua kali)', 3],
            ['Terlambat masuk sekolah lebih dari 15 menit (Tiga kali dan selebihnya)', 5],
            ['Terlambat masuk karena izin', 3],
            ['Terlambat masuk karena diberi tugas guru', 2],
            ['Terlambat masuk karena alasan yang dibuat-buat', 5],
            ['Izin keluar saat proses belajar berlangsung dan tidak kembali', 10],
            ['Pulang tanpa izin', 10],
        ]);

        // B. KEHADIRAN
        $cat = KategoriPelanggaran::create([
            'nama_kategori' => 'KEHADIRAN', 
            'kategori_induk' => 'KERAJINAN'
        ]);

        $this->insertViolations($cat->id, [
            ['Sakit tanpa keterangan (surat)', 2],
            ['Izin tanpa keterangan (surat)', 2],
            ['Alpa', 5],
            ['Tidak mengikuti kegiatan belajar (membolos)', 10],
            ['Siswa tidak masuk dengan membuat keterangan (surat) Palsu', 10],
            ['Siswa keluar kelas saat proses belajar mengajar berlangsung tanpa izin', 5],
        ]);


        // ==============================================================
        // III. KERAPIAN
        // ==============================================================

        // A. PAKAIAN
        $cat = KategoriPelanggaran::create([
            'nama_kategori' => 'PAKAIAN', 
            'kategori_induk' => 'KERAPIAN'
        ]);

        $this->insertViolations($cat->id, [
            ['Memakai seragam tidak rapi / tidak dimasukkan', 5],
            ['Siswa putri memakai seragam yang ketat / rok pendek', 5],
            ['Tidak memakai perlengkapan upacara bendera (topi)', 5],
            ['Salah memakai baju, rok atau celana', 5],
            ['Salah atau tidak memakai ikat pinggang', 5],
            ['Salah memakai sepatu (tidak sesuai ketentuan)', 5],
            ['Tidak memakai kaos kaki', 5],
            ['Salah / tidak memakai kaos dalam', 5],
            ['Memakai topi yang bukan topi sekolah di lingkungan sekolah', 5],
            ['Siswa putri memakai perhiasan perlebihan', 5],
            ['Siswa putra memakai perhiasan atau aksesories (kalung, gelang, dll)', 5],
        ]);

        // B. RAMBUT
        $cat = KategoriPelanggaran::create([
            'nama_kategori' => 'RAMBUT', 
            'kategori_induk' => 'KERAPIAN'
        ]);

        $this->insertViolations($cat->id, [
            ['Potongan rambut putra tidak sesuai dengan ketentuan sekolah', 15],
            ['Dicat / diwarna-warnai (putra-putri)', 15],
        ]);

        // C. BADAN
        $cat = KategoriPelanggaran::create([
            'nama_kategori' => 'BADAN', 
            'kategori_induk' => 'KERAPIAN'
        ]);

        $this->insertViolations($cat->id, [
            ['Bertato', 100],
            ['Kuku di cat', 20],
        ]);
    }

    /**
     * Fungsi bantuan untuk memasukkan data pelanggaran lebih rapi
     */
    private function insertViolations($kategoriId, $items)
    {
        foreach ($items as $item) {
            JenisPelanggaran::create([
                'kategori_pelanggaran_id' => $kategoriId,
                'nama_pelanggaran' => $item[0],
                'poin' => $item[1],
            ]);
        }
    }
}