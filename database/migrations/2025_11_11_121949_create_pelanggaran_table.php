<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('jenis_pelanggaran_id')->constrained('jenis_pelanggaran')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            
            // User
            $table->foreignId('user_pencatat')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_verifikator')->nullable()->constrained('users')->onDelete('set null');
            
            // Data
            $table->integer('poin');
            $table->text('keterangan')->nullable();
            $table->string('foto_bukti')->nullable(); // <-- Fitur Baru
            
            // Status
            $table->enum('status_verifikasi', ['menunggu', 'diverifikasi', 'ditolak'])->default('menunggu');
            $table->text('catatan_verifikasi')->nullable();
            
            $table->dateTime('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggaran');
    }
};