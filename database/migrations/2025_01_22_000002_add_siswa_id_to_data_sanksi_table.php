<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_sanksi', function (Blueprint $table) {
            $table->unsignedBigInteger('siswa_id')->nullable()->after('id');
            $table->foreignId('kategori_sanksi_id')->nullable()->after('siswa_id')->constrained('master_kategori_sanksi')->onDelete('set null');
        });

        // Update data lama: isi siswa_id dari pelanggaran
        DB::statement('
            UPDATE data_sanksi ds
            INNER JOIN pelanggaran p ON ds.pelanggaran_id = p.id
            SET ds.siswa_id = p.siswa_id
            WHERE ds.pelanggaran_id IS NOT NULL
        ');

        // Tambah foreign key setelah data terisi
        Schema::table('data_sanksi', function (Blueprint $table) {
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('data_sanksi', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropForeign(['kategori_sanksi_id']);
            $table->dropColumn(['siswa_id', 'kategori_sanksi_id']);
        });
    }
};
